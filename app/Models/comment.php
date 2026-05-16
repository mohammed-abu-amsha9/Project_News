<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class comment extends Model
{
    use HasFactory;

    // التعليق كتبه مستخدم واحد
    public function user()
    {
        return $this->belongsTo(user::class);
    }

    // التعليق تابع لمقال واحد
    public function article()
    {
        return $this->belongsTo(article::class);
    }

    // التعليق قد يكون محظورًا (له سجل في جدول الحظر)
    public function block()
    {
        return $this->hasOne(blockedComment::class);
    }

    // التعليقات التابعة (الردود)
    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }


    // التعليق الأصل (الذي يتم الرد عليه)
    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    public function likes()
    {
        return $this->hasMany(commentLike::class);
    }
}
