<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Support\Facades\DB;

class ShoppingListController extends Controller
{
    public function index()
    {
        $cart = Session::get('shopping_list', []);
        $products = Product::all();
        return view('cliente.lista', compact('cart', 'products'));
    }

    public function add(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);

        $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $product->stock,
        ]);

        $quantity = $request->input('quantity');
        $cart = Session::get('shopping_list', []);

        $found = false;
        foreach ($cart as &$item) {
            if ($item['id'] == $product->id) {
                $item['quantity'] += $quantity;
                $found = true;
                break;
            }
        }

        if (!$found) {
            $cart[] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $quantity,
            ];
        }

        Session::put('shopping_list', $cart);

        // 🔄 Redireciona de volta para a mesma tela, não para a lista
        return redirect()->back()->with('success', 'Produto adicionado à lista!');
    }

    public function remove($productId)
    {
        $cart = Session::get('shopping_list', []);
        $cart = array_filter($cart, fn($item) => $item['id'] != $productId);
        Session::put('shopping_list', array_values($cart));
        return redirect()->back()->with('success', 'Produto removido da lista.');
    }

    public function clear()
    {
        Session::forget('shopping_list');
        return redirect()->back()->with('success', 'Lista esvaziada.');
    }

    public function checkout()
    {
        $cart = Session::get('shopping_list', []);
        return view('cliente.finalizar_compra', compact('cart'));
    }

    public function confirm(Request $request)
    {
        $request->validate([
            'payment_method' => 'required',
        ]);

        $cart = Session::get('shopping_list', []);
        if (empty($cart)) {
            return redirect()->back()->with('error', 'A lista está vazia.');
        }

        DB::beginTransaction();

        try {
            $total = array_reduce($cart, function ($carry, $item) {
                return $carry + ($item['price'] * $item['quantity']);
            }, 0);

            $sale = Sale::create([
                'user_id' => auth()->id(),
                'total' => $total,
                'payment_method' => $request->payment_method,
                'sale_date' => now(),
            ]);

            foreach ($cart as $item) {
                $product = Product::findOrFail($item['id']);

                if ($product->stock < $item['quantity']) {
                    throw new \Exception("Estoque insuficiente para o produto {$product->name}");
                }

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
            Session::forget('shopping_list');

            // ✅ Redireciona para a nova tela de confirmação
            return redirect()->route('compra.finalizada');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Erro ao finalizar a compra: ' . $e->getMessage());
        }
    }
}
