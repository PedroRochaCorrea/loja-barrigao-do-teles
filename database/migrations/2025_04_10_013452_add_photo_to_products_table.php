<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    // Método que executa a alteração no banco
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Adicionando uma coluna nova chamada 'photo', que pode ser nula
            $table->string('photo')->nullable()->after('name');
        });
    }

    // Método que desfaz a alteração (rollback)
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Remove a coluna 'photo' caso a gente precise reverter a migration
            $table->dropColumn('photo');
        });
    }
};
