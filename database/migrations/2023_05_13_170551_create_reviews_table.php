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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->integer('company_id');
            $table->integer('approved_by')->nullable();
            $table->enum('review_type', ['REVIEW', 'INTERVIEW'])->default('REVIEW');
            $table->string('title', 250);
            $table->string('job_title', 250)->nullable();
            $table->text('description');
            $table->integer('salary')->nullable();
            $table->smallInteger('rate')->nullable()->default(0);
            $table->date('start_date')->nullable(); // تاریخ شروع همکاری یا زمان مصاحبه
            $table->string('edit_key', 250)->nullable();
            $table->enum('review_status', ['NO_RESPONSE', 'REJECT', 'ACCEPT', 'WORKING', 'NOT_WORKING'])
                ->nullable()->default('NOT_WORKING');
            $table->enum('status', ['PENDING', 'PUBLISH', 'REMOVE', 'SPAM'])->default('pending');
            $table->boolean('sexual_harassment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
