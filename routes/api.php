<?php

use App\Http\Controllers\Auth\ApiAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('auth')->group(function(){
    Route::post('/login', [ApiAuthController::class, 'Login']);
    Route::post('/login-pt', [ApiAuthController::class, 'LoginPT']);
    Route::post('/login-pgct', [ApiAuthController::class, 'LoginPGCT']);
});

Route::prefix('auth')->middleware('auth:api')->group(function(){
    Route::put('/changePassword', [ApiAuthController::class, 'changePassword']);
    Route::get('/logout', [ApiAuthController::class, 'Logout']);
});
