<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\PricingPlan;
use App\Models\User;
use App\Models\Transaction;
use App\helper\helper;
use App\Models\Service;
use App\Models\Settings;
use App\Models\Tax;
use App\Models\Customdomain;
use App\Models\Product;
use App\Models\SystemAddons;
use Illuminate\Support\Facades\Config;
use Stripe;
use PDF;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Str;

class PlanPricingController extends Controller
{
    public function view_plan(Request $request)
    {
        if (SystemAddons::where('unique_identifier', 'subscription')->first() == null) {
            return redirect()->back()->with(['error' => 'You can not charge your end customers in regular license. Please purchase extended license to charge your end customers']);
        } else {
            $allplan = PricingPlan::orderBy('reorder_id');
            if (Auth::user()->type == 2 || (Auth::user()->type == 4 && Auth::user()->vendor_id != 1)) {
                $allplan = $allplan->where('is_available', '1');
            }
            $allplan = $allplan->get();
            return view('admin.plan.plan', compact("allplan"));
        }
    }
    public function add_plan(Request $request)
    {
        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        $gettaxlist = Tax::where('vendor_id', $vendor_id)->where('is_deleted', 2)->where('is_available', 1)->orderBy('reorder_id')->get();
        $vendors = User::where('type', 2)->where('is_available', 1)->where('is_deleted', 2)->get();
        return view('admin.plan.add_plan', compact('gettaxlist', 'vendors'));
    }
    public function save_plan(Request $request)
    {
        $request->validate([
            'plan_name' => 'required',
            'plan_price' => 'required',
            'plan_duration' => 'required_if:type,1',
            'plan_max_business' => 'required_if:service_limit_type,1',
            'plan_appoinment_limit' => 'required_if:booking_limit_type,1',
            'plan_days' => 'required_if:type,2',
        ], [
            'plan_name.required' => trans('messages.name_required'),
            'plan_price.required' => trans('messages.price_required'),
            'plan_duration.required_if' => trans('messages.duration_required'),
            'plan_max_business.required_if' => trans('messages.plan_max_business'),
            'plan_appoinment_limit.required_if' => trans('messages.appoinment_limit'),
            'plan_days.required_if' => trans('messages.days_required'),
        ]);
        if ($request->themecheckbox == null && $request->themecheckbox == "") {
            return redirect('admin/plan/add')->with('error', trans('messages.theme_required'));
        }
        $exitplan = PricingPlan::where('price', '0')->count();
        if ($exitplan > 0 && $request->plan_price == '0') {
            return redirect('admin/plan')->with('error', trans('messages.already_exist_plan'));
        } else {
            if ($request->coupons == "on") {
                $coupons = "1";
            } else {
                $coupons = "2";
            }
            if ($request->custom_domain == "on") {
                $custom_domain = "1";
            } else {
                $custom_domain = "2";
            }
            if ($request->google_analytics == "on") {
                $google_analytics = "1";
            } else {
                $google_analytics = "2";
            }
            if ($request->blogs == "on") {
                $blogs = "1";
            } else {
                $blogs = "2";
            }
            if ($request->google_login == "on") {
                $google_login = "1";
            } else {
                $google_login = "2";
            }
            if ($request->facebook_login == "on") {
                $facebook_login = "1";
            } else {
                $facebook_login = "2";
            }
            if ($request->sound_notification == "on") {
                $sound_notification = "1";
            } else {
                $sound_notification = "2";
            }
            if ($request->whatsapp_message == "on") {
                $whatsapp_message = "1";
            } else {
                $whatsapp_message = "2";
            }
            if ($request->telegram_message == "on") {
                $telegram_message = "1";
            } else {
                $telegram_message = "2";
            }
            if ($request->vendor_app == "on") {
                $vendor_app = "1";
            } else {
                $vendor_app = "2";
            }
            if ($request->customer_app == "on") {
                $customer_app = "1";
            } else {
                $customer_app = "2";
            }
            if ($request->pwa == "on") {
                $pwa = "1";
            } else {
                $pwa = "2";
            }
            if ($request->employee == "on") {
                $employee = "1";
            } else {
                $employee = "2";
            }
            if ($request->zoom == "on") {
                $zoom = "1";
            } else {
                $zoom = "2";
            }
            if ($request->calendar == "on") {
                $calendar = "1";
            } else {
                $calendar = "2";
            }
            if ($request->vendor_calendar == "on") {
                $vendor_calendar = "1";
            } else {
                $vendor_calendar = "2";
            }
            if ($request->pixel == "on") {
                $pixel = "1";
            } else {
                $pixel = "2";
            }
            $saveplan = new PricingPlan();
            $saveplan->name = $request->plan_name;
            $saveplan->themes_id = "0";
            $saveplan->description = $request->plan_description;
            $saveplan->features =  $request->plan_features != null &&  $request->plan_features != "" ? implode("|", $request->plan_features) :  $request->plan_features;
            $saveplan->price = $request->plan_price;
            $saveplan->tax = empty($request->plan_tax)  ? null : implode("|", $request->plan_tax);
            $saveplan->plan_type = $request->type;
            if ($request->type == "1") {
                $saveplan->duration = $request->plan_duration;
                $saveplan->days = 0;
            }
            if ($request->type == "2") {
                $saveplan->duration = "";
                $saveplan->days = $request->plan_days;
            }
            if ($request->service_limit_type == "1") {
                $saveplan->order_limit = $request->plan_max_business;
            } elseif ($request->service_limit_type == "2") {
                $saveplan->order_limit = -1;
            }
            if ($request->booking_limit_type == "1") {
                $saveplan->appointment_limit = $request->plan_appoinment_limit;
            } elseif ($request->booking_limit_type == "2") {
                $saveplan->appointment_limit = -1;
            }
            if ($request->product_limit_type == "1") {
                $saveplan->product_order_limit = $request->product_plan_max_business;
            } elseif ($request->product_limit_type == "2") {
                $saveplan->product_order_limit = -1;
            }
            if ($request->order_limit_type == "1") {
                $saveplan->order_appointment_limit = $request->order_plan_appoinment_limit;
            } elseif ($request->order_limit_type == "2") {
                $saveplan->order_appointment_limit = -1;
            }
            $saveplan->coupons = $coupons;
            $saveplan->custom_domain = $custom_domain;
            $saveplan->google_analytics = $google_analytics;
            $saveplan->blogs = $blogs;
            $saveplan->google_login = $google_login;
            $saveplan->facebook_login = $facebook_login;
            $saveplan->sound_notification = $sound_notification;
            $saveplan->whatsapp_message = $whatsapp_message;
            $saveplan->telegram_message = $telegram_message;
            $saveplan->vendor_app = $vendor_app;
            $saveplan->customer_app = $customer_app;
            $saveplan->pwa = $pwa;
            $saveplan->employee = $employee;
            $saveplan->zoom = $zoom;
            $saveplan->calendar = $calendar;
            $saveplan->vendor_calendar = $vendor_calendar;
            $saveplan->pixel = $pixel;
            $saveplan->themes_id = $request->themecheckbox != "" && $request->themecheckbox != null ? implode("|", $request->themecheckbox) : $request->themecheckbox;
            $saveplan->vendor_id = $request->vendors != "" && $request->vendors != null ? implode("|", $request->vendors) : $request->vendors;
            $saveplan->save();
            return redirect('admin/plan')->with('success', trans('messages.success'));
        }
    }
    public function edit_plan($id)
    {
        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        $editplan = PricingPlan::where('id', $id)->first();
        $gettaxlist = Tax::where('vendor_id', $vendor_id)->where('is_deleted', 2)->where('is_available', 1)->orderBy('reorder_id')->get();
        $editplan = PricingPlan::where('id', $id)->first();
        $vendors = User::where('type', 2)->where('is_available', 1)->where('is_deleted', 2)->get();
        return view('admin.plan.edit_plan', compact("editplan", 'gettaxlist', 'vendors'));
    }
    public function update_plan(Request $request, $id)
    {

        $request->validate([
            'plan_name' => 'required',
            'plan_price' => 'required',
            'plan_duration' => 'required_if:type,1',
            'plan_max_business' => 'required_if:service_limit_type,1',
            'plan_appoinment_limit' => 'required_if:booking_limit_type,1',
            'plan_days' => 'required_if:type,2',
        ], [
            'plan_name.required' => trans('messages.name_required'),
            'plan_price.required' =>  trans('messages.price_required'),
            'plan_duration.required_if' => trans('messages.plan_duration'),
            'plan_max_business.required_if' => trans('messages.plan_max_business'),
            'plan_appoinment_limit.required_if' => trans('messages.appoinment_limit'),
            'plan_days.required_if' => trans('messages.days_required'),
        ]);
        if ($request->themecheckbox == null && $request->themecheckbox == "") {
            return redirect('admin/plan/edit-' . $id)->with('error', trans('messages.theme_required'));
        }
        if ($request->coupons == "on") {
            $coupons = "1";
        } else {
            $coupons = "2";
        }
        if ($request->custom_domain == "on") {
            $custom_domain = "1";
        } else {
            $custom_domain = "2";
        }
        if ($request->google_analytics == "on") {
            $google_analytics = "1";
        } else {
            $google_analytics = "2";
        }
        if ($request->blogs == "on") {
            $blogs = "1";
        } else {
            $blogs = "2";
        }
        if ($request->google_login == "on") {
            $google_login = "1";
        } else {
            $google_login = "2";
        }
        if ($request->facebook_login == "on") {
            $facebook_login = "1";
        } else {
            $facebook_login = "2";
        }
        if ($request->sound_notification == "on") {
            $sound_notification = "1";
        } else {
            $sound_notification = "2";
        }
        if ($request->whatsapp_message == "on") {
            $whatsapp_message = "1";
        } else {
            $whatsapp_message = "2";
        }
        if ($request->telegram_message == "on") {
            $telegram_message = "1";
        } else {
            $telegram_message = "2";
        }
        if ($request->vendor_app == "on") {
            $vendor_app = "1";
        } else {
            $vendor_app = "2";
        }
        if ($request->customer_app == "on") {
            $customer_app = "1";
        } else {
            $customer_app = "2";
        }
        if ($request->pwa == "on") {
            $pwa = "1";
        } else {
            $pwa = "2";
        }
        if ($request->employee == "on") {
            $employee = "1";
        } else {
            $employee = "2";
        }
        if ($request->zoom == "on") {
            $zoom = "1";
        } else {
            $zoom = "2";
        }
        if ($request->calendar == "on") {
            $calendar = "1";
        } else {
            $calendar = "2";
        }
        if ($request->vendor_calendar == "on") {
            $vendor_calendar = "1";
        } else {
            $vendor_calendar = "2";
        }
        if ($request->pixel == "on") {
            $pixel = "1";
        } else {
            $pixel = "2";
        }
        $exitplan = PricingPlan::where('price', '0')->count();
        if ($exitplan > 1 && $request->plan_price == '0') {
            return redirect('admin/plan/edit-' . $id)->with('error', trans('messages.already_exist_plan'));
        } else {
            $editplan = PricingPlan::where('id', $id)->first();
            $editplan->name = $request->plan_name;
            $editplan->themes_id = "0";
            $editplan->description = $request->plan_description;
            $editplan->features = implode("|", $request->plan_features);
            $editplan->price = $request->plan_price;
            $editplan->tax = empty($request->plan_tax)  ? null : implode("|", $request->plan_tax);
            $editplan->plan_type = $request->type;
            if ($request->type == "1") {
                $editplan->duration = $request->plan_duration;
                $editplan->days = "";
            }
            if ($request->type == "2") {
                $editplan->duration = "";
                $editplan->days = $request->plan_days;
            }
            if ($request->service_limit_type == "1") {
                $editplan->order_limit = $request->plan_max_business;
            } elseif ($request->service_limit_type == "2") {
                $editplan->order_limit = -1;
            }
            if ($request->booking_limit_type == "1") {
                $editplan->appointment_limit = $request->plan_appoinment_limit;
            } elseif ($request->booking_limit_type == "2") {
                $editplan->appointment_limit = -1;
            }
            if ($request->product_limit_type == "1") {
                $editplan->product_order_limit = $request->product_plan_max_business;
            } elseif ($request->product_limit_type == "2") {
                $editplan->product_order_limit = -1;
            }
            if ($request->order_limit_type == "1") {
                $editplan->order_appointment_limit = $request->order_plan_appoinment_limit;
            } elseif ($request->order_limit_type == "2") {
                $editplan->order_appointment_limit = -1;
            }
            $editplan->coupons = $coupons;
            $editplan->custom_domain = $custom_domain;
            $editplan->google_analytics = $google_analytics;
            $editplan->blogs = $blogs;
            $editplan->google_login = $google_login;
            $editplan->facebook_login = $facebook_login;
            $editplan->sound_notification = $sound_notification;
            $editplan->whatsapp_message = $whatsapp_message;
            $editplan->telegram_message = $telegram_message;
            $editplan->vendor_app = $vendor_app;
            $editplan->customer_app = $customer_app;
            $editplan->pwa = $pwa;
            $editplan->employee = $employee;
            $editplan->zoom = $zoom;
            $editplan->calendar = $calendar;
            $editplan->vendor_calendar = $vendor_calendar;
            $editplan->pixel = $pixel;
            $editplan->themes_id = $request->themecheckbox != "" && $request->themecheckbox != null ? implode("|", $request->themecheckbox) : $request->themecheckbox;
            $editplan->vendor_id = $request->vendors != "" && $request->vendors != null ? implode("|", $request->vendors) : $request->vendors;
            $editplan->update();
            return redirect('admin/plan')->with('success', trans('messages.success'));
        }
    }
    public function status_change($id, $status)
    {
        PricingPlan::where('id', $id)->update(['is_available' => $status]);
        return redirect('admin/plan')->with('success', trans('messages.success'));
    }
    public function select_plan($id)
    {
        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }

