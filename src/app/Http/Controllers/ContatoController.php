<?php

namespace App\Http\Controllers;

class ContatoController extends Controller
{
    public function index()
    {
        // Tem de apontar para a tua view principal da casinha
        return view('site.contato.contato'); // Muda se o nome do teu ficheiro principal for outro
    }
}