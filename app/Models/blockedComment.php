<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class blockedComment extends Model
{
    use HasFactory, SoftDeletes;

    // التعليق المحظور مرتبط بتعليق واحد
    public function comment()
    {
        return $this->belongsTo(comment::class);
    }

    // التعليق المحظور مرتبط بمقال واحد (للسهولة في الاستعلام)
    public function article()
    {
        return $this->belongsTo(article::class);
    }

    // الحظر تم بواسطة مستخدم (محرر/مشرف)
    public function blockedBy()
    {
        return $this->belongsTo(User::class, 'blocked_by');
    }
}
