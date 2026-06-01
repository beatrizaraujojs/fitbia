<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // O ponto significa: pasta 'site' > pasta 'home' > arquivo 'home'
        return view('site.home.home');
    }
}