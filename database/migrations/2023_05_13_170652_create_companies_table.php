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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('slug');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('site')->nullable();
            $table->string('rate')->nullable();
            $table->integer('total_review')->default(0);
            $table->integer('total_interview')->default(0);
            $table->smallInteger('is_famous')->default(0);
            $table->integer('salary_min')->default(0);
            $table->integer('salary_max')->default(0);
            $table->enum('status', ['PENDING', 'PUBLISH', 'DRAFT', 'REMOVE'])->default('PUBLISH');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
