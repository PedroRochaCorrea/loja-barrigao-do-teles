<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class ProdutoSeeder extends Seeder
{
    /**
     * Popula a tabela de produtos.
     */
    public function run(): void
    {
        // Busca as categorias já inseridas
        $alimentos = Category::where('code', 'ALIM')->first();
        $frutas = Category::where('code', 'FRUT')->first();
        $construcoes = Category::where('code', 'CONS')->first();
        $eletronicos = Category::where('code', 'ELEC')->first();

        // Produtos
        $produtos = [
            [
                'name' => 'Arroz',
                'photo' => 'arroz.jpg',
                'price' => 10.50,
                'stock' => 50,
                'category_id' => $alimentos->id,
            ],
            [
                'name' => 'Feijão',
                'photo' => 'feijao.jpg',
                'price' => 8.75,
                'stock' => 60,
                'category_id' => $alimentos->id,
            ],
            [
                'name' => 'Laranja',
                'photo' => 'laranja.jpg',
                'price' => 3.25,
                'stock' => 100,
                'category_id' => $frutas->id,
            ],
            [
                'name' => 'Goiaba',
                'photo' => 'goiaba.jpg',
                'price' => 4.00,
                'stock' => 80,
                'category_id' => $frutas->id,
            ],
            [
                'name' => 'Casa',
                'photo' => 'casa.jpg',
                'price' => 50000.00,
                'stock' => 2,
                'category_id' => $construcoes->id,
            ],
            [
                'name' => 'iPhone 16',
                'photo' => 'iphone.jpg',
                'price' => 7999.99,
                'stock' => 10,
                'category_id' => $eletronicos->id,
            ],
        ];

        foreach ($produtos as $produto) {
            Product::create($produto);
        }
    }
}
