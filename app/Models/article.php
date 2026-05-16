<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class article extends Model
{
    use HasFactory;

    // App\Models\Article
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // المقال مرتبط بمستخدم واحد ككاتب (مستخدم يملك المقال)
    public function author()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // المقال يحتوي على عدة تعليقات
    public function comments()
    {
        return $this->hasMany(comment::class)->with('user');
    }

    // المقال مرتبط بتصنيف واحد فقط
    public function category()
    {
        return $this->belongsTo(category::class);
    }

    // المقال يحتوي على عدة إعجابات من المستخدمين
    public function likes()
    {
        return $this->hasMany(articleLike::class);
    }

    // المقال يمكن أن يُرفض عدة مرات (مع أسباب مختلفة)
    public function rejections()
    {
        return $this->hasMany(rejectArticle::class);
    }

    // المقال يحتوي على عدة تعليقات تم حظرها
    public function blockedComments()
    {
        return $this->hasMany(blockedComment::class);
    }

    // المقال بحتوي على عدة صور
    public function images()
    {
        return $this->hasMany(articleImage::class);
    }


}
