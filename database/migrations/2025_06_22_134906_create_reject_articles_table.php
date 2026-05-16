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
        Schema::create('reject_articles', function (Blueprint $table) {
            // رفض المقالات
            $table->engine = 'InnoDB';
            $table->id();
            $table->foreignId('article_id')->constrained()->onDelete('cascade');
            $table->text('reason'); // سبب
            $table->foreignId('rejected_by')->constrained('users')->onDelete('cascade'); // يشسر الى من رفض المقال
            $table->timestamp('rejected_at')->useCurrent(); // تاريخ ووقت الرفض
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reject_articles');
    }
};
