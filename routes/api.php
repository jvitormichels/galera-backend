<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\{
    UserAuthController,
    PostsController
};


Route::prefix('auth')->group(function () {
    Route::post('register', [UserAuthController::class, 'register']);
    Route::post('login', [UserAuthController::class, 'login']);
    Route::middleware('auth:sanctum')->post('logout', [UserAuthController::class, 'logout']);
    Route::middleware('auth:sanctum')->group(function () { Route::get('/user', [UserAuthController::class, 'show']); });
});

Route::prefix('posts')->group(function () {
    Route::get('/{post}', [PostsController::class, 'show']);
    
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/', [PostsController::class, 'index']);
        Route::post('/', [PostsController::class, 'store']);
        Route::put('/{post}', [PostsController::class, 'update']);
        Route::delete('/{post}', [PostsController::class, 'destroy']);
    });
});
