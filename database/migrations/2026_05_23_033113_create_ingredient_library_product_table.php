<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Foreign keys require InnoDB; parent tables may have been created without it.
        DB::statement('ALTER TABLE `products` ENGINE=InnoDB');
        DB::statement('ALTER TABLE `ingredients_library` ENGINE=InnoDB');

        Schema::create('ingredient_library_product', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->foreignId('product_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('ingredient_library_id')
                ->constrained('ingredients_library')
                ->cascadeOnDelete();
                

            $table->primary(['product_id', 'ingredient_library_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ingredient_library_product');
    }
};
