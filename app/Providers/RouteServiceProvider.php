<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/home';
    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */
    // protected $namespace = 'App\\Http\\Controllers';
    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();
        $this->routes(function () {
            Route::prefix('api')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api.php'));
            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/web.php'));
            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/calendar.php'));
            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/cart_checkout_countdown.php'));
            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/cart_checkout_progressbar.php'));
            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/include/coupon.php'));
            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/customdomain.php'));
            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/analytics.php'));
            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/zoommeeting.php'));
            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/include/language.php'));
            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/include/blog.php'));
            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/include/store_reviews.php'));
            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/include/whatsappmessage.php'));
            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/telegrammessage.php'));
            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/customers.php'));
            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/notification.php'));
            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/paypal.php'));
            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/myfatoorah.php'));
            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/mercadopago.php'));
            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/toyyibpay.php'));
            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/paytab.php'));
            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/vendorcalendar.php'));
            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/embedded.php'));
            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/recaptcha.php'));
            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/employee.php'));
            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/pwa.php'));
            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/pixel.php'));
            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/product.php'));
            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/shipping.php'));
            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/emailsettings.php'));
            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/custom_status.php'));
            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/tawk.php'));
            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/top_deals.php'));
            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/import.php'));
            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/googlelogin.php'));
            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/facebooklogin.php'));
            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/quick_call.php'));
            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/fake_sales_notification.php'));
            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/age_verification.php'));
            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/product_fake_view.php'));
            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/bank.php'));
            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/payout.php'));
            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/phonepe.php'));
            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/mollie.php'));
            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/khalti.php'));
            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/xendit.php'));
            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/wizz_chat.php'));
            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/question_answer.php'));
            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/currency.php'));
            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/ical_file.php'));
        });
    }
    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });
    }
}
