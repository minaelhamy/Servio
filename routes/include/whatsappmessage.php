<?php



use Illuminate\Support\Facades\Route;

use App\Http\Controllers\addons\include\WhatsappController;
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
        Route::get('/whatsapp_settings', [WhatsappController::class, 'index']);
        Route::post('settings/order_message_update', [WhatsappController::class, 'order_message_update']);
        Route::post('settings/status_message', [WhatsappController::class, 'status_message']);
        Route::post('settings/business_api', [WhatsappController::class, 'business_api']);
    });
});

// $domain = env('WEBSITE_HOST');
// $parsedUrl = parse_url(url()->current());
// $host = $parsedUrl['host'];
// if (array_key_exists('host', $parsedUrl)) {
//     // if it is a path based URL
//     if ($host == env('WEBSITE_HOST')) {
//         $domain = $domain;
//         $prefix = '{vendor}';
//     }
//     // if it is a subdomain / custom domain
//     else {
//         $prefix = '';
//     }
// }
// Route::post($prefix . '/sendonwhatsapp', [WhatsappController::class, 'sendonwhatsapp']);
