<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Services\CarrinhoService;

class VendaController extends Controller
{
    protected $carrinho;

    public function __construct(CarrinhoService $carrinho)
    {
        $this->carrinho = $carrinho;
    }

    public function montarVenda()
    {
        $produtos = Product::all();
        $carrinho = $this->carrinho->listar('venda_carrinho');
        $total = $this->carrinho->total('venda_carrinho');

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

        $this->carrinho->adicionar('venda_carrinho', $produto, $request->quantidade);

        return redirect()->back()->with('success', 'Produto adicionado à venda.');
    }

    public function removerItem($id)
    {
        $this->carrinho->remover('venda_carrinho', $id);
        return redirect()->back()->with('success', 'Item removido da venda.');
    }

    public function esvaziarVenda()
    {
        $this->carrinho->limpar('venda_carrinho');
        return redirect()->back()->with('success', 'Venda esvaziada com sucesso.');
    }

    public function finalizarVenda(Request $request)
    {
        $request->validate([
            'forma_pagamento' => 'required|in:Dinheiro,Cartão de Crédito,Cartão de Débito,Pix,Boleto,Outros',
        ]);

        $carrinho = $this->carrinho->listar('venda_carrinho');

        if (empty($carrinho)) {
            return redirect()->back()->with('error', 'Nenhum produto na venda.');
        }

        if (!$this->carrinho->validarEstoque('venda_carrinho')) {
            return redirect()->back()->with('error', 'Estoque insuficiente em um ou mais itens.');
        }

        DB::beginTransaction();

        try {
            $total = $this->carrinho->total('venda_carrinho');

            $venda = Sale::create([
                'user_id' => auth()->id(),
                'total' => $total,
                'payment_method' => $request->forma_pagamento,
                'sale_date' => Carbon::now(),
            ]);

            foreach ($carrinho as $item) {
                $produto = Product::findOrFail($item['produto_id']);

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
            $this->carrinho->limpar('venda_carrinho');

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
}
