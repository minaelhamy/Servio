<?php

use App\helper\helper;
use App\Http\Controllers\addons\MercadopagoController;
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
        Route::middleware('VendorMiddleware')->group(function () {
            Route::group(
                ['prefix' => 'plan'],
                function () {

                    Route::post('buyplan/mercadorequest', [MercadopagoController::class, 'mercadorequest']);
                }
            );
        });
    });
});

helper::registerStorefrontRoutes(function () {
    Route::post('/mercadoorder', [MercadopagoController::class, 'front_mercadoorderrequest']);
    Route::post('/mercadoorder-{booking_number}', [MercadopagoController::class, 'front_mercadoorderrequest']);
});
