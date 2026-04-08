<?php

namespace App\Http\Controllers\Api\user;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Service;
use App\Models\Booking;
use App\Models\User;
use App\Models\Favorite;
use Carbon\Carbon;
use App\helper\helper;
use App\Models\Timing;
use App\Models\Testimonials;
use Carbon\CarbonPeriod;

class ServiceController extends Controller
{
    public function category(Request $request)
    {
        if ($request->vendor_id == "") {
            return response()->json(["status" => 0, "message" => trans('messages.vendor_id_required')], 400);
        }
        $getcategories = Category::select("id", "vendor_id", "name", DB::raw("CONCAT('" . url(env('ASSETPATHURL') . 'admin-assets/images/categories') . "/', image) AS image"))->where('is_available', "1")->where('is_deleted', "2")->where('vendor_id', $request->vendor_id)->get();

        foreach ($getcategories as $category) {
            $data[] = array(
                'id' =>  $category->id,
                'name' =>  $category->name,
                'vendor_id' => $category->vendor_id,
                'image' => $category->image,
                'count' => helper::service_count($category->id),
            );
        }

        return response()->json(['status' => 1, 'message' => trans('messages.success'), 'data' => $data], 200);
    }
    public function services(Request $request)
    {
        $userid = "";
        if ($request->user_id != "") {
            $userid = $request->user_id;
        }
        if ($request->vendor_id == "") {
            return response()->json(["status" => 0, "message" => trans('messages.vendor_id_required')], 400);
        }
        $getservice = Service::with('service_image_api','reviews')->select('services.*', DB::raw('(case when favorite.service_id is null then 0 else 1 end) as is_favorite'),DB::raw('ROUND(AVG(testimonials.star),1) as ratings_average'),\DB::raw("categories.name as category_name"))->leftJoin('favorite', function ($query) use ($userid) {
            $query->on('favorite.service_id', '=', 'services.id')
                ->where('favorite.user_id', '=', $userid);
        })->leftJoin('testimonials', 'testimonials.service_id', '=', 'services.id')->join("categories",\DB::raw("FIND_IN_SET(categories.id,replace(services.category_id, '|', ','))"),">",\DB::raw("'0'"))->where('services.is_available', 1)->where('services.is_deleted', 2)->where('services.vendor_id', $request->vendor_id)->orderByDesc('services.id');
        if (!empty($request->search_input)) {
            $getservice = $getservice->where('services.name', 'like', '%' . $request->search_input . '%');
        }
        if (!empty($request->category_id)) {
            $getservice = $getservice->where(DB::Raw("FIND_IN_SET($request->category_id, replace(services.category_id, '|', ','))"), '>', 0);
        }
        $getservice = $getservice->paginate(16);
        return response()->json(['status' => 1, 'message' => trans('messages.success'), 'data' => $getservice], 200);
    }
    public function getbookingslots(Request $request)
    {
        try {
            if ($request->vendor_id == "") {
                return response()->json(["status" => 0, "message" => trans('messages.vendor_id_required')], 400);
            }
            if ($request->date == "") {
                return response()->json(["status" => 0, "message" => trans('messages.date_required')], 400);
            }
            if ($request->service_id == "") {
                return response()->json(["status" => 0, "message" => trans('messages.service_id_required')], 400);
            }
            $timezone = helper::appdata($request->vendor_id);
            $slots = [];
            date_default_timezone_set($timezone->timezone);
            $service = Service::where('id',$request->service_id)->where('vendor_id',$request->vendor_id)->first();
            if ($request->date != "" || $request->date != null) {
                $day = date('l', strtotime($request->date));
                $minute = "";
                $time = Timing::where('vendor_id', $request->vendor_id)->where('service_id',$request->service_id)->where('day', $day)->first();
                if ($time->is_always_close == 1) {
                    $slots = "1";
                } else {
                    if ($service->interval_type == 2) {
                        $minute = (float)$service->interval_time * 60;
                    }
                    if ($service->interval_type == 1) {
                        $minute = $service->interval_time;
                    }
                    $firsthalf = new CarbonPeriod(date("H:i", strtotime($time->open_time)) , $minute . ' minutes', date("H:i", strtotime($time->break_start))); // for create use 24 hours format later change format 
                    $secondhalf =  new CarbonPeriod(date("H:i", strtotime($time->break_end)) , $minute . ' minutes', date("H:i", strtotime($time->close_time)));

                    foreach ($firsthalf as $item) {
                        $starttime[] = $item->format("h:i A");
                    }
                    foreach ($secondhalf as $item) {
                        $endtime[] = $item->format("h:i A");
                    }
                    for ($i = 0; $i < count($starttime) - 1; $i++) {
                        $temparray[] = $starttime[$i] . ' ' . '-' . ' ' . next($starttime);
                    }
                    for ($i = 0; $i < count($endtime) - 1; $i++) {
                        $temparray[] = $endtime[$i] . ' ' . '-' . ' ' . next($endtime);
                    }
                   
                    $currenttime = Carbon::now()->format('h:i a');
                    $current_date = Carbon::now()->format('Y-m-d');

                    foreach ($temparray as $item) {
                        if ($request->date == $current_date) {
                            $slottime = explode('-', $item);
                            if (strtotime($slottime[0]) <= strtotime($currenttime)) {
                                $status = "";
                            } else {
                                $status = "active";
                            }
                        } else {
                            $status = "active";
                        }
                        $slots[] = array(
                            'slot' =>  $item,
                            'status' => $status,
                        );
                    }
                }
            }
            return response()->json(['status' => 1, 'message' => trans('messages.success'), 'timeslot' => $slots], 200);
        } catch (\Throwable $th) {
            
            return response()->json(['status' => 0, 'message' => trans('messages.wrong')], 200);
        }
    }
    function servicedetails(Request $request)
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
        $service = Service::with('service_image_api','reviews','multi_image')->select('services.*',\DB::raw("categories.name as category_name"), DB::raw('(case when favorite.service_id is null then 0 else 1 end) as is_favorite'))->leftJoin('favorite', function ($query) use ($userid) {
            $query->on('favorite.service_id', '=', 'services.id')
                ->where('favorite.user_id', '=', $userid);
        })->join("categories",\DB::raw("FIND_IN_SET(categories.id,replace(services.category_id, '|', ','))"),">",\DB::raw("'0'"))->where('services.id', $request->service_id)->where('services.vendor_id', $request->vendor_id)->first();
        $categry = Category::whereIn('id',explode('|',$service->category_id))->get();

