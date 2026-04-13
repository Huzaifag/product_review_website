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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->foreignId('sub_category_id')->nullable()
                ->constrained()->nullOnDelete();
            //  -- Basic info
            $table->string('name');               // "Weleda Skin Food Body Butter"
            $table->string('slug')->unique();     // "weleda-skin-food-body-butter"
            $table->string('brand_name', 191);    // "Weleda"
            $table->text('description')->nullable();

            //  -- Pricing
            $table->decimal('price', 8, 2)->nullable();
            $table->string('currency', 3)->default('GBP');
            $table->string('product_size')->nullable();   // "50ml"
            //  -- Certifications
            $table->boolean('organic_certified')->default(false);
            $table->string('organic_certifier')->nullable(); // "NATRUE", "COSMOS"

            //  -- ÖKO-TEST grading
            $table->enum('overall_grade', [
                'very_good',
                'good',
                'satisfactory',
                'adequate',
                'poor',
                'failing'
            ])->nullable();


            // -- INCI ingredient list (full declaration)
            $table->text('ingredients_inci')->nullable();

            //    -- Test metadata
            $table->boolean('lab_verified')->default(false);
            $table->date('test_date')->nullable();
            $table->string('test_year', 4)->nullable();     //   -- "2023"
            $table->string('test_edition')->nullable();        //   -- "J2212"
            $table->integer('magazine_page')->nullable();      //   -- page number in magazine


            //   -- Flags
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);
            $table->integer('view_count')->default(0);

            $table->timestamps();
            $table->softDeletes();

            //   -- Indexes for fast filtering
            $table->index('overall_grade');
            $table->index('brand_name');
            $table->index('organic_certified');
            $table->index('test_year');
            $table->index('is_featured');
            $table->index(['category_id', 'overall_grade']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
