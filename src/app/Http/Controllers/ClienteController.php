<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Usuario; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ClienteController extends Controller
{
    // Exibe a página de login
    public function mostrarLogin()
    {
        return view('site.cadastro.cadastro'); 
    }

    // Exibe a página de cadastro
    public function mostrarCadastro()
    {
        return view('site.cadastro.cadastro'); 
    }

    // Processa o cadastro do novo cliente
    public function registrar(Request $request)
    {
        $request->validate([
            'nome_cliente'     => 'required|string|max:255',
            'email_cliente'    => 'required|string|email|max:255|unique:tbl_cliente,email_cliente|unique:tbl_usuario,email_usuario',
            'whatsapp_cliente' => 'required|string|unique:tbl_cliente,whatsapp_cliente',
            'senha_cliente'    => 'required|string|min:6',
        ], [
            'email_cliente.unique'    => 'Este e-mail já está cadastrado em nosso sistema. Tente fazer login.',
            'whatsapp_cliente.unique' => 'Este número de WhatsApp já está sendo utilizado por outro cliente.',
            'senha_cliente.min'       => 'A sua senha deve ter pelo menos 6 caracteres.',
        ]);

        // 1. Salva na tbl_cliente
        $cliente = Cliente::create([
            'nome_cliente'     => $request->nome_cliente,
            'email_cliente'    => $request->email_cliente,
            'whatsapp_cliente' => $request->whatsapp_cliente,
            'senha_cliente'    => Hash::make($request->senha_cliente),
            'status_cliente'   => 'ATIVO',
        ]);

        // 2. Salva na tbl_usuario como espelho
        Usuario::create([
            'nome_usuario'         => $request->nome_cliente,
            'email_usuario'        => $request->email_cliente,
            'senha_usuario'        => Hash::make($request->senha_cliente),
            'cpf_usuario'          => null,
            'nivel_acesso_usuario' => 'CLIENTE',
            'status_usuario'       => 'ATIVO',
        ]);

        // Faz o login automático do cliente
        Auth::login($cliente);

        // Redirecionamento inteligente baseado no carrinho
        if (session()->has('carrinho') && count(session('carrinho')) > 0) {
            return redirect()->route('site.checkout')->with('success', 'Cadastro realizado com sucesso! Já se encontra logado(a).');
        }

        return redirect()->route('site.painel')->with('success', 'Conta criada com sucesso! Bem-vindo ao seu painel.');
    }

    // Processa a tentativa de login (Unificado: Cliente e Admin)
    public function autenticar(Request $request)
    {
        // 1. Valida os dados vindo do formulário do seu Header
        $request->validate([
            'email_cliente' => 'required|email',
            'password'      => 'required',
        ]);

        // 2. TENTATIVA A: Verificar se é um CLIENTE comum (tbl_cliente)
        if (Auth::guard('web')->attempt(['email_cliente' => $request->email_cliente, 'password' => $request->password])) {
            $request->session()->regenerate();
            
            return redirect()->intended(route('site.painel'));
        }

        // 3. TENTATIVA B: Se não achou cliente, verifica se é da EQUIPE (tbl_usuario)
        $usuarioAdmin = Usuario::where('email_usuario', $request->email_cliente)->first();

        if ($usuarioAdmin && Hash::check($request->password, $usuarioAdmin->senha_usuario)) {
            
            if ($usuarioAdmin->status_usuario === 'ATIVO' && in_array($usuarioAdmin->nivel_acesso_usuario, ['ADMIN', 'FUNCIONARIO'])) {
                
                Auth::guard('admin')->login($usuarioAdmin);
                $request->session()->regenerate();

                return redirect()->route('admin.dashboard');
            }
        }

        // 4. Fallback: Se não bater com nenhuma conta, retorna o erro na caixinha
        return back()->withErrors([
            'email_cliente' => 'As credenciais fornecidas não correspondem aos nossos registros.',
        ])->onlyInput('email_cliente');
    }

    // Processa o logout (Sair da conta)
    public function logout(Request $request)
    {
        // Limpa o login do Cliente (web) e do Admin, por segurança
        Auth::guard('web')->logout();
        Auth::guard('admin')->logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Até logo!');
    }

    // Atualiza os dados do cliente
    public function atualizarPerfil(Request $request)
    {
        $cliente = auth()->user();

        $request->validate([
            'nome_cliente'     => 'required|string|max:255',
            'whatsapp_cliente' => 'required|string|unique:tbl_cliente,whatsapp_cliente,' . $cliente->id_cliente . ',id_cliente',
            'cpf_cliente'      => 'nullable|string|unique:tbl_cliente,cpf_cliente,' . $cliente->id_cliente . ',id_cliente',
            'data_nascimento'  => 'nullable|date',
            'senha_cliente'    => 'nullable|string|min:6',
        ], [
            'cpf_cliente.unique'      => 'Este CPF já está cadastrado em outra conta da Fit Bia.',
            'whatsapp_cliente.unique' => 'Este número de WhatsApp já está cadastrado em outra conta.',
        ]);

        $cliente->nome_cliente = $request->nome_cliente;
        $cliente->whatsapp_cliente = $request->whatsapp_cliente;
        $cliente->cpf_cliente = $request->cpf_cliente;
        $cliente->data_nascimento = $request->data_nascimento;
        
        if ($request->filled('senha_cliente')) {
            $cliente->senha_cliente = Hash::make($request->senha_cliente);
        }
        $cliente->save();

        return back()->with('success', 'Perfil updated com sucesso!');
    }

    // Salva ou atualiza o endereço do painel do cliente
    public function salvarEndereco(Request $request)
    {
        $request->validate([
            'cep_endereco'    => 'required|string',
            'rua_endereco'    => 'required|string',
            'numero_endereco' => 'required|string',
            'bairro_endereco' => 'required|string',
            'cidade_endereco' => 'required|string',
        ]);

        \App\Models\Endereco::updateOrCreate(
            ['id_cliente_fk' => auth()->user()->id_cliente], 
            [
                'cep_endereco'         => $request->cep_endereco,
                'rua_endereco'         => $request->rua_endereco,
                'numero_endereco'      => $request->numero_endereco,
                'complemento_endereco' => $request->complemento_endereco,
                'bairro_endereco'      => $request->bairro_endereco,
                'cidade_endereco'      => $request->cidade_endereco,
            ]
        );

        return back()->with('success', 'Endereço salvo com sucesso!');
    }
}