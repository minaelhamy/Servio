<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\addons\VendorcalendarController;

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
              // calendar
              Route::get('/calendar', [VendorcalendarController::class, 'index']);
              Route::get('/calendar/add', [VendorcalendarController::class, 'add']);
              Route::post('/calendar/timeslot', [VendorcalendarController::class, 'timeslot']);
              Route::post('/calendar/save', [VendorcalendarController::class, 'save']);
              Route::post('/calendar/getcustomer', [VendorcalendarController::class, 'getcustomer']);
              Route::post('/calendar/slotlimit', [VendorcalendarController::class, 'slotlimit']);
              Route::post('/calendar/getstaff', [VendorcalendarController::class, 'getstaff']);
            
        });
    });
});

