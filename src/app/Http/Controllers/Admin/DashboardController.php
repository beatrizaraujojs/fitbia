<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Retorna a view dashboard.blade.php
        return view('admin.dash.dashboard');
    }
}


