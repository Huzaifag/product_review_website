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
        Schema::table('user_product_view_counts', function (Blueprint $table) {
            // Drop foreign key first
            $table->dropForeign(['plan_id']);

            // remove old column
            $table->dropColumn('plan_id');

            // add new column
            $table->json('plan_ids')->nullable()->after('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_product_view_counts', function (Blueprint $table) {
            // add old column back
            $table->unsignedBigInteger('plan_id')->nullable()->after('user_id');

            // remove new column
            $table->dropColumn('plan_ids');
        });
    }
};
