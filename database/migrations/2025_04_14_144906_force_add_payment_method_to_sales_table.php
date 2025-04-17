<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasColumn('sales', 'payment_method')) {
            Schema::table('sales', function (Blueprint $table) {
                $table->string('payment_method')->after('sale_date')->nullable();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('sales', 'payment_method')) {
            Schema::table('sales', function (Blueprint $table) {
                $table->dropColumn('payment_method');
            });
        }
    }
};
