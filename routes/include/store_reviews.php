<?php

use App\Http\Controllers\addons\include\TestimonialController;
use Illuminate\Support\Facades\Route;
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
        //testimonial
        Route::get('/testimonials', [TestimonialController::class, 'index']);
        Route::get('/testimonials/add', [TestimonialController::class, 'add']);
        Route::post('/testimonials/save', [TestimonialController::class, 'save']);
        Route::get('/testimonials/edit-{id}', [TestimonialController::class, 'edit']);
        Route::post('/testimonials/update-{id}', [TestimonialController::class, 'update']);
        Route::get('/testimonials/delete-{id}', [TestimonialController::class, 'delete']);
        Route::post('/testimonials/reorder_testimonials', [TestimonialController::class, 'reorder_testimonials']);
        Route::get('/testimonials/bulk_delete', [TestimonialController::class, 'bulk_delete']);

    });
});
