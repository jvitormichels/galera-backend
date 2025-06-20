<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\{
    UserAuthController,
    PostsController,
    FollowsController,
    UsersController,
    CommentsController
};


Route::prefix('auth')->group(function () {
    Route::post('register', [UserAuthController::class, 'register']);
    Route::post('login', [UserAuthController::class, 'login']);
    Route::middleware('auth:sanctum')->post('logout', [UserAuthController::class, 'logout']);
    Route::middleware('auth:sanctum')->group(function () { Route::get('/user', [UserAuthController::class, 'show']); });
});



Route::prefix('users')->group(function () {
    Route::middleware('auth:sanctum')->group(function () {
        Route::put('/', [UsersController::class, 'update']);
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


Route::prefix('posts')->group(function () {
    Route::get('/{post}', [PostsController::class, 'show']);
    Route::get('/{post}/comments', [CommentsController::class, 'index']);
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/', [PostsController::class, 'timeline']);
        Route::post('/', [PostsController::class, 'store']);
        Route::delete('/{post}', [PostsController::class, 'destroy']);
        
        Route::post('/{post}/comments', [CommentsController::class, 'store']);
        Route::delete('/{post}/comments/{comment}', [CommentsController::class, 'destroy'])->scopeBindings();;
    });
});