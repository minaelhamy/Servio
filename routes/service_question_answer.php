<?php

use App\helper\helper;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\addons\ProductQuestionAnswerController;

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

//product_question_answer
Route::group(['namespace' => 'admin', 'prefix' => 'admin'], function () {
    Route::group(['middleware' => 'AuthMiddleware'], function () {
        Route::middleware('VendorMiddleware')->group(function () {
            Route::get('/question_answer', [ProductQuestionAnswerController::class, 'question_answer']);
            Route::post('/product_answer', [ProductQuestionAnswerController::class, 'product_answer']);
            Route::get('/question_answer/delete-{id}', [ProductQuestionAnswerController::class, 'delete']);
        });
    }); 
});
helper::registerStorefrontRoutes(function () {
    Route::post('/product_question_answer', [ProductQuestionAnswerController::class, 'product_question_answer']);
});
