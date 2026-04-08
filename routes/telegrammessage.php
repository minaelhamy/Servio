<?php



use App\helper\helper;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\addons\TelegramController;
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
            Route::get('/telegram_settings', [TelegramController::class, 'index']);
            Route::post('telegrammessage/business_api', [TelegramController::class, 'business_api']);
            Route::post('telegrammessage/order_message_update', [TelegramController::class, 'order_message_update']);
        });
    });
});

helper::registerStorefrontRoutes(function () {
    Route::get('/telegram/{booking_number}', [TelegramController::class, 'telegrammessage']);
    Route::get('/ordertelegram/{order_number}', [TelegramController::class, 'ordertelegrammessage']);
});
