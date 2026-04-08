<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\addons\include\PromocodeController;
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
        // Coupons
        Route::group(['prefix' => 'promocode'], function () {
            Route::get('', [PromocodeController::class, 'index']);
            Route::get('/add', [PromocodeController::class, 'add']);
            Route::post('/save', [PromocodeController::class, 'save']);
            Route::get('/edit-{id}', [PromocodeController::class, 'edit']);
            Route::post('/update-{id}', [PromocodeController::class, 'update']);
            Route::get('/status_change-{id}/{status}', [PromocodeController::class, 'status_change']);
            Route::get('/delete-{id}', [PromocodeController::class, 'delete']);
            Route::get('/bulk_delete', [PromocodeController::class, 'bulk_delete']);

        });
        Route::middleware('VendorMiddleware')->group(function () {
            Route::post('/applycoupon', [PromocodeController::class, 'vendorapplypromocode']);
            Route::post('/removecoupon', [PromocodeController::class, 'vendorremovepromocode']);
        });
    });
});
Route::namespace('front')->group(function () {
    Route::post('/service/apply', [PromocodeController::class, 'applypromocode']);
    Route::post('/service/remove', [PromocodeController::class, 'removepromocode']);
    Route::post('/order/applypromocode', [PromocodeController::class, 'orderapplypromocode']);
    Route::post('/order/removepromocode', [PromocodeController::class, 'orderremovepromocode']);
});
