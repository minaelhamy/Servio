<?php



use App\helper\helper;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\addons\PayTabController;
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
            Route::group(
                ['prefix' => 'plan'],
                function () {
                    Route::post('buyplan/paytab', [PayTabController::class, 'paytabrequest']);
                }
            );
        });
    });
});

helper::registerStorefrontRoutes(function () {
    Route::post('/paytabrequest', [PayTabController::class, 'front_paytabrequest']);
    Route::post('/paytabrequest-{booking_number}', [PayTabController::class, 'front_paytabrequest']);
});

Route::post('/checkpaymentstatus', [PayTabController::class, 'checkpaymentstatus']);
