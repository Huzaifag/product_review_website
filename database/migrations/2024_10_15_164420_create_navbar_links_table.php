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
        Schema::create('navbar_links', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('link');
            $table->tinyInteger('type')->default(1);
            $table->foreignId('parent_id')->nullable()->constrained('navbar_links')->onDelete('cascade');
            $table->bigInteger('order')->default(0);
            $table->string('lang', 4);
            $table->foreign("lang")->references("code")->on('languages')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('navbar_links');
    }
};