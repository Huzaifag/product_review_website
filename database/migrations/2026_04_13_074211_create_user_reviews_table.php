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
        // User comments on test results (text reviews only).
        Schema::create('user_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            $table->string('title')->nullable();
            $table->text('body');
            $table->boolean('is_helpful')->nullable(); // null = not voted
            $table->integer('helpful_count')->default(0);
            $table->boolean('is_approved')->default(false);
            $table->boolean('is_flagged')->default(false);

            $table->timestamps();
            $table->softDeletes();

            $table->unique(['product_id', 'user_id']); // One comment per product per user.
            $table->index('is_approved');
        });

        // User bookmarks / saved products.
        Schema::create('saved_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['user_id', 'product_id']);
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('saved_products');
        Schema::dropIfExists('user_reviews');
    }
};
