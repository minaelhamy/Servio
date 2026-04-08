<?php

use App\helper\helper;
use App\Http\Controllers\addons\IcalFileController;
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

helper::registerStorefrontRoutes(function () {
 
    Route::get('/icalfile-{booking_number}/{vendor_id}/{type}', [IcalFileController::class, 'icalfile']);
   
});
