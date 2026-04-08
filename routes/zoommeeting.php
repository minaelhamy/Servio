<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\addons\ZoommeetingController;

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
    Route::post('/zoom', [ZoommeetingController::class, 'zoom']);
    Route::group(['middleware' => 'AuthMiddleware'], function () {
        Route::middleware('VendorMiddleware')->group(function () {
            Route::get('/bookings/zoom-{booking_number}/{vendor_id}', [ZoommeetingController::class, 'zoom_data']);
        });
    });
});
