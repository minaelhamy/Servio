<?php

use App\helper\helper;
use App\Http\Controllers\addons\ProductController;
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
            //product
            Route::group(['prefix' => 'products'], function () {
                Route::get('/', [ProductController::class, 'index']);
                Route::get('/add', [ProductController::class, 'add']);
                Route::post('/save', [ProductController::class, 'save']);
                Route::get('/edit-{slug}', [ProductController::class, 'edit']);
                Route::post('/update-{slug}', [ProductController::class, 'update_product']);
                Route::get('/status_change-{slug}/{status}', [ProductController::class, 'status_change']);
                Route::get('/delete-{slug}', [ProductController::class, 'delete_product']);
                Route::get('/bulk_delete', [ProductController::class, 'bulk_delete_product']);
                Route::post('/reorder_product', [ProductController::class, 'reorder_product']);
                Route::post('/add_image', [ProductController::class, 'add_image']);
                Route::post('/update', [ProductController::class, 'update_image']);
                Route::get('/delete_image-{id}/{product_id}', [ProductController::class, 'delete_image']);
                Route::post('/reorder_image-{item_id}', [ProductController::class, 'reorder_image']);
                Route::get('/review/delete-{id}', [ProductController::class, 'review_delete']);
            });
            //shipping
            Route::group(['prefix' => 'shipping'], function () {
                Route::get('/', [ProductController::class, 'shippingindex']);
                Route::post('/savecontent', [ProductController::class, 'savecontent']);
            });
        });
    });
});

helper::registerStorefrontRoutes(function () {
    Route::get('/product', [ProductController::class, 'productlisting']);
    Route::get('/product-{slug}', [ProductController::class, 'product_detail']);

    //Cart
    Route::get('/cartproduct', [ProductController::class, 'cartindex']);
    Route::post('/cart/add', [ProductController::class, 'addtocart']);
    Route::post('cart/qtyupdate', [ProductController::class, 'qtyupdate']);
    Route::get('/cart/delete-{cid}', [ProductController::class, 'deletecart']);
    //Checkout
    Route::get('/checkout', [ProductController::class, 'checkoutindex']);
    Route::post('/placeorder', [ProductController::class, 'placeorder']);
    Route::get('/order-success-{order_number}', [ProductController::class, 'order_success']);
    Route::get('/order/{order_number}', [ProductController::class, 'order_details']);
    Route::get('order/status_change-{order_number}/{status}', [ProductController::class, 'order_status_change']);
    Route::any('/paymentsuccess', [ProductController::class, 'paymentsuccess']);
});
