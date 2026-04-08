<?php

namespace App\Http\Controllers\Api\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\helper\helper;
use App\helper\whatsapp_helper;
use App\Models\User;
use App\Models\Transaction;
use App\Models\SystemAddons;
use App\Models\Payment;
use App\Models\CustomStatus;
use URL;
use Config;
use Stripe;


class BookingController extends Controller
{
    public function savebooking(Request $request)
    {
        if ($request->vendor_id == "") {
            return response()->json(["status" => 0, "message" => trans('messages.vendor_id_required')], 200);
        }
        try {
            date_default_timezone_set(helper::appdata($request->vendor_id)->timezone);
            $defaultsatus = CustomStatus::where('vendor_id', $request->vendor_id)->where('type', 1)->where('is_available', 1)->where('is_deleted', 2)->first();
            if (empty($defaultsatus) && $defaultsatus == null) {
                return response()->json(['status' => 0, 'message' => trans('messages.default_status_msg')], 200);
            }
            $checkplan = helper::checkplan($request->vendor_id, 3);
            $v = json_decode(json_encode($checkplan));
            if (@$v->original->status == 2) {
                return response()->json(["status" => 0, "message" => @$v->original->message], 200);
            }
            $vendordata = User::where('id', $request->vendor_id)->first();
            $checkplan = Transaction::where('vendor_id', $vendordata->id)->orderByDesc('id')->first();
            if ($checkplan->appoinment_limit == -1 || $checkplan->appoinment_limit > 0) {
                $bookinginfo = new Booking();
                $getbookingnumber = Booking::select('booking_number','booking_number_digit', 'order_number_start')->where('vendor_id', $request->vendor_id)->orderBy('id', 'DESC')->first();
           

                if (empty($getbookingnumber->booking_number_digit)) {
                    $n = helper::appdata($request->vendor_id)->order_number_start;
                    $newbooking_number = str_pad($n, 0, STR_PAD_LEFT);
                } else {
                    if ($getbookingnumber->order_number_start == helper::appdata($request->vendor_id)->order_number_start) {
                        $n = (int)($getbookingnumber->booking_number_digit);
                        $newbooking_number = str_pad($n + 1, 0, STR_PAD_LEFT);
                    } else {
                        $n = helper::appdata($request->vendor_id)->order_number_start;
                        $newbooking_number = str_pad($n, 0, STR_PAD_LEFT);
                    }
                }
    
                $bookinginfo = new Booking();
                $booking_number = helper::appdata($request->vendor_id)->order_prefix . $newbooking_number;
                $bookinginfo->booking_number = $booking_number;
                $bookinginfo->booking_number_digit = $newbooking_number;
                $bookinginfo->order_number_start = helper::appdata($request->vendor_id)->order_number_start;
                $bookinginfo->vendor_id = $request->vendor_id;
                if ($request->user_id != "") {
                    $bookinginfo->user_id = $request->user_id;
                }
                $bookinginfo->service_id = $request->service_id;
                $bookinginfo->service_image  = $request->service_image;
                $bookinginfo->service_name  = $request->service_name;
                if ($request->offer_code != "") {
                    $bookinginfo->offer_code  = $request->offer_code;
                    $bookinginfo->offer_amount = $request->offer_amount;
                } else {
                    $bookinginfo->offer_code = "";
                    $bookinginfo->offer_amount = 0;
                }
                $bookinginfo->booking_date = date('Y-m-d', strtotime($request->booking_date));
                $time = explode('-', $request->booking_time);
                $bookinginfo->booking_time = $time[0];
                $bookinginfo->booking_endtime = $time[1];
                $bookinginfo->customer_name = $request->name;
                $bookinginfo->mobile    = $request->mobile;
                $bookinginfo->email = $request->email;
                $bookinginfo->city = $request->city;
                $bookinginfo->state = $request->state;
                $bookinginfo->country = $request->country;
                $bookinginfo->postalcode = $request->postalcode;
                $bookinginfo->landmark = $request->landmark;
                $bookinginfo->address = $request->address;
                $bookinginfo->booking_notes = $request->message;
                $bookinginfo->sub_total = $request->sub_total;
                $bookinginfo->tax = $request->tax;
                $bookinginfo->tax_name = $request->tax_name;
                $bookinginfo->grand_total = $request->grand_total;
                $bookinginfo->payment_status = 1;
                $bookinginfo->transaction_id = "";
                $bookinginfo->transaction_type = "";
                $bookinginfo->status = $defaultsatus->id;
                $bookinginfo->status_type = $defaultsatus->type;
                $bookinginfo->staff_id = $request->staff_id;
                if ($bookinginfo->save()) {
                    $traceurl = URL::to($vendordata->slug . '/booking-' . $booking_number);
                    $contacturl = URL::to($vendordata->slug . '/contact');
                    helper::send_mail_forbooking($bookinginfo, $traceurl, $contacturl);
                    if ($checkplan->appoinment_limit != -1) {
                        $checkplan->appoinment_limit -= 1;
                        $checkplan->save();
                    }
                    if (SystemAddons::where('unique_identifier', 'whatsapp_message')->first() != null && SystemAddons::where('unique_identifier', 'whatsapp_message')->first()->activated == 1) {
                        $whmessage = whatsapp_helper::whatsappmessage($booking_number, $vendordata->slug, $vendordata);
                        $whatsapp_number = helper::appdata($vendordata->id)->whatsapp_number;
                    } else {
                        $whmessage = "";
                        $whatsapp_number = "";
                    }
                    return response()->json(['status' => 1, 'message' => trans('messages.success'), "whmessage" => $whmessage, "whatsapp_number" => $whatsapp_number, "booking_number" => $booking_number], 200);
                } else {
                    return response()->json(['status' => 0, 'message' => trans('messages.wrong')], 200);
                }
            } else {
                return response()->json(['status' => 0, 'message' => trans('messages.wrong')], 200);
            }
        } catch (\Throwable $th) {
            return response()->json(['status' => 1, 'message' => trans('messages.wrong')], 200);
        }
    }
    public function history(Request $request)
    {
        try {
            if ($request->vendor_id == "") {
                return response()->json(["status" => 0, "message" => trans('messages.vendor_id_required')], 400);
            }

            if (helper::appdata($request->vendor_id)->online_order == 1) {
                if ($request->user_id != "" && $request->user_id != null) {
                    $bookings = Booking::select("bookings.id", "bookings.booking_number", "bookings.service_name", "bookings.grand_total", "bookings.status", "bookings.status_type", "bookings.booking_date", 'bookings.staff_id', 'custom_status.name')->join('custom_status', 'custom_status.id', 'bookings.status')->where('bookings.vendor_id', $request->vendor_id)->where('bookings.user_id', $request->user_id)->orderByDesc('id')->get();
                } else {
                    $bookings = Booking::select("bookings.id", "bookings.booking_number", "bookings.service_name", "bookings.grand_total", "bookings.status", "bookings.status_type", "bookings.booking_date", 'bookings.staff_id', 'custom_status.name')->join('custom_status', 'custom_status.id', 'bookings.status')->where('bookings.vendor_id', $request->vendor_id)->orderByDesc('id')->get();
                }
            } else {
                if ($request->user_id != "" && $request->user_id != null) {
                    $bookings = Booking::select("id", "booking_number", "service_name", "grand_total", "status", "status_type", "booking_date", 'staff_id')->where('vendor_id', $request->vendor_id)->where('user_id', $request->user_id)->orderByDesc('id')->get();
                } else {
                    $bookings = Booking::select("id", "booking_number", "service_name", "grand_total", "status", "status_type", "booking_date", 'staff_id')->where('vendor_id', $request->vendor_id)->orderByDesc('id')->get();
                }
            }
            if (empty($bookings)) {
                return response()->json(['status' => 0, 'message' => trans('labels.nodata_found')], 200);
            } else {
                return response()->json(['status' => 1, 'message' => trans('messages.success'), 'data' => $bookings,], 200);
            }
        } catch (\Throwable $th) {
            return response()->json(['status' => 0, 'message' => trans('messages.wrong')], 200);
        }
    }

