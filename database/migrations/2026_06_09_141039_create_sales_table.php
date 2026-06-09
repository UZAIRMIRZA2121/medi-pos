<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create("sales", function (Blueprint $table) {
            $table->id();
            $table->foreignId("customer_id")->nullable()->constrained()->onDelete("set null");
            $table->string("invoice_number")->unique();
            $table->integer("total_items");
            $table->decimal("subtotal", 10, 2);
            $table->decimal("discount_percent", 5, 2)->default(0);
            $table->decimal("tax_percent", 5, 2)->default(0);
            $table->decimal("grand_total", 10, 2);
            $table->decimal("paid_amount", 10, 2)->default(0);
            $table->decimal("due_amount", 10, 2)->default(0);
            $table->decimal("return_amount", 10, 2)->default(0);
            $table->string("payment_method")->default("cash");
            $table->text("notes")->nullable();
            $table->timestamps();
        });
    }
    public function down() {
        Schema::dropIfExists("sales");
    }
};