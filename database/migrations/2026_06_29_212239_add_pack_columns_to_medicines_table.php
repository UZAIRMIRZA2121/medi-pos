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
        Schema::table('medicines', function (Blueprint $table) {
            $table->decimal("pack_purchase_price", 10, 2)->nullable()->default(0)->after("barcode");
            $table->decimal("pack_sale_price", 10, 2)->nullable()->default(0)->after("pack_purchase_price");
            $table->integer("pack_stock_quantity")->nullable()->default(0)->after("pack_sale_price");
            $table->integer("items_per_pack")->nullable()->default(1)->after("pack_stock_quantity");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('medicines', function (Blueprint $table) {
            $table->dropColumn([
                'pack_purchase_price',
                'pack_sale_price',
                'pack_stock_quantity',
                'items_per_pack'
            ]);
        });
    }
};
