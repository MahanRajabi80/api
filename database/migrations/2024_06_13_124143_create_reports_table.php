<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use \App\Models\Reason;
use \App\Models\Review;
use \App\Models\Comment;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Reason::class, 'reason_id');
            $table->foreignIdFor(Review::class, 'review_id');
            $table->foreignIdFor(Comment::class, 'comment_id')->nullable();
            $table->text('description')->nullable();
            $table->enum('content_type', ['REVIEW', 'INTERVIEW', 'COMMENT'])->default('REVIEW');
            $table->enum('report_status', ['PENDING', 'REJECT', 'ACCEPT'])->default('PENDING');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
