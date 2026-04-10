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
        Schema::create('payment_gateways', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('alias')->unique();
            $table->string('logo');
            $table->integer('fees')->default(0);
            $table->string('currency')->nullable();
            $table->decimal('rate', 28, 9)->nullable();
            $table->longText('credentials')->nullable();
            $table->longText('parameters')->nullable();
            $table->enum('mode', ['sandbox', 'live'])->nullable();
            $table->longText('instructions')->nullable();
            $table->boolean('type')->default(false);
            $table->boolean('status')->default(false);
            $table->bigInteger('sort_id')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_gateways');
    }
};
