<?php

namespace App\Policies;

use App\Models\User;
use App\Models\article;
use Illuminate\Auth\Access\Response;

class ArticlePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
        return $user->hasPermissionTo('Read Articles');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, article $article): bool
    {
        //
        return $user->hasPermissionTo('Read One Article');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
        return $user->hasPermissionTo('Create Article');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, article $article): bool
    {
        //
        return $user->hasPermissionTo('Edit Article');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, article $article): bool
    {
        //
        // dd($user->getPermissionNames()); // أو hasPermissionTo(...)
        return $user->hasPermissionTo('Delete Article');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, article $article): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, article $article): bool
    {
        //
    }

    public function draftsArticle(User $user, article $article)
    {
        return $user->hasPermissionTo('Drafts Article');
    }

    public function deleted_article(User $user, article $article)
    {
        return $user->hasPermissionTo('Deleted Articles');
    }
}
