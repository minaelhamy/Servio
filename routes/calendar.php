<?php

use App\helper\helper;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\addons\CalendarController;

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
    Route::post('/google_calendar', [CalendarController::class, 'google_calendar']);
    Route::group(['middleware' => 'AuthMiddleware'], function () {
        Route::middleware('VendorMiddleware')->group(function () {
            // bookings google calendar
            Route::get('/bookings/event', [CalendarController::class, 'event']);
            Route::get('/bookings/googlesync-{booking_number}/{vendor_id}/{type}', [CalendarController::class, 'googlesync']);
        });
    });
});

helper::registerStorefrontRoutes(function () {
 
    Route::get('/bookings/event', [CalendarController::class, 'event']);
    // Route::get('/event', [CalendarController::class, 'event']);
    Route::get('/googlesync-{booking_number}/{vendor_id}/{type}', [CalendarController::class, 'googlesync']);
   
});
