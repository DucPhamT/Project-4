<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('testing', function () {
    return 'this is a testing';
});

Route::prefix('posts')->group(function () {
    // require sanctum auth (personal access token) for creating posts
    Route::post('add-post', [PostController::class, 'store'])->middleware('auth:sanctum');

    Route::get('show-post', [PostController::class, 'index']);

    Route::put('update-post/{id}', [PostController::class, 'update']);

    Route::delete('delete/{id}', [PostController::class, 'delete']);

    Route::get('top-five-users', [PostController::class, 'topFiveUser']);

    Route::get('post-without-comment', [PostController::class, 'postNoComment']);

    Route::get('category/{category}', [PostController::class, 'getPostFromCategory']);

    Route::get('count-categorized-post/{category}', [PostController::class, 'countPostsWithCategories']);

    Route::get('get-post', [PostController::class, 'getPost']);
});

// Route::get('create', [PostController::class, 'create']);



Route::prefix('users')->group(function () {
    Route::get('top-five-users', [UserController::class, 'topFiveUser']);

    Route::get('commenter-without-post', [UserController::class, 'commentersWithoutPosts']);
    Route::get('get-latest-post', [UserController::class, 'getUserLatestPost']);

});
