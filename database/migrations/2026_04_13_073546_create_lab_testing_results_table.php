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
        // Core test result table per product.
        Schema::create('lab_testing_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();

            // Row 1: Mineral UV filters (none | Zinc Oxide | Titanium Dioxide)
            $table->string('mineral_uv_filter')->nullable();

            // Row 2: Concerning chemical UV filters
            $table->boolean('concerning_uv_filter')->default(false);

            // Row 3: Fragrance / essential oils
            $table->boolean('has_fragrance')->default(false);

            // Row 4: Further concerning ingredients
            $table->boolean('further_concerns')->default(false);
            $table->string('further_concerns_detail')->nullable();

            // Ingredient test grade
            $table->enum('ingredient_grade', [
                'very_good',
                'good',
                'satisfactory',
                'adequate',
                'poor',
                'failing',
            ])->nullable();

            // Row 5: Plastic compounds in formula
            $table->boolean('plastic_compounds')->default(false);

            // Row 6: Further defects
            $table->boolean('further_defects')->default(false);
            $table->string('further_defects_detail')->nullable();

            // Defects test grade
            $table->enum('defects_grade', [
                'very_good',
                'good',
                'satisfactory',
                'adequate',
                'poor',
                'failing',
            ])->nullable();

            // Overall grade (final verdict)
            $table->enum('overall_grade', [
                'very_good',
                'good',
                'satisfactory',
                'adequate',
                'poor',
                'failing',
            ])->nullable();

            // Footnotes and metadata
            $table->string('footnote_ref')->nullable();
            $table->text('footnote_text')->nullable();
            $table->text('test_summary')->nullable();
            $table->date('tested_at')->nullable();
            $table->string('lab_name')->nullable();

            $table->timestamps();

            $table->index('overall_grade');
            $table->index('ingredient_grade');
        });

        // Master reference table for known concerning ingredients.
        Schema::create('ingredients_library', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('inci_name')->nullable();
            $table->string('slug')->unique();

            $table->enum('severity', ['avoid', 'concern', 'caution']);
            $table->text('concern_description');
            $table->text('health_effects')->nullable();
            $table->text('regulatory_status')->nullable();
            $table->string('cas_number')->nullable();

            $table->integer('found_in_count')->default(0);
            $table->boolean('is_published')->default(true);
            $table->timestamps();

            $table->index('severity');
            $table->index('found_in_count');
        });

        // Per-product flagged ingredients.
        Schema::create('ingredient_concerns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->foreignId('ingredient_library_id')
                ->nullable()
                ->constrained('ingredients_library')
                ->nullOnDelete();

            $table->string('ingredient_name');
            $table->string('inci_name')->nullable();
            $table->enum('severity', ['avoid', 'concern', 'caution']);
            $table->text('description')->nullable();
            $table->decimal('concentration', 8, 4)->nullable();

            $table->timestamps();
            $table->index('severity');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ingredient_concerns');
        Schema::dropIfExists('ingredients_library');
        Schema::dropIfExists('lab_testing_results');
    }
};
