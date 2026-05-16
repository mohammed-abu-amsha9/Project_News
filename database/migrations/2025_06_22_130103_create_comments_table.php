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
        Schema::create('comments', function (Blueprint $table) {
            // التعليقات
            $table->engine = 'InnoDB';
            $table->id();
            $table->string('comment');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('article_id')->constrained()->onDelete('cascade');
            // $table->unsignedBigInteger('parent_id')->nullable(); //رد على التعليق
            // $table->foreign('parent_id')->references('id')->on('comments')->onDelete('cascade');
            $table->boolean('visible')->default(true)->comment('هل التعليق ظاهر للعامة؟');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
