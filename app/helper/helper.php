<?php

namespace App\helper;

use App\Models\AdditionalService;
use App\Models\Booking;
use App\Models\PricingPlan;
use App\Models\Settings;
use App\Models\User;
use App\Models\SystemAddons;
use App\Models\Service;
use App\Models\Promocode;
use App\Models\Payment;
use App\Models\Transaction;
use App\Models\Languages;
use App\Models\Category;
use App\Models\Pixcel;
use App\Models\Timing;
use App\Models\CustomStatus;
use App\Models\Tax;
use App\Models\SubscriptionSettings;
use App\Models\Favorite;
use App\Models\Bank;
use App\Models\SocialLinks;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Models\Footerfeatures;
use App\Models\LandingSettings;
use App\Models\Blog;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Models\AgeVerification;
use App\Models\Cart;
use App\Models\CurrencySettings;
use App\Models\Customdomain;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\OtherSettings;
use App\Models\Product;
use App\Models\RoleAccess;
use App\Models\RoleManager;
use App\Models\TelegramMessage;
use App\Models\Testimonials;
use App\Models\TopDeals;
use App\Models\WhatsappMessage;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;

class helper
{
    public static function platformHost()
    {
        $host = parse_url((string) env('APP_URL', ''), PHP_URL_HOST);

        if (!empty(env('WEBSITE_HOST'))) {
            $host = env('WEBSITE_HOST');
        }

        return self::normalizeHost($host);
    }

    public static function normalizeHost($host = null)
    {
        if (empty($host)) {
            return null;
        }

        return strtolower(preg_replace('/:\d+$/', '', trim((string) $host)));
    }

    public static function currentHost()
    {
        return self::normalizeHost(request()->getHost() ?: ($_SERVER['HTTP_HOST'] ?? null));
    }

    public static function isPlatformHost($host = null)
    {
        $host = self::normalizeHost($host ?: self::currentHost());
        $platformHost = self::platformHost();

        return !empty($platformHost) && $host === $platformHost;
    }

    public static function isPlatformSubdomainRequest($host = null)
    {
        $host = self::normalizeHost($host ?: self::currentHost());
        $platformHost = self::platformHost();

        return !empty($platformHost) && !self::isPlatformHost($host) && Str::endsWith($host, '.' . $platformHost);
    }

    public static function isCustomDomainRequest($host = null)
    {
        $host = self::normalizeHost($host ?: self::currentHost());

        return !empty($host) && !self::isPlatformHost($host) && !self::isPlatformSubdomainRequest($host);
    }

    public static function tenantSubdomain($host = null)
    {
        $host = self::normalizeHost($host ?: self::currentHost());
        $platformHost = self::platformHost();

        if (!self::isPlatformSubdomainRequest($host) || empty($platformHost)) {
            return null;
        }

        return Str::before($host, '.' . $platformHost);
    }

    public static function customDomainRoutePattern()
    {
        $platformHost = preg_quote((string) self::platformHost(), '/');

        if (empty($platformHost)) {
            return '.+';
        }

        return '^(?!.*' . $platformHost . '$).+';
    }

    public static function registerStorefrontRoutes(callable $callback, $pathParameter = 'vendor', $middleware = ['frontmiddleware'])
    {
        $attributes = [];

        if (!empty($middleware)) {
            $attributes['middleware'] = $middleware;
        }

        $platformHost = self::platformHost();

        if (!empty($platformHost)) {
            Route::group(array_merge($attributes, [
                'domain' => $platformHost,
                'prefix' => '{' . $pathParameter . '}',
            ]), $callback);

            Route::group(array_merge($attributes, [
                'domain' => '{store_subdomain}.' . $platformHost,
            ]), $callback);
        }

        Route::group(array_merge($attributes, [
            'domain' => '{custom_domain}',
            'where' => ['custom_domain' => self::customDomainRoutePattern()],
        ]), $callback);
    }

    public static function customDomainRecord($host = null)
    {
        $host = self::normalizeHost($host ?: self::currentHost());

        if (empty($host)) {
            return null;
        }

        $record = Customdomain::where('current_domain', $host)
            ->where('status', 2)
            ->first();

        if (!empty($record)) {
            return $record;
        }

        $settings = Settings::where('custom_domain', $host)->first();

        if (empty($settings) || empty($settings->vendor_id)) {
            return null;
        }

        $fallbackRecord = new Customdomain();
        $fallbackRecord->vendor_id = $settings->vendor_id;
        $fallbackRecord->current_domain = $host;

        return $fallbackRecord;
    }

    public static function customDomainEnabledForVendor($vendor)
    {
        if (empty($vendor)) {
            return false;
        }

        if ((int) $vendor->allow_without_subscription === 1) {
            return true;
        }

        $latestTransaction = Transaction::where('vendor_id', $vendor->id)
            ->whereNull('transaction_type')
            ->orderByDesc('id')
            ->first();

        return !empty($latestTransaction) && (int) $latestTransaction->custom_domain === 1;
    }

    public static function customDomainForVendor($vendorId)
    {
        $vendor = $vendorId instanceof User ? $vendorId : User::find($vendorId);

        if (empty($vendor) || !self::customDomainEnabledForVendor($vendor)) {
            return null;
        }

        $customDomain = Customdomain::where('vendor_id', $vendor->id)
            ->where('status', 2)
            ->value('current_domain');

        if (empty($customDomain)) {
            $customDomain = Settings::where('vendor_id', $vendor->id)->value('custom_domain');
        }

        return self::normalizeHost($customDomain);
    }

    public static function currentStoreUser($slug = null)
    {
        if (!empty($slug)) {
            return self::vendor_data($slug);
        }

        if (self::isPlatformSubdomainRequest()) {
            return self::vendor_data(self::tenantSubdomain());
        }

        if (self::isCustomDomainRequest()) {
            $record = self::customDomainRecord();

            if (!empty($record)) {
                $vendor = User::find($record->vendor_id);

                if (!empty($vendor) && self::customDomainEnabledForVendor($vendor)) {
                    return $vendor;
                }
            }

            return null;
        }

        $routeVendor = request()->route('vendor')
            ?: request()->route('vendor_slug')
            ?: request()->vendor
            ?: request()->vendor_slug;

        return !empty($routeVendor) ? self::vendor_data($routeVendor) : null;
    }

    public static function storeinfo($slug = null)
    {
        $vendor = self::currentStoreUser($slug);

        if (!empty($vendor)) {
            return Settings::where('vendor_id', $vendor->id)->first();
        }

        return Settings::first();
    }

    public static function storefront_base_url($vendorOrSlug = null)
    {
        $vendor = $vendorOrSlug instanceof User
            ? $vendorOrSlug
            : (is_numeric($vendorOrSlug) ? User::find($vendorOrSlug) : self::vendor_data($vendorOrSlug));

        if (empty($vendor)) {
            return rtrim((string) config('app.url'), '/');
        }

        $scheme = request()->getScheme();
        $customDomain = self::customDomainForVendor($vendor);

        if (!empty($customDomain)) {
            return $scheme . '://' . $customDomain;
        }

        if (filter_var(env('STORE_SUBDOMAIN_ROUTING', false), FILTER_VALIDATE_BOOLEAN)) {
            return $scheme . '://' . $vendor->slug . '.' . self::platformHost();
        }

        return rtrim((string) config('app.url'), '/') . '/' . ltrim($vendor->slug, '/');
    }

    public static function storefront_url($vendorOrSlug = null, $path = '')
    {
        $baseUrl = rtrim(self::storefront_base_url($vendorOrSlug), '/');
        $path = ltrim((string) $path, '/');

        return empty($path) ? $baseUrl : $baseUrl . '/' . $path;
    }

    public static function storefront_request_is(...$patterns)
    {
        $currentPath = trim(request()->path(), '/');

        if (self::isPlatformHost() && !empty(request()->route('vendor'))) {
            $currentPath = trim(Str::after($currentPath, request()->route('vendor')), '/');
        }

        foreach ($patterns as $pattern) {
            if (Str::is(trim($pattern, '/'), $currentPath)) {
                return true;
            }
        }

        return false;
    }

    // admin
    public static function appdata($vendor_id)
    {
        if (!empty($vendor_id)) {
            $data = Settings::where('vendor_id', $vendor_id)->first();

            if (!empty($data)) {
                return $data;
            }
        }

        $storeSettings = self::storeinfo();

        return !empty($storeSettings) ? $storeSettings : Settings::first();
    }

    public static function otherappdata($vendor_id)
    {
        if (!empty($vendor_id)) {
            $data = OtherSettings::where('vendor_id', $vendor_id)->first();

            if (!empty($data)) {
                return $data;
            }
        }

        $vendor = self::currentStoreUser();

        if (!empty($vendor)) {
            $data = OtherSettings::where('vendor_id', $vendor->id)->first();

            if (!empty($data)) {
                return $data;
            }
        }

        return OtherSettings::first();
    }

    public static function vendordata()
    {
        return self::currentStoreUser();
    }
    public static function telegramdata($vendor_id)
    {
        $data = TelegramMessage::where('vendor_id', $vendor_id)->first();
        return $data;
    }

    public static function currency_formate($price, $vendor_id)
    {
        $price = $price * helper::currencyinfo($vendor_id)->exchange_rate;

        if (helper::currencyinfo($vendor_id)->currency_position == "1") {
            if (helper::currencyinfo($vendor_id)->decimal_separator == 1) {
                if (helper::currencyinfo($vendor_id)->currency_space == 1) {
                    return helper::currencyinfo($vendor_id)->currency . ' ' . number_format($price, helper::currencyinfo($vendor_id)->currency_formate, '.', ',');
                } else {
                    return helper::currencyinfo($vendor_id)->currency . number_format($price, helper::currencyinfo($vendor_id)->currency_formate, '.', ',');
                }
            } else {
                if (helper::currencyinfo($vendor_id)->currency_space == 1) {
                    return helper::currencyinfo($vendor_id)->currency . ' ' . number_format($price, helper::currencyinfo($vendor_id)->currency_formate, ',', '.');
                } else {
                    return helper::currencyinfo($vendor_id)->currency . number_format($price, helper::currencyinfo($vendor_id)->currency_formate, ',', '.');
                }
            }
        }
        if (helper::currencyinfo($vendor_id)->currency_position == "2") {
            if (helper::currencyinfo($vendor_id)->decimal_separator == 1) {
                if (helper::currencyinfo($vendor_id)->currency_space == 1) {
                    return number_format($price, helper::currencyinfo($vendor_id)->currency_formate, '.', ',') . ' ' . helper::currencyinfo($vendor_id)->currency;
                } else {
                    return number_format($price, helper::currencyinfo($vendor_id)->currency_formate, '.', ',') . helper::currencyinfo($vendor_id)->currency;
                }
            } else {
                if (helper::currencyinfo($vendor_id)->currency_space == 1) {
                    return number_format($price, helper::currencyinfo($vendor_id)->currency_formate, ',', '.') . ' ' . helper::currencyinfo($vendor_id)->currency;
                } else {
                    return number_format($price, helper::currencyinfo($vendor_id)->currency_formate, ',', '.') . helper::currencyinfo($vendor_id)->currency;
                }
                return number_format($price, helper::currencyinfo($vendor_id)->currency_formate, ',', '.') . helper::currencyinfo($vendor_id)->currency;
            }
        }
        return $price;
    }

    //Send Email Start
    public static function send_mail_forpassword($email, $name, $password, $logo)
    {
        $var = ["{user}", "{password}"];
        $newvar = [$name, $password];
        $forpasswordmessage = str_replace($var, $newvar, nl2br(helper::appdata('')->forget_password_email_message));
        $data = ['title' => "New Password", 'email' => $email, 'forpasswordmessage' => $forpasswordmessage, 'logo' => helper::image_path($logo)];
        try {
            Mail::send('email.sendpassword', $data, function ($message) use ($data) {
                $message->to($data['email'])->subject($data['title']);
            });
            return 1;
        } catch (\Throwable $th) {
            return $th;
        }
    }
    // public static function send_mail_forotp($name, $email, $otp, $logo)
    // {
    //     $data = ['title' => trans('labels.email_verification'), 'email' => $email, 'name' => $name, 'otp' => $otp, 'logo' => helper::image_path($logo)];
    //     try {
    //         Mail::send('email.otpverification', $data, function ($message) use ($data) {
    //             $message->to($data['email'])->subject($data['title']);
    //         });
    //         return 1;
    //     } catch (\Throwable $th) {
    //         return $th;
    //     }
    // }

