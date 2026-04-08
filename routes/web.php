<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\PlanPricingController;
use App\Http\Controllers\admin\GalleryController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\ServiceController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\PaymentController;
use App\Http\Controllers\admin\SettingsController;
use App\Http\Controllers\admin\HowItWorkController;
use App\Http\Controllers\admin\TransactionController;
use App\Http\Controllers\admin\BannerController;
use App\Http\Controllers\admin\WebsiteSettingsController;
use App\Http\Controllers\admin\StoreCategoryController;
use App\Http\Controllers\addons\include\BlogController;
use App\Http\Controllers\admin\BookingsController;
use App\Http\Controllers\admin\FeaturesController;
use App\Http\Controllers\admin\TaxController;
use App\Http\Controllers\admin\OtherController;
use App\Http\Controllers\admin\ReportController;
use App\Http\Controllers\admin\ThemeController;
use App\Http\Controllers\admin\WhyChooseUsController;
use App\Http\Controllers\admin\MediaController;
use App\Http\Controllers\front\ServiceController as FrontServiceController;
use App\Http\Controllers\front\CategoryController as FrontCategoryController;
use App\Http\Controllers\front\HomeController;
use App\Http\Controllers\front\BookingController;
use App\Http\Controllers\front\OtherPagesController;
use App\Http\Controllers\admin\SystemAddonsController;
use App\Http\Controllers\front\UserController as FrontUserContrloller;
use App\Http\Controllers\landing\HomeController as LandingHomeController;
use App\helper\helper;
use App\Http\Controllers\addons\include\CurrencyController;
use App\Http\Controllers\addons\ProductQuestionAnswerController;
use App\Http\Controllers\admin\OrderController;
use App\Http\Controllers\admin\POSController;
use App\Models\ProductQuestionAnswer;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. Thesebooking
| contains the "web" middleware group. Now create something great!
|
*/

