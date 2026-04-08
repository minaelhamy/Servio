<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\addons\SocialLoginController;

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
 Route::get('checklogin/google/callback-{logintype}', [SocialLoginController::class, 'check_login']);
 //Login with facebook
 Route::get('checklogin/facebook/callback-{logintype}', [SocialLoginController::class, 'check_login']);
Route::group(['namespace' => 'admin', 'prefix' => 'admin'], function () {
    Route::post('/social_login', [SocialLoginController::class, 'socialloginsettings']);
    Route::get('login/google-{type}', [SocialLoginController::class, 'redirectToGoogle']);
    Route::get('login/facebook-{type}', [SocialLoginController::class, 'redirectToFacebook']);
});
Route::group(['namespace' => 'front', 'middleware' => 'frontmiddleware'], function () {
     //Login with Google
    Route::get('{vendor}/login/google-{type}', [SocialLoginController::class, 'redirectToGoogle']);
    // //Login with facebook
    Route::get('{vendor}/login/facebook-{type}', [SocialLoginController::class, 'redirectToFacebook']);
});
