<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            // REMOVER colunas antigas
            $table->dropColumn(['product_id', 'quantity', 'price']);
        });
    }

    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            // REVERTER se necessário
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->integer('quantity');
            $table->decimal('price', 10, 2);
        });
    }
};
