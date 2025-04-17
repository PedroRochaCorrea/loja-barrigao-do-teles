<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    /**
     * Exibe o painel do cliente.
     */
    public function index()
    {
        return view('cliente.dashboard');
    }

    /**
     * Exibe o histórico de compras do cliente autenticado.
     */
    public function historico()
    {
        // Busca todas as vendas do cliente com os itens e os produtos relacionados
        $vendas = Sale::with('itens.product')
            ->where('user_id', auth()->id())
            ->latest('sale_date')
            ->get();

        return view('cliente.historico', compact('vendas'));
    }
}
