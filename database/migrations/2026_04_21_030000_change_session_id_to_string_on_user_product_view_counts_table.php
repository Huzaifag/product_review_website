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
        Schema::table('user_product_view_counts', function (Blueprint $table) {
            // ->after('ip_address') places the column exactly where you want
            // ->nullable() prevents "field has no default value" errors on existing rows
            $table->string('season_id', 191)
                  ->after('ip_address')
                  ->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_product_view_counts', function (Blueprint $table) {
            $table->dropColumn('season_id');
        });
    }
};