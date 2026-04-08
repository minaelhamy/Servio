<?php



use App\helper\helper;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\addons\MollieController;
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
                    Route::post('buyplan/mollie', [MollieController::class, 'mollie']);
                }
            );
        });
    });
});

helper::registerStorefrontRoutes(function () {
    Route::post('/mollierequest-{booking_number}', [MollieController::class, 'front_mollierequest']);
    Route::post('/mollierequest', [MollieController::class, 'front_mollierequest']);
});
