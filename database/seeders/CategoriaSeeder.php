<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoriaSeeder extends Seeder
{
    /**
     * Popula a tabela de categorias.
     */
    public function run(): void
    {
        $categorias = [
            [
                'name' => 'Alimentos',
                'code' => 'ALIM',
                'icon' => 'bi-egg-fried',
                'description' => 'Produtos alimentícios em geral',
            ],
            [
                'name' => 'Frutas',
                'code' => 'FRUT',
                'icon' => 'bi-apple',
                'description' => 'Frutas frescas e naturais',
            ],
            [
                'name' => 'Construções',
                'code' => 'CONS',
                'icon' => 'bi-house-door',
                'description' => 'Itens para obras e construções',
            ],
            [
                'name' => 'Aparelhos eletrônicos',
                'code' => 'ELEC',
                'icon' => 'bi-phone',
                'description' => 'Produtos eletrônicos modernos',
            ],
        ];

        foreach ($categorias as $categoria) {
            Category::create($categoria);
        }
    }
}
