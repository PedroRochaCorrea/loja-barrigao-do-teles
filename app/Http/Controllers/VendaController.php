<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class VendaController extends Controller
{
    public function montarVenda()
    {
        $produtos = Product::all();
        $carrinho = session()->get('venda_carrinho', []);
        $total = $this->calcularTotal($carrinho);

        return view('vendedor.montar_venda', compact('produtos', 'carrinho', 'total'));
    }

    public function adicionarItem(Request $request)
    {
        $request->validate([
            'produto_id' => 'required|exists:products,id',
            'quantidade' => 'required|integer|min:1',
        ]);

        $produto = Product::findOrFail($request->produto_id);

        if ($produto->stock < $request->quantidade) {
            return redirect()->back()->with('error', 'Estoque insuficiente para o produto selecionado.');
        }

        $carrinho = session()->get('venda_carrinho', []);

        $existe = false;
        foreach ($carrinho as &$item) {
            if ($item['produto_id'] == $produto->id) {
                $item['quantidade'] += $request->quantidade;
                $existe = true;
                break;
            }
        }

        if (!$existe) {
            $carrinho[] = [
                'produto_id' => $produto->id,
                'nome' => $produto->name,
                'preco' => $produto->price,
                'quantidade' => $request->quantidade,
            ];
        }

        session()->put('venda_carrinho', $carrinho);

        return redirect()->back()->with('success', 'Produto adicionado à venda.');
    }

    public function removerItem($id)
    {
        $carrinho = session()->get('venda_carrinho', []);
        $carrinho = array_filter($carrinho, fn($item) => $item['produto_id'] != $id);

        session()->put('venda_carrinho', array_values($carrinho));

        return redirect()->back()->with('success', 'Item removido da venda.');
    }

    public function esvaziarVenda()
    {
        session()->forget('venda_carrinho');
        return redirect()->back()->with('success', 'Venda esvaziada com sucesso.');
    }

    public function finalizarVenda(Request $request)
    {
        $request->validate([
            'forma_pagamento' => 'required|in:Dinheiro,Cartão de Crédito,Cartão de Débito,Pix,Boleto,Outros',
        ]);

        $carrinho = session()->get('venda_carrinho', []);

        if (empty($carrinho)) {
            return redirect()->back()->with('error', 'Nenhum produto na venda.');
        }

        DB::beginTransaction();

        try {
            $total = $this->calcularTotal($carrinho);

            $venda = Sale::create([
                'user_id' => auth()->id(),
                'total' => $total,
                'payment_method' => $request->forma_pagamento,
                'sale_date' => Carbon::now(),
            ]);

            foreach ($carrinho as $item) {
                $produto = Product::findOrFail($item['produto_id']);

                if ($produto->stock < $item['quantidade']) {
                    throw new \Exception("Estoque insuficiente para o produto {$produto->name}");
                }

                SaleItem::create([
                    'sale_id' => $venda->id,
                    'product_id' => $produto->id,
                    'quantity' => $item['quantidade'],
                    'unit_price' => $produto->price,
                    'total' => $item['quantidade'] * $produto->price,
                ]);

                $produto->stock -= $item['quantidade'];
                $produto->save();
            }

            DB::commit();
            session()->forget('venda_carrinho');

            return redirect()->route('vendedor.vendas.historico')->with('success', 'Venda registrada com sucesso.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Erro: ' . $e->getMessage());
        }
    }

    public function historico()
    {
        $vendas = Sale::with('itens.product')->where('user_id', auth()->id())->latest()->get();
        return view('vendedor.vendas_historico', compact('vendas'));
    }

    private function calcularTotal($carrinho)
    {
        return array_reduce($carrinho, fn($total, $item) => $total + $item['preco'] * $item['quantidade'], 0);
    }
}
