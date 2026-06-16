<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index()
    {
        return view('site.checkout.checkout');
    }
public function adicionarItem(\Illuminate\Http\Request $request) 
    {
        $dados = $request->validate([
            'produto_id' => 'required',
            'adicionais' => 'array',
            'observacao' => 'nullable|string'
        ]);

        $carrinho = session()->get('carrinho', []);
        $carrinho[] = $dados;
        session()->put('carrinho', $carrinho);

        return response()->json([
            'sucesso' => true,
            'mensagem' => 'Item adicionado com sucesso!',
            'totalItens' => count($carrinho)
        ]);
    }



    // Método que você já deve ter para os pedidos
    public function pedidos()
    {
        return view('site.checkout.pedidos');
    }

    // ADICIONE ESTE MÉTODO PARA AS ETAPAS:
    public function layout()
    {
        // Certifique-se de que o caminho corresponde à pasta (site -> checkout -> etapas.blade.php)
        return view('site.checkout.layout');
    }

}