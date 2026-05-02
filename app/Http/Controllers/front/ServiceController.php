<?php

namespace App\Http\Controllers\front;

use App\helper\helper;
use App\Http\Controllers\Controller;
use App\Models\AdditionalService;
use App\Models\Booking;
use App\Models\Category;
use App\Models\Promocode;
use App\Models\Service;
use App\Models\Settings;
use App\Models\User;
use App\Models\Testimonials;
use App\Models\Timing;
use App\Models\SystemAddons;
use App\Models\Payment;
use App\Models\Favorite;
use App\Models\OrderDetails;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\QuestionAnswer;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Jorenvh\Share\ShareFacade;

class ServiceController extends Controller
{
    private function resolveStorefrontVendor(Request $request): array
    {
        $vendordata = helper::currentStoreUser($request->route('vendor'));
        if (empty($vendordata)) {
            abort(404);
        }

        return [$vendordata, $vendordata->id];
    }

    public function index(Request $request)
    {
        [$vendordata, $vdata] = $this->resolveStorefrontVendor($request);
        $category_name = "";
        $getservice = Service::with('service_image')->where('is_available', 1)->where('is_deleted', 2)->where('vendor_id', @$vendordata->id);
        $categories = Category::where('is_available', 1)->where('is_deleted', 2)->where('vendor_id', @$vendordata->id)->orderBy('reorder_id')->get();

        if (request()->get('type') == 'topdeals' && helper::top_deals($vendordata->id) != null) {
            $getservice = $getservice->where('services.top_deals', "1");
        }
        $sorter = $request->get('sorter');
        if ($sorter == "high-to-low-price") {
            $getservice = $getservice->orderBy('price', 'DESC');
        }
        if ($sorter == "low-to-high-price") {
            $getservice = $getservice->orderBy('price', 'ASC');
        }
        if ($sorter == "high-to-low-rating") {
            $getservice = Service::with('service_image')
                ->leftJoin('testimonials', 'testimonials.service_id', '=', 'services.id')
                ->select('services.*', DB::raw('COALESCE(AVG(testimonials.star), 0) as average'))
                ->where('services.vendor_id', @$vendordata->id)
                ->where('services.is_available', 1)
                ->where('services.is_deleted', 2)
                ->groupBy('services.id')
                ->orderByDesc('average');
            if (request()->get('type') == 'topdeals' && helper::top_deals($vendordata->id) != null) {
                $getservice = $getservice->where('services.top_deals', "1");
            }
        }
        if ($sorter == "low-to-high-rating") {
            $getservice = Service::with('service_image')
                ->leftJoin('testimonials', 'testimonials.service_id', '=', 'services.id')
                ->select('services.*', DB::raw('COALESCE(AVG(testimonials.star), 0) as average'))
                ->where('services.vendor_id', @$vendordata->id)
                ->where('services.is_available', 1)
                ->where('services.is_deleted', 2)
                ->groupBy('services.id')
                ->orderBy('average');
            if (request()->get('type') == 'topdeals' && helper::top_deals($vendordata->id) != null) {
                $getservice = $getservice->where('services.top_deals', "1");
            }
        }
        if (!empty($request->search_input)) {
            $getservice = $getservice->where('services.name', 'like', '%' . $request->search_input . '%');
        }
        if (!empty($request->category)) {
            $category = Category::where('slug', $request->category)->first();
            $getservice = $getservice->where(DB::Raw("FIND_IN_SET($category->id, replace(category_id, '|', ','))"), '>', 0);
            $category_name = $category->name;
        }
        $getservice = $getservice->orderBy('reorder_id')->paginate(16);
        return view('front.service.service_list', compact('getservice', 'vendordata','vdata','categories', 'category_name', 'sorter'));
    }
    public function servicedetails(Request $request)
    {
        if (Auth::user() && Auth::user()->type == 3) {
            $userid = Auth::user()->id;
        } else {
            $userid = "";
        }
        [$vendordata, $vdata] = $this->resolveStorefrontVendor($request);
        $checkplan = helper::checkplan(@$vendordata->id, 3);
        $v = json_decode(json_encode($checkplan));
        if (@$v->original->status == 2) {
            return redirect()->back()->with('error', @$v->original->message);
        }

        $service = Service::with('service_image', 'multi_image')->where('slug', $request->slug)->where('vendor_id', @$vendordata->id)->first();
        $promocode = Promocode::where('vendor_id', @$vendordata->id)->where('is_available', '1')->get();
        if (empty($service)) {
            abort(404);
        }
        $url = Request()->url();
        $shareComponent = ShareFacade::page(
            $url
        )
            ->facebook()
            ->twitter()
            ->linkedin()
            ->telegram()
            ->whatsapp()
            ->reddit();
        $raplceid = str_replace('|', ',', $service->category_id);

        $related_services = Service::with('service_image', 'multi_image')->where('id', '!=', $service->id)->where('vendor_id', $vendordata->id)->whereIn('category_id', explode(',', $raplceid))->orderBy('reorder_id')->where('is_available', 1)->where('is_deleted', 2)->get();
        $reviews = Testimonials::with('user_info')->where('vendor_id', $vendordata->id)->where('service_id', $service->id)->get();
        $averagerating = Testimonials::where('service_id', $service->id)->where('vendor_id', $vendordata->id)->avg('star');
        $totalreview = Testimonials::where('service_id', $service->id)->where('vendor_id', $vendordata->id)->count();
        $fivestaraverage = Testimonials::where('service_id', $service->id)->where('vendor_id', $vendordata->id)->where('star', 5)->count('star');
        $fourstaraverage = Testimonials::where('service_id', $service->id)->where('vendor_id', $vendordata->id)->where('star', 4)->count('star');
        $threestaraverage = Testimonials::where('service_id', $service->id)->where('vendor_id', $vendordata->id)->where('star', 3)->count('star');
        $twostaraverage = Testimonials::where('service_id', $service->id)->where('vendor_id', $vendordata->id)->where('star', 2)->count('star');
        $onestaraverage = Testimonials::where('service_id', $service->id)->where('vendor_id', $vendordata->id)->where('star', 1)->count('star');
        $times = Timing::where('vendor_id', $vendordata->id)->where('service_id', $service->id)->get();
        $additional_service = AdditionalService::where('service_id', $service->id)->get();
        $question_answer = QuestionAnswer::where('service_id', $service->id)->where('vendor_id', $vendordata->id)->whereNot('answer', '')->get();

        // recent view Service module start
        $servicedata = Service::with('service_image', 'multi_image')->where('id', @$service->id)->firstOrFail();
        $recent = session()->get('recently_viewed', []);
        $recent = array_filter($recent, function ($id) use ($servicedata) {
            return $id != $servicedata->id;
        });
        array_unshift($recent, $servicedata->id);
        $recent = array_slice($recent, 0, 5);
        session(['recently_viewed' => $recent]);
        $recentServicesOrdered = Service::with('service_image', 'multi_image')
            ->whereIn('id', $recent)
            ->where('vendor_id', $vendordata->id)
            ->where('id', '!=', $servicedata->id)
            ->get()
            ->keyBy('id');
        $recentServices  = collect($recent)
            ->map(fn($id) => $recentServicesOrdered->get($id))
            ->filter();
        // recent view Service module end
        return view('front.service.serviceview', compact('service', 'vendordata','vdata', 'times', 'promocode', 'reviews', 'related_services', 'averagerating', 'totalreview', 'shareComponent', 'fivestaraverage', 'fourstaraverage', 'threestaraverage', 'twostaraverage', 'onestaraverage', 'additional_service', 'question_answer','recentServices'));
    }
    public function servicebooking(Request $request)
    {
        [$vendordata, $vdata] = $this->resolveStorefrontVendor($request);

        $checkplan = helper::checkplan(@$vendordata->id, 3);
        $v = json_decode(json_encode($checkplan));
        if (@$v->original->status == 2) {
            return redirect()->back()->with('error', @$v->original->message);
        }
        $service = Service::with('service_image', 'multi_image', 'category_info', 'additional_service')->where('id', $request->id)->where('vendor_id', @$vendordata->id)->first();
        $timeslot = Timing::where('vendor_id', @$vendordata->id)->get();
        $additional_service = [];
        if (Session::get('id')) {
            $id = Session::get('id');
            $add_service_id = explode("|", $id);
            $additional_service = AdditionalService::whereIn('id', $add_service_id)->get();
        }
        if (empty($service)) {
            abort(404);
        }

        $averagerating = Testimonials::where('service_id', $request->id)->where('vendor_id', $vendordata->id)->avg('star');
        $totalreview = Testimonials::where('service_id', $request->id)->where('vendor_id', $vendordata->id)->count();
        $getstaflist = User::where('type', 4)->where('vendor_id', $vendordata->id)->whereIn('id', explode('|', $service->staff_id))->where('is_available', 1)->where('role_type', 1)->where('is_deleted', 2)->orderBy('reorder_id')->get();
        if (
            SystemAddons::where('unique_identifier', 'commission_module')->first() != null &&
            SystemAddons::where('unique_identifier', 'commission_module')->first()->activated == 1
        ) {
            if (helper::getslug($vendordata->id)->commission_on_off == 1) {
                $getpayment = Payment::where('is_available', '1')->where('vendor_id', 1)->whereNotIn('payment_type', ['1', '16'])->where('is_activate', '1')->orderBy('reorder_id')->get();
            } else {
                if (Auth::user() && Auth::user()->type == 3) {
                    $getpayment = Payment::where('is_available', '1')->where('vendor_id', $vendordata->id)->whereNotIn('payment_type', ['1'])->where('is_activate', '1')->orderBy('reorder_id')->get();
                } else {
                    $getpayment = Payment::where('is_available', '1')->where('vendor_id', $vendordata->id)->whereNotIn('payment_type', ['1', '16'])->where('is_activate', '1')->orderBy('reorder_id')->get();
                }
            }
        } else {
            if (Auth::user() && Auth::user()->type == 3) {
                $getpayment = Payment::where('is_available', '1')->where('vendor_id', $vendordata->id)->whereNotIn('payment_type', ['1'])->where('is_activate', '1')->orderBy('reorder_id')->get();
            } else {
                $getpayment = Payment::where('is_available', '1')->where('vendor_id', $vendordata->id)->whereNotIn('payment_type', ['1', '16'])->where('is_activate', '1')->orderBy('reorder_id')->get();
            }
        }

        return view('front.service.servicedetail', compact('service', 'vendordata','vdata', 'timeslot', 'averagerating', 'totalreview', 'getstaflist', 'getpayment', 'additional_service'));
    }
    public function addtional_service(Request $request)
    {

        Session::put('id', $request->value);
        return response()->json(['status' => 1], 200);
    }
    public function timeslot(Request $request)
    {
        $timezone = helper::appdata($request->vendor_id);
        $slots = [];
        date_default_timezone_set($timezone->timezone);
        $service = Service::where('id', $request->service_id)->where('vendor_id', $request->vendor_id)->first();

        if ($request->inputDate != "" || $request->inputDate != null) {
            $day = date('l', strtotime($request->inputDate));
            $minute = "";
            $time = Timing::where('vendor_id', $request->vendor_id)->where('day', $day)->where('service_id', $request->service_id)->first();

            if (empty($time)) {
                return response()->json(['status' => 0], 200);
            }

            if ($time->is_always_close == 1) {
                $slots = "1";
            } else {
                if ((int) $service->interval_type === 1) {
                    $minute = (int) $service->interval_time * 60;
                }
                if ((int) $service->interval_type === 2) {
                    $minute = (int) $service->interval_time;
                }
                $openTime = date("H:i", strtotime((string) $time->open_time));
                $closeTime = date("H:i", strtotime((string) $time->close_time));
                $breakStart = !empty($time->break_start) ? date("H:i", strtotime((string) $time->break_start)) : null;
                $breakEnd = !empty($time->break_end) ? date("H:i", strtotime((string) $time->break_end)) : null;
                $ranges = [];

                if ($minute <= 0 || strtotime($closeTime) <= strtotime($openTime)) {
                    return response()->json(['status' => 0], 200);
                }

                if (
                    $breakStart !== null &&
                    $breakEnd !== null &&
                    strtotime($breakStart) > strtotime($openTime) &&
                    strtotime($breakEnd) < strtotime($closeTime) &&
                    strtotime($breakEnd) > strtotime($breakStart)
                ) {
                    $ranges[] = [$openTime, $breakStart];
                    $ranges[] = [$breakEnd, $closeTime];
                } else {
                    $ranges[] = [$openTime, $closeTime];
                }

                $temparray = [];
                if (helper::appdata($request->vendor_id)->time_format == 1) {
                    foreach ($ranges as [$rangeStart, $rangeEnd]) {
                        $period = new CarbonPeriod($rangeStart, $minute . ' minutes', $rangeEnd);
                        $rangeSlots = [];
                        foreach ($period as $item) {
                            $rangeSlots[] = $item->format("H:i");
                        }
                        for ($i = 0; $i < count($rangeSlots) - 1; $i++) {
                            $temparray[] = $rangeSlots[$i] . ' - ' . $rangeSlots[$i + 1];
                        }
                    }
                } else {
                    foreach ($ranges as [$rangeStart, $rangeEnd]) {
                        $period = new CarbonPeriod($rangeStart, $minute . ' minutes', $rangeEnd);
                        $rangeSlots = [];
                        foreach ($period as $item) {
                            $rangeSlots[] = $item->format("h:i A");
                        }
                        for ($i = 0; $i < count($rangeSlots) - 1; $i++) {
                            $temparray[] = $rangeSlots[$i] . ' - ' . $rangeSlots[$i + 1];
                        }
                    }
                }
                $currenttime = Carbon::now()->format('h:i a');
                $current_date = Carbon::now()->format('Y-m-d');
                if (is_array(@$temparray)) {
                    foreach ($temparray as $item) {
                        if ($request->inputDate == $current_date) {
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
                } else {
                    return response()->json(['status' => 0], 200);
                }
            }
        }
        return $slots;
    }

    public function slotlimit(Request $request)
    {
        try {

            $timezone = helper::appdata($request->vendor_id);
            date_default_timezone_set($timezone->timezone);
            $time = explode('-', $request->time);
            $booking = Booking::where('vendor_id', $request->vendor_id)->where('booking_date', $request->inputdate)->where('booking_time', $time[0])->whereNotIn('status_type', [3, 4])->where('booking_endtime', $time[1])->get();
            $setting = Service::select('per_slot_limit')->where('id', $request->service_id)->where('vendor_id', $request->vendor_id)->first();
            $limit = 1;
            if ($booking->count() >= $setting->per_slot_limit) {
                $limit = "0";
            }
            return $limit;
        } catch (\Throwable $th) {
            return response()->json(['status' => 0, 'message' => trans('messages.wrong')], 200);
        }
    }
    public function postreview(Request $request)
    {
        [$vendordata, $vdata] = $this->resolveStorefrontVendor($request);
        if (Auth::user() && Auth::user()->type == 3) {
            if (isset($request->product_id)) {
                $booking = OrderDetails::where('user_id', Auth::user()->id)->where('vendor_id', $vendordata->id)->where('product_id', $request->product_id)->count();
                $rattingcount = Testimonials::where('user_id', Auth::user()->id)->where('product_id', $request->product_id)->where('vendor_id', $vendordata->id)->count();
            } else {
                $rattingcount = Testimonials::where('user_id', Auth::user()->id)->where('service_id', $request->service_id)->where('vendor_id', $vendordata->id)->count();
                $booking = Booking::where('user_id', Auth::user()->id)->where('vendor_id', $vendordata->id)->where('service_id', $request->service_id)->count();
            }
            if ($booking > 0 && $rattingcount == 0) {
                $review = new Testimonials();
                $review->vendor_id = $vendordata->id;
                $review->user_id = Auth::user()->id;
                if (isset($request->product_id)) {
                    $review->product_id = $request->product_id;
                } else {
                    $review->service_id = $request->service_id;
                }
                $review->star = $request->ratting;
                $review->description = $request->review == null ? '-' : $request->review;
                $review->save();
                return redirect()->back()->with('success', trans('messages.success'));
            } else {
                if (isset($request->product_id)) {
                    return redirect()->back()->with('error', trans('messages.product_post_review_message'));
                } else {
                    return redirect()->back()->with('error', trans('messages.post_review_message'));
                }
            }
        } else {
            session()->put('previous_url', Request()->url());
            return redirect($vendordata->slug . '/login');
        }
    }
    public function managefavorite(Request $request)
    {
        try {
            if ($request->is($request->vendor . '/product/managefavorite')) {
                $favorite = Favorite::where('product_id', $request->service_id)->where('vendor_id', $request->vendor_id)->where('user_id', Auth::user()->id)->first();
            } else {
                $favorite = Favorite::where('service_id', $request->service_id)->where('vendor_id', $request->vendor_id)->where('user_id', Auth::user()->id)->first();
            }
            if (!empty($favorite)) {
                $favorite->delete();
            } else {
                $favorite = new Favorite();
                $favorite->vendor_id = $request->vendor_id;
                $favorite->user_id = Auth::user()->id;
                if ($request->is($request->vendor . '/product/managefavorite')) {
                    $favorite->product_id = $request->service_id;
                } else {
                    $favorite->service_id = $request->service_id;
                }
                $favorite->save();
            }
            return response()->json(['status' => 1, 'message' => trans('messages.success')], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => 0, 'message' => trans('messages.wrong')], 200);
        }
    }
    public function removeall(Request $request)
    {
        [$vendordata, $vdata] = $this->resolveStorefrontVendor($request);
        $favorite = Favorite::where('user_id', Auth::user()->id)->where('vendor_id', $vendordata->id)->get();
        Favorite::destroy($favorite->pluck('id')->toArray());
        return redirect()->back()->with('success', trans('messages.success'));
    }
    public function stafflimit(Request $request)
    {
        $time = explode('-', $request->booking_time);
        if ($request->staff_id != "" && $request->staff_id != null) {
            $checkbooking = Booking::where('staff_id', $request->staff_id)->where('booking_time', $time[0])->where('booking_endtime', $time[1])->where('booking_date', $request->booking_date)->whereNotIn('status', [3, 4, 5])->where('vendor_id', $request->vendor_id)->get();
            if ($checkbooking->count() > 0) {
                return response()->json(['status' => 0, 'message' => trans('messages.staff_booked_message')], 200);
            }
        } else {
            return response()->json(['status' => 1], 200);
        }
    }
}
