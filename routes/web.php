<?php

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Client\SitemapsController;

Route::get('/sitemap.xml', [SitemapsController::class, 'index']);
//Route::get('/sitemap/reviews/{page?}', [SitemapsController::class, 'reviews']);
//Route::get('/sitemap/companies/{page?}', [SitemapsController::class, 'companies']);

//Route::get('/ip_test', function () {
//    return ['test' => Request::ip()];
//});
