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
        Schema::create('users', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            // نوع قاعدة البيانات: InnoDB تدعم العلاقات (FK) والمعاملات
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('image');
            $table->string('mobile');
            $table->string('location');
            $table->timestamp('last_login_at')->nullable();// تاريخ آخر تسجيل دخول
            $table->timestamp('password_changed_at')->nullable();// تاريخ آخر تغيير لكلمة المرور
            $table->rememberToken(); // تذكرني
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