        $plan = PricingPlan::where('id', $id)->first();
        $totalservice = Service::where('vendor_id', $vendor_id)->count();
        $totalproduct = Product::where('vendor_id', $vendor_id)->count();
        
        if (!empty($totalservice)) {
            if ($plan->order_limit != -1) {
                if ($plan->order_limit < $totalservice) {
                    return redirect('admin/plan')->with('error', trans('messages.not_eligible_for_plan'));
                }
            }
            if ($plan->product_order_limit != -1) {
                if ($plan->product_order_limit < $totalproduct) {
                    return redirect('admin/plan')->with('error', trans('messages.not_eligible_for_plan'));
                }
            }
        }
        $checkbanktransfer = helper::checkplan($vendor_id, '');
        $data = json_decode(json_encode($checkbanktransfer), true);
        if (@$data['original']['status'] == 2 && @$data['original']['bank_transfer'] == 1) {
            return redirect('admin/plan')->with('error', @$data['original']['message']);
        }
        if ($plan->price > 0) {
            $paymentmethod = Payment::where('vendor_id', 1)->whereNot('payment_type', 16)->where('is_available', '1')->where('is_activate', '1')->orderBy('reorder_id')->get();
            return view('admin.plan.plan_payment', compact('plan', 'paymentmethod'));
        } else {
            $transaction = new Transaction();
            $transaction->vendor_id = $vendor_id;
            $transaction->plan_id = $id;
            $transaction->plan_name = $plan->name;
            $transaction->payment_type = "";
            $transaction->payment_id = "";
            $transaction->amount = $plan->price;
            $transaction->offer_code = "";
            $transaction->offer_amount =  "";
            $tax_amount = [];
            $tax_name = [];
            if ($plan->tax != null && $plan->tax != "") {
                $tax_detail = helper::gettax($plan->tax);
                $tax_amount = [];
                $tax_name = [];
                foreach ($tax_detail as $tax) {
                    if ($tax->type == 1) {
                        $tax_amount[] = $tax->tax;
                    } else {
                        $tax_amount[] = ($tax->tax / 100) * $plan->price;
                    }

                    $tax_name[] = $tax->name;
                }
            }
            $transaction->tax = implode('|', $tax_amount);
            $transaction->tax_name = implode('|', $tax_name);
            $transaction->grand_total =  0;
            $transaction->service_limit = $plan->order_limit;
            $transaction->appoinment_limit = $plan->appointment_limit;
            $transaction->product_limit = $plan->product_order_limit;
            $transaction->order_appointment_limit = $plan->order_appointment_limit;
            $transaction->expire_date = helper::get_plan_exp_date($plan->duration, $plan->days);
            $transaction->duration = $plan->duration;
            $transaction->days = $plan->days;
            $transaction->purchase_date = date("Y-m-d h:i:sa");
            $transaction->custom_domain = $plan->custom_domain;
            $transaction->zoom = $plan->zoom;
            $transaction->calendar = $plan->calendar;
            $transaction->blogs = $plan->blogs;
            $transaction->coupons = $plan->coupons;
            $transaction->whatsapp_message = $plan->whatsapp_message;
            $transaction->telegram_message = $plan->telegram_message;
            $transaction->google_login = $plan->google_login;
            $transaction->facebook_login = $plan->facebook_login;
            $transaction->sound_notification = $plan->sound_notification;
            $transaction->employee = $plan->employee;
            $transaction->pwa = $plan->pwa;
            $transaction->google_analytics = $plan->google_analytics;
            $transaction->vendor_calendar = $plan->vendor_calendar;
            $transaction->vendor_app = $plan->vendor_app;
            $transaction->customer_app = $plan->customer_app;
            $transaction->pixel = $plan->pixel;
            $transaction->themes_id = $plan->themes_id;
            $transaction->transaction_number = Str::upper(Str::random(8));
            $transaction->save();
            User::where('id', $vendor_id)->update(['plan_id' => $id, 'purchase_amount' => $plan->price, 'purchase_date' => Carbon::now()->toDateTimeString()]);
            $emaildata = helper::emailconfigration(helper::appdata('')->id);
            Config::set('mail', $emaildata);
            helper::send_subscription_email(Auth::user()->email, Auth::user()->name, $plan->name, helper::get_plan_exp_date($plan->duration, $plan->days), helper::currency_formate($plan->price, ""), "-", "-");
            return redirect()->back()->with('success', trans('messages.success'));
        }
    }
    public function success(Request $request)
    {
        try {
            if (@$request->paymentId != "") {
                $paymentid = $request->paymentId;
            }
            if (@$request->payment_id != "") {
                $paymentid = $request->payment_id;
            }
            if (@$request->transaction_id != "") {
                $paymentid = $request->transaction_id;
            }
            if (Auth::user()->type == 4) {
                $vendor_id = Auth::user()->vendor_id;
            } else {
                $vendor_id = Auth::user()->id;
            }

            if (session()->get('payment_type') == "12") {
                $checkstatus = app('App\Http\Controllers\addons\PayTabController')->checkpaymentstatus(session()->get('tran_ref'), '1');

                if ($checkstatus == "A") {
                    $paymentid = session()->get('tran_ref');
                } else {
                    return redirect('admin/plan')->with('error', session()->get('paytab_response'));
                }
            }

            $plan = PricingPlan::where('id', session()->get('plan_id'))->first();
            $checkuser = User::find($vendor_id);
            $checkuser->plan_id = session()->get('plan_id');
            $checkuser->purchase_amount = session()->get('amount');
            $checkuser->purchase_date = date("Y-m-d h:i:sa");
            $checkuser->save();
            $transaction = new Transaction;
            $transaction->vendor_id = $vendor_id;
            $transaction->plan_id = session()->get('plan_id');
            $transaction->plan_name = $plan->name;
            $transaction->payment_type = session()->get('payment_type');
            $transaction->amount = $plan->price;
            $tax_amount = [];
            $tax_name = [];
            if ($plan->tax != null && $plan->tax != "") {
                $tax_detail = helper::gettax($plan->tax);
                $tax_amount = [];
                $tax_name = [];
                foreach ($tax_detail as $tax) {
                    if ($tax->type == 1) {
                        $tax_amount[] = $tax->tax;
                    } else {
                        $tax_amount[] = ($tax->tax / 100) * $plan->price;
                    }
                    $tax_name[] = $tax->name;
                }
            }
            $transaction->tax = implode('|', $tax_amount);
            $transaction->tax_name = implode('|', $tax_name);
            if (session()->has('discount_data')) {
                $transaction->offer_code = session()->has('discount_data') ?  session()->get('discount_data')['offer_code'] : '';;
                $transaction->offer_amount = session()->has('discount_data') ?  session()->get('discount_data')['offer_amount'] : '';
            }
            $transaction->grand_total =  session()->get('amount');
            $transaction->payment_id = @$paymentid;
            $transaction->service_limit = $plan->order_limit;
            $transaction->appoinment_limit = $plan->appointment_limit;
            $transaction->product_limit = $plan->product_order_limit;
            $transaction->order_appointment_limit = $plan->order_appointment_limit;
            $transaction->expire_date = helper::get_plan_exp_date($plan->duration, $plan->days);
            $transaction->duration = $plan->duration;
            $transaction->days = $plan->days;
            $transaction->custom_domain = $plan->custom_domain;
            $transaction->zoom = $plan->zoom;
            $transaction->calendar = $plan->calendar;
            $transaction->blogs = $plan->blogs;
            $transaction->coupons = $plan->coupons;
            $transaction->whatsapp_message = $plan->whatsapp_message;
            $transaction->telegram_message = $plan->telegram_message;
            $transaction->google_login = $plan->google_login;
            $transaction->facebook_login = $plan->facebook_login;
            $transaction->sound_notification = $plan->sound_notification;
            $transaction->employee = $plan->employee;
            $transaction->pwa = $plan->pwa;
            $transaction->google_analytics = $plan->google_analytics;
            $transaction->vendor_calendar = $plan->vendor_calendar;
            $transaction->vendor_app = $plan->vendor_app;
            $transaction->customer_app = $plan->customer_app;
            $transaction->status = "2";
            $transaction->themes_id = $plan->themes_id;
            $transaction->pixel = $plan->pixel;
            $transaction->purchase_date = date("Y-m-d h:i:sa");
            $transaction->transaction_number = Str::upper(Str::random(8));
            $transaction->save();
            $emaildata = helper::emailconfigration(helper::appdata('')->id);
            Config::set('mail', $emaildata);
            helper::send_subscription_email(Auth::user()->email, Auth::user()->name, $plan->name, helper::get_plan_exp_date($plan->duration, $plan->days), helper::currency_formate($plan->price, ""), helper::getpayment(session()->get('payment_type'), 1)->payment_name, @$paymentid);
            session()->forget(['amount', 'plan_id', 'payment_type']);
            return redirect('admin/plan')->with('success', trans('messages.success'));
        } catch (\Throwable $th) {
            return $th;
        }
    }
    public function buyplan(Request $request)
    {
        try {
            if (Auth::user()->type == 4) {
                $vendor_id = Auth::user()->vendor_id;
            } else {
                $vendor_id = Auth::user()->id;
            }
            $plan = PricingPlan::where('id', $request->plan_id)->first();
            if ($request->payment_type == "3") {
                $paymentmethod = Payment::where('payment_type', $request->payment_type)->where('is_available', 1)->first();
                Stripe\Stripe::setApiKey($paymentmethod->secret_key);
                $charge = Stripe\Charge::create([
                    'amount' => $request->amount * 100,
                    'currency' => $request->currency,
                    'description' => 'Example charge',
                    'source' => $request->payment_id,
                ]);
                $payment_id = $charge->id;
            } else {
                $payment_id = $request->payment_id;
            }

            $checkuser = User::find($vendor_id);
            $checkuser->plan_id = $request->plan_id;
            $checkuser->purchase_amount = $request->amount;
            $checkuser->purchase_date = date("Y-m-d h:i:sa");
            $transaction = new Transaction();
            if ($request->payment_type == '6') {
                if ($request->hasFile('screenshot')) {
                    $validator = Validator::make($request->all(), [
                        'screenshot' => 'image|max:' . helper::imagesize() . '|' . helper::imageext(),
                    ], [
                        'screenshot.max' => trans('messages.image_size_message'),
                    ]);
                    if ($validator->fails()) {
                        return redirect()->back()->with('error', trans('messages.image_size_message') . ' ' . helper::appdata('')->image_size . ' ' . 'MB');
                    } else {
                        $filename = 'screenshot-' . uniqid() . "." . $request->file('screenshot')->getClientOriginalExtension();
                        $request->file('screenshot')->move('storage/app/public/admin-assets/images/screenshot/', $filename);
                        $transaction->screenshot = $filename;
                    }
                }
                $payment_id = "";
                $status = 1;
            } elseif ($request->payment_type == "1") {
                $status = 1;
            } else {
                $status = 2;
            }
            $transaction->vendor_id = $vendor_id;
            $transaction->plan_id = $request->plan_id;
            $transaction->plan_name = $plan->name;
            // payment_type = COD : 1,RazorPay : 2, Stripe : 3, Flutterwave : 4, Paystack : 5, Mercado Pago : 7, PayPal : 8, MyFatoorah : 9, toyyibpay : 10
            $transaction->payment_type =  $request->payment_type;
            $transaction->payment_id = $payment_id;
            $transaction->amount = $plan->price;
            $transaction->offer_code = session()->has('discount_data') ?  session()->get('discount_data')['offer_code'] : '';
            $transaction->offer_amount = session()->has('discount_data') ? session()->get('discount_data')['offer_amount'] : '';
            $transaction->grand_total = $request->amount;
            $tax_amount = [];
            $tax_name = [];
            if ($plan->tax != null && $plan->tax != "") {
                $tax_detail = helper::gettax($plan->tax);
                $tax_amount = [];
                $tax_name = [];
                foreach ($tax_detail as $tax) {
                    if ($tax->type == 1) {
                        $tax_amount[] = $tax->tax;
                    } else {
                        $tax_amount[] = ($tax->tax / 100) * $plan->price;
                    }
                    $tax_name[] = $tax->name;
                }
            }
            $transaction->tax = implode('|', $tax_amount);
            $transaction->tax_name = implode('|', $tax_name);
            $transaction->service_limit = $plan->order_limit;
            $transaction->appoinment_limit = $plan->appointment_limit;
            $transaction->product_limit = $plan->product_order_limit;
            $transaction->order_appointment_limit = $plan->order_appointment_limit;
            $transaction->status = $status;
            $transaction->purchase_date = date("Y-m-d h:i:sa");
            $transaction->expire_date = helper::get_plan_exp_date($plan->duration, $plan->days);
            $transaction->duration = $plan->duration;
            $transaction->days = $plan->days;
            $transaction->custom_domain = $plan->custom_domain;
            $transaction->zoom = $plan->zoom;
            $transaction->calendar = $plan->calendar;
            $transaction->blogs = $plan->blogs;
            $transaction->coupons = $plan->coupons;
            $transaction->whatsapp_message = $plan->whatsapp_message;
            $transaction->telegram_message = $plan->telegram_message;
            $transaction->google_login = $plan->google_login;
            $transaction->facebook_login = $plan->facebook_login;
            $transaction->sound_notification = $plan->sound_notification;
            $transaction->employee = $plan->employee;
            $transaction->pwa = $plan->pwa;
            $transaction->google_analytics = $plan->google_analytics;
            $transaction->vendor_calendar = $plan->vendor_calendar;
            $transaction->vendor_app = $plan->vendor_app;
            $transaction->customer_app = $plan->customer_app;
            $transaction->pixel = $plan->pixel;
            $transaction->themes_id = $plan->themes_id;
            $transaction->transaction_number = Str::upper(Str::random(8));
            $transaction->save();
            $checkuser->save();
            session()->forget('discount_data');
            if ($plan->custom_domain == "2") {
                Settings::where('vendor_id', Auth::user()->id)->update(['custom_domain' => "-"]);
            }
            if ($plan->custom_domain == "1") {
                $checkdomain = Customdomain::where('vendor_id', Auth::user()->id)->first();
                if (@$checkdomain->status == 2) {
                    Settings::where('vendor_id', Auth::user()->id)->update(['custom_domain' => $checkdomain->current_domain]);
                }
            }
            if ($request->payment_type == "1") {
                $emaildata = helper::emailconfigration(helper::appdata('')->id);
                Config::set('mail', $emaildata);
                helper::cod_request(Auth::user()->email, Auth::user()->name, $plan->name, helper::get_plan_exp_date($plan->duration, $plan->days), helper::currency_formate($plan->price, ""), helper::getpayment($request->payment_type, 1)->payment_name, @$payment_id);
                return redirect('admin/plan')->with('success', trans('messages.success'));
            } elseif ($request->payment_type == '6') {
                $emaildata = helper::emailconfigration(helper::appdata('')->id);
                Config::set('mail', $emaildata);
                helper::bank_transfer_request(Auth::user()->email, Auth::user()->name, $plan->name, helper::get_plan_exp_date($plan->duration, $plan->days), helper::currency_formate($plan->price, ""), helper::getpayment($request->payment_type, 1)->payment_name, @$payment_id);
                return redirect('admin/plan')->with('success', trans('messages.success'));
            } else {
                $emaildata = helper::emailconfigration(helper::appdata('')->id);
                Config::set('mail', $emaildata);
                helper::send_subscription_email(Auth::user()->email, Auth::user()->name, $plan->name, helper::get_plan_exp_date($plan->duration, $plan->days), helper::currency_formate($plan->price, ""), helper::getpayment($request->payment_type, 1)->payment_name, @$payment_id);
                return response()->json(['status' => 1, 'message' => trans('messages.success')], 200);
            }
        } catch (\Throwable $th) {
            if ($request->payment_type) {
                return redirect()->back()->with('error', trans('messages.wrong'));
            } else {
                return response()->json(['status' => 0, 'message' => trans('messages.wrong')], 200);
            }
        }
    }
    public function delete(Request $request)
    {
        $deleteplan = PricingPlan::where('id', $request->id)->first();
        $deleteplan->delete();
        return redirect('admin/plan')->with('success', trans('messages.success'));
    }
    public function plan_details(Request $request)
    {
        $plan = Transaction::where('id', $request->id)->first();
        return view('admin.plan.plan_details', compact('plan'));
    }
    public function generatepdf(Request $request)
    {

        $plan = Transaction::where('id', $request->id)->first();
        $user = User::where('id', $plan->vendor_id)->first();
        $pdf = PDF::loadView('admin.plan.plandetailspdf', ['plan' => $plan, 'user' => $user]);
        return $pdf->download(trans('labels.transaction') . '_' . $plan->transaction_number . '.pdf');
    }
    public function reorder_plan(Request $request)
    {

        if ($request->has('ids')) {

            $arr = explode('|', $request->input('ids'));
            foreach ($arr as $sortOrder => $id) {
                $menu = PricingPlan::find($id);
                $menu->reorder_id = $sortOrder;
                $menu->save();
            }
        }
        return response()->json(['status' => 1, 'msg' => trans('messages.success')], 200);
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
                $path =  url(env('ASSETPATHURL') . 'admin-assets/images/defaultimages/placeholder.png');
            }
            $newpath[] = $path;
        }
        $html = view('admin.theme.themeimages', compact('newpath'))->render();
        return response()->json(['status' => 1, 'output' => $html], 200);
    }

    // public function updateimage(Request $request)
    // {
    //     if ($request->has('theme_image')) {

    //         $validator = Validator::make($request->all(), [
    //             'image' => 'image|max:' . helper::imagesize() . '|' . helper::imageext(),
    //         ], [
    //             'image.max' => trans('messages.image_size_message'),
    //         ]);
    //         if ($validator->fails()) {
    //             return redirect()->back()->with('error', trans('messages.image_size_message') . ' ' . helper::appdata('')->image_size . ' ' . 'MB');
    //         }

    //         $reimage = 'theme-' . $request->image_id . '.' . $request->theme_image->getClientOriginalExtension();
    //         $extension = $request->theme_image->getClientOriginalExtension();
    //         $convertimg = str_replace($extension, 'webp', $reimage);
    //         $manager = new ImageManager(new Driver());
    //         // read image from file system
    //         $image = $manager->read($request->theme_image);
    //         $convert = $image->toWebp();
    //         $convertimg = str_replace($extension, 'webp', $reimage);
    //         $directory_name = storage_path('app/public/admin-assets/images/theme/');
    //         if (file_exists(storage_path('app/public/admin-assets/images/theme/' .  $convertimg))) {
    //             unlink(storage_path('app/public/admin-assets/images/theme/' .  $convertimg));
    //         }
    //         $convert->save("$directory_name/$convertimg");
    //         return redirect()->back()->with('success', trans('messages.success'));
    //     }
    // }
    public function updateimage(Request $request)
{
    if ($request->hasFile('theme_image')) {

        $validator = Validator::make($request->all(), [
            'theme_image' => 'image|max:' . helper::imagesize(),
        ], [
            'theme_image.max' => trans('messages.image_size_message'),
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('error', trans('messages.image_size_message') . ' ' . helper::appdata('')->image_size . ' MB');
        }

        // File info
        $image = $request->file('theme_image');
        $image_id = $request->image_id;

        // Always save as webp (to match your themeimages() logic)
        $filename = 'theme-' . $image_id . '.webp';

        // Define target directory (same as themeimages)
        $directory = storage_path('app/public/admin-assets/images/theme/');

        // Create folder if not exists
        if (!file_exists($directory)) {
            mkdir($directory, 0775, true);
        }

        // Delete old image if exists
        if (file_exists($directory . $filename)) {
            unlink($directory . $filename);
        }

        // Just move uploaded file (rename with .webp extension even if not converted)
        // Laravel will just copy as-is, the extension doesn't affect the image itself
        $image->move($directory, $filename);

        // Double-check if file saved correctly
        if (file_exists($directory . $filename)) {
            return redirect()->back()->with('success', trans('messages.success'));
        } else {
            return redirect()->back()->with('error', 'Image upload failed, please try again.');
        }
    }

    return redirect()->back()->with('error', 'No image uploaded.');
}
}
