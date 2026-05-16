<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class category extends Model
{
    use HasFactory;

    // التصنيف يحتوي على عدة مقالات
    public function articles()
    {
        return $this->hasMany(article::class);
    }
}
