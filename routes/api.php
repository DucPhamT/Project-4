<?php

use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('testing', function () {
    return 'this is a testing';
});


Route::get('add-post', [PostController::class, 'store']);

Route::get('show-post', [PostController::class, 'index']);

Route::put('update/{id}', [PostController::class, 'update']);

Route::delete('delete/{id}', [PostController::class, 'delete']);

Route::get('top-five-users', [PostController::class, 'topFiveUser']);

Route::get('post-without-comment', [PostController::class, 'postNoComment']);
