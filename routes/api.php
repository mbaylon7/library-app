<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\AuthorController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\RatingController;
use App\Http\Controllers\Api\TagController;

// ---------------- Resource Routes ---------------- //
Route::apiResource('books', BookController::class);
Route::apiResource('authors', AuthorController::class);
Route::apiResource('categories', CategoryController::class);
Route::apiResource('tags', TagController::class);

// ---------------- Auth Routes ---------------- //
Route::controller(AuthController::class)->group(function () {
    Route::post('register', 'register')->name('register');
    Route::post('login', 'login')->name('login');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::get('get-user', 'userInfo')->name('get-user');
        Route::post('logout', 'logout')->name('logout');
    });

    Route::controller(RatingController::class)->group(function () {
        Route::get('ratings', 'index')->name('ratings');
    });
});