    public static function referral($email, $referralmessage)
    {
        $data = ['title' => trans('labels.referral_earning'), 'email' => $email, 'logo' => helper::image_path(@helper::appdata('')->logo), 'referralmessage' => $referralmessage];
        try {
            Mail::send('email.referral', $data, function ($message) use ($data) {
                $message->to($data['email'])->subject($data['title']);
            });
            return 1;
        } catch (\Throwable $th) {
            return 0;
        }
    }
    public static function send_mail_vendor_block($vendor)
    {
        $var = ["{vendorname}"];
        $newvar = [$vendor->name];
        $vendorblokedmessage = str_replace($var, $newvar, nl2br(helper::appdata('')->vendor_status_change_email_message));
        $data = ['title' => trans('labels.account_deleted'), 'vendorblokedmessage' => $vendorblokedmessage, 'vendor_email' => $vendor->email];
        try {
            Mail::send('email.vendorbloked', $data, function ($message) use ($data) {
                $message->to($data['vendor_email'])->subject($data['title']);
            });
            return 1;
        } catch (\Throwable $th) {
            return 0;
        }
    }
    public static function send_mail_delete_account($vendor)
    {
        $var = ["{vendorname}"];
        $newvar = [$vendor->name];
        $userdeletemessage = str_replace($var, $newvar, nl2br(helper::appdata('')->delete_account_email_message));
        $data = ['title' => trans('labels.account_deleted'), 'userdeletemessage' => $userdeletemessage, 'email' => $vendor->email];
        try {
            Mail::send('email.accountdeleted', $data, function ($message) use ($data) {
                $message->to($data['email'])->subject($data['title']);
            });
            return 1;
        } catch (\Throwable $th) {
            return 0;
        }
    }
    public static function send_mail_vendor_register($vendor)
    {
        $admininfo = User::where('id', 1)->first();
        $vendorvar = ["{vendorname}"];
        $vendornewvar = [$vendor->name];
        $vendormessage = str_replace($vendorvar, $vendornewvar, nl2br(helper::appdata('')->vendor_register_email_message));

        $adminvar = ["{adminname}", "{vendorname}", "{vendoremail}", "{vendormobile}"];
        $adminnewvar = [$admininfo->name, $vendor->name, $vendor->email, $vendor->mobile];
        $adminmessage = str_replace($adminvar, $adminnewvar, nl2br(helper::appdata('')->admin_vendor_register_email_message));

        $data = ['title' => trans('labels.registration'), 'title1' => 'New Vendor Registration', 'vendor_email' => $vendor->email, 'admin_email' => $admininfo->email, "vendormessage" => $vendormessage, 'adminmessage' => $adminmessage];
        try {
            Mail::send('email.vendorregister', $data, function ($message) use ($data) {
                $message->to($data['vendor_email'])->subject($data['title']);
            });

            Mail::send('email.newvendorregistration', $data, function ($message) use ($data) {
                $message->to($data['admin_email'])->subject($data['title1']);
            });
            return 1;
        } catch (\Throwable $th) {
            return 0;
        }
    }
    public static function send_mail_forbooking($booking_info, $traceurl, $customer_email)
    {
        $vendor_email = User::where('id', $booking_info->vendor_id)->first();

        $bookinginvoicevar = ["{customername}", "{booking_number}", "{booking_date}", "{booking_starttime}", "{booking_endtime}", "{grandtotal}", "{track_booking_url}", "{vendorname}"];
        $bookinginvoicenewvar = [$booking_info->customer_name, $booking_info->booking_number, $booking_info->booking_date, $booking_info->booking_time, $booking_info->booking_endtime, helper::currency_formate($booking_info->grand_total, $vendor_email->vendor_id), $traceurl, helper::appdata($vendor_email->vendor_id)->web_title];
        $newbookinginvoicemessage = str_replace($bookinginvoicevar, $bookinginvoicenewvar, nl2br(helper::appdata($booking_info->vendor_id)->new_order_invoice_email_message));

        $bookingemailvar = ["{customername}", "{booking_number}", "{booking_date}", "{booking_starttime}", "{booking_endtime}", "{grandtotal}", "{vendorname}"];
        $bookingemailnewvar = [$booking_info->customer_name, $booking_info->booking_number, $booking_info->booking_date, $booking_info->booking_time, $booking_info->booking_endtime, helper::currency_formate($booking_info->grand_total, $vendor_email->vendor_id), helper::appdata($vendor_email->vendor_id)->web_title];
        $vendornewbookingemailmessage = str_replace($bookingemailvar, $bookingemailnewvar, nl2br(helper::appdata($booking_info->vendor_id)->vendor_new_order_email_message));

        $data = ['title' => trans('labels.booking_invoice'), 'email' => $customer_email, 'vendor_email' => $vendor_email->email, 'newbookinginvoicemessage' => $newbookinginvoicemessage, 'vendornewbookingemailmessage' => $vendornewbookingemailmessage,];
        try {
            Mail::send('email.emailinvoice', $data, function ($message) use ($data) {
                $message->to($data['email'])->subject($data['title']);
            });
            Mail::send('email.bookinginvoice', $data, function ($message) use ($data) {
                $message->to($data['vendor_email'])->subject($data['title']);
            });
            return 1;
        } catch (\Throwable $th) {
            return 0;
        }
    }
    public static function booking_status_email($email, $name, $title, $message_text, $vendor)
    {
        $var = ["{customername}", "{status_message}", "{vendorname}"];
        $newvar = [$name, $message_text, $vendor->name];
        $bookingstatusmessage = str_replace($var, $newvar, nl2br(helper::appdata($vendor->id)->order_status_email_message));
        $data = ['email' => $email, 'title' => $title, 'bookingstatusmessage' => $bookingstatusmessage, 'logo' => helper::image_path(@helper::appdata($vendor->id)->logo)];
        try {
            Mail::send('email.bookingstatus', $data, function ($message) use ($data) {
                $message->to($data['email'])->subject($data['title']);
            });
            return 1;
        } catch (\Throwable $th) {
            return 0;
        }
    }
    public static function send_mail_formeeting($customer_name, $meetingid, $service_name, $booking_number, $email, $password, $logo, $booking_date, $vendor, $join_url)
    {

        $data = ['title' => 'Meeting info', 'customer_name' => $customer_name, 'id' => $meetingid, 'service_name' => $service_name, 'booking_number' => $booking_number, 'password' => $password, 'email' => $email, 'logo' => helper::image_path($logo), 'booking_date' => $booking_date, 'vendor' => $vendor, 'join_url' => $join_url];
        try {
            Mail::send('email.meetingdetail', $data, function ($message) use ($data) {
                $message->to($data['email'])->subject($data['title']);
            });
            return 1;
        } catch (\Throwable $th) {
            return 0;
        }
    }
    public static function vendor_contact_data($id, $vendor_name, $vendor_email, $full_name, $useremail, $usermobile, $usermessage)
    {
        $var = ["{vendorname}", "{username}", "{useremail}", "{usermobile}", "{usermessage}"];
        $newvar = [$vendor_name, $full_name, $useremail, $usermobile, $usermessage];
        $vendorcontactmessage = str_replace($var, $newvar, nl2br(helper::appdata($id)->contact_email_message));

        $data = ['title' => trans('labels.inquiry'), 'vendor_email' => $vendor_email, 'vendorcontactmessage' => $vendorcontactmessage];
        try {
            Mail::send('email.vendorcontact', $data, function ($message) use ($data) {
                $message->to($data['vendor_email'])->subject($data['title']);
            });
            return 1;
        } catch (\Throwable $th) {
            return 0;
        }
    }
    public static function send_subscription_email($vendor_email, $vendor_name, $plan_name, $duration, $price, $payment_method, $transaction_id)
    {
        $admininfo = User::where('id', '1')->first();
        $vendorvar = ["{vendorname}", "{payment_type}", "{subscription_duration}", "{subscription_price}", "{plan_name}", "{adminname}", "{adminemail}"];
        $vendornewvar = [$vendor_name, $payment_method, $duration, $price, $plan_name, $admininfo->name, $admininfo->email];
        $vendormessage = str_replace($vendorvar, $vendornewvar, nl2br(helper::appdata('')->subscription_success_email_message));

        $adminvar = ["{adminname}", "{vendorname}", "{vendoremail}", "{plan_name}", "{subscription_duration}", "{subscription_price}", "{payment_type}"];
        $adminnewvar = [$admininfo->name, $vendor_name, $vendor_email, $plan_name, $duration, $price, $payment_method];
        $adminmessage = str_replace($adminvar, $adminnewvar, nl2br(helper::appdata('')->admin_subscription_success_email_message));

        $data = ['title' => trans('labels.new_subscription_purchase'), 'vendor_email' => $vendor_email, 'vendormessage' => $vendormessage];

        $adminemail = ['title' => trans('labels.new_subscription_purchase'), 'admin_email' => $admininfo->email, 'adminmessage' => $adminmessage];

        try {
            Mail::send('email.subscription', $data, function ($message) use ($data) {
                $message->to($data['vendor_email'])->subject($data['title']);
            });

            Mail::send('email.adminsubscription', $adminemail, function ($message) use ($adminemail) {
                $message->to($adminemail['admin_email'])->subject($adminemail['title']);
            });
            return 1;
        } catch (\Throwable $th) {
            return 0;
        }
    }
    public static function subscription_rejected($vendor_email, $vendor_name, $plan_name, $payment_method)
    {
        $admindata = User::select('name', 'email')->where('id', '1')->first();
        $var = ["{vendorname}", "{payment_type}", "{plan_name}", "{adminname}", "{adminemail}"];
        $newvar = [$vendor_name, $payment_method, $plan_name, $admindata->name, $admindata->email];
        $rejectmessage = str_replace($var, $newvar, nl2br(helper::appdata('')->subscription_reject_email_message));

        $data = ['title' => trans('messages.cod_rejected'), 'vendor_email' => $vendor_email, 'rejectmessage' => $rejectmessage];
        try {
            Mail::send('email.banktransferreject', $data, function ($message) use ($data) {
                $message->to($data['vendor_email'])->subject($data['title']);
            });
            return 1;
        } catch (\Throwable $th) {
            return 0;
        }
    }
    public static function cod_request($vendor_email, $vendor_name, $plan_name, $duration, $price, $payment_method, $transaction_id)
    {
        $admininfo = User::where('id', '1')->first();
        $vendorvar = ["{vendorname}", "{adminname}", "{adminemail}"];
        $vendornewvar = [$vendor_name, $admininfo->name, $admininfo->email];
        $vendormessage = str_replace($vendorvar, $vendornewvar, nl2br(helper::appdata('')->cod_request_email_message));

        $adminvar = ["{adminname}", "{vendorname}", "{vendoremail}", "{plan_name}", "{subscription_duration}", "{subscription_price}", "{payment_type}"];
        $adminnewvar = [$admininfo->name, $vendor_name, $vendor_email, $plan_name, $duration, $price, $payment_method];
        $adminmessage = str_replace($adminvar, $adminnewvar, nl2br(helper::appdata('')->admin_subscription_request_email_message));

        $data = ['title' =>  trans('labels.cod'), 'vendor_email' => $vendor_email, 'vendormessage' => $vendormessage];
        $adminemail = ['title' =>  trans('labels.cod'), 'admin_email' => $admininfo->email, 'adminmessage' => $adminmessage];
        try {
            Mail::send('email.codvendor', $data, function ($message) use ($data) {
                $message->to($data['vendor_email'])->subject($data['title']);
            });

            Mail::send('email.banktransferadmin', $adminemail, function ($message) use ($adminemail) {
                $message->to($adminemail['admin_email'])->subject($adminemail['title']);
            });
            return 1;
        } catch (\Throwable $th) {
            return 0;
        }
    }
    public static function bank_transfer_request($vendor_email, $vendor_name, $plan_name, $duration, $price, $payment_method, $transaction_id)
    {
        $admininfo = User::where('id', '1')->first();
        $vendorvar = ["{vendorname}", "{adminname}", "{adminemail}"];
        $vendornewvar = [$vendor_name, $admininfo->name, $admininfo->email];
        $vendormessage = str_replace($vendorvar, $vendornewvar, nl2br(helper::appdata('')->banktransfer_request_email_message));

        $adminvar = ["{adminname}", "{vendorname}", "{vendoremail}", "{plan_name}", "{subscription_duration}", "{subscription_price}", "{payment_type}"];
        $adminnewvar = [$admininfo->name, $vendor_name, $vendor_email, $plan_name, $duration, $price, $payment_method];
        $adminmessage = str_replace($adminvar, $adminnewvar, nl2br(helper::appdata('')->admin_subscription_request_email_message));

        $data = ['title' => "Bank transfer", 'vendor_email' => $vendor_email, 'vendormessage' => $vendormessage];
        $adminemail = ['title' => "Bank transfer", 'admin_email' => $admininfo->email, 'adminmessage' => $adminmessage];
        try {
            Mail::send('email.banktransfervendor', $data, function ($message) use ($data) {
                $message->to($data['vendor_email'])->subject($data['title']);
            });

            Mail::send('email.banktransferadmin', $adminemail, function ($message) use ($adminemail) {
                $message->to($adminemail['admin_email'])->subject($adminemail['title']);
            });
            return 1;
        } catch (\Throwable $th) {
            return 0;
        }
    }
    public static function cancel_booking($email, $name, $title, $message_text, $booking)
    {
        $var = ["{customername}", "{status_message}", "{vendorname}"];
        $newvar = [$name, $message_text, $booking->customer_name];
        $bookingstatusmessage = str_replace($var, $newvar, nl2br(helper::appdata($booking->vendor_id)->order_status_email_message));
        $data = ['email' => $email, 'title' => $title, 'bookingstatusmessage' => $bookingstatusmessage, 'message_text' => $message_text, 'logo' => helper::image_path(@helper::appdata($booking->vendor_id)->logo)];
        try {
            Mail::send('email.bookingstatus', $data, function ($message) use ($data) {
                $message->to($data['email'])->subject($data['title']);
            });
            return 1;
        } catch (\Throwable $th) {
            return 0;
        }
    }

