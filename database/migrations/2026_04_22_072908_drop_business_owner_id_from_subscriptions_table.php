<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasColumn('subscriptions', 'business_owner_id')) {
            return;
        }

        $foreignKey = DB::table('information_schema.TABLE_CONSTRAINTS')
            ->where('TABLE_SCHEMA', DB::raw('DATABASE()'))
            ->where('TABLE_NAME', 'subscriptions')
            ->where('CONSTRAINT_TYPE', 'FOREIGN KEY')
            ->where('CONSTRAINT_NAME', 'subscriptions_business_owner_id_foreign')
            ->exists();

        Schema::table('subscriptions', function (Blueprint $table) use ($foreignKey) {
            if ($foreignKey) {
                $table->dropForeign('subscriptions_business_owner_id_foreign');
            }

            $table->dropColumn('business_owner_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (!Schema::hasColumn('subscriptions', 'business_owner_id')) {
            Schema::table('subscriptions', function (Blueprint $table) {
                $table->unsignedBigInteger('business_owner_id')->nullable()->after('id');
            });
        }

        $foreignKey = DB::table('information_schema.TABLE_CONSTRAINTS')
            ->where('TABLE_SCHEMA', DB::raw('DATABASE()'))
            ->where('TABLE_NAME', 'subscriptions')
            ->where('CONSTRAINT_TYPE', 'FOREIGN KEY')
            ->where('CONSTRAINT_NAME', 'subscriptions_business_owner_id_foreign')
            ->exists();

        if (!$foreignKey) {
            Schema::table('subscriptions', function (Blueprint $table) {
                $table->foreign('business_owner_id')
                    ->references('id')
                    ->on('business_owners')
                    ->cascadeOnDelete();
            });
        }
    }
};
