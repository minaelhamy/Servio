<?php

namespace App\Http\Controllers\Api\user;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Service;
use App\Models\Blog;
use App\Models\User;
use App\Models\Payment;
use App\Models\Testimonials;
use App\Models\WhyChooseUs;
use App\Models\SystemAddons;
use App\helper\helper;

class HomeController extends Controller
{
    public function home(Request $request)
    {
        $userid = "";
        if($request->vendor_id == ""){
            return response()->json(["status"=>0,"message"=>trans('messages.vendor_id_required')],400);
        }
        if ($request->user_id != "") {
            $userid = $request->user_id;
        }
        $currency = helper::appdata($request->vendor_id)->currency;
        $currency_position = helper::appdata($request->vendor_id)->currency_position;
        $currency_formate = helper::appdata($request->vendor_id)->currency_formate;
        $decimal_separator = helper::appdata($request->vendor_id)->decimal_separator;

        $getbannersection1 = Banner::select("vendor_id","service_id","category_id",DB::raw("CONCAT('".url(env('ASSETPATHURL').'admin-assets/images/banner')."/', image) AS image"),"type")->where('section', '1')->where('is_available',1)->where('vendor_id', $request->vendor_id)->orderByDesc('id')->get();
        $getbannersection2 = Banner::select("vendor_id","service_id","category_id",DB::raw("CONCAT('".url(env('ASSETPATHURL').'admin-assets/images/banner')."/', image) AS image"),"type",'banner_title','banner_subtitle','link_text')->where('section', '2')->where('is_available',1)->where('vendor_id', $request->vendor_id)->orderByDesc('id')->get();
        $getbannersection3 = Banner::select("vendor_id","service_id","category_id",DB::raw("CONCAT('".url(env('ASSETPATHURL').'admin-assets/images/banner')."/', image) AS image"),"type")->where('section', '3')->where('is_available',1)->where('vendor_id', $request->vendor_id)->orderByDesc('id')->get();
        $getcategories = Category::select("id","vendor_id","name",DB::raw("CONCAT('".url(env('ASSETPATHURL').'admin-assets/images/categories')."/', image) AS image"))->where('is_available', "1")->where('is_deleted', "2")->where('vendor_id', $request->vendor_id)->take(12)->get();

        foreach ($getcategories as $category) {
            $catdata[] = array(
                'id' =>  $category->id,
                'name' =>  $category->name,
                'vendor_id' => $category->vendor_id,
                'image' => $category->image,
                'count' => helper::service_count($category->id),
            );
        }

        $getservices=Service::with('service_image_api','reviews')->select('services.*', DB::raw('(case when favorite.service_id is null then 0 else 1 end) as is_favorite'),DB::raw('ROUND(AVG(testimonials.star),1) as ratings_average'),\DB::raw("categories.name as category_name"))->leftJoin('favorite', function ($query) use ($userid) {
            $query->on('favorite.service_id', '=', 'services.id')
                ->where('favorite.user_id', '=', $userid);
        })->leftJoin('testimonials', 'testimonials.service_id', '=', 'services.id')->join("categories",\DB::raw("FIND_IN_SET(categories.id,replace(services.category_id, '|', ','))"),">",\DB::raw("'0'"))
        ->groupBy('services.id')
        ->where('services.is_available', "1")
        ->where('services.is_deleted', "2")
        ->where('services.vendor_id', $request->vendor_id)
        ->orderBy('services.reorder_id')
        ->take(12)
        ->get();

        $getblog = Blog::select("vendor_id","title","description",DB::raw("CONCAT('".url(env('ASSETPATHURL').'admin-assets/images/blog')."/', image) AS image"),"created_at")->where('vendor_id', $request->vendor_id)->orderByDesc('id')->take(3)->take(12)->get();

        $testimonials = Testimonials::select('*',DB::raw("CONCAT('".url(env('ASSETPATHURL').'admin-assets/images/testimonials')."/', image) AS image"))->where('vendor_id', $request->vendor_id)->where('user_id', null)->where('service_id', null)->get();
        $choose = WhyChooseUs::select("*",DB::raw("CONCAT('".url(env('ASSETPATHURL').'admin-assets/images/index')."/', image) AS image"))->where('vendor_id', $request->vendor_id)->get();
        $choose_us_section = ['image' => helper::image_path(helper::appdata($request->vendor_id)->why_choose_image),'title' => helper::appdata($request->vendor_id)->why_choose_title,'sub_title' => helper::appdata($request->vendor_id)->why_choose_subtitle];
        $gettoprated=Service::with('service_image_api','reviews')->select('services.*', DB::raw('(case when favorite.service_id is null then 0 else 1 end) as is_favorite'),DB::raw('ROUND(AVG(testimonials.star),1) as ratings_average'))->leftJoin('favorite', function ($query) use ($userid) {
            $query->on('favorite.service_id', '=', 'services.id')
                ->where('favorite.user_id', '=', $userid);
        })
        ->leftJoin('testimonials', 'testimonials.service_id', '=', 'services.id')
        ->groupBy('services.id')
        ->where('services.is_available', "1")
        ->where('services.is_deleted', "2")
        ->where('services.vendor_id',$request->vendor_id)
        ->orderByDesc('ratings_average')
        ->take(6)
        ->get();
        return response()->json(['status' => 1, 'message' => trans('messages.success'), 'bannersection1' => $getbannersection1, 'bannersection2' => $getbannersection2, 'bannersection3' => $getbannersection3, 'blogs' => $getblog, 'categories' => $catdata, 'services' => $getservices,'currency'=>$currency,'currency_position'=>$currency_position,'currency_formate'=>$currency_formate,'decimal_separator'=>$decimal_separator,'testimonials' => $testimonials,'choose_us' => $choose,'top_rated' => $gettoprated,'choose_us_section' => $choose_us_section,'whatsapp_number' => helper::appdata($request->vendor_id)->whatsapp_number,'contact' => helper::appdata($request->vendor_id)->contact], 200);
    }
    public function systemaddon(Request $request)
    {
        if ($request->vendor_id == "") {
            return response()->json(["status" => 0, "message" => trans('messages.vendor_id_required')], 400);
        }
        $addons = SystemAddons::select('unique_identifier', 'activated')->get();
        $checkcustomerlogin = helper::appdata($request->vendor_id)->checkout_login_required;
        return response()->json(["status" => 1, "message" => trans('messages.success'), 'addons' =>  $addons, 'checkout_login_required' => $checkcustomerlogin, 'session_id'=>session()->getId(),'primary_color' =>  @helper::appdata($request->vendor_id)->primary_color,'service_ratting'=>@helper::appdata($request->vendor_id)->product_ratting_switch,'online_service'=>@helper::appdata($request->vendor_id)->online_order,'google_review'=>helper::appdata($request->vendor_id)->google_review], 200);
    }
    public function paymentmethods(Request $request)
    {
        if ($request->vendor_id == "") {
            return response()->json(["status" => 0, "message" => trans('messages.vendor_id_required')], 200);
        }
        $getpaymentmethodslist = Payment::where('is_available', 1)->where('vendor_id', $request->vendor_id)->whereNotIn('payment_name', ['wallet'])->where('is_activate', 1)->orderBy('reorder_id')->get();
        foreach($getpaymentmethodslist as $paymentlist)
        {
            $paymentlist->image = helper::image_path($paymentlist->image);
        }
        return response()->json(['status' => 1, 'message' => trans('messages.success'), "paymentmethods" => $getpaymentmethodslist], 200);
    }
    public function getstafflist(Request $request)
    {
        if ($request->vendor_id == "") {
            return response()->json(["status" => 0, "message" => trans('messages.vendor_id_required')], 200);
        }
        if ($request->service_id == "") {
            return response()->json(["status" => 0, "message" => trans('messages.service_id_required')], 200);
        }
        $userid = "";
        if ($request->user_id != "") {
            $userid = $request->user_id;
        }
        $service = Service::with('service_image_api','reviews','multi_image')->select('services.*', DB::raw('(case when favorite.service_id is null then 0 else 1 end) as is_favorite'))->leftJoin('favorite', function ($query) use ($userid) {
            $query->on('favorite.service_id', '=', 'services.id')
                ->where('favorite.user_id', '=', $userid);
        })->where('services.id', $request->service_id)->where('services.vendor_id', $request->vendor_id)->first();
        if($service->tax != null && $service->tax != "")
        {
            $tax_detail = helper::gettax($service->tax);
            $tax_amount = [];
            $tax_name = [];
            $totaltax = 0;
            foreach($tax_detail as $tax)
            {
                if($tax->type == 1)
                {
                    $tax_amount[] = $tax->tax;
                }else{
                    $tax_amount[] = ($tax->tax/100) * $service->price;
                }
               
               $tax_name[] = $tax->name;
            }
           foreach($tax_amount as $item)
           {
            $totaltax += (float)$item;
           }
        }
        $getstaflist = User::where('type',4)->where('vendor_id',$request->vendor_id)->whereIn('id',explode('|',$service->staff_id))->where('is_available',1)->get();
        return response()->json(['status' => 1, 'message' => trans('messages.success'),'staff_list' => $getstaflist,'tax_name'=>$tax_name,'tax_rate'=>$tax_amount,'total_tax'=>$totaltax], 200);
    }
}
