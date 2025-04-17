<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\VendedorController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShoppingListController;
use App\Http\Controllers\VendaController;

// Página inicial
Route::get('/', function () {
    if (Auth::check()) {
        $role = Auth::user()->role;
        return match ($role) {
            'admin' => redirect()->route('admin.dashboard'),
            'vendedor' => redirect()->route('vendedor.dashboard'),
            'cliente' => redirect()->route('cliente.dashboard'),
            default => redirect('/login')
        };
    }

    return view('home'); // View: resources/views/home.blade.php
})->name('home');

// Rotas protegidas por autenticação
Route::middleware('auth')->group(function () {

    // Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoryController::class);

    // Vendedor
    Route::prefix('vendedor')->group(function () {
        Route::get('/dashboard', [VendedorController::class, 'index'])->name('vendedor.dashboard');
        Route::get('/venda', [VendaController::class, 'montarVenda'])->name('vendedor.venda.index');
        Route::post('/venda/adicionar', [VendaController::class, 'adicionarItem'])->name('vendedor.venda.adicionar');
        Route::delete('/venda/remover/{id}', [VendaController::class, 'removerItem'])->name('vendedor.venda.remover');
        Route::get('/venda/esvaziar', [VendaController::class, 'esvaziarVenda'])->name('vendedor.venda.esvaziar');
        Route::post('/venda/finalizar', [VendaController::class, 'finalizarVenda'])->name('vendedor.venda.finalizar');
        Route::get('/vendas/historico', [VendaController::class, 'historico'])->name('vendedor.vendas.historico');
    });

    // Cliente
    Route::get('/cliente/dashboard', [ClienteController::class, 'index'])->name('cliente.dashboard');
    Route::get('/cliente/historico', [ClienteController::class, 'historico'])->name('cliente.historico');
    Route::get('/produtos', [ProductController::class, 'publicIndex'])->name('produtos.cliente');
    Route::get('/lista-de-compras', [ShoppingListController::class, 'index'])->name('shopping.list.index');
    Route::post('/lista-de-compras/adicionar/{productId}', [ShoppingListController::class, 'add'])->name('shopping.list.add');
    Route::delete('/lista-de-compras/remover/{productId}', [ShoppingListController::class, 'remove'])->name('shopping.list.remove');
    Route::delete('/lista-de-compras/limpar', [ShoppingListController::class, 'clear'])->name('shopping.list.clear');
    Route::get('/finalizar-compra', [ShoppingListController::class, 'checkout'])->name('shopping.list.checkout');
    Route::post('/finalizar-compra', [ShoppingListController::class, 'confirm'])->name('shopping.list.confirm');

    // ✅ Rota para tela de confirmação de compra
    Route::get('/compra/finalizada', function () {
        return view('cliente.compra_finalizada');
    })->name('compra.finalizada');
});

// Autenticação
require __DIR__.'/auth.php';
