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
        Schema::create('packages', function (Blueprint $table) {
            $table->id();

            $table->string('name'); // Starter Cloud, Business Lifetime, Enterprise Offline
            $table->string('slug')->unique();

            $table->decimal('price', 10, 2);

            $table->enum('billing_type', [
                'monthly',
                'yearly',
                'one_time'
            ])->default('monthly');

            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();

            $table->boolean('is_cloud')->default(false);
            $table->boolean('is_offline')->default(false);
            $table->boolean('lifetime_license')->default(false);
            $table->boolean('hosting_included')->default(false);
            $table->boolean('support_included')->default(true);
            $table->boolean('free_updates')->default(true);

            $table->integer('trial_days')->default(0);

            $table->enum('status', ['active', 'inactive'])
                  ->default('active');

            $table->integer('sort_order')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
