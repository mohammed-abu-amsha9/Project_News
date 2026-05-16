<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ArticleLikeController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\BlockedCommentController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CommentLikeController;
use App\Http\Controllers\contactController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\userController;
use App\Models\articleLike;
use App\Models\blockedComment;
use App\Models\category;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });


Route::prefix('new')->middleware('guest')->group(function () {
    // Route::prefix('new')->group(function(){
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/forgotPassword', [AuthController::class, 'forgotPassword'])->name('forgot-password');
    Route::post('/forgotPassword', [AuthController::class, 'sendResetEamil'])->name('sendResetEamil');
    Route::get('/forgot-password/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
    Route::get('/register', [AuthController::class, 'registerUser'])->name('register');
    Route::post('/addUser', [userController::class, 'addUserRegister'])->name('add-user');
});



Route::prefix('new')->middleware(['auth', 'verified'])->group(function () {
    // Route::prefix('new')->group(function(){

    Route::view('/', 'news.home')->name('home');
    Route::view('/allNews', 'news.all-news')->name('news-all-news');
    Route::view('/newsDetailes', 'news.news-detailes')->name('news-news-detailes');
    Route::view('/contact', 'news.contact')->name('news-contact');

    Route::resource('/categories', CategoryController::class);
    Route::resource('/users', userController::class);
    Route::resource('/articles', ArticleController::class);
    Route::resource('/comments', CommentController::class);
    Route::resource('/articleLikes', ArticleLikeController::class);
    Route::resource('/blockedComments', BlockedCommentController::class);

    Route::put('/role-permissions', [RoleController::class, 'updateRolePermission'])->name('role-update-permission');
    Route::resource('/roles', RoleController::class);
    Route::get('/users/{user}/permissions/edit', [UserController::class, 'editUserPermission'])->name('users.permissions.edit');
    Route::post('/users/{user}/permissions/update', [UserController::class, 'updateUserPermission'])->name('users.permissions.update');

    Route::resource('/permissions', PermissionController::class);
    Route::resource('/commentLikes', CommentLikeController::class);

    Route::get('/articlesDrafts', [ArticleController::class, 'drafts'])->name('articles.drafts');
    Route::get('/articlesDelete', [ArticleController::class, 'deletedArticle'])->name('articles.deleted');
    Route::patch('/articles/{article}/publish', [ArticleController::class, 'publish'])->name('articles.publish');
    Route::patch('/articles/{article}/delete', [ArticleController::class, 'delete'])->name('articles.delete');

    Route::get('/local-news', [ArticleController::class, 'localNews'])->name('news.local');
    Route::get('/sport-news', [ArticleController::class, 'sportNews'])->name('news.sport');
    Route::get('/international-news', [ArticleController::class, 'internationalNews'])->name('news.international');

    Route::put('/comments/{comment}/block', [BlockedCommentController::class, 'block'])->name('comments.block');
    Route::post('/comments/{comment}/recover', [BlockedCommentController::class, 'recover'])->name('comments.recover');

    Route::get('/profile', [userController::class, 'showProfile'])->name('user.profile');

    Route::post('/contact/send', [contactController::class, 'send'])->name('contact.send');
    Route::put('/users/{user}/crop-image', [UserController::class, 'cropImage'])->name('users.cropImage'); // لقص الصورة



    Route::get('/editPassword', [AuthController::class, 'editPassword'])->name('edit-password');
    Route::put('/updatePassword', [AuthController::class, 'updatePassword'])->middleware('throttle:3,3')->name('update-password');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::prefix('new')->middleware('auth')->group(function () {
    Route::get('/verification-notice', [AuthController::class, 'verificationNotice'])->name('verification.notice');
    Route::get('/verification-request', [AuthController::class, 'verificationRequest'])->middleware('throttle:3,3')->name('verification.request');
    Route::get('/verification-verify/{id}/{hash}', [AuthController::class, 'verificationVerify'])->middleware('signed')->name('verification.verify');
});
