<?php

namespace App\Http\Controllers\front;

use App\helper\helper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Service;
use App\Models\Blog;
use App\Models\AppSettings;
use App\Models\Testimonials;
use App\Models\WhyChooseUs;
use DB;

class HomeController extends Controller
{
    public function maintanance()
    {
        return view('front.maintenance');
    }
    public function checkvendor(Request $request)
    {
        $checkvendor = helper::checkplan($request->vendor_id, "3");
        return response(@$checkvendor->original, 200);
    }
    public function index(Request $request)
    {
        $vendordata = helper::currentStoreUser($request->route('vendor'));
        $vdata = @$vendordata->id;

        if (empty($vendordata)) {
            abort(404);
        }
        $setting = Settings::where('vendor_id', $vendordata->id)->first();
        $getbannersection1 = Banner::where('section', '1')->where('is_available', 1)->where('vendor_id', @$vendordata->id)->orderBy('reorder_id')->get();
        $getbannersection2 = Banner::with('category_info')->where('section', '2')->where('is_available', 1)->where('vendor_id', @$vendordata->id)->orderBy('reorder_id')->get();
        $getbannersection3 = Banner::where('section', '3')->where('is_available', 1)->where('vendor_id', @$vendordata->id)->orderBy('reorder_id')->get();
        $getblog = Blog::where('vendor_id', @$vendordata->id)->orderBy('reorder_id');
        $getcategories = Category::where('is_available', "1")->where('is_deleted', "2")->orderBY('reorder_id')->where('vendor_id', @$vendordata->id);
        $testimonials = Testimonials::where('vendor_id', @$vendordata->id)->where('user_id', null)->where('service_id', null)->orderBy('reorder_id')->get();
        $choose = WhyChooseUs::where('vendor_id', $vendordata->id)->where('reorder_id')->get();
        if (helper::appdata(@$vendordata->id)->theme == 3) {
            $getcategories = $getcategories->take(6)->get();
            $getblog = $getblog->take(4)->get();
        } elseif (helper::appdata(@$vendordata->id)->theme == 4) {
            $getcategories = $getcategories->get();
            $getblog = $getblog->take(4)->get();
        } else {
            $getcategories = $getcategories->get();
            $getblog = $getblog->take(8)->get();
        }
        // $getservices = Service::with('service_image', 'category_info','average_ratting')->where('is_available', "1")->where('is_deleted', "2")->where('vendor_id', @$vendordata->id)->orderByDesc('id')->take(12)->get();
        $app_section = AppSettings::where('vendor_id', $vendordata->id)->first();
        $getservices = Service::with('service_image', 'multi_image', 'reviews')
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
            $gettoprated = Service::with('service_image', 'multi_image', 'reviews')
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
            $gettoprated = Service::with('service_image', 'multi_image', 'reviews')
                ->select('services.*', DB::raw('ROUND(AVG(testimonials.star),1) as ratings_average'))
                ->leftJoin('testimonials', 'testimonials.service_id', '=', 'services.id')
                ->groupBy('services.id')
                ->where('services.is_available', "1")
                ->where('services.is_deleted', "2")
                ->where('services.vendor_id', @$vendordata->id)
                ->orderByDesc('ratings_average')
                ->take(8)
                ->get();
        }
        $reviewimage = Testimonials::where('vendor_id', $vendordata->id)->where('user_id', null)->where('service_id', null)->orderBy('reorder_id')->take(5)->get();
        if (helper::storefront_request_is('pwa')) {
            return view('front.themepwa', compact('getbannersection1', 'getbannersection2', 'getbannersection3', 'getblog', 'getcategories', 'getservices', 'gettoprated', 'vendordata','vdata', 'testimonials', 'choose', 'app_section', 'reviewimage'));
        } else {
            return view('front.theme-' . helper::appdata(@$vendordata->id)->theme . '.index', compact('getbannersection1', 'getbannersection2', 'getbannersection3', 'getblog', 'getcategories', 'getservices', 'gettoprated', 'vendordata','vdata', 'testimonials', 'choose', 'app_section', 'reviewimage'));
        }
    }
    public function direction(Request $request)
    {
        session()->put('direction', $request->btndirection);
        return redirect()->back();
    }
}
