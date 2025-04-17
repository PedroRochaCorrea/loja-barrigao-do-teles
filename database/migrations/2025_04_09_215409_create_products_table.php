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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nome do produto
            $table->text('description')->nullable(); // Descrição opcional
            $table->decimal('price', 8, 2); // Preço com 2 casas decimais
            $table->unsignedInteger('stock')->default(0); // Estoque com valor padrão 0
            $table->unsignedBigInteger('category_id'); // ID da categoria (relacionamento)
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->timestamps(); // created_at e updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
