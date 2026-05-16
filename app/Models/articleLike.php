<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class articleLike extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'article_likes';

    // الإعجاب قام به مستخدم واحد
    public function user()
    {
        return $this->belongsTo(user::class);
    }

    // الإعجاب مرتبط بمقال واحد
    public function article()
    {
        return $this->belongsTo(article::class);
    }
}