Route::post('add-on/session/save', [AdminController::class, 'sessionsave']);
Route::group(['namespace' => 'admin', 'prefix' => 'admin'], function () {
    Route::get('/', [AdminController::class, 'login']);
    Route::post('/checklogin', [AdminController::class, 'check_admin_login']);
    Route::get('/register', [AdminController::class, 'register']);
    Route::post('/register_vendor', [AdminController::class, 'register_vendor']);
    Route::get('/forgot_password', [AdminController::class, 'forgot_password']);
    Route::post('/send_password', [AdminController::class, 'send_password']);
    Route::post('/getcity', [AdminController::class, 'getcity']);
    Route::get(
        '/verify',
        function () {
            return view('admin.auth.verify');
        }
    );

    Route::group(['middleware' => 'AuthMiddleware'], function () {
        Route::post('systemverification', [AdminController::class, 'systemverification'])->name('admin.systemverification');
        Route::get('apps', [SystemAddonsController::class, 'index'])->name('systemaddons');
        Route::get('createsystem-addons', [SystemAddonsController::class, 'createsystemaddons']);
        Route::post('systemaddons/store', [SystemAddonsController::class, 'store']);
        Route::get('systemaddons/status-{id}/{status}', [SystemAddonsController::class, 'change_status']);
        // common
        Route::get('/logout', [AdminController::class, 'logout']);
        Route::get('/dashboard', [AdminController::class, 'index']);
        // mobile section
        Route::post('/mobile_section/save', [WebsiteSettingsController::class, 'save']);
        // contact settings
        Route::post('/contact_settings', [WebsiteSettingsController::class, 'contact_settings']);

        //setting
        Route::get('/settings', [SettingsController::class, 'index']);
        Route::post('/add', [SettingsController::class, 'store']);
        Route::post('/edit-profile', [AdminController::class, 'edit_profile']);
        Route::post('/change-password', [AdminController::class, 'change_password']);
        Route::get('/plan', [PlanPricingController::class, 'view_plan']);
        Route::get('/plan/delete-{id}', [PlanPricingController::class, 'delete']);


        Route::get('settings/delete-feature-{id}', [SettingsController::class, 'delete_feature']);
        Route::get('/settings/delete-sociallinks-{id}', [WebsiteSettingsController::class, 'delete_sociallinks']);
        Route::get('/themeimages', [PlanPricingController::class, 'themeimages']);
        // transaction
        Route::group(['prefix' => 'transaction'], function () {
            Route::get('/', [TransactionController::class, 'index']);
            Route::get('/plandetails-{id}', [PlanPricingController::class, 'plan_details']);
            Route::get('/generatepdf-{id}', [PlanPricingController::class, 'generatepdf']);
        });

        // payment
        Route::group(['prefix' => 'payment'], function () {
            Route::get('/', [PaymentController::class, 'index']);
            Route::post('/update', [PaymentController::class, 'update']);
            Route::post('/reorder_payment', [PaymentController::class, 'reorder_payment']);
        });
        // other pages
        Route::get('/privacypolicy', [OtherController::class, 'privacypolicy']);
        Route::post('/privacypolicy/update', [OtherController::class, 'update_privacypolicy']);
        Route::get('/termscondition', [OtherController::class, 'termscondition']);
        Route::post('/termscondition/update', [OtherController::class, 'update_terms']);
        Route::get('/aboutus', [OtherController::class, 'aboutus']);
        Route::post('/aboutus/update', [OtherController::class, 'update_aboutus']);
        Route::get('refund_policy', [OtherController::class, 'refund_policy']);
        Route::post('refund_policy/update', [OtherController::class, 'refund_policy_update']);
        // contacts
        Route::get('/contacts', [OtherController::class, 'index']);
        Route::get('/contacts/delete-{id}', [OtherController::class, 'delete']);
        Route::get('/contacts/bulk_delete', [OtherController::class, 'inquiries_bulk_delete']);
        Route::get('/subscribers', [OtherController::class, 'subscribers']);
        Route::get('/subscribers/delete-{id}', [OtherController::class, 'subscribers_delete']);
        Route::get('/subscribers/bulk_delete', [OtherController::class, 'subscribers_bulk_delete']);

        Route::get('/invoice-{vendor_id}-{booking_number}', [BookingsController::class, 'booking_invoice']);
        Route::post('/staff_member-{booking_number}', [BookingsController::class, 'staff_member']);
        Route::get('/bookings/generatepdf/{vendor_id}/{booking_number}', [BookingsController::class, 'generatepdf']);
        Route::get('/orders/invoice-{vendor_id}-{order_number}', [OrderController::class, 'order_invoice']);
        Route::get('/orders/generatepdf/{vendor_id}/{order_number}', [OrderController::class, 'order_generatepdf']);

        // FAQs
        Route::get('/faqs', [OtherController::class, 'faq_index']);
        Route::get('/faqs/add', [OtherController::class, 'faq_add']);
        Route::post('/faqs/save', [OtherController::class, 'faq_save']);
        Route::get('/faqs/edit-{id}', [OtherController::class, 'faq_edit']);
        Route::post('/faqs/update-{id}', [OtherController::class, 'faq_update']);
        Route::get('/faqs/delete-{id}', [OtherController::class, 'faq_delete']);
        Route::post('/faqs/reorder_faqs', [OtherController::class, 'reorder_faqs']);
        Route::get('/faqs/bulk_delete', [OtherController::class, 'faq_bulk_delete']);


        Route::get('/basic_settings', [WebsiteSettingsController::class, 'basic_settings']);
        Route::post('social_links/update', [WebsiteSettingsController::class, 'social_links_update']);
        Route::post('/other_settings', [WebsiteSettingsController::class, 'other_settings']);
        Route::post('/themeupdate', [WebsiteSettingsController::class, 'themeupdate']);
        Route::post('/og_image', [WebsiteSettingsController::class, 'save_seo']);
        Route::post('/notice_update', [SettingsController::class, 'notice_update']);
        Route::post('/maintenance_update', [SettingsController::class, 'maintenance_update']);
        Route::post('/tips_update', [SettingsController::class, 'tips_update']);


        // tax
        Route::group(
            ['prefix' => 'tax'],
            function () {
                Route::get('/', [TaxController::class, 'index']);
                Route::get('add', [TaxController::class, 'add']);
                Route::post('save', [TaxController::class, 'save']);
                Route::get('edit-{id}', [TaxController::class, 'edit']);
                Route::post('update-{id}', [TaxController::class, 'update']);
                Route::get('change_status-{id}/{status}', [TaxController::class, 'change_status']);
                Route::get('delete-{id}', [TaxController::class, 'delete']);
                Route::post('reorder_tax', [TaxController::class, 'reorder_tax']);
                Route::get('bulk_delete', [TaxController::class, 'bulk_delete']);
            }
        );
        Route::middleware('VendorMiddleware')->group(function () {
            // share
            Route::get('share', [OtherController::class, 'share']);
            Route::get('/deleteaccount-{id}', [SettingsController::class, 'deleteaccount']);
            Route::post('/safe-secure-store', [SettingsController::class, 'safe_secure_store']);

            // categories
            Route::group(['prefix' => 'categories'], function () {
                Route::get('/', [CategoryController::class, 'view_category']);
                Route::get('/add', [CategoryController::class, 'add_category']);
                Route::post('/save', [CategoryController::class, 'save_category']);
                Route::get('/edit-{slug}', [CategoryController::class, 'edit_category']);
                Route::post('/update-{slug}', [CategoryController::class, 'update_category']);
                Route::get('/change_status-{slug}/{status}', [CategoryController::class, 'change_status']);
                Route::get('/delete-{slug}', [CategoryController::class, 'delete_category']);
                Route::post('/reorder_category', [CategoryController::class, 'reorder_category']);
                Route::get('/bulk_delete', [CategoryController::class, 'bulk_delete_category']);

            });

            // product-category
            Route::group(['prefix' => 'product-category'], function () {
                Route::get('/', [CategoryController::class, 'view_product_category']);
                Route::get('/add', [CategoryController::class, 'add_product_category']);
                Route::post('/save', [CategoryController::class, 'save_product_category']);
                Route::get('/edit-{slug}', [CategoryController::class, 'edit_product_category']);
                Route::post('/update-{slug}', [CategoryController::class, 'update_product_category']);
                Route::get('/change_status-{slug}/{status}', [CategoryController::class, 'change_product_category_status']);
                Route::get('/delete-{slug}', [CategoryController::class, 'delete_product_category']);
                Route::get('/bulk_delete', [CategoryController::class, 'bulk_delete_product_category']);
                Route::post('/reorder_category', [CategoryController::class, 'reorder_product_category']);
            });

            // services
            Route::group(['prefix' => 'services'], function () {
                Route::get('/', [ServiceController::class, 'index']);
                Route::get('/add', [ServiceController::class, 'add']);
                Route::post('/save', [ServiceController::class, 'save']);
                Route::get('/edit-{slug}', [ServiceController::class, 'edit']);
                Route::post('/update-{slug}', [ServiceController::class, 'update_service']);
                Route::get('/deleteadditional-{id}', [ServiceController::class, 'deleteadditional']);
                Route::get('/delete-{slug}', [ServiceController::class, 'delete_service']);
                Route::get('/bulk_delete', [ServiceController::class, 'bulk_delete_service']);
                Route::post('/update', [ServiceController::class, 'update_image']);
                Route::get('/delete_image-{id}/{service_id}', [ServiceController::class, 'delete_image']);
                Route::post('/add_image', [ServiceController::class, 'add_image']);
                Route::get('/status_change-{slug}/{status}', [ServiceController::class, 'status_change']);
                Route::post('/reorder_service', [ServiceController::class, 'reorder_service']);
                Route::get('/review/delete-{id}', [ServiceController::class, 'review_delete']);
                Route::post('/reorder_image-{item_id}', [ServiceController::class, 'reorder_image']);
                Route::post('/update_working_hours', [ServiceController::class, 'update_working_hours']);
            });
            // pos
            Route::group(['prefix' => 'pos'], function () {
                Route::get('/', [POSController::class, 'index']);
            });
            // plan
            Route::group(
                ['prefix' => 'plan'],
                function () {
                    Route::get('selectplan-{id}', [PlanPricingController::class, 'select_plan']);
                    Route::post('buyplan', [PlanPricingController::class, 'buyplan']);
                    Route::any('buyplan/payment/success', [PlanPricingController::class, 'success']);
                }
            );
            Route::get('/admin_back', [UserController::class, 'admin_back']);
            // banner
            Route::group(['prefix' => 'bannersection-1'], function () {
                Route::get('', [BannerController::class, 'index']);
                Route::get('/add', [BannerController::class, 'add']);
                Route::get('/edit-{id}', [BannerController::class, 'edit']);
                Route::post('/save-{section}', [BannerController::class, 'save_banner']);
                Route::post('/update-{id}', [BannerController::class, 'edit_banner']);
                Route::get('/status_change-{id}/{status}', [BannerController::class, 'status_update']);
                Route::get('/delete-{id}', [BannerController::class, 'delete']);
                 Route::get('/bulk_delete', [BannerController::class, 'bulk_delete']);
                Route::post('/reorder_banner', [BannerController::class, 'reorder_banner']);
            });
            Route::group(['prefix' => 'bannersection-2'], function () {
                Route::get('', [BannerController::class, 'index']);
                Route::get('/add', [BannerController::class, 'add']);
                Route::get('/edit-{id}', [BannerController::class, 'edit']);
                Route::post('/save-{section}', [BannerController::class, 'save_banner']);
                Route::post('/update-{id}', [BannerController::class, 'edit_banner']);
                Route::get('/status_change-{id}/{status}', [BannerController::class, 'status_update']);
                Route::get('/delete-{id}', [BannerController::class, 'delete']);
                Route::get('/bulk_delete', [BannerController::class, 'bulk_delete']);
                Route::post('/reorder_banner', [BannerController::class, 'reorder_banner']);
            });
            // bookings
            Route::get('/bookings', [BookingsController::class, 'index']);
            Route::get('/bookings/status_change-{booking_number}/{status}/{type}', [BookingsController::class, 'status_change']);
            Route::post('/bookings/customerinfo', [BookingsController::class, 'customerinfo']);
            Route::post('/bookings/vendor_note', [BookingsController::class, 'vendor_note']);
            Route::post('/bookings/payment_status-{status}', [BookingsController::class, 'payment_status']);
            // orders
            Route::get('/orders', [OrderController::class, 'index']);
            Route::get('/orders/print/{order_number}', [OrderController::class, 'print_invoice']);
            Route::get('/orders/status_change-{order_number}/{status}/{type}', [OrderController::class, 'status_change']);
            Route::post('/orders/customerinfo', [OrderController::class, 'customerinfo']);
            Route::post('/orders/vendor_note', [OrderController::class, 'vendor_note']);
            Route::post('/orders/payment_status-{status}', [OrderController::class, 'payment_status']);
            // Reports
            Route::get('/reports', [ReportController::class, 'index']);
            Route::get('/orderreports', [ReportController::class, 'orderindex']);
            // Gallery
            Route::get('/gallery', [GalleryController::class, 'index']);
            Route::get('/gallery/add', [GalleryController::class, 'add']);
            Route::post('/gallery/save', [GalleryController::class, 'save']);
            Route::get('/gallery/edit-{id}', [GalleryController::class, 'edit']);
            Route::post('/gallery/update-{id}', [GalleryController::class, 'update']);
            Route::get('/gallery/delete-{id}', [GalleryController::class, 'delete']);
            Route::get('/gallery/bulk_delete', [GalleryController::class, 'bulk_delete']);
            Route::post('/gallery/reorder_gallery', [GalleryController::class, 'reorder_gallery']);
            // why choose us
            Route::get('/choose_us', [WhyChooseUsController::class, 'index']);
            Route::post('/choose_us/savecontent', [WhyChooseUsController::class, 'savecontent']);
            Route::get('/choose_us/add', [WhyChooseUsController::class, 'add']);
            Route::get('/choose_us/edit-{id}', [WhyChooseUsController::class, 'edit']);
            Route::post('/choose_us/update-{id}', [WhyChooseUsController::class, 'update']);
            Route::post('/choose_us/save', [WhyChooseUsController::class, 'save']);
            Route::get('/choose_us/delete-{id}', [WhyChooseUsController::class, 'delete']);
            Route::post('/choose_us/reorder_choose_us', [WhyChooseUsController::class, 'reorder_choose_us']);



            // footer features
            Route::post('/footer_features/save', [WebsiteSettingsController::class, 'footer_features']);

            // Media
            Route::group(['prefix' => 'media'], function () {
                Route::get('/', [MediaController::class, 'index']);
                Route::post('/add_image', [MediaController::class, 'add_image']);
                Route::get('delete-{id}', [MediaController::class, 'delete_media']);
                Route::get('download-{id}', [MediaController::class, 'download']);
            });
            Route::group(['prefix' => 'productmedia'], function () {
                Route::get('/', [MediaController::class, 'index']);
                Route::post('/add_image', [MediaController::class, 'add_image']);
                Route::get('delete-{id}', [MediaController::class, 'delete_media']);
                Route::get('download-{id}', [MediaController::class, 'download']);
            });
        });

        Route::middleware('adminmiddleware')->group(function () {
            Route::get('transaction-{id}-{status}', [TransactionController::class, 'status']);
            // plan
            Route::group(['prefix' => 'plan'], function () {
                Route::get('/add', [PlanPricingController::class, 'add_plan']);
                Route::post('/save_plan', [PlanPricingController::class, 'save_plan']);
                Route::get('/edit-{id}', [PlanPricingController::class, 'edit_plan']);
                Route::post('/update_plan-{id}', [PlanPricingController::class, 'update_plan']);
                Route::get('/status_change-{id}/{status}', [PlanPricingController::class, 'status_change']);
                Route::get('/delete-{id}', [PlanPricingController::class, 'delete']);
                Route::post('reorder_plan', [PlanPricingController::class, 'reorder_plan']);
                Route::post('updateimage', [PlanPricingController::class, 'updateimage']);
            });
            // users
            Route::group(['prefix' => 'users'], function () {
                Route::get('/', [UserController::class, 'view_users']);
                Route::get('/add', [UserController::class, 'add']);
                Route::get('/edit-{slug}', [UserController::class, 'edit']);
                Route::post('/edit_vendorprofile', [UserController::class, 'edit_vendorprofile']);
                Route::get('/status-{slug}/{status}', [UserController::class, 'change_status']);
                Route::get('/login-{slug}', [UserController::class, 'vendor_login']);
                Route::get('delete-{id}', [UserController::class, 'deletevendor']);
            });

            //features
            Route::get('/features', [FeaturesController::class, 'index']);
            Route::get('/features/add', [FeaturesController::class, 'add']);
            Route::post('/features/save', [FeaturesController::class, 'save']);
            Route::get('/features/edit-{id}', [FeaturesController::class, 'edit']);
            Route::post('/features/update-{id}', [FeaturesController::class, 'update']);
            Route::get('/features/delete-{id}', [FeaturesController::class, 'delete']);
            Route::post('/features/reorder_features', [FeaturesController::class, 'reorder_features']);
            Route::get('/features/bulk_delete', [FeaturesController::class, 'bulk_delete']);
            


            // promotional banner
            Route::group(
                ['prefix' => 'promotionalbanners'],
                function () {
                    Route::get('/', [BannerController::class, 'promotional_banner']);
                    Route::get('add', [BannerController::class, 'promotional_banneradd']);
                    Route::get('edit-{id}', [BannerController::class, 'promotional_banneredit']);
                    Route::post('save', [BannerController::class, 'promotional_bannersave_banner']);
                    Route::post('update-{id}', [BannerController::class, 'promotional_bannerupdate']);
                    Route::get('delete-{id}', [BannerController::class, 'promotional_bannerdelete']);
                    Route::post('/reorder_promotionalbanners', [BannerController::class, 'reorder_promotionalbanners']);
                    Route::get('bulk_delete', [BannerController::class, 'promotional_bulkdelete']);
                }
            );

            // countries
            Route::group(
                ['prefix' => 'countries'],
                function () {
                    Route::get('/', [OtherController::class, 'countries']);
                    Route::get('/add', [OtherController::class, 'add_country']);
                    Route::post('/save', [OtherController::class, 'save_country']);
                    Route::get('/edit-{id}', [OtherController::class, 'edit_country']);
                    Route::post('/update-{id}', [OtherController::class, 'update_country']);
                    Route::get('/delete-{id}', [OtherController::class, 'delete_country']);
                    Route::get('/change_status-{id}/{status}', [OtherController::class, 'statuschange_country']);
                    Route::post('/reorder_country', [OtherController::class, 'reorder_country']);
                    Route::get('/bulk_delete', [OtherController::class, 'bulk_delete_country']);
                }
            );
            // city
            Route::group(
                ['prefix' => 'cities'],
                function () {
                    Route::get('/', [OtherController::class, 'cities']);
                    Route::get('/add', [OtherController::class, 'add_city']);
                    Route::post('/save', [OtherController::class, 'save_city']);
                    Route::get('/edit-{id}', [OtherController::class, 'edit_city']);
                    Route::post('/update-{id}', [OtherController::class, 'update_city']);
                    Route::get('/delete-{id}', [OtherController::class, 'delete_city']);
                    Route::get('/change_status-{id}/{status}', [OtherController::class, 'statuschange_city']);
                    Route::post('/reorder_city', [OtherController::class, 'reorder_city']);
                    Route::get('/bulk_delete', [OtherController::class, 'bulk_delete_city']);
                }
            );
            // STORE CATEGORIES
            Route::group(
                ['prefix' => 'store_categories'],
                function () {
                    Route::get('/', [StoreCategoryController::class, 'index']);
                    Route::get('add', [StoreCategoryController::class, 'add_category']);
                    Route::post('save', [StoreCategoryController::class, 'save_category']);
                    Route::get('edit-{id}', [StoreCategoryController::class, 'edit_category']);
                    Route::post('update-{id}', [StoreCategoryController::class, 'update_category']);
                    Route::get('change_status-{id}/{status}', [StoreCategoryController::class, 'change_status']);
                    Route::get('delete-{id}', [StoreCategoryController::class, 'delete_category']);
                    Route::post('/reorder_category', [StoreCategoryController::class, 'reorder_category']);
                    Route::get('bulk_delete', [StoreCategoryController::class, 'bulk_delete_category']);

                }
            );
            // theme
            Route::get('/themes', [ThemeController::class, 'index']);
            Route::get('themes/add', [ThemeController::class, 'add']);
            Route::post('/themes/save', [ThemeController::class, 'save']);
            Route::get('/themes/edit-{id}', [ThemeController::class, 'edit']);
            Route::post('/themes/update-{id}', [ThemeController::class, 'update']);
            Route::get('/themes/delete-{id}', [ThemeController::class, 'delete']);
            Route::get('/themes/bulk_delete', [ThemeController::class, 'bulk_delete']);
            Route::post('/themes/reorder_theme', [ThemeController::class, 'reorder_theme']);

            Route::get('/how_it_works', [HowItWorkController::class, 'index']);
            Route::get('/how_it_works/add', [HowItWorkController::class, 'add']);
            Route::get('/how_it_works/edit-{id}', [HowItWorkController::class, 'edit']);
            Route::post('/how_it_works/save', [HowItWorkController::class, 'save']);
            Route::post('/how_it_works/update-{id}', [HowItWorkController::class, 'update']);
            Route::get('/how_it_works/delete-{id}', [HowItWorkController::class, 'delete']);
            Route::get('/how_it_works/bulk_delete', [HowItWorkController::class, 'bulk_delete']);
            Route::post('/how_it_works/reorder_how_work', [HowItWorkController::class, 'reorder_how_work']);

            Route::post('/fun_fact/update', [WebsiteSettingsController::class, 'fun_fact_update']);
            Route::get('/fun_fact/delete-{id}', [WebsiteSettingsController::class, 'fun_fact_delete']);
        });

        // currency-setting
        Route::group(['prefix' => 'currency-settings'], function () {
            Route::get('/', [CurrencyController::class, 'index']);
            Route::get('/currency/edit-{id}', [CurrencyController::class, 'edit']);
            Route::post('/update-{id}', [CurrencyController::class, 'update']);
        });
    });
});
Route::domain(helper::platformHost())->group(function () {
    Route::group(['namespace' => '', 'middleware' => 'landingMiddleware'], function () {
        if (@helper::appdata('')->landing_page == 1) {
            Route::get('/', [LandingHomeController::class, 'index']);
        }
        Route::post('/emailsubscribe', [LandingHomeController::class, 'emailsubscribe']);
        Route::post('/inquiry', [LandingHomeController::class, 'inquiry']);
        Route::get('/aboutus', [LandingHomeController::class, 'aboutus']);
        Route::get('/privacypolicy', [LandingHomeController::class, 'privacypolicy']);
        Route::get('/termscondition', [LandingHomeController::class, 'termscondition']);
        Route::get('/blogdetail-{slug}', [BlogController::class, 'pageblogdetail']);
        Route::get('/blogs', [BlogController::class, 'allblogs']);
        Route::get('/refund_policy', [LandingHomeController::class, 'refund_policy']);
        Route::get('/faqs', [LandingHomeController::class, 'faqs']);
        Route::get('/contact', [LandingHomeController::class, 'contact']);
        Route::get('/stores', [LandingHomeController::class, 'allstores']);
        Route::post('/getcity', [AdminController::class, 'getcity']);
        Route::get('/themeimages', [LandingHomeController::class, 'themeimages']);
    });
});

