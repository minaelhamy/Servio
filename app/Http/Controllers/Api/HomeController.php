<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\helper\helper;
use App\Models\User;
use App\Models\Payment;
use App\Models\CustomStatus;
use App\Models\SystemAddons;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        if ($request->vendor_id == "") {
            return response()->json(["status" => 0, "message" => trans('messages.vendor_id_required')], 400);
        }
        $currency = helper::appdata($request->vendor_id)->currency;
        $currency_formate = helper::appdata($request->vendor_id)->currency_formate;
        $currency_position = helper::appdata($request->vendor_id)->currency_position;
        $decimal_separator = helper::appdata($request->vendor_id)->decimal_separator;
        $admindata = User::select('mobile', 'email')->where('type', 1)->first();
        $revenue = Booking::where('vendor_id', $request->vendor_id)->where('payment_status', '2')->where('status_type', '3')->sum('grand_total');
        $totalorders = Booking::where('vendor_id', $request->vendor_id)->count();
        $completedorders = Booking::where('status_type', 3)->where('vendor_id', $request->vendor_id)->count();
        $cancelorders = Booking::where('vendor_id', $request->vendor_id)->where('status_type', 4)->count();
        $orderlist = Booking::select("id", "booking_number", "service_name", "grand_total", "status", "booking_date", 'status_type')->where('vendor_id', $request->vendor_id)->whereIn('status', [1, 2])->orderByDesc('id')->get();
        return response()->json(['status' => 1, 'message' => trans('messages.success'), 'revenue' => $revenue, 'totalorders' => $totalorders, 'completedorders' => $completedorders, 'cancelorders' => $cancelorders, 'data' => $orderlist, 'currency' => $currency, 'currency_formate' => $currency_formate, 'currency_position' => $currency_position, 'decimal_separator' => $decimal_separator, 'admin_mobile' => $admindata->mobile, 'admin_email' => $admindata->email], 200);
    }
    public function servicedetail(Request $request)
    {
        if ($request->vendor_id == "") {
            return response()->json(["status" => 0, "message" => trans('messages.vendor_id_required')], 400);
        }
        if ($request->booking_number == "") {
            return response()->json(["status" => 0, "message" => trans('messages.booking_number_required')], 400);
        }
        $bookingdetail = Booking::select('id', 'booking_number', 'vendor_id', 'user_id', 'service_id', 'service_image', 'service_name', 'customer_name', 'email', 'mobile', 'address', 'landmark', 'postalcode', 'city', 'state', 'country', 'booking_date', 'booking_time', 'booking_endtime', 'offer_code', 'offer_amount', 'sub_total', 'tax','tax_name','grand_total', 'status', 'status_type', 'booking_notes', 'join_url', 'staff_id')->where('vendor_id', $request->vendor_id)->where('booking_number', $request->booking_number)->first();
        $bookingdetail->service_image = helper::image_path($bookingdetail->service_image);
        $staff =  User::where('type', 4)->where('vendor_id', $request->vendor_id)->where('id', $bookingdetail->staff_id)->first();
        $defaultsatus = CustomStatus::where('vendor_id', $request->vendor_id)->where('type', $bookingdetail->status_type)->where('id', $bookingdetail->status)->where('is_available', 1)->where('is_deleted', 2)->first();
        $paymentname = Payment::select('payment_name')->where('payment_type', $bookingdetail->transaction_type)->where('vendor_id', $request->vendor_id)->first();
        return response()->json(['status' => 1, 'message' => trans('messages.success'), 'data' => $bookingdetail, 'staff' => $staff, 'status' => $defaultsatus->name, 'payment_name' =>  $paymentname], 200);
    }
    public function history(Request $request)
    {
        if ($request->vendor_id == "") {
            return response()->json(["status" => 0, "message" => trans('messages.vendor_id_required')], 400);
        }
        if (helper::appdata($request->vendor_id)->online_order == 1) {
            $bookings = Booking::select("bookings.id", "bookings.booking_number", "bookings.service_name", "bookings.grand_total", "bookings.status", "bookings.status_type", "bookings.booking_date", "bookings.staff_id","custom_status.name")->join('custom_status','custom_status.id','bookings.status')->where('bookings.vendor_id', $request->vendor_id)->orderByDesc('id')->get();
        }else{
            $bookings = Booking::select("id", "booking_number", "service_name", "grand_total", "status", "status_type", "booking_date", "staff_id")->where('vendor_id', $request->vendor_id)->orderByDesc('id')->get();
        }
       
        $defaultsatus = CustomStatus::where('vendor_id', $request->vendor_id)->where('is_available', 1)->where('is_deleted', 2)->get();
        return response()->json(['status' => 1, 'message' => trans('messages.success'), 'data' => $bookings, 'custom_status' => $defaultsatus], 200);
    }
    public function status_change(Request $request)
    {
        if ($request->vendor_id == "") {
            return response()->json(["status" => 0, "message" => trans('messages.vendor_id_required')], 400);
        }
        if ($request->status == "") {
            return response()->json(["status" => 0, "message" => trans('messages.status_required')], 400);
        }
        if ($request->status_type == "") {
            return response()->json(["status" => 0, "message" => trans('messages.status_type_required')], 400);
        }
        if ($request->booking_number == "") {
            return response()->json(["status" => 0, "message" => trans('messages.booking_number_required')], 400);
        }
        $defaultsatus = CustomStatus::where('vendor_id', $request->vendor_id)->where('type', $request->status_type)->where('id', $request->status)->where('is_available', 1)->where('is_deleted', 2)->first();
        if (empty($defaultsatus)) {
            return response()->json(['status' => 0, 'message' => trans('messages.wrong')], 200);
        }
        Booking::where('booking_number', $request->booking_number)->update(['status' => $defaultsatus->id, 'status_type' => $defaultsatus->type]);
        return response()->json(['status' => 1, 'message' => trans('messages.success')], 200);
    }
    public function systemaddon(Request $request)
    {
        $addons = SystemAddons::select('unique_identifier', 'activated')->get();
        return response()->json(["status" => 1, "message" => trans('messages.success'), 'addons' =>  $addons], 200);
    }
    public function staffassign(Request $request)
    {
        if ($request->vendor_id == "") {
            return response()->json(["status" => 0, "message" => trans('messages.vendor_id_required')], 400);
        }
        if ($request->booking_number == "") {
            return response()->json(["status" => 0, "message" => trans('messages.booking_number_required')], 400);
        }
        try {
            $booking = Booking::where('booking_number', $request->booking_number)->where('vendor_id', $request->vendor_id)->first();
            if ($request->staff_id != "" && $request->staff_id != null) {
                $checkbooking = Booking::where('staff_id', $request->staff_id)->where('booking_time', $booking->booking_time)->where('booking_endtime', $booking->booking_endtime)->where('booking_date', $booking->booking_date)->whereNotIn('status', [3, 4, 5])->get();
                if ($checkbooking->count() > 0) {
                    return response()->json(['status' => 0, 'message' => trans('messages.staff_booked_message')], 200);
                }
            }
            $booking->staff_id = $request->staff_id;
            $booking->update();
            return response()->json(['status' => 1, 'message' => trans('messages.success')], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => 0, 'message' => trans('messages.wrong')], 200);
        }
    }
}
