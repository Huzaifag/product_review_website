<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */

    public function up(): void
    {
        Schema::create('user_product_view_counts', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address', 45)->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('plan_id')->nullable();
            $table->unsignedBigInteger('subscription_id')->nullable();
            $table->integer('products_viewed')->default(0);
            $table->json('product_ids')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('plan_id')->references('id')->on('plans')->onDelete('set null');
            $table->foreign('subscription_id')->references('id')->on('subscriptions')->onDelete('set null');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_product_view_counts');
    }
};
