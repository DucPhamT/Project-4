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
    Route::get('add-post', [PostController::class, 'store']);

    Route::get('show-post', [PostController::class, 'index']);

    Route::put('update/{id}', [PostController::class, 'update']);

    Route::delete('delete/{id}', [PostController::class, 'delete']);

    Route::get('top-five-users', [PostController::class, 'topFiveUser']);

    Route::get('post-without-comment', [PostController::class, 'postNoComment']);

    Route::get('category/{category}', [PostController::class, 'getPostFromCategory']);

    Route::get('get-latest-post', [PostController::class, 'getUserLatestPost']);


});
Route::prefix('users')->group(function () {
    Route::get('top-five-users', [PostController::class, 'topFiveUser']);

    Route::get('commenter-without-post', [UserController::class, 'commentersWithoutPosts']);
});
