<?php

use App\helper\helper;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\addons\QuestionAnswerController;

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
            Route::get('/question_answer', [QuestionAnswerController::class, 'question_answer']);
            Route::post('/product_answer', [QuestionAnswerController::class, 'product_answer']);
            Route::get('/question_answer/delete-{id}', [QuestionAnswerController::class, 'delete']);
            Route::get('/question_answer/bulk_delete', [QuestionAnswerController::class, 'bulk_delete']);
            Route::get('/service_question_answer', [QuestionAnswerController::class, 'services_question_answer']);
        });
    });
});


helper::registerStorefrontRoutes(function () {
    Route::post('/product_question_answer', [QuestionAnswerController::class, 'product_question_answer']);
    Route::post('/service_question_answer', [QuestionAnswerController::class, 'service_question_answer']);
});
