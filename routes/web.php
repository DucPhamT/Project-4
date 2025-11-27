<?php
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;

use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});



Route::middleware('auth')->group(function () {
    // login
    Route::post('/logout', [AuthController::class, 'logout']);

    // homepage
    Route::get('/homepage', [HomeController::class, 'index']);

    // homepage->create_post
    Route::get('/create-post', [PostController::class, 'createPost'])->name('create-post');
    // homepage->show_posts
    Route::get('/show-posts', [PostController::class, 'showPost'])->name('show-posts');
    // homepage->delete_post
    Route::delete('/delete-post/{id}', [PostController::class, 'deletePost'])->name('delete-post');

    // homepage->update_post
    Route::get('/edit-post/{post}', [PostController::class, 'editPost'])->name('edit-post');

    Route::put('/update-post/{id}', [PostController::class, 'updatePost']);
    //Route::put()


});



Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
