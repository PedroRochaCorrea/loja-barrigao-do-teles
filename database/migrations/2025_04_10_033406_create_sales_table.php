<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade'); // Relacionamento com produtos
            $table->integer('quantity'); // Quantidade do produto vendido
            $table->decimal('price', 10, 2); // Preço do produto na venda
            $table->decimal('total', 10, 2); // Total da venda (quantidade * preço)
            $table->date('sale_date'); // Data da venda
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
