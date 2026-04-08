<?php

use App\helper\helper;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\addons\include\BlogController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['namespace' => 'admin', 'prefix' => 'admin'], function () {
    Route::group(['middleware' => 'AuthMiddleware'], function () {
        // blog
        Route::group(['prefix' => 'blogs'], function () {
            Route::get('', [BlogController::class, 'index']);
            Route::get('/add', [BlogController::class, 'add']);
            Route::post('/save', [BlogController::class, 'save']);
            Route::get('/edit-{slug}', [BlogController::class, 'edit']);
            Route::post('/update-{slug}', [BlogController::class, 'update']);
            Route::get('/delete-{slug}', [BlogController::class, 'delete']);
            Route::get('bulk_delete', [BlogController::class, 'bulk_delete']);
            Route::post('/reorder_blogs', [BlogController::class, 'reorder_blogs']);
        });
    });
});

helper::registerStorefrontRoutes(function () {
    // blogs
    Route::get('/blog-{blogslug}', [BlogController::class, 'front_blogdetails']);
    Route::get('/allblogs', [BlogController::class, 'front_index']);
});
