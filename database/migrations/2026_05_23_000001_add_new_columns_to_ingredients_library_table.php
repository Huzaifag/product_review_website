<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ingredients_library', function (Blueprint $table) {
            $table->text('description')->nullable()->after('concern_description');
            $table->boolean('oko_verified')->default(false)->after('is_published');
            $table->integer('hazard_score')->nullable()->after('oko_verified');
            $table->json('concerns')->nullable()->after('hazard_score');
            $table->json('functions')->nullable()->after('concerns');
            $table->json('synonyms')->nullable()->after('functions');
            $table->json('concern_flags')->nullable()->after('synonyms');
            $table->text('image_url')->nullable()->after('concern_flags');
            $table->text('source')->nullable()->after('image_url');
            $table->boolean('inhalation_risk_flag')->default(false)->after('source');
        });
    }

    public function down(): void
    {
        Schema::table('ingredients_library', function (Blueprint $table) {
            $table->dropColumn([
                'description',
                'oko_verified',
                'hazard_score',
                'concerns',
                'functions',
                'synonyms',
                'concern_flags',
                'image_url',
                'source',
                'inhalation_risk_flag',
            ]);
        });
    }
};
