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
        Schema::create('test_attributes', function (Blueprint $table) {
            $table->id();
            //name
            $table->string('name')->nullable();
            //type default text
            $table->string('type')->default('text')->nullable();
            //options
            $table->json('options')->nullable();
            //status default active
            $table->enum('status', ['active', 'inactive'])->default('active')->nullable();
            //deleted at
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('test_attributes');
    }
};
