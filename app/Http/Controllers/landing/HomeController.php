<?php

namespace App\Http\Controllers\landing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Features;
use App\Models\PricingPlan;
use App\Models\User;
use App\Models\Testimonials;
use App\Models\Blog;
use App\Models\Subscriber;
use App\Models\Category;
use App\Models\WhyChooseUs;
use App\Models\Banner;
use App\Models\Settings;
use App\Models\Country;
use App\Models\City;
use App\Models\Promotionalbanner;
use App\Models\Faq;
use App\Models\AppSettings;
use App\Models\StoreCategory;
use App\Models\Contact;
use App\Models\Theme;
use App\Models\SystemAddons;
use App\helper\helper;
use App\Models\HowWorks;
use App\Models\FunFact;
use Illuminate\Support\Facades\Config;
use Lunaweb\RecaptchaV3\Facades\RecaptchaV3;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // if the current host contains the website domain
        $host = $_SERVER['HTTP_HOST'];
        if ($host  ==  env('WEBSITE_HOST')) {
            $admindata = User::where('type', 1)->first();
            $features = Features::where('vendor_id', $admindata->id)->orderBy('reorder_id')->get();
            $planlist = PricingPlan::where('is_available', 1)->where('vendor_id', null)->orderBy('reorder_id')->get();
            $testimonials = Testimonials::where('vendor_id', $admindata->id)->orderBy('reorder_id')->get();
            $blogs = Blog::where('vendor_id', $admindata->id)->orderBy('reorder_id')->take(6)->get();
            $settingdata = Settings::where('vendor_id', $admindata->id)->first();
            $workdata = HowWorks::where('vendor_id', $admindata->id)->orderBy('reorder_id')->get();
            $themes = Theme::where('vendor_id', $admindata->id)->orderBy('reorder_id')->get();
            $app_settings = AppSettings::where('vendor_id', $admindata->id)->first();
            $funfacts = FunFact::where('vendor_id', $admindata->id)->orderByDesc('id')->get();
            return view('landing.index', compact('features', 'planlist', 'testimonials', 'blogs', 'settingdata', 'workdata', 'themes', 'app_settings', 'funfacts'));
        }
        // if the current host doesn't contain the website domain (meaning, custom domain)
        else {
            $host = $_SERVER['HTTP_HOST'];
            if ($host  ==  env('WEBSITE_HOST')) {
                $vendordata = helper::vendor_data($request->vendor);
            }
            // if the current host doesn't contain the website domain (meaning, custom domain)
            else {
                $vendordata = Settings::where('custom_domain', $host)->first();
            }

            if (empty($vendordata)) {
                abort(404);
            }
            $setting = Settings::where('vendor_id', $vendordata->id)->first();
            $getbannersection1 = Banner::where('section', '1')->where('is_available', 1)->where('vendor_id', @$vendordata->id)->orderBy('reorder_id')->get();
            $getbannersection2 = Banner::with('category_info')->where('section', '2')->where('is_available', 1)->where('vendor_id', @$vendordata->id)->orderBy('reorder_id')->get();
            $getbannersection3 = Banner::where('section', '3')->where('is_available', 1)->where('vendor_id', @$vendordata->id)->orderBy('reorder_id')->get();
            $getblog = Blog::where('vendor_id', @$vendordata->id)->orderBy('reorder_id');
            $getcategories = Category::where('is_available', "1")->where('is_deleted', "2")->orderBY('reorder_id')->where('vendor_id', @$vendordata->id);
            $testimonials = Testimonials::where('vendor_id', @$vendordata->id)->where('user_id', null)->where('service_id', null)->where('reorder_id')->get();
            $choose = WhyChooseUs::where('vendor_id', $vendordata->id)->where('reorder_id')->get();
            if (helper::appdata(@$vendordata->id)->theme == 3) {
                $getcategories = $getcategories->take(6)->get();
                $getblog = $getblog->take(4)->get();
            } elseif (helper::appdata(@$vendordata->id)->theme == 4) {
                $getcategories = $getcategories->get();
                $getblog = $getblog->take(4)->get();
            } else {
                $getcategories = $getcategories->get();
                $getblog = $getblog->take(3)->get();
            }
            // $getservices = Service::with('service_image', 'category_info','average_ratting')->where('is_available', "1")->where('is_deleted', "2")->where('vendor_id', @$vendordata->id)->orderByDesc('id')->take(12)->get();
            $app_section = AppSettings::where('vendor_id', $vendordata->id)->first();
            $getservices = Service::with('service_image', 'reviews')
                ->select('services.*', DB::raw('ROUND(AVG(testimonials.star),1) as ratings_average'))
                ->leftJoin('testimonials', 'testimonials.service_id', '=', 'services.id')
                ->groupBy('services.id')
                ->where('services.is_available', "1")
                ->where('services.is_deleted', "2")
                ->where('services.vendor_id', @$vendordata->id)
                ->orderBy('services.reorder_id')
                ->take(12)
                ->get();

            if (helper::appdata(@$vendordata->id)->theme == 4) {
                $gettoprated = Service::with('service_image', 'reviews')
                    ->select('services.*', DB::raw('ROUND(AVG(testimonials.star),1) as ratings_average'))
                    ->leftJoin('testimonials', 'testimonials.service_id', '=', 'services.id')
                    ->groupBy('services.id')
                    ->where('services.is_available', "1")
                    ->where('services.is_deleted', "2")
                    ->where('services.vendor_id', @$vendordata->id)
                    ->orderByDesc('ratings_average')
                    ->take(10)
                    ->get();
            } else {
                $gettoprated = Service::with('service_image', 'reviews')
                    ->select('services.*', DB::raw('ROUND(AVG(testimonials.star),1) as ratings_average'))
                    ->leftJoin('testimonials', 'testimonials.service_id', '=', 'services.id')
                    ->groupBy('services.id')
                    ->where('services.is_available', "1")
                    ->where('services.is_deleted', "2")
                    ->where('services.vendor_id', @$vendordata->id)
                    ->orderByDesc('ratings_average')
                    ->take(6)
                    ->get();
            }
            $reviewimage = Testimonials::where('vendor_id', $vendordata->id)->where('user_id', null)->where('service_id', null)->orderBy('reorder_id')->take(5)->get();
            return view('front.theme-' . helper::appdata(@$vendordata->id)->theme . '.index', compact('getbannersection1', 'getbannersection2', 'getbannersection3', 'getblog', 'getcategories', 'getservices', 'gettoprated', 'vendordata', 'testimonials', 'choose', 'app_section', 'reviewimage'));
        }
    }
    public function emailsubscribe(Request $request)
    {
        $newsubscriber = new Subscriber();
        $newsubscriber->vendor_id = 1;
        $newsubscriber->email = $request->email;
        $newsubscriber->save();
        return redirect()->back()->with('success', trans('messages.success'));
    }
    public function inquiry(Request $request)
    {
        try {
            if (
                SystemAddons::where('unique_identifier', 'google_recaptcha')->first() != null &&
                SystemAddons::where('unique_identifier', 'google_recaptcha')->first()->activated == 1
            ) {

                if (helper::appdata('')->recaptcha_version == 'v2') {
                    $request->validate([
                        'g-recaptcha-response' => 'required'
                    ], [
                        'g-recaptcha-response.required' => 'The g-recaptcha-response field is required.'
                    ]);
                }
                if (helper::appdata('')->recaptcha_version == 'v3') {
                    $score = RecaptchaV3::verify($request->get('g-recaptcha-response'), 'contact');
                    if ($score <= helper::appdata('')->score_threshold) {
                        return redirect()->back()->with('error', 'You are most likely a bot');
                    }
                }
            }
            $newinquiry = new Contact();
            $newinquiry->vendor_id = 1;
            $newinquiry->name = $request->name;
            $newinquiry->email = $request->email;
            $newinquiry->mobile = $request->mobile;
            $newinquiry->message = $request->message;
            $newinquiry->save();
            $vendordata = User::select('name', 'email')->where('id', 1)->first();
            $emaildata = helper::emailconfigration(helper::appdata('')->id);
            Config::set('mail', $emaildata);
            helper::vendor_contact_data(1, $vendordata->name, $vendordata->email, $request->name, $request->email, $request->mobile, $request->message);
            return redirect()->back()->with('success', trans('messages.success'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', trans('messages.wrong'));
        }
    }
    public function termscondition()
    {
        $terms = Settings::select('terms_content')->where('vendor_id', 1)->first();
        return view('landing.terms_condition', compact('terms'));
    }
    public function aboutus()
    {
        $aboutus = Settings::select('about_content')->where('vendor_id', 1)->first();
        return view('landing.aboutus', compact('aboutus'));
    }
    public function privacypolicy()
    {
        $privacypolicy = Settings::select('privacy_content')->where('vendor_id', 1)->first();
        return view('landing.privacypolicy', compact('privacypolicy'));
    }
    public function refund_policy()
    {
        $policy = Settings::select('refund_policy')->where('vendor_id', 1)->first();
        return view('landing.refund_policy', compact('policy'));
    }
    public function faqs(Request $request)
    {
        $allfaqs = Faq::where('vendor_id', 1)->orderBy('reorder_id')->get();
        return view('landing.faq', compact('allfaqs'));
    }
    public function contact()
    {
        return view('landing.contact');
    }
    public function allstores(Request $request)
    {
        $countries = Country::where('is_deleted', 2)->where('is_available', 1)->get();
        $vendordata = User::where('id', 1)->first();

        $banners = Promotionalbanner::with('vendor_info')->orderBy('reorder_id')->get();
        $storecategory = StoreCategory::where('is_available', 1)->where('is_deleted', 2)->get();
        $stores = User::where('type', 2)->where('is_deleted', 2)->where('is_available', 1);
        if ($request->country == "" && $request->city == "") {
            $stores = $stores;
        }
        $city_name = "";
        if ($request->has('country') && $request->country != "") {
            $country = Country::select('id')->where('name', $request->country)->first();
            $stores =  $stores->where('country_id', $country->id);
        }
        if ($request->has('city') && $request->city != "") {
            $city = City::where('city', $request->city)->first();
            $stores =  $stores->where('city_id', $city->id);
            $city_name = $city->city;
        }
        if ($request->has('store') && $request->store != "") {
            $storeinfo = StoreCategory::where('name', $request->store)->first();
            $stores =  $stores->where('store_id', $storeinfo->id);
        }
        if ($stores != null) {
            $stores = $stores->paginate(12);
        }
        return view('landing.stores', compact('countries', 'stores', 'city_name', 'banners', 'storecategory', 'vendordata'));
    }
    public function themeimages(Request $request)
    {
        $newpath = [];
        $output = '';
        foreach ($request->theme_id as $theme_id) {
            $image = 'theme-' . $theme_id . '.webp';

            if (file_exists(storage_path('app/public/admin-assets/images/theme/' . $image))) {
                $path = url(env('ASSETPATHURL') . 'admin-assets/images/theme/' . $image);
            } else {
                $path =  url(env('ASSETPATHURL') . 'admin-assets/images/about/defaultimages/item-placeholder.png');
            }
            $newpath[] = $path;
        }

        $html = view('admin.theme.themeimages', compact('newpath'))->render();
        return response()->json(['status' => 1, 'output' => $html], 200);
    }
}
