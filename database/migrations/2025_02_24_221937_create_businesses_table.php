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
        Schema::create('businesses', function (Blueprint $table) {
            $table->id()->startingValue(1000);
            $table->string('name');
            $table->string('website')->unique();
            $table->string('domain')->unique();
            $table->string('logo')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('short_description');
            $table->longText('description')->nullable();
            $table->text('tags')->nullable();
            $table->string('address_line_1')->nullable();
            $table->string('address_line_2')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zip')->nullable();
            $table->string('country')->nullable();
            $table->text('social_links')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->boolean('is_trending')->default(false);
            $table->boolean('is_best_rating')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->decimal('avg_ratings', 2, 1)->default(0);
            $table->unsignedBigInteger('total_reviews')->default(0);
            $table->unsignedInteger('avg_ratings')->default(0);
            $table->unsignedInteger('total_views')->default(0);
            $table->unsignedInteger('current_month_views')->default(0);
            $table->foreignId('business_owner_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->nullable()->constrained('categories')->onDelete('cascade');
            $table->tinyInteger('status')->default(1)->comment('0:Suspended 1:Active');
            $table->timestamps();
        });

        Schema::create('business_business_owner', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_id')->constrained()->onDelete('cascade');
            $table->foreignId('business_owner_id')->constrained()->onDelete('cascade');
            $table->enum('role', array_column(BusinessRole::cases(), 'value'));
            $table->timestamps();
        });

        Schema::create('business_views', function (Blueprint $table) {
            $table->id();
            $table->string('ip');
            $table->string('referrer')->nullable();
            $table->foreignId('business_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('business_sub_sub_category', function (Blueprint $table) {
            $table->id();
            $table->foreignId('business_id')->constrained('businesses')->onDelete('cascade');
            $table->foreignId('sub_sub_category_id')->constrained('sub_sub_categories')->onDelete('cascade');
        });

        Schema::create('business_employees', function (Blueprint $table) {
            $table->id();
            $table->string('email')->nullable();
            $table->enum('role', array_column(BusinessRole::cases(), 'value'));
            $table->string('token')->unique()->nullable();
            $table->tinyInteger('status')->default(1)->comment('1:Pending 2:Active');
            $table->foreignId('business_id')->constrained()->onDelete('cascade');
            $table->foreignId('business_owner_id')->nullable()->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('business_notifications', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('image');
            $table->string('link')->nullable();
            $table->boolean('status')->default(false);
            $table->foreignId('business_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('business_reviews', function (Blueprint $table) {
            $table->id()->startingValue(1000);
            $table->string('title', 100);
            $table->longText('body');
            $table->dateTime('experience_date');
            $table->unsignedInteger('stars');
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->unsignedBigInteger('likes')->default(0);
            $table->tinyInteger('status')->default(1)->comment('1:Pending 2:Published');
            $table->string('ip_address')->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('business_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('business_review_replies', function (Blueprint $table) {
            $table->id();
            $table->longText('body');
            $table->foreignId('business_review_id')->constrained()->onDelete('cascade');
            $table->foreignId('business_owner_id')->constrained()->onDelete('cascade');
            $table->foreignId('business_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('business_review_reports', function (Blueprint $table) {
            $table->id()->startingValue(1000);
            $table->longText('reason');
            $table->foreignId('business_review_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('business_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('businesses');
        Schema::dropIfExists('business_business_owner');
        Schema::dropIfExists('business_views');
        Schema::dropIfExists('business_sub_sub_category');
        Schema::dropIfExists('business_employees');
        Schema::dropIfExists('business_notifications');
        Schema::dropIfExists('business_reviews');
        Schema::dropIfExists('business_review_replies');
        Schema::dropIfExists('business_review_reports');
    }
};
