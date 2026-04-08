<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\SystemAddons;
use App\helper\helper;
use App\helper\whatsapp_helper;
use App\Models\AdditionalService;
use App\Models\Service;
use App\Models\Payment;
use App\Models\User;
use App\Models\Testimonials;
use App\Models\CustomStatus;
use App\Models\Transaction;
use Stripe;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    public function savebooking(Request $request)
    {

        try {
            if (Auth::user() && Auth::user()->type == 3) {
                $checkuser = User::where('is_available', 1)->where('vendor_id', $request->vendor_id)->where('id', @Auth::user()->id)->first();
                if ($request->payment_type == 16) {
                    if ($checkuser->wallet == "" || ($checkuser->wallet < $request->grand_total)) {
                        return response()->json(['status' => 0, 'message' => trans('messages.insufficient_wallet')], 200);
                    }
                }
            }
            if ($request->payment_type == "3") {
                $paymentmethod = Payment::where('payment_type', $request->payment_type)->where('vendor_id', $request->vendor_id)->first();
                Stripe\Stripe::setApiKey($paymentmethod->secret_key);
                $charge = Stripe\Charge::create([
                    'amount' => $request->grand_total * 100,
                    'currency' => $paymentmethod->currency,
                    'description' => 'BookingDo-SAAS-OrderPayment',
                    'source' => $request->payment_id,
                ]);
                $payment_id = $charge->id;
            } else {
                $payment_id = $request->payment_id;
            }
            if ($request->modal_payment_type == "6") {
                if ($request->hasFile('screenshot')) {
                    $validator = Validator::make($request->all(), [
                        'screenshot' => 'image|mimes:jpg,jpeg,png|max:' . helper::imagesize(),
                    ], [
                        'screenshot.mage' => trans('messages.enter_image_file'),
                        'screenshot.mimes' => trans('messages.valid_image'),
                        'screenshot.max' => trans('messages.image_size_message') . ' ' . helper::appdata('')->image_size . ' ' . 'MB',
                    ]);
                    if ($validator->fails()) {
                        return redirect()->back()->with('error', $validator->errors());
                    } else {
                        $filename = 'screenshot-' . uniqid() . "." . $request->file('screenshot')->getClientOriginalExtension();
                        $request->file('screenshot')->move('storage/app/public/admin-assets/images/screenshot/', $filename);
                    }
                }
                $payment_id = "";
                $bookingresponse = helper::createbooking($request->modal_vendor_id, $request->modal_service_id, $request->modal_service_image, $request->modal_service_name, $request->modal_booking_date, $request->modal_booking_time, $request->modal_name, $request->modal_mobile, $request->modal_email, $request->modal_city, $request->modal_state, $request->modal_country, $request->modal_postal_code, $request->modal_landmark, preg_replace("/\r|\n/", " ", $request->modal_address), $request->modal_message, $request->modal_sub_total, $request->modal_tax, $request->modal_tax_name, $request->modal_grand_total, $request->modal_tips, 1, $payment_id, $request->modal_payment_type, $request->modal_staff, $filename);
                if ($bookingresponse == "false") {
                    return redirect()->back()->with('error', trans('order not placed without default status !!'));
                } else {
                    return redirect(helper::storefront_url($request->modal_vendor_slug, 'success-' . $bookingresponse))->with('success', trans('messages.success'));
                }
            } else {
                $bookingresponse = helper::createbooking($request->vendor_id, $request->service_id, $request->service_image, $request->service_name, $request->booking_date, $request->booking_time, $request->name, $request->mobile, $request->email, $request->city, $request->state, $request->country, $request->postalcode, $request->landmark, preg_replace("/\r|\n/", " ", $request->address), $request->message, $request->sub_total, $request->tax, $request->tax_name, $request->grand_total, $request->tips, $request->payment_status, $payment_id, $request->payment_type, $request->staff, '');
                
                if ($bookingresponse == "false") {
                    return response()->json(['status' => 0, 'message' => trans('order not placed without default status !!')], 200);
                } else {
                    $nexturl = helper::storefront_url($request->slug, 'success-' . $bookingresponse);

                    return response()->json(['status' => 1, 'message' => trans('messages.success'), 'nexturl' => $nexturl], 200);
                }
            }
        } catch (\Throwable $th) {
            dd($th);
            return response()->json(['status' => 0, 'message' => trans('messages.wrong')], 200);
        }
    }
    public function booking_success(Request $request)
    {
        $vendordata = helper::currentStoreUser($request->route('vendor'));
        $vendor_slug = @$vendordata->slug;
        $vdata = @$vendordata->id;
        $booking_number = $request->booking_number;
        $whmessage = "";
        if (@helper::checkaddons('whatsapp_message')) {
            if (@whatsapp_helper::whatsapp_message_config($vendordata->id)->order_created == 1) {
                if (whatsapp_helper::whatsapp_message_config($vendordata->id)->message_type == 2) {
                    $whmessage = whatsapp_helper::whatsappmessage($booking_number, $vendor_slug, $vendordata);
                } else {
                    whatsapp_helper::whatsappmessage($booking_number, $vendor_slug, $vendordata);
                }
            }
        }
        return view('front.booking.booking_success', compact('vendor_slug', 'booking_number', 'vendordata','vdata', 'whmessage'));
    }
    public function booking_detail(Request $request)
    {
        $vendordata = helper::currentStoreUser($request->route('vendor'));
        $vdata = @$vendordata->id;
        $booking_detail = Booking::where('booking_number', $request->booking_number)->where('vendor_id', $vdata)->first();
        if (
            SystemAddons::where('unique_identifier', 'commission_module')->first() != null &&
            SystemAddons::where('unique_identifier', 'commission_module')->first()->activated == 1
        ) {
            if (helper::getslug($vdata)->commission_on_off == 1) {
                $getpayment = Payment::where('is_available', '1')->where('vendor_id', 1)->whereNotIn('payment_type', ['1', '16'])->where('is_activate', '1')->orderBy('reorder_id')->get();
            } else {
                if (Auth::user() && Auth::user()->type == 3) {
                    $getpayment = Payment::where('is_available', '1')->where('vendor_id', $booking_detail->vendor_id)->whereNotIn('payment_type', ['1'])->where('is_activate', '1')->orderBy('reorder_id')->get();
                } else {
                    $getpayment = Payment::where('is_available', '1')->where('vendor_id', $booking_detail->vendor_id)->whereNotIn('payment_type', ['1', '16'])->where('is_activate', '1')->orderBy('reorder_id')->get();
                }
            }
        } else {
            if (Auth::user() && Auth::user()->type == 3) {
                $getpayment = Payment::where('is_available', '1')->where('vendor_id', $booking_detail->vendor_id)->whereNotIn('payment_type', ['1'])->where('is_activate', '1')->orderBy('reorder_id')->get();
            } else {
                $getpayment = Payment::where('is_available', '1')->where('vendor_id', $booking_detail->vendor_id)->whereNotIn('payment_type', ['1', '16'])->where('is_activate', '1')->orderBy('reorder_id')->get();
            }
        }

        if (!empty($booking_detail)) {
            $getservice = Service::with('category_info')->where('id', $booking_detail->service_id)->first();

            $whmessage = whatsapp_helper::whatsappmessage($booking_detail->booking_number, $vendordata->slug, $vendordata);
            $reviewimage = Testimonials::where('vendor_id', $vdata)->where('user_id', null)->where('service_id', null)->orderBy('reorder_id')->take(5)->get();

            return view('front.booking.booking_detail', compact('booking_detail', 'vendordata','vdata', 'getservice', 'getpayment', 'whmessage', 'reviewimage'));
        } else {
            abort(404);
        }
    }
    public function booking_payment(Request $request)
    {
        $vendordata = helper::currentStoreUser($request->route('vendor'));
        $vdata = @$vendordata->id;
        if (Auth::user() && Auth::user()->type == 3) {
            $checkuser = User::where('is_available', 1)->where('vendor_id', $vdata)->where('id', @Auth::user()->id)->first();
            if ($request->payment_type == 16) {
                if ($checkuser->wallet == "" || ($checkuser->wallet < $request->grand_total)) {
                    return response()->json(['status' => 0, 'message' => trans('messages.insufficient_wallet')], 200);
                }
            }
        }

        if ($request->modal_payment_type == 6) {
            if ($request->hasFile('screenshot')) {
                $validator = Validator::make($request->all(), [
                    'screenshot' => 'image|mimes:jpg,jpeg,png|max:' . helper::imagesize(),
                ], [
                    'screenshot.mage' => trans('messages.enter_image_file'),
                    'screenshot.mimes' => trans('messages.valid_image'),
                    'screenshot.max' => trans('messages.image_size_message') . ' ' . helper::appdata('')->image_size . ' ' . 'MB',
                ]);
                if ($validator->fails()) {
                    return redirect()->back()->with('error', $validator->errors());
                } else {
                    $filename = 'screenshot-' . uniqid() . "." . $request->file('screenshot')->getClientOriginalExtension();
                    $request->file('screenshot')->move('storage/app/public/admin-assets/images/screenshot/', $filename);
                }
            }
            $payment = helper::payment($request->grand_total, "", $request->modal_payment_type, $request->modal_booking_number, $filename, $vdata);
            if ($payment == 1) {
                return redirect()->back()->with('success', trans('messages.success'));
            }
            if ($payment == 0) {
                return redirect()->back()->with('error', trans('messages.wrong'));
            }
        } else {
            $currency = "";
            $payment_id = $request->payment_id;
            if ($request->has("currency")) {
                $currency = $request->currency;
            }
            if ($request->payment_type == "3") {
                $paymentmethod = Payment::where('payment_type', $request->payment_type)->where('is_available', 1)->first();
                Stripe\Stripe::setApiKey($paymentmethod->secret_key);
                $charge = Stripe\Charge::create([
                    'amount' => $request->grand_total * 100,
                    'currency' => $currency,
                    'description' => 'BookingDo-SAAS-OrderPayment',
                    'source' => $payment_id,
                ]);
                $payment_id = $charge->id;
            } else {
                $payment_id = $request->payment_id;
            }
            // payment_type = COD : 1,RazorPay : 2, Stripe : 3, Flutterwave : 4, Paystack : 5,banktransfer:6, Mercado Pago : 7, PayPal : 8, MyFatoorah : 9, toyyibpay : 10
            $payment = helper::payment($request->grand_total, $payment_id, $request->payment_type, $request->booking_number, '', $vdata);
            if ($payment == 1) {
                return response()->json(['status' => 1, 'message' => trans('messages.success')], 200);
            }
            if ($payment == 0) {
                return response()->json(['status' => 0, 'message' => trans('messages.wrong')], 200);
            }
        }
    }
    public function mercadoorder(Request $request)
    {
        try {
            if (@$request->paymentId != "" && $request->paymentId != null) {
                $paymentid = $request->paymentId;
            }
            if (@$request->payment_id != "" && $request->payment_id != null) {
                $paymentid = $request->payment_id;
            }
            if (@$request->transaction_id != "" && $request->transaction_id != null) {
                $paymentid = $request->transaction_id;
            }
            $payment_status = 2;
            $booking_number = Session::get('booking_number');
            $vendor_id = session()->get('vendor_id');

            $vendor_slug = User::select('slug')->where('id', $vendor_id)->first();
            if (Session::get('payment_type') == "6") {
                $screenshot = 'screenshot-' . uniqid() . "." . $request->file('screenshot')->getClientOriginalExtension();
                $request->file('screenshot')->move('storage/app/public/admin-assets/images/screenshot/', $screenshot);
                $payment_status = 1;
            }
            if (session()->get('payment_type') == "11") {
                if ($request->code == "PAYMENT_SUCCESS") {
                    $paymentid = $request->transactionId;
                }
            }

            if (Session::get('payment_type') == "12") {
                $checkstatus = app('App\Http\Controllers\addons\PayTabController')->checkpaymentstatus(Session::get('tran_ref'), $vendor_id);
                if ($checkstatus == "A") {
                    $paymentid = Session::get('tran_ref');
                } else {
                    return redirect(helper::storefront_url($vendor_slug->slug, 'booking/' . $booking_number))->with('error', session()->get('paytab_response'));
                }
            }

            if (Session::get('payment_type') == "13") {
                $checkstatus = app('App\Http\Controllers\addons\MollieController')->checkpaymentstatus(Session::get('tran_ref'), $vendor_id);

                if ($checkstatus == "A") {
                    $paymentid = Session::get('tran_ref');
                } else {
                    return redirect(Session::get('failureurl'))->with('error', session()->get('paytab_response'));
                }
            }
            if (Session::get('payment_type') == "14") {
                if ($request->status == "Completed") {
                    $paymentid = $request->transaction_id;
                } else {
                    return redirect(Session::get('failureurl'))->with('error', session()->get('paytab_response'));
                }
            }
            if (session()->get('payment_type') == "15") {
                $checkstatus = app('App\Http\Controllers\addons\XenditController')->checkpaymentstatus(session()->get('tran_ref'), $vendor_id);

                if ($checkstatus == "PAID") {
                    $paymentid = session()->get('payment_id');
                } else {
                    return redirect(Session::get('failureurl'))->with('error', session()->get('paytab_response'));
                }
            }

            if ($booking_number == "") {
                if (Session::get('payment_type') != "6") {
                    if (@$paymentid == "" || @$paymentid == null || @$paymentid == "null") {
                        return redirect(helper::storefront_url($vendor_slug->slug, 'booking-' . Session::get('service_id')))->with('error', trans('messages.wrong'));
                    }
                }
                $bookingresponse = helper::createbooking($vendor_id, Session::get('service_id'), Session::get('service_image'), Session::get('service_name'), Session::get('booking_date'), Session::get('booking_time'), Session::get('name'), Session::get('mobile'), Session::get('email'), Session::get('city'), Session::get('state'), Session::get('country'), Session::get('postalcode'), Session::get('landmark'), Session::get('address'), Session::get('message'), Session::get('sub_total'), Session::get('tax'), Session::get('tax_name'), Session::get('grand_total'), Session::get('tips'), $payment_status, @$paymentid, Session::get('payment_type'), Session::get('staff'), @$screenshot);

                if ($bookingresponse == "false") {
                    return response()->json(['status' => 0, 'message' => trans('order not placed without default status !!')], 200);
                } else {
                    $nexturl = helper::storefront_url($vendor_slug->slug, 'success-' . $bookingresponse);

                    return redirect($nexturl);
                }
            } else {
                if ($paymentid == "" || $paymentid == null || $paymentid == "null") {
                    return redirect(helper::storefront_url($vendor_slug->slug, 'booking/' . $booking_number))->with('error', trans('messages.wrong'));
                }
                $payment = helper::payment("", $paymentid, Session::get('payment_type'), $booking_number, "", $vendor_id);

                if ($payment == 1) {
                    return redirect(helper::storefront_url($vendor_slug->slug, 'booking/' . $booking_number));
                }
            }
        } catch (\Throwable $th) {
            return redirect(helper::storefront_url($vendor_slug->slug))->with('error', trans('messages.wrong'));
        }
    }
    public function status_change(Request $request)
    {
        $vendordata = helper::currentStoreUser($request->route('vendor'));
        $vid = @$vendordata->id;
        $booking = Booking::where('booking_number', $request->booking_number)->where('vendor_id', $vid)->first();
        if ($booking->status_type == 2) {
            return redirect()->back()->with('error', trans('messages.already_accepted'));
        } else if ($booking->status_type == 4) {
            return redirect()->back()->with('error', trans('messages.already_rejected'));
        } else if ($booking->status_type == 3) {
            return redirect()->back()->with('error', trans('messages.already_delivered'));
        }
        $defaultsatus = CustomStatus::where('vendor_id', $vid)->where('type', 4)->where('status_use', 1)->where('is_available', 1)->where('is_deleted', 2)->first();
        if (empty($defaultsatus)) {
            return redirect()->back()->with('error', trans('messages.wrong'));
        }
        if ($booking->transaction_type == 16) {
            $walletuser = User::where('id', $booking->user_id)->first();
            $walletuser->wallet += $booking->grand_total;
            $walletuser->save();

            $transaction = new Transaction();
            $transaction->vendor_id = $booking->vendor_id;
            $transaction->user_id = $booking->user_id;
            $transaction->order_id = $booking->id;
            $transaction->payment_id = $booking->payment_id;
            $transaction->product_type = 1;
            $transaction->transaction_type = 3;
            $transaction->amount = $booking->grand_total;
            $transaction->order_number = $booking->booking_number;
            $transaction->save();
            if (
                SystemAddons::where('unique_identifier', 'commission_module')->first() != null &&
                SystemAddons::where('unique_identifier', 'commission_module')->first()->activated == 1
            ) {
                $currentbalance = helper::getslug($booking->vendor_id)->wallet;

                $updatebalance = $currentbalance - $booking->grand_total;

                User::where('id', $booking->vendor_id)->update(['wallet' => $updatebalance]);
            }
        }
        $title = trans('labels.order_calcelled');
        $message_text = 'Booking  ' . $booking->order_number . ' has been cancelled by ' . $booking->customer_name;
        $emaildata = helper::emailconfigration($vid);
        Config::set('mail', $emaildata);
        helper::cancel_booking($vendordata->email, $vendordata->name, $title, $message_text, $booking);
        $emaildata = User::select('id', 'name', 'slug', 'email', 'mobile', 'token')->where('id', $booking->vendor_id)->first();
        $title = trans('labels.order_calcelled');
        $body = "#" . $booking->order_number  . " has been cancelled";
        helper::push_notification($emaildata->token, $title, $body, "order", $booking->id);
        $booking->status = $defaultsatus->id;
        $booking->status_type = $defaultsatus->type;
        $booking->update();
        return redirect()->back()->with('success', trans('messages.success'));
    }
}
