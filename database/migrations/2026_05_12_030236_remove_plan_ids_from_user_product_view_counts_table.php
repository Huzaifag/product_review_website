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
                // Drop column safely
            if (Schema::hasColumn('user_product_view_counts', 'plan_ids')) {
                $table->dropColumn('plan_ids');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_product_view_counts', function (Blueprint $table) {
            // Add the column back if it doesn't exist
            if (!Schema::hasColumn('user_product_view_counts', 'plan_ids')) {
                $table->json('plan_ids')->nullable()->after('user_id');
            }
        });
    }
};
