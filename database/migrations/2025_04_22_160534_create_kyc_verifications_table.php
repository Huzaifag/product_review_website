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
        Schema::create('kyc_verifications', function (Blueprint $table) {
            $table->bigIncrements('id')->startingValue(1000);
            $table->enum('document_type', ['national_id', 'passport']);
            $table->string('document_number', 30);
            $table->text('documents');
            $table->tinyInteger('status')->default(1)->comment('1:Pending 2:Approved 3:Rejected');
            $table->text('rejection_reason')->nullable();
            $table->foreignId('business_owner_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kyc_verifications');
    }
};