    public function servicedetail(Request $request)
    {
        if ($request->vendor_id == "") {
            return response()->json(["status" => 0, "message" => trans('messages.vendor_id_required')], 400);
        }
        if ($request->booking_number == "") {
            return response()->json(["status" => 0, "message" => trans('messages.booking_number_required')], 400);
        }
        if ($request->user_id != "" || $request->user_id != null) {
            $bookingdetail = Booking::select('id', 'booking_number', 'vendor_id', 'user_id', 'service_id', 'service_image', 'service_name', 'customer_name', 'email', 'mobile', 'address', 'landmark', 'postalcode', 'city', 'state', 'country', 'booking_date', 'booking_time', 'booking_endtime', 'offer_code', 'offer_amount', 'sub_total', 'tax', 'tax_name', 'grand_total', 'status', 'status_type', 'payment_status', 'transaction_type', 'booking_notes', 'join_url', 'staff_id')->where('vendor_id', $request->vendor_id)->where('user_id', $request->user_id)->where('booking_number', $request->booking_number)->first();
        } else {
            $bookingdetail = Booking::select('id', 'booking_number', 'vendor_id', 'user_id', 'service_id', 'service_image', 'service_name', 'customer_name', 'email', 'mobile', 'address', 'landmark', 'postalcode', 'city', 'state', 'country', 'booking_date', 'booking_time', 'booking_endtime', 'offer_code', 'offer_amount', 'sub_total', 'tax', 'tax_name', 'grand_total', 'status', 'status_type', 'payment_status', 'transaction_type', 'booking_notes', 'join_url', 'staff_id')->where('vendor_id', $request->vendor_id)->where('booking_number', $request->booking_number)->first();
        }
        $defaultsatus = CustomStatus::select('name')->where('vendor_id', $request->vendor_id)->where('is_deleted', 2)->where('id', $bookingdetail->status)->where('type', $bookingdetail->status_type)->first();
        $staff =  User::select('name')->where('type', 4)->where('vendor_id', $request->vendor_id)->where('id', $bookingdetail->staff_id)->first();
        $paymentname = Payment::select('payment_name')->where('payment_type', @$bookingdetail->transaction_type)->where('vendor_id', $request->vendor_id)->first();
        if (empty($bookingdetail)) {
            return response()->json(['status' => 0, 'message' => trans('labels.nodata_found')], 200);
        } else {
            $bookingdetail->service_image = helper::image_path($bookingdetail->service_image);
            return response()->json(['status' => 1, 'message' => trans('messages.success'), 'data' => $bookingdetail, 'staff' => @$staff, 'status_name' => @$defaultsatus, 'paymentname' => $paymentname], 200);
        }
    }
    public function status_change(Request $request)
    {
        if ($request->vendor_id == "") {
            return response()->json(["status" => 0, "message" => trans('messages.vendor_id_required')], 400);
        }
        if ($request->booking_number == "") {
            return response()->json(["status" => 0, "message" => trans('messages.booking_number_required')], 400);
        }
        $defaultsatus = CustomStatus::where('vendor_id',$request->vendor_id )->where('type', 4)->where('is_available', 1)->where('is_deleted', 2)->first();
        if (empty($defaultsatus)) {
            return response()->json(['status' => 0, 'message' => trans('messages.wrong')], 200);
        }
        $vendordata = User::where('id', $request->vendor_id)->first();
        $booking = Booking::where('booking_number', $request->booking_number)->first();
        $title = trans('labels.order_calcelled');
        $message_text = 'Order ' . $booking->order_number . ' has been cancelled by' . $booking->user_name;
        $emaildata = helper::emailconfigration($request->vendor_id);
        Config::set('mail', $emaildata);
        helper::cancel_booking($vendordata->email, $vendordata->name, $title, $message_text, $booking);
        Booking::where('booking_number', $request->booking_number)->update(['status' => $defaultsatus->id, 'status_type' => $defaultsatus->type]);
        return response()->json(['status' => 1, 'message' => trans('messages.success')], 200);
    }

