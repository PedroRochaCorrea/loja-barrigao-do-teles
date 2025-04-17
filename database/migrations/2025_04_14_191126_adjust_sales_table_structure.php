<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            // Se a foreign key ainda existir, remova com segurança
            if (Schema::hasColumn('sales', 'product_id')) {
                $table->dropForeign(['product_id']); // Remove a constraint
                $table->dropColumn('product_id');    // Remove a coluna
            }

            if (Schema::hasColumn('sales', 'quantity')) {
                $table->dropColumn('quantity');
            }

            if (Schema::hasColumn('sales', 'price')) {
                $table->dropColumn('price');
            }
        });
    }

    public function down(): void
    {
        Schema::table('sales', function (Blueprint $table) {
            // Recria as colunas antigas (caso precise reverter)
            $table->foreignId('product_id')->nullable()->constrained()->onDelete('set null');
            $table->integer('quantity')->nullable();
            $table->decimal('price', 10, 2)->nullable();
        });
    }
};
