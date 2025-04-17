<?php

namespace App\Services;

use App\Models\Product;

class CarrinhoService
{
    public function listar(string $sessionKey): array
    {
        return session()->get($sessionKey, []);
    }

    public function adicionar(string $sessionKey, Product $produto, int $quantidade): void
    {
        $carrinho = session()->get($sessionKey, []);
        $encontrado = false;

        foreach ($carrinho as &$item) {
            $id = $item['id'] ?? $item['produto_id'];
            if ($id == $produto->id) {
                // ✅ Incrementa corretamente de acordo com o tipo de carrinho
                if (isset($item['quantity'])) {
                    $item['quantity'] += $quantidade;
                }
                if (isset($item['quantidade'])) {
                    $item['quantidade'] += $quantidade;
                }
                $encontrado = true;
                break;
            }
        }

        if (!$encontrado) {
            // ✅ Estrutura correta para cliente ou vendedor
            $carrinho[] = $sessionKey === 'shopping_list'
                ? [
                    'id' => $produto->id,
                    'name' => $produto->name,
                    'price' => $produto->price,
                    'quantity' => $quantidade,
                ]
                : [
                    'produto_id' => $produto->id,
                    'nome' => $produto->name,
                    'preco' => $produto->price,
                    'quantidade' => $quantidade,
                ];
        }

        session()->put($sessionKey, $carrinho);
    }

    public function remover(string $sessionKey, int $produtoId): void
    {
        $carrinho = session()->get($sessionKey, []);
        $carrinho = array_filter($carrinho, fn($item) =>
            ($item['id'] ?? $item['produto_id']) != $produtoId
        );
        session()->put($sessionKey, array_values($carrinho));
    }

    public function limpar(string $sessionKey): void
    {
        session()->forget($sessionKey);
    }

    public function total(string $sessionKey): float
    {
        $carrinho = session()->get($sessionKey, []);
        return array_reduce($carrinho, function ($soma, $item) {
            return $soma + ($item['preco'] ?? $item['price']) * ($item['quantidade'] ?? $item['quantity']);
        }, 0);
    }

    public function quantidadeTotal(string $sessionKey): int
    {
        $carrinho = session()->get($sessionKey, []);
        return array_reduce($carrinho, function ($total, $item) {
            return $total + ($item['quantidade'] ?? $item['quantity']);
        }, 0);
    }

    public function validarEstoque(string $sessionKey): bool
    {
        $carrinho = session()->get($sessionKey, []);
        foreach ($carrinho as $item) {
            $produto = Product::find($item['id'] ?? $item['produto_id']);
            if (!$produto || $produto->stock < ($item['quantidade'] ?? $item['quantity'])) {
                return false;
            }
        }
        return true;
    }
}