    public static function create_order_invoice($customer_email, $customer_name, $vendoremail, $vendorname, $vendorid, $order_number, $date, $trackurl, $grandtotal)
    {
        $orderinvoicevar = ["{customername}", "{order_number}", "{order_date}", "{grandtotal}", "{track_order_url}", "{vendorname}"];
        $orderinvoicenewvar = [$customer_name, $order_number, $date, $grandtotal, $trackurl, $vendorname];
        $neworderinvoicemessage = str_replace($orderinvoicevar, $orderinvoicenewvar, nl2br(helper::appdata($vendorid)->new_product_order_invoice_email_message));

        $orderemailvar = ["{customername}", "{order_number}", "{order_date}", "{grandtotal}", "{vendorname}"];
        $orderemailnewvar = [$customer_name, $order_number, $date, $grandtotal, $vendorname];
        $neworderemailmessage = str_replace($orderemailvar, $orderemailnewvar, nl2br(helper::appdata($vendorid)->vendor_new_product_order_email_message));

        $data = ['title' => trans('labels.new_order_invoice'), 'customer_email' => $customer_email, 'neworderinvoicemessage' => $neworderinvoicemessage, 'neworderemailmessage' => $neworderemailmessage, 'company_email' => $vendoremail];

        try {
            Mail::send('email.productemailinvoice', $data, function ($message) use ($data) {
                $message->to($data['customer_email'])->subject($data['title']);
            });

            Mail::send('email.orderemail', $data, function ($message) use ($data) {
                $message->to($data['company_email'])->subject($data['title']);
            });
            return 1;
        } catch (\Throwable $th) {
            return 0;
        }
    }
    public static function order_status_email($email, $name, $title, $message_text, $vendor)
    {
        $var = ["{customername}", "{status_message}", "{vendorname}"];
        $newvar = [$name, $message_text, $vendor->name];
        $orderstatusmessage = str_replace($var, $newvar, nl2br(helper::appdata($vendor->id)->product_order_status_email_message));
        $data = ['user_email' => $email, 'title' => $title, 'orderstatusmessage' => $orderstatusmessage];
        try {
            Mail::send('email.orderstatus', $data, function ($message) use ($data) {
                $message->to($data['user_email'])->subject($data['title']);
            });
            return 1;
        } catch (\Throwable $th) {
            return 0;
        }
    }
    public static function cancel_order($email, $name, $title, $message_text, $vendor)
    {
        $var = ["{customername}", "{status_message}", "{vendorname}"];
        $newvar = [$name, $message_text, $vendor->user_name];
        $orderstatusmessage = str_replace($var, $newvar, nl2br(helper::appdata($vendor->vendor_id)->order_status_email_message));
        $data = ['email' => $email, 'title' => $title, 'orderstatusmessage' => $orderstatusmessage, 'logo' => Helper::image_path(@Helper::appdata($vendor->id)->logo)];
        try {
            Mail::send('email.orderstatus', $data, function ($message) use ($data) {
                $message->to($data['email'])->subject($data['title']);
            });
            return 1;
        } catch (\Throwable $th) {
            return 0;
        }
    }

