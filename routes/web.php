<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/check-db', function () {
    try {
        $db = DB::connection()->getDatabaseName();
        return "Đang kết nối đến database: " . $db;
    } catch (Exception $e) {
        return "Không thể kết nối DB: " . $e->getMessage();
    }
});