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
        $tables = ['categories', 'suppliers', 'customers', 'medicines', 'sales', 'sale_items', 'expenses', 'purchase_orders', 'purchase_order_items', 'staff', 'business_settings', 'print_settings'];

        foreach ($tables as $table) {
            if (Schema::hasTable($table) && !Schema::hasColumn($table, 'last_synced_at')) {
                Schema::table($table, function (Blueprint $table) {
                    $table->timestamp('last_synced_at')->nullable();
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tables = ['categories', 'suppliers', 'customers', 'medicines', 'sales', 'sale_items', 'expenses', 'purchase_orders', 'purchase_order_items', 'staff', 'business_settings', 'print_settings'];

        foreach ($tables as $table) {
            if (Schema::hasTable($table) && Schema::hasColumn($table, 'last_synced_at')) {
                Schema::table($table, function (Blueprint $table) {
                    $table->dropColumn('last_synced_at');
                });
            }
        }
    }
};
