<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\addons\EmbeddedController;
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
                Route::middleware('VendorMiddleware')->group(function () {
                        Route::post('/framesettings', [EmbeddedController::class, 'framesetting']);
                });
        });
});

Route::namespace('front')->group(function () {
        Route::get('/{vendor}/embedded', [EmbeddedController::class, 'category']);
        Route::get('/{vendor}/embedded/services', [EmbeddedController::class, 'services']);
        Route::get('/{vendor}/embedded/datetime', [EmbeddedController::class, 'datetime']);
        Route::get('/{vendor}/embedded/information', [EmbeddedController::class, 'information']);
        Route::get('/{vendor}/embedded/confirmation', [EmbeddedController::class, 'confirmation']);
        Route::get('/{vendor}/embedded/success', [EmbeddedController::class, 'success']);
        Route::post('/{vendor}/embedded/timeslot', [EmbeddedController::class, 'timeslot']);
        Route::post('/{vendor}/embedded/info', [EmbeddedController::class, 'sessioninfo']);
        Route::post('/{vendor}/embedded/slotlimit', [EmbeddedController::class, 'slotlimit']);
        Route::get('/{vendor}/embedded/telegram/{booking_number}', [EmbeddedController::class, 'telegram']);
});
