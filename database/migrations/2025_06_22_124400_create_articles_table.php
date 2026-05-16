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
        Schema::create('articles', function (Blueprint $table) {
            // المقالات
            $table->engine = 'InnoDB';
            $table->id();
            $table->string('title');
            $table->string('info', 1000);
            $table->string('Short_description');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['draft', 'published', 'deleted'])->default('draft'); // معلق - منشور - محذوف
            $table->unsignedBigInteger('views')->default(0)->comment('عدد مرات مشاهدة الخبر');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