        $raplceid = str_replace('|',',',$service->category_id);
      
        $related_services = Service::with('service_image', 'multi_image')->where('id', '!=', $service->id)->where('vendor_id', $vendordata->id)->whereIn('category_id',explode(',',$raplceid))->orderBy('reorder_id')->get();
        $review = Testimonials::select('*', DB::raw("CONCAT('" . url(env('ASSETPATHURL') . 'admin-assets/images/testimonials') . "/', image) AS image"))->where('vendor_id', $request->vendor_id)->where('service_id', $request->id)->get();

        $averagerating = Testimonials::where('service_id', $request->service_id)->where('vendor_id', $request->vendor_id)->avg('star');
        $totalreview = Testimonials::where('service_id', $request->service_id)->where('vendor_id', $request->vendor_id)->count();

        if($totalreview != 0) {
            $avgfive = (Testimonials::where('service_id', $request->item_id)->where('vendor_id', $request->vendor_id)->where('star', 5)->count()) / $totalreview * 100;
            $avgfour = (Testimonials::where('service_id', $request->item_id)->where('vendor_id', $request->vendor_id)->where('star', 4)->count()) / $totalreview * 100;
            $avgthree = (Testimonials::where('service_id', $request->item_id)->where('vendor_id', $request->vendor_id)->where('star', 3)->count()) / $totalreview * 100;
            $avgtwo = (Testimonials::where('service_id', $request->item_id)->where('vendor_id', $request->vendor_id)->where('star', 2)->count()) / $totalreview * 100;
            $avgone = (Testimonials::where('service_id', $request->item_id)->where('vendor_id', $request->vendor_id)->where('star', 1)->count()) / $totalreview * 100;
        } else {     
            $avgfive = 0;
            $avgfour = 0;
            $avgthree = 0;
            $avgtwo = 0;
            $avgone = 0;
        }
        $getstaflist = User::where('type',4)->where('vendor_id',$request->vendor_id)->whereIn('id',explode('|',$service->staff_id))->where('is_available',1)->get();
        return response()->json(['status' => 1, 'message' => trans('messages.success'), 'service_detail' => $service, 'related_service' => $related_services, 'user_review' => $review, 'avg_rating' => number_format($averagerating, 1), 'total_reviews' => $totalreview, 'avgfive' => number_format($avgfive, 1), 'avgfour' => number_format($avgfour, 1), 'avgthree' => number_format($avgthree, 1), 'avgtwo' => number_format($avgtwo, 1), 'avgone' => number_format($avgone, 1),'staff_list' => $getstaflist,'category_name' => $categry[0]->name], 200);
    }
    public function postreview(Request $request)
    {
        if ($request->vendor_id == "") {
            return response()->json(["status" => 0, "message" => trans('messages.vendor_id_required')], 200);
        }
        if ($request->service_id == "") {
            return response()->json(["status" => 0, "message" => trans('messages.service_id_required')], 200);
        }
        if ($request->user_id == "") {
            return response()->json(["status" => 0, "message" => trans('messages.user_id_required')], 200);
        }
        $booking = Booking::where('user_id', $request->user_id)->where('vendor_id', $request->vendor_id)->where('service_id', $request->service_id)->count();
        $rattingcount = Testimonials::where('user_id', $request->user_id)->where('service_id', $request->service_id)->where('vendor_id', $request->vendor_id)->count();
        if ($booking > 0 && $rattingcount == 0) {
            $user = User::where('id', $request->user_id)->first();
            $review = new Testimonials();
            $review->vendor_id = $request->vendor_id;
            $review->user_id = $request->user_id;
            $review->service_id = $request->service_id;
            $review->star = $request->ratting;
            $review->description = $request->review;
            $review->name = $user->name;
            $review->image = $user->image;
            $review->save();
            return response()->json(['status' => 1, 'message' => trans('messages.success')], 200);
        } else {
            return response()->json(['status' => 0, 'message' => trans('messages.post_review_message')], 200);
        }
    }
    public function managefavorite(Request $request)
    {

        if ($request->vendor_id == "") {
            return response()->json(["status" => 0, "message" => trans('messages.vendor_id_required')], 200);
        }
        if ($request->service_id == "") {
            return response()->json(["status" => 0, "message" => trans('messages.service_id_required')], 200);
        }
        if ($request->user_id == "") {
            return response()->json(["status" => 0, "message" => trans('messages.user_id_required')], 200);
        }
        if ($request->type == "") {
            return response()->json(["status" => 0, "message" => trans('messages.type_required')], 200);
        }
        $favorite = Favorite::where('service_id', $request->service_id)->where('vendor_id', $request->vendor_id)->where('user_id', $request->user_id)->first();
        if (!empty($favorite) && $request->type == 2) {
            $favorite->delete();
        } 
        if($request->type == 1 && empty($favorite)) {
            $favorite = new Favorite();
            $favorite->vendor_id = $request->vendor_id;
            $favorite->user_id = $request->user_id;
            $favorite->service_id = $request->service_id;
            $favorite->save();
        }
        return response()->json(['status' => 1, 'message' => trans('messages.success')], 200);
    }
    public function checkbooking(Request $request)
    {
        if ($request->vendor_id == "") {
            return response()->json(["status" => 0, "message" => trans('messages.vendor_id_required')], 200);
        }
        if ($request->service_id == "") {
            return response()->json(["status" => 0, "message" => trans('messages.service_id_required')], 200);
        }
       
        if ($request->booking_time == "") {
            return response()->json(["status" => 0, "message" => trans('messages.booking_time_required')], 200);
        }
        if ($request->booking_date == "") {
            return response()->json(["status" => 0, "message" => trans('messages.booking_date_required')], 200);
        }
        try {
            $timezone = helper::appdata($request->vendor_id);
            date_default_timezone_set($timezone->timezone);
            $time = explode('-', $request->booking_time);
            $booking = Booking::where('vendor_id', $request->vendor_id)->where('booking_date', $request->booking_date)->where('booking_time', $time[0])->whereNotIn('status', [3, 4, 5])->where('booking_endtime', $time[1])->get();
            $setting = Service::select('per_slot_limit')->where('id',$request->service_id)->first();
            if ($request->staff_id != "" || $request->staff_id !=null) {
                $checkbooking = Booking::where('staff_id',$request->staff_id)->where('booking_time',$time[0])->where('booking_endtime',$time[1])->where('booking_date',$request->booking_date)->whereNotIn('status', [3, 4, 5])->where('vendor_id',$request->vendor_id)->get();
                if($checkbooking->count() > 0)
                {
                   return response()->json(['status' => 0, 'message' => trans('messages.staff_booked_message')], 200);
                }
            }
            if ($booking->count() >= $setting->per_slot_limit) {
                return response()->json(['status' => 0, 'message' => trans('messages.already_booked')], 200);
            }else{
                return response()->json(['status' => 1, 'message' => trans('messages.success')], 200);
            }
        } catch (\Throwable $th) {
            return response()->json(['status' => 0, 'message' => trans('messages.wrong')], 200);
        }
    }
}
