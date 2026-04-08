<?php

use App\helper\helper;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\addons\GoogleLoginController;
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


//Login with Google
Route::get('checklogin/google/callback-{logintype}', [GoogleLoginController::class, 'check_login']);


Route::group(['namespace' => 'admin', 'prefix' => 'admin'], function () {
    Route::post('/google_login', [GoogleLoginController::class, 'googleloginsettings']);

    //Login with Google
    Route::get('login/google-{type}', [GoogleLoginController::class, 'redirectToGoogle']);
});

helper::registerStorefrontRoutes(function () {
    //Login with Google
    Route::get('/login/google-{type}', [GoogleLoginController::class, 'redirectToGoogle']);
}, 'vendor_slug', []);
