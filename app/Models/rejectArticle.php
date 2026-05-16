<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rejectArticle extends Model
{
    use HasFactory;

    // رفض المقال مرتبط بمقال واحد فقط
    public function article()
    {
        return $this->belongsTo(article::class);
    }

    // رفض المقال تم بواسطة مستخدم (محرر/مشرف)
    public function rejectedBy()
    {
        return $this->belongsTo(User::class, 'rejected_by');
    }
}
