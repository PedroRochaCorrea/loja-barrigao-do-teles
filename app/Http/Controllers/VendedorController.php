<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VendedorController extends Controller
{
    public function index()
    {
        return view('vendedor.dashboard'); // Retorne a view para o painel do vendedor
    }
}
