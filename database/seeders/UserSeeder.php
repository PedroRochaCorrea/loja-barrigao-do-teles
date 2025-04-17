<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Usuário ADMIN
        User::create([
            'name' => 'Teles Barrigão',
            'email' => 'barrigaadmin@loja.com',
            'password' => Hash::make('soubarrigudo123'),
            'role' => 'admin',
        ]);

        // Usuário VENDEDOR
        User::create([
            'name' => 'Teles Vendedor Barrigudão',
            'email' => 'barrigavendedor@loja.com',
            'password' => Hash::make('soubarrigudo123'),
            'role' => 'vendedor',
        ]);

        // Usuário CLIENTE
        User::create([
            'name' => 'Teles Barriga grande',
            'email' => 'barrigacliente@loja.com',
            'password' => Hash::make('soubarrigudo123'),
            'role' => 'cliente',
        ]);
    }
}
