<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Support\Facades\DB;
use App\Services\CarrinhoService;

class ShoppingListController extends Controller
{
    protected $carrinho;

    public function __construct(CarrinhoService $carrinho)
    {
        $this->carrinho = $carrinho;
    }

    public function index()
    {
        $cart = $this->carrinho->listar('shopping_list');
        $products = Product::all();
        return view('cliente.lista', compact('cart', 'products'));
    }

    public function add(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);

        $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $product->stock,
        ]);

        $this->carrinho->adicionar('shopping_list', $product, $request->quantity);

        return redirect()->back()->with('success', 'Produto adicionado à lista!');
    }

    public function remove($productId)
    {
        $this->carrinho->remover('shopping_list', $productId);
        return redirect()->back()->with('success', 'Produto removido da lista.');
    }

    public function clear()
    {
        $this->carrinho->limpar('shopping_list');
        return redirect()->back()->with('success', 'Lista esvaziada.');
    }

    public function checkout()
    {
        $cart = $this->carrinho->listar('shopping_list');
        return view('cliente.finalizar_compra', compact('cart'));
    }

    public function confirm(Request $request)
    {
        $request->validate([
            'payment_method' => 'required',
        ]);

        $cart = $this->carrinho->listar('shopping_list');

        if (empty($cart)) {
            return redirect()->back()->with('error', 'A lista está vazia.');
        }

        if (!$this->carrinho->validarEstoque('shopping_list')) {
            return redirect()->back()->with('error', 'Um ou mais produtos estão com estoque insuficiente.');
        }

        DB::beginTransaction();

        try {
            $total = $this->carrinho->total('shopping_list');

            $sale = Sale::create([
                'user_id' => auth()->id(),
                'total' => $total,
                'payment_method' => $request->payment_method,
                'sale_date' => now(),
            ]);

            foreach ($cart as $item) {
                $product = Product::findOrFail($item['id']);

                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'unit_price' => $product->price,
                    'total' => $item['price'] * $item['quantity'],
                ]);

                $product->stock -= $item['quantity'];
                $product->save();
            }

            DB::commit();
            $this->carrinho->limpar('shopping_list');

            return redirect()->route('compra.finalizada');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Erro ao finalizar a compra: ' . $e->getMessage());
        }
    }
}