    public static function send_payout_email($vendor_email, $vendor_name, $payable_amt, $commission, $earning_amt)
    {
        $admininfo = User::where('id', '1')->first();
        $vendorpayoutvar = ["{vendorname}", "{earning_amt}", "{commission}", "{payable_amt}", "{adminname}", "{adminemail}"];
        $vendorpayoutnewvar = [$vendor_name, $earning_amt, $commission, $payable_amt, $admininfo->name, $admininfo->email];
        $vendorpayoutmessage = str_replace($vendorpayoutvar, $vendorpayoutnewvar, nl2br(helper::appdata('')->payout_request_email_message));

        $adminpayoutvar = ["{adminname}", "{earning_amt}", "{commission}", "{payable_amt}", "{vendorname}", "{vendoremail}"];
        $adminpayoutnewvar = [$admininfo->name, $earning_amt, $commission, $payable_amt, $vendor_name, $vendor_email];
        $adminpayoutmessage = str_replace($adminpayoutvar, $adminpayoutnewvar, nl2br(helper::appdata('')->admin_payout_request_email_message));

        $data = ['title' => trans('labels.payout'), 'vendor_email' => $vendor_email, 'admin_email' => $admininfo->email, 'vendorpayoutmessage' => $vendorpayoutmessage, 'adminpayoutmessage' => $adminpayoutmessage];

        try {
            Mail::send('email.payout', $data, function ($message) use ($data) {
                $message->to($data['vendor_email'])->subject($data['title']);
            });

            Mail::send('email.adminpayout', $data, function ($message) use ($data) {
                $message->to($data['admin_email'])->subject($data['title']);
            });
            return 1;
        } catch (\Throwable $th) {
            return 0;
        }
    }
    // Send Email end
    public static function date_formate($date, $vendor_id)
    {
        return date(helper::appdata($vendor_id)->date_format, strtotime($date));
    }
    public static function time_format($time, $vendor_id)
    {
        if (helper::appdata($vendor_id)->time_format == 1) {
            return $time->format('H:i');
        } else {
            return $time->format('h:i A');
        }
    }
    public static function image_path($image)
    {

        if ($image == "" && $image == null) {
            $url = asset('storage/app/public/admin-assets/images/defaultimages/placeholder.png');
        } else {
            $url = asset('storage/app/public/admin-assets/images/defaultimages/placeholder.png');
        }
        if (Str::contains($image, 'no-data')) {
            if (file_exists(storage_path('app/public/admin-assets/images/about/' . $image))) {
                $url = url(env('ASSETPATHURL') . 'admin-assets/images/about/' . $image);
            }
        }
        if (Str::contains($image, 'profile')) {
            if (file_exists(env('ASSETPATHURL') . 'admin-assets/images/profile/'  . $image)) {
                $url = url(env('ASSETPATHURL') . 'admin-assets/images/profile/' . $image);
            }
        }
        if (Str::contains($image, 'category')) {
            if (file_exists(env('ASSETPATHURL') . 'admin-assets/images/categories/'  . $image)) {
                $url = url(env('ASSETPATHURL') . 'admin-assets/images/categories/' . $image);
            }
        }
        if (Str::contains($image, 'service')) {
            if (file_exists(env('ASSETPATHURL') . 'admin-assets/images/service/'  . $image)) {
                $url = url(env('ASSETPATHURL') . 'admin-assets/images/service/' . $image);
            }
        }
        if (Str::contains($image, 'product')) {
            if (file_exists(env('ASSETPATHURL') . 'admin-assets/images/product/'  . $image)) {
                $url = url(env('ASSETPATHURL') . 'admin-assets/images/product/' . $image);
            }
        }
        if (Str::contains($image, 'theme-')) {
            if (file_exists(env('ASSETPATHURL') . 'admin-assets/images/theme/'  . $image)) {
                $url = url(env('ASSETPATHURL') . 'admin-assets/images/theme/' . $image);
            }
        }
        if (Str::contains($image, 'feature-')) {
            if (file_exists(env('ASSETPATHURL') . 'admin-assets/images/feature/'  . $image)) {
                $url = url(env('ASSETPATHURL') . 'admin-assets/images/feature/' . $image);
            }
        }
        if (Str::contains($image, 'testimonial-')) {
            if (file_exists(env('ASSETPATHURL') . 'admin-assets/images/testimonials/'  . $image)) {
                $url = url(env('ASSETPATHURL') . 'admin-assets/images/testimonials/' . $image);
            }
        }
        if (Str::contains($image, 'payment')  || Str::contains($image, 'cod') || Str::contains($image, 'stripe') || Str::contains($image, 'paystack') || Str::contains($image, 'razorpay') || Str::contains($image, 'wallet') || Str::contains($image, 'flutterwave') || Str::contains($image, 'bank') || Str::contains($image, 'mercadopago') || Str::contains($image, 'paypal') || Str::contains($image, 'myfatoorah') || Str::contains($image, 'toyyibpay')  || Str::contains($image, 'phonepe') || Str::contains($image, 'paytab') || Str::contains($image, 'mollie') || Str::contains($image, 'khalti') || Str::contains($image, 'xendit') || Str::contains($image, 'payment')) {
            if (file_exists(env('ASSETPATHURL') . 'admin-assets/images/about/payment/'  . $image)) {
                $url = url(env('ASSETPATHURL') . 'admin-assets/images/about/payment/' . $image);
            }
        }
        if (Str::contains($image, 'screenshot')) {
            if (file_exists(env('ASSETPATHURL') . 'admin-assets/images/screenshot/'  . $image)) {
                $url = url('storage/app/public/admin-assets/images/screenshot/' . $image);
            }
        }
        if (Str::contains($image, 'logo')) {
            if (file_exists(env('ASSETPATHURL') . 'admin-assets/images/about/logo/'  . $image)) {
                $url = url(env('ASSETPATHURL') . 'admin-assets/images/about/logo/' . $image);
            }

            if (file_exists(env('ASSETPATHURL') . 'admin-assets/images/defaultimages/' . $image)) {
                $url = url(env('ASSETPATHURL') . 'admin-assets/images/defaultimages/' . $image);
            }
        }
        if (Str::contains($image, 'favicon-')) {
            if (file_exists(env('ASSETPATHURL') . 'admin-assets/images/about/favicon/'  . $image)) {
                $url = url(env('ASSETPATHURL') . 'admin-assets/images/about/favicon/' . $image);
            }
            if (file_exists(env('ASSETPATHURL') . 'admin-assets/images/defaultimages/' . $image)) {
                $url = url(env('ASSETPATHURL') . 'admin-assets/images/defaultimages/' . $image);
            }
        }
        if (Str::contains($image, 'og_image')) {
            if (file_exists(env('ASSETPATHURL') . 'admin-assets/images/about/og_image/'  . $image)) {
                $url = url(env('ASSETPATHURL') . 'admin-assets/images/about/og_image/' . $image);
            }
            if (file_exists(env('ASSETPATHURL') . 'admin-assets/images/defaultimages/' . $image)) {
                $url = url(env('ASSETPATHURL') . 'admin-assets/images/defaultimages/' . $image);
            }
        }
        if (Str::contains($image, 'banner') || Str::contains($image, 'promotion')) {
            if (file_exists(env('ASSETPATHURL') . 'admin-assets/images/banner/'  . $image)) {
                $url = url(env('ASSETPATHURL') . 'admin-assets/images/banner/' . $image);
            }
        }
        if (Str::contains($image, 'blog')) {
            if (file_exists(env('ASSETPATHURL') . 'admin-assets/images/blog/'  . $image)) {
                $url = url(env('ASSETPATHURL') . 'admin-assets/images/blog/' . $image);
            }
        }
        if (Str::contains($image, 'flag')) {
            if (file_exists(env('ASSETPATHURL') . 'admin-assets/images/language/'  . $image)) {
                $url = url(env('ASSETPATHURL') . 'admin-assets/images/language/' . $image);
            }
        }
        if (Str::contains($image, 'cover')) {

            $url = url(env('ASSETPATHURL') . 'admin-assets/images/coverimage/' . $image);
        }
        if (Str::contains($image, 'gallery')) {
            if (file_exists(env('ASSETPATHURL') . 'admin-assets/images/gallery/'  . $image)) {
                $url = url(env('ASSETPATHURL') . 'admin-assets/images/gallery/' . $image);
            }
        }
        if (Str::contains($image, 'trusted_badge')) {
            if (file_exists(env('ASSETPATHURL') . 'admin-assets/images/about/trusted_badge/'  . $image)) {
                $url = url(env('ASSETPATHURL') . 'admin-assets/images/about/trusted_badge/' . $image);
            }
        }
        if (Str::contains($image, 'choose') || Str::contains($image, 'appsection') ||  Str::contains($image, 'subscription') ||  Str::contains($image, 'subscribe') || Str::contains($image, 'work') || Str::contains($image, 'faq') || Str::contains($image, 'order_success') || Str::contains($image, 'no_data') || Str::contains($image, 'maintenance') || Str::contains($image, 'store_unavailable') || Str::contains($image, 'auth')  || Str::contains($image, 'frame_logo') || Str::contains($image, 'referral')) {
            if (file_exists(env('ASSETPATHURL') . 'admin-assets/images/index/'  . $image)) {
                $url = url(env('ASSETPATHURL') . 'admin-assets/images/index/' . $image);
            }
        }
        if (Str::contains($image, 'contact')) {
            if (file_exists(env('ASSETPATHURL') . 'admin-assets/images/contact/'  . $image)) {
                $url = url(env('ASSETPATHURL') . 'admin-assets/images/contact/' . $image);
            }
        }
        if (Str::contains($image, 'auth')) {
            if (file_exists(env('ASSETPATHURL') . 'admin-assets/images/form/'  . $image)) {
                $url = url(env('ASSETPATHURL') . 'admin-assets/images/form/' . $image);
            }
        }
        if (Str::contains($image, 'additional_service')) {
            if (file_exists(env('ASSETPATHURL') . 'admin-assets/images/additional_service/'  . $image)) {
                $url = url(env('ASSETPATHURL') . 'admin-assets/images/additional_service/' . $image);
            }
        }
        if (Str::contains($image, 'login') || Str::contains($image, 'default') || Str::contains($image, 'home') || Str::contains($image, 'quick-call')) {
            if (file_exists(env('ASSETPATHURL') . 'admin-assets/images/about/'  . $image)) {
                $url = url(env('ASSETPATHURL') . 'admin-assets/images/about/' . $image);
            }
        }
        return $url;
    }
    public static function plandetail($plan_id)
    {
        $planinfo = PricingPlan::where('id', $plan_id)->first();
        return $planinfo;
    }
    public static function getlimit($id)
    {
        $limit = Transaction::where('vendor_id', $id)->orderbyDesc('id')->first();
        return $limit;
    }
    public static function checkplan($id, $type)
    {
        $check = SystemAddons::where('unique_identifier', 'subscription')->first();
        if (@$check->activated != 1) {
            return response()->json(['status' => 1, 'message' => '', 'expdate' => "", 'showclick' => "0", 'plan_message' => '', 'plan_date' => '', 'checklimit' => '', 'bank_transfer' => ''], 200);
        }
        $vendordata = User::where('id', $id)->first();
        $checkplan = Transaction::where('vendor_id', $vendordata->id)->where('transaction_type', null)->orderByDesc('id')->first();
        $totalservice = Service::where('vendor_id', $vendordata->id)->count();
        $totalproduct = Product::where('vendor_id', $vendordata->id)->count();
        if ($vendordata->allow_without_subscription != 1) {
            if (!empty($checkplan)) {
                if ($vendordata->is_available == 2) {
                    return response()->json(['status' => 2, 'message' => trans('messages.account_blocked_by_admin'), 'showclick' => "0", 'plan_message' => '', 'plan_date' => '', 'checklimit' => '', 'bank_transfer' => ''], 200);
                }
                if ($checkplan->payment_type == 1) {
                    if ($checkplan->status == 1) {
                        return response()->json(['status' => 2, 'message' => trans('messages.cod_pending'), 'showclick' => "0", 'plan_message' => trans('messages.cod_pending'), 'plan_date' => '', 'checklimit' => '', 'bank_transfer' => '1'], 200);
                    } elseif ($checkplan->status == 3) {
                        return response()->json(['status' => 2, 'message' => trans('messages.cod_rejected'), 'showclick' => "1", 'plan_message' => trans('messages.cod_rejected'), 'plan_date' => '', 'checklimit' => '', 'bank_transfer' => ''], 200);
                    }
                }
                if ($checkplan->payment_type == 6) {

                    if ($checkplan->status == 1) {
                        return response()->json(['status' => 2, 'message' => trans('messages.bank_request_pending'), 'showclick' => "0", 'plan_message' => trans('messages.bank_request_pending'), 'plan_date' => '', 'checklimit' => '', 'bank_transfer' => '1'], 200);
                    } elseif ($checkplan->status == 3) {
                        return response()->json(['status' => 2, 'message' => trans('messages.bank_request_rejected'), 'showclick' => "1", 'plan_message' => trans('messages.bank_request_rejected'), 'plan_date' => '', 'checklimit' => '', 'bank_transfer' => ''], 200);
                    }
                }
                if ($checkplan->expire_date != "") {
                    if (date('Y-m-d') > $checkplan->expire_date) {
                        return response()->json(['status' => 2, 'message' => trans('messages.plan_expired'), 'expdate' => $checkplan->expire_date, 'showclick' => "1", 'plan_message' => trans('messages.plan_expired'), 'plan_date' => $checkplan->expire_date, 'checklimit' => '', 'bank_transfer' => ''], 200);
                    }
                }
                if (Str::contains(request()->url(), 'admin')) {
                    if ($checkplan->service_limit != -1) {
                        if ($totalservice >= $checkplan->service_limit) {
                            if (Auth::user()->type == 1 || (Auth::user()->type == 4 && Auth::user()->vendor_id == 1)) {
                                return response()->json(['status' => 2, 'message' => trans('messages.products_limit_exceeded'), 'expdate' => '', 'showclick' => "1", 'plan_message' => trans('messages.plan_expires'), 'plan_date' => '', 'checklimit' => '', 'bank_transfer' => ''], 200);
                            }
                            if (Auth::user()->type == 2 || (Auth::user()->type == 4 && Auth::user()->vendor_id != 1)) {
                                if ($checkplan->expire_date != "") {
                                    return response()->json(['status' => 2, 'message' => trans('messages.vendor_products_limit_message'), 'expdate' => '', 'showclick' => "1", 'plan_message' => trans('messages.plan_expires'), 'plan_date' => $checkplan->expire_date, 'checklimit' => 'service', 'bank_transfer' => ''], 200);
                                } else {
                                    return response()->json(['status' => 2, 'message' => trans('messages.vendor_products_limit_message'), 'expdate' => '', 'showclick' => "1", 'plan_message' => trans('messages.lifetime_subscription'), 'plan_date' => $checkplan->expire_date, 'checklimit' => 'service', 'bank_transfer' => ''], 200);
                                }
                            }
                        }
                    }
                    if ($checkplan->appoinment_limit != -1) {
                        if ($checkplan->appoinment_limit <= 0) {
                            if (Auth::user()->type == 1 || (Auth::user()->type == 4 && Auth::user()->vendor_id == 1)) {
                                return response()->json(['status' => 2, 'message' => trans('messages.order_limit_exceeded'), 'expdate' => '', 'showclick' => "1", 'plan_message' => trans('messages.plan_expires'), 'plan_date' => '', 'checklimit' => '', 'bank_transfer' => ''], 200);
                            }
                            if (Auth::user()->type == 2 || (Auth::user()->type == 4 && Auth::user()->vendor_id != 1)) {
                                if ($checkplan->expire_date != "") {
                                    return response()->json(['status' => 2, 'message' => trans('messages.vendor_order_limit_message'), 'expdate' => '', 'showclick' => "1", 'plan_message' => trans('messages.plan_expires'), 'plan_date' => $checkplan->expire_date, 'checklimit' => 'booking', 'bank_transfer' => ''], 200);
                                } else {
                                    return response()->json(['status' => 2, 'message' => trans('messages.vendor_order_limit_message'), 'expdate' => '', 'showclick' => "1", 'plan_message' => trans('messages.lifetime_subscription'), 'plan_date' => $checkplan->expire_date, 'checklimit' => 'service', 'bank_transfer' => ''], 200);
                                }
                            }
                        }
                    }
                    if (@helper::checkaddons('product_shop')) {
                        if ($checkplan->product_limit != -1) {
                            if ($totalproduct >= $checkplan->product_limit) {
                                if (Auth::user()->type == 1 || (Auth::user()->type == 4 && Auth::user()->vendor_id == 1)) {
                                    return response()->json(['status' => 2, 'message' => trans('messages.products_limit_exceeded'), 'expdate' => '', 'showclick' => "1", 'plan_message' => trans('messages.plan_expires'), 'plan_date' => '', 'checklimit' => '', 'bank_transfer' => ''], 200);
                                }
                                if (Auth::user()->type == 2 || (Auth::user()->type == 4 && Auth::user()->vendor_id != 1)) {
                                    if ($checkplan->expire_date != "") {
                                        return response()->json(['status' => 2, 'message' => trans('messages.vendor_product_s_limit_message'), 'expdate' => '', 'showclick' => "1", 'plan_message' => trans('messages.plan_expires'), 'plan_date' => $checkplan->expire_date, 'checklimit' => 'service', 'checklimit' => '', 'bank_transfer' => ''], 200);
                                    } else {
                                        return response()->json(['status' => 2, 'message' => trans('messages.vendor_product_s_limit_message'), 'expdate' => '', 'showclick' => "1", 'plan_message' => trans('messages.lifetime_subscription'), 'plan_date' => $checkplan->expire_date, 'checklimit' => 'service', 'bank_transfer' => ''], 200);
                                    }
                                }
                            }
                        }
                        if ($checkplan->order_appointment_limit != -1) {
                            if ($checkplan->order_appointment_limit <= 0) {
                                if (Auth::user()->type == 1 || (Auth::user()->type == 4 && Auth::user()->vendor_id == 1)) {
                                    return response()->json(['status' => 2, 'message' => trans('messages.order_limit_exceeded'), 'expdate' => '', 'showclick' => "1", 'plan_message' => trans('messages.plan_expires'), 'plan_date' => '', 'checklimit' => '', 'bank_transfer' => ''], 200);
                                }
                                if (Auth::user()->type == 2 || (Auth::user()->type == 4 && Auth::user()->vendor_id != 1)) {
                                    if ($checkplan->expire_date != "") {
                                        return response()->json(['status' => 2, 'message' => trans('messages.vendor_orders_limit_message'), 'expdate' => '', 'showclick' => "1", 'plan_message' => trans('messages.plan_expires'), 'plan_date' => $checkplan->expire_date, 'checklimit' => 'booking', 'bank_transfer' => ''], 200);
                                    } else {
                                        return response()->json(['status' => 2, 'message' => trans('messages.vendor_orders_limit_message'), 'expdate' => '', 'showclick' => "1", 'plan_message' => trans('messages.lifetime_subscription'), 'plan_date' => $checkplan->expire_date, 'checklimit' => 'service', 'bank_transfer' => ''], 200);
                                    }
                                }
                            }
                        }
                    }
                }
                if (@$type == 3) {
                    if ($checkplan->appoinment_limit != -1) {
                        if ($checkplan->appoinment_limit <= 0) {
                            return response()->json(['status' => 2, 'message' => trans('messages.front_store_unavailable'), 'expdate' => '', 'showclick' => "1", 'plan_message' => trans('messages.plan_expires'), 'plan_date' => '', 'checklimit' => 'booking', 'bank_transfer' => ''], 200);
                        }
                    }
                    if (@helper::checkaddons('product_shop')) {
                        if ($checkplan->order_appointment_limit != -1) {
                            if ($checkplan->order_appointment_limit <= 0) {
                                return response()->json(['status' => 2, 'message' => trans('messages.front_product_store_unavailable'), 'expdate' => '', 'showclick' => "1", 'plan_message' => trans('messages.plan_expires'), 'plan_date' => '', 'checklimit' => 'booking', 'bank_transfer' => ''], 200);
                            }
                        }
                    }
                }
                if ($checkplan->expire_date != "") {
                    return response()->json(['status' => 1, 'message' => trans('messages.plan_expires'), 'expdate' => $checkplan->expire_date, 'showclick' => "0", 'plan_message' => trans('messages.plan_expires'), 'plan_date' => $checkplan->expire_date, 'checklimit' => '', 'bank_transfer' => ''], 200);
                } else {
                    return response()->json(['status' => 1, 'message' => trans('messages.lifetime_subscription'), 'expdate' => $checkplan->expire_date, 'showclick' => "0", 'plan_message' => trans('messages.lifetime_subscription'), 'plan_date' => $checkplan->expire_date, 'checklimit' => '', 'bank_transfer' => ''], 200);
                }
            } else {
                if (Auth::user()->type == 1 || (Auth::user()->type == 4 && Auth::user()->vendor_id == 1)) {
                    return response()->json(['status' => 2, 'message' => trans('messages.doesnot_select_any_plan'), 'expdate' => '', 'showclick' => "0", 'plan_message' => '', 'plan_date' => '', 'checklimit' => '', 'bank_transfer' => ''], 200);
                }
                if (Auth::user()->type == 2 || (Auth::user()->type == 4 && Auth::user()->vendor_id != 1)) {
                    return response()->json(['status' => 2, 'message' => trans('messages.vendor_plan_purchase_message'), 'expdate' => '', 'showclick' => "1", 'plan_message' => '', 'plan_date' => '', 'checklimit' => '', 'bank_transfer' => ''], 200);
                }
            }
        }
    }
    public static function get_plan_exp_date($duration, $days)
    {
        date_default_timezone_set(helper::appdata('')->timezone);
        $purchasedate = date("Y-m-d h:i:sa");
        $exdate = "";
        if (!empty($duration) && $duration != "") {
            if ($duration == "1") {
                $exdate = date('Y-m-d', strtotime($purchasedate . ' + 30 days'));
            }
            if ($duration == "2") {
                $exdate = date('Y-m-d', strtotime($purchasedate . ' + 90 days'));
            }
            if ($duration == "3") {
                $exdate = date('Y-m-d', strtotime($purchasedate . ' + 180 days'));
            }
            if ($duration == "4") {
                $exdate = date('Y-m-d', strtotime($purchasedate . ' + 365 days'));
            }
            if ($duration == "5") {
                $exdate = "";
            }
        }
        if (!empty($days) && $days != "") {
            $exdate = date('Y-m-d', strtotime($purchasedate . ' + ' . $days .  'days'));
        }
        return $exdate;
    }
    // front
    public static function vendor_data($slug)
    {
        $vendordata = User::where('slug', $slug)->first();
        return $vendordata;
    }
    public static function service_count($category_id)
    {
        $totalservice = Service::where(DB::Raw("FIND_IN_SET($category_id, replace(category_id, '|', ','))"), '>', 0)->count();;
        return $totalservice;
    }

