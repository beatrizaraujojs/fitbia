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
}

