<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\{
    UserAuthController,
    PostsController,
    FollowsController
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
        // Route::get('/', [PostsController::class, 'index']);
        Route::post('/', [PostsController::class, 'store']);
        Route::delete('/{post}', [PostsController::class, 'destroy']);
    });
});

Route::prefix('users/{user}')->namespace('App\Http\Controllers')->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/posts', [PostsController::class, 'userPosts']);
        Route::get('/followers', [FollowsController::class, 'followers']);
        Route::get('/following', [FollowsController::class, 'following']);
        Route::post('/follow', [FollowsController::class, 'store']);
        Route::delete('/follow', [FollowsController::class, 'destroy']);
    });
});