    public function booking_payment(Request $request)
    {
        if ($request->vendor_id == "") {
            return response()->json(["status" => 0, "message" => trans('messages.vendor_id_required')], 400);
        }
        if ($request->booking_number == "") {
            return response()->json(["status" => 0, "message" => trans('messages.booking_number_required')], 400);
        }
        if ($request->payment_type == "") {
            return response()->json(["status" => 0, "message" => trans('messages.payment_type_required')], 400);
        }
        if ($request->grand_total == "") {
            return response()->json(["status" => 0, "message" => trans('messages.grand_total_required')], 400);
        }
        $currency = "";
        $payment_id = $request->payment_id;
        if ($request->has("currency")) {
            $currency = $request->currency;
        }
        if ($request->payment_type == "3") {
            $paymentmethod = Payment::where('payment_type', '3')->where('is_available', 1)->first();
            $stripe = new \Stripe\StripeClient($paymentmethod->secret_key);
            $gettoken = $stripe->tokens->create([
                'card' => [
                    'number' => $request->card_number,
                    'exp_month' => $request->card_exp_month,
                    'exp_year' => $request->card_exp_year,
                    'cvc' => $request->card_cvc,
                ],
            ]);
            Stripe\Stripe::setApiKey($paymentmethod->secret_key);
            $payment = Stripe\Charge::create([
                "amount" => $request->grand_total * 100,
                "currency" => $paymentmethod->currency,
                "source" => $gettoken->id,
                "description" => "BookingDo-SAAS-OrderPayment",
            ]);
            $payment_id = $payment->id;
        }
        // payment_type = COD : 1,RazorPay : 2, Stripe : 3, Flutterwave : 4, Paystack : 5, Mercado Pago : 7, PayPal : 8, MyFatoorah : 9, toyyibpay : 10
        if ($request->payment_type == 6) {
            if ($request->hasFile('screenshot')) {
                $filename = 'screenshot-' . uniqid() . "." . $request->file('screenshot')->getClientOriginalExtension();
                $request->file('screenshot')->move('storage/app/public/admin-assets/images/screenshot/', $filename);
            }
            $currency = $filename;
        }
        $payment = helper::payment($request->grand_total, $payment_id, $request->payment_type, $request->booking_number, $currency);
        if ($payment == 1) {
            return response()->json(['status' => 1, 'message' => trans('messages.success')], 200);
        }
        if ($payment == 0) {
            return response()->json(['status' => 0, 'message' => trans('messages.wrong')], 200);
        }
    }
}
