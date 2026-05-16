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
        Schema::create('blocked_comments', function (Blueprint $table) {
            // حظر التعليق
            $table->engine = 'InnoDB';
            $table->id();
            $table->foreignId('comment_id')->constrained('comments')->onDelete('cascade');// التعليق المحظور
            $table->foreignId('article_id')->constrained('articles')->onDelete('cascade');// رقم الخبر المرتبط بالتعليق
            $table->string('reason')->comment('سبب حظر التعليق');
            $table->foreignId('blocked_by')->constrained('users')->onDelete('cascade');// من قام بالحظر
            $table->timestamp('blocked_at')->useCurrent();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blocked_comments');
    }
};
