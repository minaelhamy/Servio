<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\addons\PayoutController;
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
         // blog
         Route::group(['prefix' => 'payout'], function () {
            Route::get('/', [PayoutController::class, 'payout']);
            Route::get('/request-{payable_amt}/{commission}/{earning_amt}', [PayoutController::class, 'request']);
            Route::post('/update-{id}', [PayoutController::class, 'update_city']);
            Route::get('/delete-{id}', [PayoutController::class, 'delete_city']);
            Route::post('/change_status/{status}', [PayoutController::class, 'statuschange_payout']);
        });
    });
});