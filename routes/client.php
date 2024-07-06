<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Client\CompanyController;
use \App\Http\Controllers\Client\ReviewController;
use \App\Http\Controllers\Client\CommentController;
use \App\Http\Controllers\Client\SearchController;
use \App\Http\Controllers\Client\HomeController;
use \App\Http\Controllers\Client\ReportController;
use \App\Http\Controllers\Client\ReasonController;

// cache this route for 15 minutes
Route::middleware('cacheResponse:900')->name('client.')->group(function () {
    Route::apiResource('company', CompanyController::class);
    Route::apiResource('review', ReviewController::class);
    Route::post('review/{review_id}', [ReviewController::class, 'update'])->middleware('doNotCacheResponse');

    Route::get('comment/{review_id}', [CommentController::class, 'index']);
    Route::post('comment', [CommentController::class, 'store'])->middleware('doNotCacheResponse');

    Route::get('search/all', [SearchController::class, 'searchAll']);
    Route::get('search/companies', [SearchController::class, 'searchCompanies']);

    Route::get('home', [HomeController::class, 'getHome']);

    Route::get('reason', [ReasonController::class, 'index']);
    Route::post('report', [ReportController::class, 'store']);
});



