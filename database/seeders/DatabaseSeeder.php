<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Criação do usuário ADMIN
        User::create([
            'name' => 'Teles Barrigão',
            'email' => 'barrigaadmin@loja.com',
            'password' => Hash::make('soubarrigudo123'),
            'role' => 'admin',
        ]);

        // Criação do usuário VENDEDOR
        User::create([
            'name' => 'Teles Vendedor Barrigudão',
            'email' => 'barrigavendedor@loja.com',
            'password' => Hash::make('soubarrigudo123'),
            'role' => 'vendedor',
        ]);

        // Criação do usuário CLIENTE
        User::create([
            'name' => 'Teles Barriga grande',
            'email' => 'barrigacliente@loja.com',
            'password' => Hash::make('soubarrigudo123'),
            'role' => 'cliente',
        ]);

        // Chamada dos seeders adicionais (categorias e produtos)
        $this->call([
            CategoriaSeeder::class,
            ProdutoSeeder::class,
        ]);
    }
}
