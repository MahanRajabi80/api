<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CommentController;



Route::controller(AuthController::class)
    ->name('admin.')
    ->middleware(['doNotCacheResponse'])
    ->group(function () {
        Route::post('login', 'login');
//    Route::post('register', 'register');
        Route::post('logout', 'logout');
        Route::post('refresh', 'refresh');
        Route::get('me', 'me');
    });

Route::middleware(['auth:api', 'doNotCacheResponse'])->name('admin.')->group(function () {
    Route::apiResource('review', ReviewController::class);
    Route::post('review/{id}/status', [ReviewController::class, 'changeStatus']);
    Route::post('review/{id}/remove-sexual-harassment', [ReviewController::class, 'removeSexualHarassment']);

    Route::apiResource('comment', CommentController::class);
    Route::post('comment/status/{id}', [CommentController::class, 'changeStatus']);
});

