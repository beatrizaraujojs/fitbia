<?php

namespace App\Http\Controllers;

class CasinhaController extends Controller
{
    public function index()
    {
        // Tem de apontar para a tua view principal da casinha
        return view('site.casinha.casinha'); // Muda se o nome do teu ficheiro principal for outro
    }
}