helper::registerStorefrontRoutes(function () {
    Route::get('/', [HomeController::class, 'index']);
    Route::get('/pwa', [HomeController::class, 'index']);
    Route::post('direction', [HomeController::class, 'direction']);
    // services
    Route::get('/service-{slug}', [FrontServiceController::class, 'servicedetails']);
    Route::get('/booking-{id}', [FrontServiceController::class, 'servicebooking']);
    Route::post('/addtional_service', [FrontServiceController::class, 'addtional_service']);
    Route::post('/service/timeslot', [FrontServiceController::class, 'timeslot']);
    Route::post('/service/slotlimit', [FrontServiceController::class, 'slotlimit']);
    Route::post('/service/stafflimit', [FrontServiceController::class, 'stafflimit']);
    // Booking
    Route::post('/service/booking', [BookingController::class, 'savebooking']);
    Route::get('/booking/{booking_number}', [BookingController::class, 'booking_detail']);
    Route::get('/status_change-{booking_number}/{status}', [BookingController::class, 'status_change']);
    Route::get('/success-{booking_number}', [BookingController::class, 'booking_success']);
    Route::post('/payment', [BookingController::class, 'booking_payment']);
    Route::any('/mercadoordersuccess', [BookingController::class, 'mercadoorder']);


    // categories
    Route::get('/categories', [FrontCategoryController::class, 'index']);
    // search service List
    Route::get('/services', [FrontServiceController::class, 'index']);
    Route::get('/contact', [OtherPagesController::class, 'index']);
    Route::post('/submit', [OtherPagesController::class, 'save_contact']);
    Route::get('/aboutus', [OtherPagesController::class, 'aboutus']);
    Route::get('/termscondition', [OtherPagesController::class, 'termscondition']);
    Route::get('/privacypolicy', [OtherPagesController::class, 'privacypolicy']);
    Route::get('/refund_policy', [OtherPagesController::class, 'refund_policy']);
    Route::get('/service_unavailable', [OtherPagesController::class, 'service_unavailable']);
    Route::get('/gallery', [OtherPagesController::class, 'gallery']);
    Route::get('/faq', [OtherPagesController::class, 'faq']);
    Route::get('/login', [FrontUserContrloller::class, 'login']);
    Route::post('/checklogin-{logintype}', [FrontUserContrloller::class, 'check_login']);

    Route::get('/register', [FrontUserContrloller::class, 'register']);
    Route::get('/forgotpassword', [FrontUserContrloller::class, 'forgot_password']);
    Route::post('/register_customer', [FrontUserContrloller::class, 'register_customer']);
    Route::post('/send_password', [FrontUserContrloller::class, 'send_password']);
    Route::get('/logout', [FrontUserContrloller::class, 'logout']);
    Route::post('/subscribe', [OtherPagesController::class, 'subscribe']);
    Route::post('/postreview', [FrontServiceController::class, 'postreview']);
    Route::post('/managefavorite', [FrontServiceController::class, 'managefavorite']);
    Route::post('product/managefavorite', [FrontServiceController::class, 'managefavorite']);
    Route::middleware('usermiddleware')->group(function () {
        // profile
        Route::get('/profile', [FrontUserContrloller::class, 'my_profile']);
        Route::post('/editprofile', [FrontUserContrloller::class, 'edit_profile']);
        Route::get('/mybookings', [FrontUserContrloller::class, 'mybookings']);
        Route::get('/myorders', [FrontUserContrloller::class, 'myorders']);
        Route::get('/changepassword', [FrontUserContrloller::class, 'changepassword']);
        Route::post('/updatepassword', [FrontUserContrloller::class, 'updatepassword']);
        Route::get('/deleteprofile', [FrontUserContrloller::class, 'deleteprofile']);
        Route::get('/refer-earn', [FrontUserContrloller::class, 'referearn']);
        Route::get('/deleteuseraccount-{id}', [FrontUserContrloller::class, 'deleteuseraccount']);
        Route::get('/wishlist', [FrontUserContrloller::class, 'wishlist']);
        Route::get('/productwishlist', [FrontUserContrloller::class, 'wishlist']);
        Route::get('/wallet', [FrontUserContrloller::class, 'wallet']);
        Route::get('/addmoneywallet', [FrontUserContrloller::class, 'addmoneywallet']);
        Route::post('/wallet/recharge', [FrontUserContrloller::class, 'addwallet']);
        Route::any('/addwalletsuccess', [FrontUserContrloller::class, 'addsuccess']);
        Route::any('/addfail', [FrontUserContrloller::class, 'addfail']);
        Route::get('/removeall', [FrontServiceController::class, 'removeall']);
    });
});