    public static function payment($amount, $payment_id, $payment_type, $booking_number, $filename, $vendor_id)
    {

        try {
            $payment = Booking::where('booking_number', $booking_number)->where('vendor_id', $vendor_id)->first();
            $payment->transaction_id = $payment_id;
            $payment->transaction_type = $payment_type;
            if ($payment_type == 1 || $payment_type == 6) {
                $payment->payment_status = 1;
            } else {
                $payment->payment_status = 2;

                $checkuser = User::where('is_available', 1)->where('vendor_id', $vendor_id)->where('id', @Auth::user()->id)->first();
                if ($payment_type == 16) {
                    $checkuser->wallet = $checkuser->wallet - $payment->grand_total;
                    $transaction = new Transaction();
                    $transaction->user_id = @$checkuser->id;
                    $transaction->order_id = $payment->id;
                    $transaction->order_number = $booking_number;
                    $transaction->payment_type = 16;
                    $transaction->product_type = 1;
                    $transaction->transaction_type = 2;
                    $transaction->amount = $payment->grand_total;
                    if ($transaction->save()) {
                        if (SystemAddons::where('unique_identifier', 'commission_module')->first() != null && SystemAddons::where('unique_identifier', 'commission_module')->first()->activated == 1) {
                            if (helper::getslug($vendor_id)->commission_on_off == 1) {
                                $checkvendor = User::where('id', 1)->where('is_available', 1)->first();
                            } else {
                                $checkvendor = User::where('id', $vendor_id)->where('is_available', 1)->first();
                            }
                        } else {
                            $checkvendor = User::where('id', $vendor_id)->where('is_available', 1)->first();
                        }
                        $checkvendor->wallet = $checkvendor->wallet + $payment->grand_total;
                        $checkvendor->save();
                        $checkuser->save();
                    }
                }
                if (
                    SystemAddons::where('unique_identifier', 'commission_module')->first() != null &&
                    SystemAddons::where('unique_identifier', 'commission_module')->first()->activated == 1
                ) {
                    $currentbalance = helper::getslug($payment->vendor_id)->wallet;
                    $currentcommission = helper::getslug($payment->vendor_id)->commission;

                    $updatebalance = $currentbalance + $payment->grand_total - @$payment->commission;
                    $updatecommission = $currentcommission + @$payment->commission;

                    User::where('id', $payment->vendor_id)->update(['wallet' => $updatebalance, 'commission' => $updatecommission]);
                }
            }
            if ($payment_type == 6) {
                $payment->screenshot = $filename;
            }
            $payment->update();
            return 1;
        } catch (\Throwable $th) {
            dd($th);
            return 0;
        }
    }
    public static function footer_features($vendor_id)
    {
        return Footerfeatures::select('id', 'icon', 'title', 'description')->where('vendor_id', $vendor_id)->get();
    }

