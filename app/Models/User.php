<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $guard_name = 'web';  // هذا مهم لتحديد الـ guard

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'email_verified_at',
        'last_login_at',
        'password_changed_at',
        'created_at',
        'updated_at',
        'deleted_at',
        'image'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // كل مستخدم يمكنه كتابة عدة مقالات
    public function articles()
    {
        return $this->hasMany(article::class, 'created_by');
    }

    // كل مستخدم يمكنه كتابة عدة تعليقات
    public function comments()
    {
        return $this->hasMany(comment::class);
    }

    // كل مستخدم يمكنه عمل إعجابات عديدة على المقالات
    public function articleLikes()
    {
        return $this->hasMany(articleLike::class);
    }

    // كل مستخدم (محرر/مشرف) يمكنه رفض عدة مقالات
    public function rejectedArticles()
    {
        return $this->hasMany(rejectArticle::class, 'rejected_by');
    }

    // كل مستخدم (محرر/مشرف) يمكنه حظر عدة تعليقات
    public function blockedComments()
    {
        return $this->hasMany(blockedComment::class, 'blocked_by');
    }

    /**
     * Find the user instance for the given username.
     */
    public function findForPassport(string $username): User
    {
        return $this->where('email', $username)->first();
    }

    /**
     * Validate the password of the user for the Passport password grant.
     */
    public function validateForPassportPasswordGrant(string $password): bool
    {
        return Hash::check($password, $this->password);
    }
}
