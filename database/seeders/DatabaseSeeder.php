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
        User::create([
            'name' => 'Admin Teste',
            'email' => 'admin@teste.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Vendedor Teste',
            'email' => 'vendedor@teste.com',
            'password' => Hash::make('password'),
            'role' => 'vendedor',
        ]);

        User::create([
            'name' => 'Cliente Teste',
            'email' => 'cliente@teste.com',
            'password' => Hash::make('password'),
            'role' => 'cliente',
        ]);
    }
}