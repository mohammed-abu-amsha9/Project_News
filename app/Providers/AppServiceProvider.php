<?php

namespace App\Providers;

use App\Models\article;
use App\Models\category;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        Schema::defaultStringLength(191);
        Passport::personalAccessTokensExpireIn(Carbon::now()->addMonth());

        view::composer('news.home', function ($view) {

            $lastArticles = article::where('status', 'published')
                ->latest()
                ->take(3)
                ->get();
            $view->with('lastArticles', $lastArticles);

            $localArticles = Article::whereHas('category', function ($query) {
                $query->where('name', 'Local News');
            })->where('status', 'published')
                ->latest()
                ->take(6)
                ->get();
            $view->with('localArticles', $localArticles);

            $sportArticles = Article::whereHas('category', function ($query) {
                $query->where('name', 'Sport News');
            })->where('status', 'published')
                ->latest()
                ->take(6)
                ->get();
            $view->with('sportArticles', $sportArticles);

            $internationalArticles = Article::whereHas('category', function ($query) {
                $query->where('name', 'International News');
            })->where('status', 'published')
                ->latest()
                ->take(6)
                ->get();
            $view->with('internationalArticles', $internationalArticles);

            $mostLikedArticle = Article::with('images')
                ->withCount('likes')
                ->orderByDesc('likes_count')
                ->first();
            $view->with('mostLikedArticle', $mostLikedArticle);
        });
    }
}