    public static function push_notification($token, $title, $body, $type, $order_id)
    {
        $customdata = array(
            "type" => $type,
            "order_id" => $order_id,
        );

        $msg = array(
            'body' => $body,
            'title' => $title,
            'sound' => 1/*Default sound*/
        );
        $fields = array(
            'to'           => $token,
            'notification' => $msg,
            'data' => $customdata
        );
        $headers = array(
            'Authorization: key=' . @helper::appdata('')->firebase,
            'Content-Type: application/json'
        );
        #Send Reponse To FireBase Server
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $firebaseresult = curl_exec($ch);
        curl_close($ch);

        return $firebaseresult;
    }
    public static function vendor_register($vendor_name, $vendor_email, $vendor_mobile, $vendor_password, $firebasetoken, $slug, $google_id, $facebook_id, $country_id, $city_id, $store_id, $username = null)
    {
        try {
            if (!empty($slug)) {
                $check = User::where('slug', $slug)->first();
                if ($check != "") {
                    $last = User::select('id')->orderByDesc('id')->first();
                    $slug =   Str::slug($slug . " " . ($last->id + 1), '-');
                } else {
                    $slug = $slug;
                }
            } else {
                $check = User::where('slug', Str::slug($vendor_name, '-'))->first();
                if ($check != "") {
                    $last = User::select('id')->orderByDesc('id')->first();
                    $slug =   Str::slug($vendor_name . " " . ($last->id + 1), '-');
                } else {
                    $slug = Str::slug($vendor_name, '-');
                }
            }

            $rec = helper::appdata('');

            date_default_timezone_set($rec->timezone);
            $logintype = "normal";
            if ($google_id != "") {
                $logintype = "google";
            }

            if ($facebook_id != "") {
                $logintype = "facebook";
            }

            $username = trim((string) $username);
            if ($username === '') {
                $usernameBase = $slug ?: ($vendor_email ? strstr($vendor_email, '@', true) : Str::slug($vendor_name, ''));
                $username = preg_replace('/[^A-Za-z0-9_]/', '', (string) $usernameBase);
                if ($username === '') {
                    $username = 'founder';
                }
            }

            $originalUsername = $username;
            $suffix = 1;
            while (User::where('username', $username)->exists()) {
                $username = $originalUsername . $suffix;
                $suffix++;
            }

            $user = new User();
            $landingsettings = LandingSettings::where('vendor_id', 1)->first();
            $user->name = $vendor_name;
            $user->username = $username;
            $user->email = $vendor_email;
            $user->password = $vendor_password;
            $user->google_id = $google_id;
            $user->facebook_id = $facebook_id;
            $user->mobile = $vendor_mobile;
            $user->type = '2';
            $user->image = "default.png";
            $user->slug = $slug;
            $user->login_type = $logintype;
            $user->token = $firebasetoken;
            $user->country_id = $country_id;
            $user->city_id = $city_id;
            $user->is_available = "1";
            $user->is_verified = "1";
            $user->wallet = 0;
            $user->store_id = $store_id;
            $user->commission_on_off = helper::getslug(1)->commission_on_off;
            $user->commission_type = helper::getslug(1)->commission_type;
            $user->commission_amount = helper::getslug(1)->commission_amount;
            $user->save();
            $vendor_id = DB::getPdo()->lastInsertId();

            $days = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];

            foreach ($days as $day) {

                $timedata = new Timing;
                $timedata->vendor_id = $vendor_id;
                $timedata->day = $day;
                $timedata->open_time = '09:00 AM';
                $timedata->break_start = '01:00 PM';
                $timedata->break_end = '02:00 PM';
                $timedata->close_time = '09:00 PM';
                $timedata->is_always_close = '2';
                $timedata->save();
            }
            $status_name = CustomStatus::where('vendor_id', '1')->get();

            foreach ($status_name as $name) {
                $customstatus = new CustomStatus;
                $customstatus->vendor_id = $vendor_id;
                $customstatus->name = $name->name;
                $customstatus->type = $name->type;
                $customstatus->status_use = $name->status_use;
                $customstatus->is_available = $name->is_available;
                $customstatus->is_deleted = $name->is_deleted;
                $customstatus->save();
            }
            $paymentlist = Payment::select('payment_name', 'unique_identifier', 'currency', 'image', 'is_activate', 'payment_type')->where('vendor_id', '1')->get();
            foreach ($paymentlist as $payment) {
                $gateway = new Payment();
                $gateway->vendor_id = $vendor_id;
                $gateway->payment_name = $payment->payment_name;
                $gateway->unique_identifier = $payment->unique_identifier;
                $gateway->currency = $payment->currency;
                $gateway->image = $payment->image;
                $gateway->payment_type = $payment->payment_type;
                $gateway->public_key = '-';
                $gateway->secret_key = '-';
                $gateway->encryption_key = '-';
                $gateway->environment = '1';
                $gateway->is_available = '1';
                $gateway->is_activate = $payment->is_activate;
                $gateway->save();
            }

            $whatsappdata = WhatsappMessage::where('vendor_id', 1)->first();
            $whatsapp = new WhatsappMessage();
            $whatsapp->vendor_id = $vendor_id;
            $whatsapp->item_message = $whatsappdata->item_message;
            $whatsapp->whatsapp_message = $whatsappdata->whatsapp_message;
            $whatsapp->status_message = $whatsappdata->status_message;
            $whatsapp->order_whatsapp_message = $whatsappdata->order_whatsapp_message;
            $whatsapp->order_status_message = $whatsappdata->order_status_message;
            $whatsapp->whatsapp_number = $whatsappdata->whatsapp_number;
            $whatsapp->whatsapp_phone_number_id = $whatsappdata->whatsapp_phone_number_id;
            $whatsapp->whatsapp_access_token = $whatsappdata->whatsapp_access_token;
            $whatsapp->whatsapp_chat_on_off = $whatsappdata->whatsapp_chat_on_off;
            $whatsapp->whatsapp_mobile_view_on_off = $whatsappdata->whatsapp_mobile_view_on_off;
            $whatsapp->whatsapp_chat_position = $whatsappdata->whatsapp_chat_position;
            $whatsapp->order_created = $whatsappdata->order_created;
            $whatsapp->status_change = $whatsappdata->status_change;
            $whatsapp->product_order_created = $whatsappdata->product_order_created;
            $whatsapp->order_status_change = $whatsappdata->order_status_change;
            $whatsapp->message_type = $whatsappdata->message_type;
            $whatsapp->save();

            $telegramdata = TelegramMessage::where('vendor_id', 1)->first();
            $telegram = new TelegramMessage();
            $telegram->vendor_id = $vendor_id;
            $telegram->item_message = $telegramdata->item_message;
            $telegram->telegram_message = $telegramdata->telegram_message;
            $telegram->order_telegram_message = $telegramdata->order_telegram_message;
            $telegram->order_created = $telegramdata->order_created;
            $telegram->product_order_created = $telegramdata->product_order_created;
            $telegram->telegram_access_token = $telegramdata->telegram_access_token;
            $telegram->telegram_chat_id = $telegramdata->telegram_chat_id;
            $telegram->save();

            $data = new Settings();
            $data->vendor_id = $vendor_id;
            $data->currencies = 'usd';
            $data->default_currency = $rec->default_currency;

            // logo===================================================
            $data->logo = "default.png";

            // favicon=============
            $data->favicon = "default.png";

            // og_image
            $data->og_image = "default.png";

            if (empty($rec->home_banner)) {
                $data->home_banner = "homebanner.png";
            } else {
                $data->home_banner = $rec->home_banner;
            }
            $data->footer_description = "";
            $data->timezone = $rec->timezone;
            $data->web_title = $rec->web_title;
            $data->copyright = $rec->copyright;
            $data->email = $user->email;
            $data->mobile = $user->mobile;
            $data->contact = '-';

            $data->time_format = $rec->time_format;
            $data->date_format = $rec->date_format;
            $data->order_prefix = 'PITS';
            $data->order_number_start = 1001;
            $data->firebase = '-';
            $data->primary_color = $landingsettings->primary_color;
            $data->secondary_color = $landingsettings->secondary_color;
            $data->contact_email_message = $rec->contact_email_message;
            $data->new_order_invoice_email_message = $rec->new_order_invoice_email_message;
            $data->vendor_new_order_email_message = $rec->vendor_new_order_email_message;
            $data->order_status_email_message = $rec->order_status_email_message;
            $data->new_product_order_invoice_email_message = $rec->new_product_order_invoice_email_message;
            $data->vendor_new_product_order_email_message = $rec->vendor_new_product_order_email_message;
            $data->product_order_status_email_message = $rec->product_order_status_email_message;
            $data->referral_earning_email_message = $rec->referral_earning_email_message;
            $data->save();

            $otherdata = OtherSettings::where('vendor_id', '1')->first();
            $other = new OtherSettings();
            $other->vendor_id = $vendor_id;
            $other->maintenance_on_off = $otherdata->maintenance_on_off;
            $other->maintenance_title = $otherdata->maintenance_title;
            $other->maintenance_description = $otherdata->maintenance_description;
            $other->save();

            $emaildata = helper::emailconfigration(helper::appdata('')->id);
            Config::set('mail', $emaildata);
            helper::send_mail_vendor_register($user);
            return $vendor_id;
        } catch (\Throwable $th) {
            dd($th);
            return $th;
        }
    }
    public static function language($vendor_id)
    {
        if (session()->get('locale') == null) {
            $layout = Languages::select('name', 'layout', 'image', 'is_default', 'code')->where('code', helper::appdata($vendor_id)->default_language)->first();
            App::setLocale($layout->code);
            session()->put('locale', $layout->code);
            session()->put('language', $layout->name);
            session()->put('flag', $layout->image);
            session()->put('direction', $layout->layout);
        } else {
            $layout = Languages::select('name', 'layout', 'image', 'is_default', 'code')->where('code', session()->get('locale'))->first();
            App::setLocale(session()->get('locale'));
            session()->put('locale', @$layout->code);
            session()->put('language', @$layout->name);
            session()->put('flag', @$layout->image);
            session()->put('direction', @$layout->layout);
        }
    }
    // get language list vendor side.
    public static function available_language($vendor_id)
    {
        if ($vendor_id == "") {
            $listoflanguage = Languages::where('is_available', '1')->where('is_deleted', 2)->get();
        } else {
            $listoflanguage = Languages::where('is_deleted', 2)->get();
        }
        return $listoflanguage;
    }
    // get language list in atuh pages.
    public static function listoflanguage()
    {
        $listoflanguage = Languages::where('is_available', '1')->get();
        return $listoflanguage;
    }

    // get currency list vendor side.
    public static function available_currency()
    {
        $listofcurrency = CurrencySettings::where('is_available', '1')->get();
        return $listofcurrency;
    }
    public static function currencyinfo($vendor_id)
    {
        if (Cookie::get('code') == null) {
            $currency = CurrencySettings::where('code', helper::appdata($vendor_id)->default_currency)->first();
            session()->put('currency', $currency->currency);
        } else {

            $currency = CurrencySettings::where('code', Cookie::get('code'))->first();
            if (empty($currency)) {
                $currency = CurrencySettings::where('code', helper::appdata($vendor_id)->default_currency)->first();
            }
            session()->put('currency', $currency->currency);
        }
        return $currency;
    }

    public static function checkcustomdomain($vendor_id)
    {
        $customdomain = Customdomain::select('current_domain')->where('vendor_id', $vendor_id)->where('status', 2)->first();

        return @$customdomain->current_domain;
    }

    public static function role($id)
    {

        $role = RoleManager::where('id', $id)->first();
        return $role;
    }

    public static function check_menu($role_id, $slug)
    {

        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        if ($role_id == "" || $role_id == null || $role_id == 0) {
            return 1;
        } else {
            $module = RoleManager::where('id', $role_id)->where('vendor_id', $vendor_id)->first();
            $module = explode('|', $module->module);
            if (in_array($slug, $module)) {
                return 1;
            } else {

                return 0;
            }
        }
    }
    public static function check_access($module, $role_id, $vendor_id, $action)
    {

        if ($role_id == "" || $role_id == null || $role_id == 0) {
            return 1;
        } else {
            $module = RoleAccess::where('module_name', $module)->where('role_id', $role_id)->where('vendor_id', $vendor_id)->first();
            if (!empty($module) && $module != null) {
                if ($action == 'add' && $module->add == 1) {
                    return 1;
                } elseif ($action == 'edit' && $module->edit == 1) {
                    return 1;
                } elseif ($action == 'delete' && $module->delete == 1) {
                    return 1;
                } elseif ($action == 'manage' && $module->manage == 1) {
                    return 1;
                } else {
                    return 0;
                }
            } else {
                return 0;
            }
        }
    }
    public static function getplantransaction($vendor_id)
    {
        $plan = Transaction::where('vendor_id', $vendor_id)->orderbyDesc('id')->first();
        return $plan;
    }
    public static function getslug($vendor_id)
    {
        $data = User::where('id', $vendor_id)->first();
        return $data;
    }

    // dynamic email configration
    public static function emailconfigration($vendor_id)
    {
        $mailsettings = Settings::where('vendor_id', $vendor_id)->first();
        if ($mailsettings) {
            $emaildata = [
                'driver' => $mailsettings->mail_driver,
                'host' => $mailsettings->mail_host,
                'port' => $mailsettings->mail_port,
                'encryption' => $mailsettings->mail_encryption,
                'username' => $mailsettings->mail_username,
                'password' => $mailsettings->mail_password,
                'from'     => ['address' => $mailsettings->mail_fromaddress, 'name' => $mailsettings->mail_fromname]
            ];
        }
        return $emaildata;
    }
    public static function getpixelid($vendor_id)
    {
        $pixcel = Pixcel::where('vendor_id', $vendor_id)->first();
        return $pixcel;
    }
    public static function ceckfavorite($service_id, $vendor_id, $user_id)
    {
        $getfavorite = Favorite::where('vendor_id', $vendor_id)->where('user_id', $user_id)->where('service_id', $service_id)->first();
        return $getfavorite;
    }
    public static function productcheckfavorite($product_id, $vendor_id, $user_id)
    {
        $getfavorite = Favorite::where('vendor_id', $vendor_id)->where('user_id', $user_id)->where('product_id', $product_id)->first();
        return $getfavorite;
    }
    public static function ratting($service_id, $vendor_id)
    {
        $rating =  Testimonials::where('service_id', $service_id)->where('vendor_id', $vendor_id)->avg('star');
        return $rating;
    }

    public static function productratting($product_id, $vendor_id)
    {
        $rating =  Testimonials::where('product_id', $product_id)->where('vendor_id', $vendor_id)->avg('star');
        return $rating;
    }
    public static function paymentlist($vendor_id)
    {
        $payment = Payment::where('vendor_id', $vendor_id)->where('is_available', 1)->where('is_activate', 1)->get();
        return $payment;
    }
    public static function allpaymentcheckaddons($vendor_id)
    {
        $getpaymentmethods = Payment::where('is_available', '1')->where('vendor_id', $vendor_id)->where('is_activate', 1)->where('payment_type', '!=', 6)->get();
        foreach ($getpaymentmethods as $pmdata) {
            $systemAddonActivated = false;
            $addon = SystemAddons::where('unique_identifier', $pmdata->unique_identifier)->first();
            if ($addon != null && $addon->activated == 1) {
                $systemAddonActivated = true;
                break;
            }
        }
        return $systemAddonActivated;
    }
    public static function subscription_details($vendor_id)
    {
        $subscription = SubscriptionSettings::where('vendor_id', $vendor_id)->first();
        return $subscription;
    }

    public static function promocode($vendor_id)
    {
        $dt = date('Y-m-d');
        $promocode = Promocode::where('start_date', '<=', $dt)
            ->where('exp_date', '>=', $dt)
            ->where('vendor_id', $vendor_id)
            ->orderBy('id', 'DESC')
            ->get();

        return $promocode;
    }
    // image size limitation.
    public static function imagesize()
    {
        $imagesize = 2048;
        return $imagesize;
    }
    public static function imageext()
    {
        $imageext = 'mimes:jpeg,jpg,png,webp';
        return $imageext;
    }
    public static function getagedetails($vendor_id)
    {
        $agedetails = AgeVerification::where('vendor_id', $vendor_id)->first();
        return $agedetails;
    }
    // display dynamic paymant name
    public static function getpayment($payment_type, $vendor_id)
    {
        $payment = Payment::select('payment_name')->where('payment_type', $payment_type)->where('vendor_id', $vendor_id)->first();
        return $payment;
    }

    public static function gettax($tax_id)
    {
        $taxArr = explode('|', $tax_id);
        $taxes = [];
        foreach ($taxArr as $tax) {
            $taxes[] = Tax::find($tax);
        }
        return $taxes;
    }

    public static function taxRate($taxRate, $price, $quantity, $tax_type)
    {
        if ($tax_type == 1) {
            return $taxRate * $quantity;
        }

        if ($tax_type == 2) {
            return ($taxRate / 100) * ($price * $quantity);
        }
    }
    public static function gettype($status, $type, $vendor_id, $status_use)
    {
        $status = CustomStatus::where('vendor_id', $vendor_id)->where('type', $type)->where('status_use', $status_use)->where('id', $status)->first();
        return $status;
    }
    public static function customstauts($vendor_id, $status_use)
    {
        $status = CustomStatus::where('vendor_id', $vendor_id)->where('status_use', $status_use)->where('is_available', 1)->where('is_deleted', 2)->orderBy('reorder_id')->get();
        return $status;
    }
    public static function getcategoryinfo($category_id, $vendor_id)
    {

        $category = Category::whereIn('id', explode('|', $category_id))->where('vendor_id', $vendor_id)->orderBy('reorder_id')->get();

        return $category;
    }
    public static function imageresize($file, $directory_name, $reimage)
    {
        // $reimage = 'service-' . uniqid() . "." . $file->getClientOriginalExtension();

        $new_width = 1000;

        // create image manager with desired driver      

        $manager = new ImageManager(new Driver());

        // read image from file system
        $image = $manager->read($file);


        // Get Height & Width
        list($width, $height) = getimagesize("$file");

        // Get Ratio
        $ratio = $width / $height;

        // Create new height & width
        $new_height = $new_width / $ratio;

        // resize image proportionally to 200px width
        $image->scale(width: $new_width, height: $new_height);

        $extension = File::extension($reimage);

        $exif = @exif_read_data("$file");

        $degrees = 0;
        if (isset($exif['Orientation'])) {
            switch ($exif['Orientation']) {
                case 8:
                    $degrees = 90;
                    break;
                case 3:
                    $degrees = 180;
                    break;
                case 6:
                    $degrees = -90;
                    break;
            }
        }

        // $image->rotate($degrees);
        $convert = $image;
        if (Str::endsWith($reimage, '.jpeg')) {
            $convert = $convert->toJpeg();
        } else if (Str::endsWith($reimage, '.jpg')) {
            $convert = $convert->toJpeg();
        } else if (Str::endsWith($reimage, '.webp')) {
            $convert = $convert->toWebp();
        } else if (Str::endsWith($reimage, '.gif')) {
            $convert = $convert->toGif();
        } else if (Str::endsWith($reimage, '.png')) {
            $convert = $convert->toPng();
        } else if (Str::endsWith($reimage, '.avif')) {
            $convert = $convert->toAvif();
        } else if (Str::endsWith($reimage, '.bmp')) {
            $convert = $convert->toBitmap();
        }

        $convertimg = str_replace($extension, 'webp', $reimage);

        $convert->save("$directory_name/$convertimg");

        return $convertimg;
    }
    public static function getsociallinks($vendor_id)
    {
        $links = SocialLinks::where('vendor_id', $vendor_id)->get();
        return $links;
    }

    // landing page condition
    public static function storedata()
    {
        $userdata = User::select('users.id', 'name', 'slug', 'settings.description', 'web_title', 'cover_image')->where('users.available_on_landing', 1)->where('users.id', '!=', 1)->join('settings', 'users.id', '=', 'settings.vendor_id')->where('users.is_deleted', 2)->get();
        return $userdata;
    }

    public static function landingsettings()
    {
        $landigsettings = LandingSettings::where('vendor_id', 1)->first();
        return $landigsettings;
    }
    public static function getblogs($vendor_id)
    {
        $blogs = Blog::where('vendor_id', @$vendor_id)->orderBy('reorder_id')->get();
        return $blogs;
    }
    public static function getbooking($vendor_id, $user_id)
    {
        $booking = Booking::where('user_id', $user_id)->where('vendor_id', $vendor_id)->get();
        return $booking;
    }
    public static function getorder($vendor_id, $user_id)
    {
        $order = Order::where('user_id', $user_id)->where('vendor_id', $vendor_id)->get();
        return $order;
    }
    public static function servicedetails($service_id, $vendor_id)
    {
        $service = Service::where('vendor_id', $vendor_id)->where('id', $service_id)->first();
        return $service;
    }
    public static function planlist()
    {
        $plans = PricingPlan::all();
        return $plans;
    }
    public static function bank_details($vendor_id)
    {
        $bank_details = Bank::where('vendor_id', $vendor_id)->first();
        return $bank_details;
    }
    public static function createbooking($vendor_id, $service_id, $service_image, $service_name, $booking_date, $booking_time, $name, $mobile, $email, $city, $state, $country, $postalcode, $landmark, $address, $message, $sub_total, $tax, $tax_name, $grand_total, $tips, $payment_status, $payment_id, $payment_type, $staff, $screenshot)
    {
        try {
            if (Session::get('id')) {
                $additional_service_id = Session::get('id');
                $add_service_id = explode("|", $additional_service_id);
                $additional_service = AdditionalService::whereIn('id', $add_service_id)->get();
                $additional_service_name = [];
                $additional_service_price = [];
                $additional_service_image = [];
                foreach ($additional_service as $data) {
                    $additional_service_name[] = $data->name;
                    $additional_service_price[] = $data->price;
                    $additional_service_image[] = $data->image;
                }
                $additional_service_name = implode("|", $additional_service_name);
                $additional_service_price = implode("|", $additional_service_price);
                $additional_service_image = implode("|", $additional_service_image);
            }

            $defaultsatus = CustomStatus::where('vendor_id', $vendor_id)->where('type', 1)->where('status_use', 1)->where('is_available', 1)->where('is_deleted', 2)->first();
            if (empty($defaultsatus) && $defaultsatus == null) {
                return response()->json(['status' => 0, 'message' => trans('messages.default_status_msg')], 200);
            }
            date_default_timezone_set(helper::appdata($vendor_id)->timezone);
            $checkplan = helper::checkplan($vendor_id, 3);
            $v = json_decode(json_encode($checkplan));
            if (@$v->original->status == 2) {
                return response()->json(['status' => 0, 'message' => @$v->original->message], 200);
            }
            $checkplan = Transaction::where('vendor_id', $vendor_id)->where('transaction_type', null)->orderByDesc('id')->first();
            $getbookingnumber = Booking::select('booking_number', 'booking_number_digit', 'order_number_start')->where('vendor_id', $vendor_id)->orderBy('id', 'DESC')->first();

            if (empty($getbookingnumber->booking_number_digit)) {
                $n = helper::appdata($vendor_id)->order_number_start;
                $newbooking_number = str_pad($n, 0, STR_PAD_LEFT);
            } else {
                if ($getbookingnumber->order_number_start == helper::appdata($vendor_id)->order_number_start) {
                    $n = (int)($getbookingnumber->booking_number_digit);
                    $newbooking_number = str_pad($n + 1, 0, STR_PAD_LEFT);
                } else {
                    $n = helper::appdata($vendor_id)->order_number_start;
                    $newbooking_number = str_pad($n, 0, STR_PAD_LEFT);
                }
            }

            if (
                SystemAddons::where('unique_identifier', 'commission_module')->first() != null &&
                SystemAddons::where('unique_identifier', 'commission_module')->first()->activated == 1
            ) {
                if (helper::getslug($vendor_id)->commission_on_off == 1) {
                    if (helper::getslug($vendor_id)->commission_type == 1) {
                        $commission = helper::getslug($vendor_id)->commission_amount;
                    } else {
                        $commission = ($sub_total * helper::getslug($vendor_id)->commission_amount) / 100;
                    }
                }
            }

            $booking_number = helper::appdata($vendor_id)->order_prefix . $newbooking_number;
            $order_number_start = helper::appdata($vendor_id)->order_number_start;

            if (Auth::user() && Auth::user()->type == 3) {
                $user_id = Auth::user()->id;
            } else {
                $user_id = "";
            }
            if (session()->has('discount_data')) {
                $offer_code  = session()->get('discount_data')['offer_code'];
                $offer_amount = session()->get('discount_data')['offer_amount'];
            } else {
                $offer_code = "";
                $offer_amount = 0;
            }

            $time = explode('-', $booking_time);

            $bookinginfo = new Booking();

            $bookinginfo->booking_number = $booking_number;
            $bookinginfo->booking_number_digit = $newbooking_number;
            $bookinginfo->order_number_start = $order_number_start;
            $bookinginfo->vendor_id = $vendor_id;
            $bookinginfo->user_id = $user_id;
            $bookinginfo->service_id = $service_id;
            $bookinginfo->service_image  = $service_image;
            $bookinginfo->service_name  = $service_name;
            $bookinginfo->offer_code  = $offer_code;
            $bookinginfo->offer_amount = $offer_amount;
            $bookinginfo->booking_date = $booking_date;
            $bookinginfo->booking_time = $time[0];
            $bookinginfo->booking_endtime = $time[1];
            $bookinginfo->customer_name = $name;
            $bookinginfo->mobile    = $mobile;
            $bookinginfo->email = $email;
            $bookinginfo->city = $city;
            $bookinginfo->state = $state;
            $bookinginfo->country = $country;
            $bookinginfo->postalcode = $postalcode;
            $bookinginfo->landmark = $landmark;
            $bookinginfo->address = $address;
            $bookinginfo->booking_notes = $message;
            $bookinginfo->sub_total = $sub_total;
            $bookinginfo->commission = @$commission;
            $bookinginfo->tax = $tax;
            $bookinginfo->tax_name = $tax_name;
            $bookinginfo->grand_total = $grand_total - @$tips;
            $bookinginfo->tips = @$tips;
            $bookinginfo->additional_service_id = @$additional_service_id;
            $bookinginfo->additional_service_name = @$additional_service_name;
            $bookinginfo->additional_service_price = @$additional_service_price;
            $bookinginfo->additional_service_image = @$additional_service_image;

            $bookinginfo->status = $defaultsatus->id;
            $bookinginfo->status_type = $defaultsatus->type;
            $bookinginfo->payment_status = $payment_status;
            $bookinginfo->transaction_id = $payment_id;
            $bookinginfo->transaction_type = $payment_type;
            $bookinginfo->staff_id = $staff;
            $bookinginfo->screenshot = $screenshot;

            if ($bookinginfo->save()) {
                if ($payment_type == 16) {
                    $checkuser = User::where('is_available', 1)->where('vendor_id', $vendor_id)->where('id', Auth::user()->id)->first();
                    $checkuser->wallet = $checkuser->wallet - $grand_total;
                    $transaction = new Transaction();
                    $transaction->user_id = @$checkuser->id;
                    $transaction->order_id = $bookinginfo->id;
                    $transaction->order_number = $booking_number;
                    $transaction->payment_type = 16;
                    $transaction->product_type = 1;
                    $transaction->transaction_type = 2;
                    $transaction->amount = $grand_total;
                    if ($transaction->save()) {
                        if (SystemAddons::where('unique_identifier', 'commission_module')->first() != null && SystemAddons::where('unique_identifier', 'commission_module')->first()->activated == 1) {
                            if (helper::getslug($vendor_id)->commission_on_off == 1) {
                                $checkvendor = User::where('id', 1)->where('is_available', 1)->first();
                            } else {
                                $checkvendor = User::where('id', $vendor_id)->where('is_available', 1)->first();
                            }
                        } else {
                            $checkvendor = User::where('id', $vendor_id)->where('is_available', 1)->first();
                        }
                        $checkvendor->wallet = $checkvendor->wallet + $grand_total;
                        $checkvendor->save();
                        $checkuser->save();
                    }
                }
            }


            $trackurl = helper::storefront_url($vendor_id, 'booking/' . $booking_number);

            $title = trans('labels.order_placed');
            $body = trans('messages.order_notification_message') . ' #' . $booking_number;


            $vendordata = User::where('id', $vendor_id)->first();
            $emaildata = helper::emailconfigration($vendordata->id);
            Config::set('mail', $emaildata);
            helper::send_mail_forbooking($bookinginfo, $trackurl, $email);
            helper::push_notification($vendordata->token, $title, $body, "order", $bookinginfo->id);

            if (session()->has('discount_data')) {
                session()->forget('discount_data');
            }
            if (session()->has('remove_coupen')) {
                session()->forget('remove_coupen');
            }
            if (session()->has('apply')) {
                session()->forget('apply');
            }
            if (!empty($checkplan)) {
                if ($checkplan->appoinment_limit != -1) {
                    $checkplan->appoinment_limit -= 1;
                    $checkplan->save();
                }
            }

            return $booking_number;
        } catch (\Throwable $th) {
            return $th;
        }
    }

    public static function createorder($vendor_slug, $user_id, $user_name, $user_email, $user_mobile, $transaction_type, $transaction_id, $address, $landmark, $postal_code, $city, $state, $country, $shipping_area, $delivery_charge, $grand_total, $tips, $sub_total, $tax_amount, $tax_name, $notes, $filename, $buynow)
    {
        try {


            $vendordata = self::currentStoreUser($vendor_slug);
            $vdata = $vendordata->id;
            $defaultsatus = CustomStatus::where('vendor_id', $vdata)->where('type', 1)->where('status_use', 2)->where('is_available', 1)->where('is_deleted', 2)->first();

            if (empty($defaultsatus) && $defaultsatus == null) {
                return false;
            }

            date_default_timezone_set(helper::appdata(@$vdata)->timezone);
            $checkplan = helper::checkplan($vdata, 3);
            $v = json_decode(json_encode($checkplan));
            if (@$v->original->status == 2) {
                return response()->json(['status' => 0, 'message' => @$v->original->message], 200);
            }
            $checkplan = Transaction::where('vendor_id', @$vdata)->where('transaction_type', null)->orderByDesc('id')->first();

            $getordernumber = Order::select('order_number', 'order_number_digit', 'order_number_start')->where('vendor_id', $vdata)->orderBy('id', 'DESC')->first();
            if (empty($getordernumber->order_number_digit)) {
                $n = helper::appdata($vdata)->product_order_number_start;
                $neworder_number = str_pad($n, 0, STR_PAD_LEFT);
            } else {
                if ($getordernumber->order_number_start == helper::appdata($vdata)->product_order_number_start) {
                    $n = (int)($getordernumber->order_number_digit);
                    $neworder_number = str_pad($n + 1, 0, STR_PAD_LEFT);
                } else {
                    $n = helper::appdata($vdata)->product_order_number_start;
                    $neworder_number = str_pad($n, 0, STR_PAD_LEFT);
                }
            }
            if (session()->has('order_discount_data')) {
                $offer_code  = session()->get('order_discount_data')['offer_code'];
                $offer_amount = session()->get('order_discount_data')['offer_amount'];
            } else {
                $offer_code = "";
                $offer_amount = 0;
            }

            $order = new Order();
            $order_number = helper::appdata($vdata)->product_order_prefix . $neworder_number;

            $trackurl = helper::storefront_url($vendordata, 'order/' . $order_number);
            $successurl = helper::storefront_url($vendordata, 'order-success-' . $order_number);
            // dd($successurl);
            if ($user_id > 0) {
                $checkcart = Cart::where('vendor_id', @$vdata)->where('user_id', $user_id)->where('buynow', $buynow)->get();
            } else {
                $checkcart = Cart::where('vendor_id', @$vdata)->where('session_id', session()->getId())->where('buynow', $buynow)->get();
            }

            if ($checkcart->count() > 0) {
                $order->order_number = $order_number;
                $order->order_number_digit = $neworder_number;
                $order->order_number_start = helper::appdata($vdata)->product_order_number_start;
                $order->vendor_id = @$vdata;
                $order->user_id = @$user_id;
                $order->user_name = $user_name;
                $order->user_email = $user_email;
                $order->user_mobile = $user_mobile;
                $order->address = $address;
                $order->landmark = $landmark;
                $order->postal_code = $postal_code;
                $order->city = $city;
                $order->state = $state;
                $order->country = $country;
                $order->offer_code = $offer_code;
                $order->offer_amount = $offer_amount;
                $order->transaction_type = $transaction_type;
                if ($transaction_type != 1) {
                    $order->transaction_id = $transaction_id;
                } else {
                    $order->transaction_id = "";
                }
                $order->shipping_area = $shipping_area;
                $order->delivery_charge = $delivery_charge;
                $order->grand_total = $grand_total - @$tips;
                $order->tips = @$tips;
                $order->sub_total = $sub_total;
                $order->tax_amount = $tax_amount;
                $order->tax_name = $tax_name;
                $order->notes = $notes;
                $order->status = $defaultsatus->id;
                $order->status_type = $defaultsatus->type;
                if ($transaction_type == 1 || $transaction_type == 6) {
                    $payment_status = 1;
                } else {
                    $payment_status = 2;
                }
                $order->payment_status = $payment_status;
                if ($transaction_type == 6) {
                    $order->screenshot = $filename;
                }

                if ($order->save()) {
                    $checkuser = User::where('is_available', 1)->where('vendor_id', $vdata)->where('id', @Auth::user()->id)->first();
                    if ($transaction_type == 16) {
                        $checkuser->wallet = $checkuser->wallet - $grand_total;
                        $transaction = new Transaction();
                        $transaction->user_id = @$checkuser->id;
                        $transaction->order_id = $order->id;
                        $transaction->order_number = $order_number;
                        $transaction->payment_type = 16;
                        $transaction->product_type = 2;
                        $transaction->transaction_type = 2;
                        $transaction->amount = $grand_total - $tips;
                        // $transaction->tips = $tips;
                        if ($transaction->save()) {
                            if (SystemAddons::where('unique_identifier', 'commission_module')->first() != null && SystemAddons::where('unique_identifier', 'commission_module')->first()->activated == 1) {
                                if (helper::getslug($vdata)->commission_on_off == 1) {
                                    $checkvendor = User::where('id', 1)->where('is_available', 1)->first();
                                } else {
                                    $checkvendor = User::where('id', $vdata)->where('is_available', 1)->first();
                                }
                            } else {
                                $checkvendor = User::where('id', $vdata)->where('is_available', 1)->first();
                            }
                            $checkvendor->wallet = $checkvendor->wallet + $grand_total;
                            $checkvendor->save();
                            $checkuser->save();
                        }
                    }
                    foreach ($checkcart as $cart) {
                        $od = new OrderDetails();
                        $od->vendor_id = @$vdata;
                        $od->order_id = $order->id;
                        $od->user_id = $user_id;
                        $od->product_id = $cart->product_id;
                        $od->product_name = $cart->product_name;
                        $od->product_slug = $cart->product_slug;
                        $od->product_image = $cart->product_image;
                        $od->product_tax = $cart->tax;
                        $od->product_price = $cart->product_price;
                        $od->qty = $cart->qty;
                        if ($od->save()) {
                            $product = Product::where('id', $cart->product_id)->where('vendor_id', $cart->vendor_id)->first();
                            $product->qty = $product->qty != 0 ?  (int)$product->qty - (int)$cart->qty : 0;
                            $product->update();
                            $cart->delete();
                        }
                    }
                    if (session()->has('order_discount_data')) {
                        session()->forget('order_discount_data');
                    }
                    if (!empty($checkplan)) {
                        if ($checkplan->order_appointment_limit != -1) {
                            $checkplan->order_appointment_limit -= 1;
                            $checkplan->save();
                        }
                    }
                    $orderdata = Order::where('id', $order->id)->first();
                    $emaildata = helper::emailconfigration($vdata);
                    Config::set('mail', $emaildata);
                    helper::create_order_invoice($user_email, $user_name, $vendordata->email, $vendordata->name, $vdata, $order_number, helper::date_formate($orderdata->created_at, $vdata), $trackurl, helper::currency_formate($grand_total, $vdata));

                    return response()->json(['status' => 1, 'message' => trans('messages.success'), 'successurl' => $successurl, 'order_number' => $order_number], 200);
                } else {
                    return response()->json(['status' => 0, 'message' => trans('messages.wrong')], 200);
                }
            } else {
                return response()->json(['status' => 0, 'message' => trans('messages.cart_empty')], 200);
            }
        } catch (\Throwable $th) {
            dd($th);
            return response()->json(['status' => 0, 'message' => trans('messages.wrong')], 200);
        }
    }

    public static function checkaddons($addons)
    {
        if (str_contains(url()->current(), 'admin')) {
            if (session()->get('demo') == "free-addon") {
                $check = SystemAddons::where('unique_identifier', $addons)->where('activated', 1)->where('type', 1)->first();
            } elseif (session()->get('demo') == "free-with-extended-addon") {
                $check = SystemAddons::where('unique_identifier', $addons)->where('activated', 1)->whereIn('type', ['1', '2'])->first();
            } elseif (session()->get('demo') == "all-addon") {
                $check = SystemAddons::where('unique_identifier', $addons)->where('activated', 1)->whereIn('type', ['1', '2', '3'])->first();
            } else {
                $check = SystemAddons::where('unique_identifier', $addons)->where('activated', 1)->first();
            }
        } else {
            $check = SystemAddons::where('unique_identifier', $addons)->where('activated', 1)->first();
        }

        return $check;
    }

    public static function checkthemeaddons($addons)
    {
        if (session()->get('demo') == "free-addon") {
            $check = SystemAddons::where('unique_identifier', 'LIKE', '%' . $addons . '%')->where('activated', 1)->where('type', 1)->get();
        } elseif (session()->get('demo') == "free-with-extended-addon") {
            $check = SystemAddons::where('unique_identifier', 'LIKE', '%' . $addons . '%')->where('activated', 1)->whereIn('type', ['1', '2'])->get();
        } elseif (session()->get('demo') == "all-addon") {
            $check = SystemAddons::where('unique_identifier', 'LIKE', '%' . $addons . '%')->where('activated', 1)->whereIn('type', ['1', '2', '3'])->get();
        } else {
            $check = SystemAddons::where('unique_identifier', 'LIKE', '%' . $addons . '%')->where('activated', 1)->get();
        }
        return $check;
    }

    public static function availablePlanThemes($directoryPrefix = 'theme-')
    {
        $themes = [];

        foreach (File::directories(resource_path('views/front')) as $directory) {
            $name = basename($directory);
            if (preg_match('/^' . preg_quote($directoryPrefix, '/') . '(\d+)$/', $name, $matches)) {
                $themes[] = (string) ((int) $matches[1]);
            }
        }

        if (empty($themes)) {
            foreach (self::checkthemeaddons('theme_') as $themeAddon) {
                $themes[] = str_replace('theme_', '', $themeAddon->unique_identifier);
            }
        }

        $themes = array_values(array_unique($themes));
        sort($themes, SORT_NATURAL);

        return $themes;
    }

    public static function top_deals($vendor_id)
    {
        date_default_timezone_set(helper::appdata($vendor_id)->timezone);
        $current_date  = Carbon::now()->format('Y-m-d');
        $current_time  = Carbon::now()->format('H:i:s');
        $topdeal = TopDeals::where('vendor_id', $vendor_id)->first();
        $topdeals = null;
        if (SystemAddons::where('unique_identifier', 'top_deals')->first() != null && SystemAddons::where('unique_identifier', 'top_deals')->first()->activated == 1) {
            if (isset($topdeal) && $topdeal->top_deals_switch == 1) {
                $startDate = $topdeal['start_date'];
                $starttime = $topdeal['start_time'];
                $endDate = $topdeal['end_date'];
                $endtime = $topdeal['end_time'];
                // Checking validity of top deal offer
                if ($topdeal->deal_type == 1) {
                    if ($current_date > $startDate) {
                        if ($current_date < $endDate) {
                            $topdeals = TopDeals::where('vendor_id', $vendor_id)->first();
                        } elseif ($current_date == $endDate) {
                            if ($current_time < $endtime) {
                                $topdeals = TopDeals::where('vendor_id', $vendor_id)->first();
                            }
                        }
                    } elseif ($current_date == $startDate) {
                        if ($current_date < $endDate && $current_time >= $starttime) {
                            $topdeals = TopDeals::where('vendor_id', $vendor_id)->first();
                        } elseif ($current_date == $endDate) {
                            if ($current_time >= $starttime && $current_time <= $endtime) {
                                $topdeals = TopDeals::where('vendor_id', $vendor_id)->first();
                            }
                        }
                    }
                } else if ($topdeal->deal_type == 2) {
                    if ($current_time >= $starttime && $current_time <= $endtime) {
                        $topdeals = TopDeals::where('vendor_id', $vendor_id)->first();
                    }
                }
            }
        }
        return $topdeals;
    }

    public static function topdealitemlist($vendor_id)
    {
        $itemlist = Service::with('service_image', 'reviews')
            ->select('services.*', DB::raw('ROUND(AVG(testimonials.star),1) as ratings_average'))
            ->leftJoin('testimonials', 'testimonials.service_id', '=', 'services.id')
            ->groupBy('services.id')
            ->where('services.is_available', "1")
            ->where('services.is_deleted', "2")
            ->where('services.top_deals', "1")
            ->where('services.vendor_id', $vendor_id)
            ->orderBy('services.reorder_id')
            ->paginate(16);

        return $itemlist;
    }

    public static function checklowqty($item_id, $vendor_id)
    {
        $item = Product::where('id', $item_id)->where('vendor_id', $vendor_id)->first();

        if ($item->qty == null && $item->qty == "") {
            return 3;
        }
        if ((string)$item->qty != null && (string)$item->qty != "") {
            if ((string)$item->qty == 0) {
                return 2;
            }
            if ($item->qty <= $item->low_qty) {
                return 1;
            }
        }
    }

    public static function getcartcount($vendor_id, $session_id, $user_id)
    {
        $vdata = $vendor_id;

        if (empty($vdata)) {
            $vendordata = self::currentStoreUser();
            $vdata = @$vendordata->id;
        }

        if ($user_id != "") {
            $cnt = Cart::where('vendor_id', $vdata)->where('user_id', $user_id)->where('buynow', 0)->count();
        } else {
            $cnt = Cart::where('vendor_id', $vdata)->where('session_id', $session_id)->where('buynow', 0)->count();
        }
        return $cnt;
    }
}
