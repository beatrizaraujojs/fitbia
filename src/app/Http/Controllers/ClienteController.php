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
        return view('site.cadastro.cadastro'); // Ajuste o caminho da view se necessário
    }

    // Exibe a página de cadastro
    public function mostrarCadastro()
    {
        return view('site.cadastro.cadastro'); // Ajuste o caminho da view se necessário
    }

    // Processa o cadastro do novo cliente
    public function registrar(Request $request)
    {
        // Validação idêntica
       $request->validate([
            'nome_cliente'     => 'required|string|max:255',
            // O e-mail já tinha a regra unique
            'email_cliente'    => 'required|string|email|max:255|unique:tbl_cliente,email_cliente|unique:tbl_usuario,email_usuario',
            // Adicionamos a regra unique no whatsapp aqui:
            'whatsapp_cliente' => 'required|string|unique:tbl_cliente,whatsapp_cliente',
            'senha_cliente'    => 'required|string|min:6',
        ], [
            // 2. Mensagens amigáveis para o cliente
            'email_cliente.unique'    => 'Este e-mail já está cadastrado em nosso sistema. Tente fazer login.',
            'whatsapp_cliente.unique' => 'Este número de WhatsApp já está sendo utilizado por outro cliente.',
            'senha_cliente.min'       => 'A sua senha deve ter pelo menos 6 caracteres.',
        ]);

        // 1. Salva na tbl_cliente usando Eloquent
        $cliente = Cliente::create([
            'nome_cliente'     => $request->nome_cliente,
            'email_cliente'    => $request->email_cliente,
            'whatsapp_cliente' => $request->whatsapp_cliente,
            'senha_cliente'    => Hash::make($request->senha_cliente),
            'status_cliente'   => 'ATIVO',
        ]);

        // 2. Salva na tbl_usuario usando Eloquent (Sem nenhuma linha de código "DB::")
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

        // Redirecionamento inteligente
        if (session()->has('carrinho') && count(session('carrinho')) > 0) {
            return redirect()->route('site.checkout')->with('success', 'Cadastro realizado com sucesso! Já se encontra logado(a).');
        }

      return redirect()->route('site.painel')->with('success', 'Conta criada com sucesso! Bem-vindo ao seu painel.');
    }

    // Processa a tentativa de login
    public function autenticar(Request $request)
{
    $credentials = $request->validate([
        'email_cliente' => ['required', 'email'],
        'password'      => ['required'],
    ]);

    if (Auth::attempt(['email_cliente' => $request->email_cliente, 'password' => $request->password])) {
        $request->session()->regenerate();

        // Se ele logar com sucesso, manda direto para a Área do Cliente
        return redirect()->route('site.painel')->with('success', 'Bem-vindo ao seu painel!');
    }

    return back()->withErrors([
        'email_cliente' => 'E-mail ou senha incorretos.',
    ]);
}

    // Processa o logout (Sair da conta)
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

       return redirect('/')->with('success', 'Até logo!');
    }


    // Atualiza os dados do cliente e do usuário espelho
   public function atualizarPerfil(Request $request)
{
    $cliente = auth()->user();

    $request->validate([
        'nome_cliente'     => 'required|string|max:255',
        'whatsapp_cliente' => 'required|string',
        'cpf_cliente'      => 'nullable|string',
        'data_nascimento'  => 'nullable|date',
        'senha_cliente'    => 'nullable|string|min:6',
    ]);

    $cliente->nome_cliente = $request->nome_cliente;
    $cliente->whatsapp_cliente = $request->whatsapp_cliente;
    $cliente->cpf_cliente = $request->cpf_cliente;
    $cliente->data_nascimento = $request->data_nascimento;
    
    if ($request->filled('senha_cliente')) {
        $cliente->senha_cliente = Hash::make($request->senha_cliente);
    }
    $cliente->save();

    // ... (o código que atualiza a tbl_usuario continua aqui) ...

    return back()->with('success', 'Perfil atualizado com sucesso!');
}


public function salvarEndereco(Request $request)
{
    // Valida os campos obrigatórios
    $request->validate([
        'cep_endereco'    => 'required|string',
        'rua_endereco'    => 'required|string',
        'numero_endereco' => 'required|string',
        'bairro_endereco' => 'required|string',
        'cidade_endereco' => 'required|string',
    ]);

    // O "updateOrCreate" procura se já existe um endereço para este cliente.
    // Se existir, atualiza. Se não existir, cria um novo (vinculando a foreign key).
    \App\Models\Endereco::updateOrCreate(
        ['id_cliente_fk' => auth()->user()->id_cliente], // O que procurar (O vínculo)
        [
            'cep_endereco'         => $request->cep_endereco,
            'rua_endereco'         => $request->rua_endereco,
            'numero_endereco'      => $request->numero_endereco,
            'complemento_endereco' => $request->complemento_endereco,
            'bairro_endereco'      => $request->bairro_endereco,
            'cidade_endereco'      => $request->cidade_endereco,
        ] // Os dados para salvar/atualizar
    );

    return back()->with('success', 'Endereço salvo com sucesso!');
}

}