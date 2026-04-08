<?php



use App\helper\helper;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\addons\MyfatoorahController;
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
                   
                    Route::post('buyplan/myfatoorahrequest', [MyfatoorahController::class, 'myfatoorahrequest']);
                }
            );
        });
    });
});

helper::registerStorefrontRoutes(function () {
    Route::post('/myfatoorahrequest', [MyfatoorahController::class, 'front_myfatoorahrequest']);
    Route::post('/myfatoorahrequest-{booking_number}', [MyfatoorahController::class, 'front_myfatoorahrequest']);
});
