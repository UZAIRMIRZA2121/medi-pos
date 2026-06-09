<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create("medicines", function (Blueprint $table) {
            $table->id();
            $table->foreignId("category_id")->constrained()->onDelete("cascade");
            $table->foreignId("supplier_id")->nullable()->constrained()->onDelete("set null");
            $table->string("name");
            $table->string("generic_name")->nullable();
            $table->string("company")->nullable();
            $table->string("batch_number")->nullable();
            $table->string("barcode")->nullable();
            $table->decimal("purchase_price", 10, 2)->default(0);
            $table->decimal("sale_price", 10, 2)->default(0);
            $table->integer("stock_quantity")->default(0);
            $table->integer("low_stock_level")->default(10);
            $table->date("expiry_date")->nullable();
            $table->date("mfg_date")->nullable();
            $table->string("rack")->nullable();
            $table->boolean("requires_prescription")->default(false);
            $table->text("description")->nullable();
            $table->timestamps();
        });
    }
    public function down() {
        Schema::dropIfExists("medicines");
    }
};