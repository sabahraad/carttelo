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
        Schema::table('products', function (Blueprint $table) {
            $table->decimal('buy_price', 10, 2)->nullable()->after('stock');
            $table->decimal('sell_price', 10, 2)->nullable()->after('buy_price');
            $table->decimal('discount_price', 10, 2)->nullable()->after('sell_price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['buy_price', 'sell_price', 'discount_price']);
        });
    }
};
