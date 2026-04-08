<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\addons\ImportController;
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
            Route::get('/import', [ImportController::class, 'import']);
            Route::get('/generatepdf', [ImportController::class, 'generatepdf']);
            Route::post('/importservices', [ImportController::class, 'importservices']);
            Route::get('/generatetaxpdf', [ImportController::class, 'generatetaxpdf']);
            Route::get('/generatestaffpdf', [ImportController::class, 'generatestaffpdf']);

            /*------------------------------- Products ------------------------------*/
            Route::get('/productimport', [ImportController::class, 'productimport']);
            Route::get('/productgeneratepdf', [ImportController::class, 'productgeneratepdf']);
            Route::post('/importproducts', [ImportController::class, 'importproducts']);

            // services
            Route::group(['prefix' => 'services'], function () {
                Route::get('/exportservices', [ImportController::class, 'exportservices']);
            });
            // products
            Route::group(['prefix' => 'products'], function () {
                Route::get('/exportproducts', [ImportController::class, 'exportproducts']);
            });
        });
    });
});
