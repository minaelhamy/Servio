<?php

use App\Http\Controllers\addons\ZoommeetingController;
use App\Http\Controllers\addons\SocialLoginController;
use App\Http\Controllers\addons\TelegramController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController as VendorController;
use App\Http\Controllers\Api\HomeController as VendorHomeController;
use App\Http\Controllers\Api\OtherController;
use App\Http\Controllers\Api\user\UserController;
use App\Http\Controllers\Api\user\HomeController;
use App\Http\Controllers\Api\user\ServiceController;
use App\Http\Controllers\Api\user\BookingController;
use App\Http\Controllers\Api\user\BlogController;
use App\Http\Controllers\Api\user\PromocodeController;
use App\Http\Controllers\Api\user\OtherPagesController;
use App\Http\Controllers\addons\MercadopagoController;
use App\Http\Controllers\addons\ToyyibpayController;
use App\Http\Controllers\addons\MyfatoorahController;
use App\Http\Controllers\addons\PayTabController;
use App\Http\Controllers\Integration\HatchersFounderSyncController;
use App\Http\Controllers\Integration\HatchersActionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('hatchers/founder-sync', HatchersFounderSyncController::class);
Route::post('hatchers/action', HatchersActionController::class);


Route::group(['namespace'=>'Api'],function (){
    Route::post('register',[VendorController::class,'register_vendor']);
    Route::post('sociallogin',[SocialLoginController::class,'social_loginvendor']);
    Route::post('login',[VendorController::class,'check_admin_login']);
    Route::post('forgotpassword',[VendorController::class,'forgotpassword']);
    Route::post('changepassword', [VendorController::class, 'change_password']);
    Route::post('editprofile', [VendorController::class, 'edit_profile']);
    Route::get('getcountry', [VendorController::class, 'getcountry']);
    Route::post('getcity', [VendorController::class, 'getcity']);
    
    Route::post('home',[VendorHomeController::class,'index']);
    Route::post('servicedetail',[VendorHomeController::class,'servicedetail']);
    Route::post('servicehistory',[VendorHomeController::class,'history']);
    Route::post('statuschange',[VendorHomeController::class,'status_change']);
    Route::post('staffassign',[VendorHomeController::class,'staffassign']);
    Route::get('cmspages',[OtherController::class,'getcontent']);
    Route::get('systemaddon', [VendorHomeController::class, 'systemaddon']);
    Route::post('inquiries',[OtherController::class,'inquiries']);
    Route::post('createzoommeeting',[ZoommeetingController::class,'zoom_apidata']);

    Route::post('user/register',[UserController::class,'register_customer']);
    Route::post('user/login',[UserController::class,'login_customer']);
    Route::post('user/sociallogin',[SocialLoginController::class,'social_loginuser']);
    Route::post('user/forgotpassword',[UserController::class,'forgotpassword']);
    Route::post('user/editprofile',[UserController::class,'edit_profile']);
    Route::post('user/changepassword',[UserController::class,'change_password']);
    Route::post('user/wishlistproduct', [UserController::class, 'wishlist_product']);
    Route::post('user/deleteuseraccount', [UserController::class, 'deleteuseraccount']);

    Route::post('user/home',[HomeController::class,'home']);
    Route::post('user/systemaddon', [HomeController::class, 'systemaddon']);
    Route::post('/user/paymentmethods', [HomeController::class, 'paymentmethods']);
    Route::post('/user/getstafflist', [HomeController::class, 'getstafflist']);
    Route::post('/user/payment', [BookingController::class, 'booking_payment']);
    Route::post('/user/services', [ServiceController::class, 'services']);
    Route::post('/user/servicesdetails', [ServiceController::class, 'servicedetails']);
    Route::post('/user/postreview', [ServiceController::class, 'postreview']);
    Route::post('/user/managefavorite', [ServiceController::class, 'managefavorite']);
    Route::post('user/category',[ServiceController::class,'category']);
    Route::post('user/getbookingslots',[ServiceController::class,'getbookingslots']);
    Route::post('user/checkbooking',[ServiceController::class,'checkbooking']);
    
    Route::post('/user/booking', [BookingController::class, 'savebooking']);
    Route::post('/user/bookinghistory',[BookingController::class,'history']);
    Route::post('/user/bookingdetail',[BookingController::class,'servicedetail']);
    
    //User booking cancel
    Route::post('/user/statuschange',[BookingController::class,'status_change']);
    
    Route::post('/user/blogs', [BlogController::class, 'blogs']);
    Route::post('/user/promocode', [PromocodeController::class, 'promocode']);
    Route::post('/user/applypromocode', [PromocodeController::class, 'applypromocode']);
    
    Route::post('/user/cmspages', [OtherPagesController::class, 'cmspages']);
    Route::post('/user/contactdata', [OtherPagesController::class, 'contactdata']);
    Route::post('/user/savecontact', [OtherPagesController::class, 'save_contact']);
    Route::post('/user/faq', [OtherPagesController::class, 'faq']);

    Route::post('/user/telegram', [TelegramController::class, 'telegram_msg']);

    //Payment-Gateway
    Route::post('user/mercadorequest', [MercadopagoController::class,'mercadorequestapi']);
    Route::post('user/toyyibpayrequest', [ToyyibpayController::class,'toyyibpayrequestapi']);
    Route::post('user/myfatoorahrequest', [MyfatoorahController::class,'myfatoorahapi']);
    Route::post('user/paytabrequest', [PayTabController::class,'paytabrequestapi']);
    Route::post('user/checkpaymentstatusapi', [PayTabController::class,'checkpaymentstatusapi']);
    
});
