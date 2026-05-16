<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class articleImage extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $fillable = ['path'];


    public function article()
    {
        return $this->belongsTo(article::class);
    }

}
