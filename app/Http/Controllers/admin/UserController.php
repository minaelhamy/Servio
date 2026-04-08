<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\helper\helper;
use App\Models\Settings;
use App\Models\Country;
use App\Models\Customdomain;
use App\Models\PricingPlan;
use App\Models\Transaction;
use App\Models\StoreCategory;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function view_users()
    {
        $users = User::where('type', "2")->where('is_deleted', 2)->get();
        return view('admin.user.user', compact('users'));
    }
    public function add()
    {
        $countries = Country::where('Is_deleted', 2)->where('is_available', 1)->get();
        $stores = StoreCategory::where('is_deleted', 2)->where('is_available', 1)->orderBy('reorder_id')->get();
        return view('admin.user.add_user', compact('countries', 'stores'));
    }
    public function edit($id)
    {

        $user = User::where('id', $id)->first();
        $countries = Country::where('Is_deleted', 2)->where('is_available', 1)->get();
        $getplanlist = PricingPlan::where('is_available', 1)->orderBy('reorder_id')->get();
        $stores = StoreCategory::where('is_deleted', 2)->where('is_available', 1)->orderBy('reorder_id')->get();
        // dd($stores);
        return view('admin.user.edit_user', compact('user', 'getplanlist', 'countries', 'stores'));
    }
    public function edit_vendorprofile(Request $request)
    {
        $edituser = User::where('id', $request->id)->first();
        $validatoremail = Validator::make(['email' => $request->email], [
            'email' => [
                'required',
                'email',
                Rule::unique('users')->whereIn('type', [1, 2, 4])->where('is_deleted', 2)->ignore($edituser->id),
            ]
        ]);
        if ($validatoremail->fails()) {
            return redirect()->back()->with('error', trans('messages.unique_email'));
        }
        $validatormobile = Validator::make(['mobile' => $request->mobile], [
            'mobile' => [
                'required',
                'numeric',
                Rule::unique('users')->whereIn('type', [1, 2, 4])->where('is_deleted', 2)->ignore($edituser->id),
            ]
        ]);
        if ($validatormobile->fails()) {
            return redirect()->back()->with('error', trans('messages.unique_mobile'));
        }
        if (@helper::checkcustomdomain($edituser->id) == null) {
            $validatorslug = Validator::make(['slug' => $request->slug], [
                'slug' => [
                    'required',
                    Rule::unique('users')->where('type', 2)->where('is_deleted', 2)->ignore($edituser->id),
                ]
            ]);
            if ($validatorslug->fails()) {
                return redirect()->back()->with('error', trans('messages.unique_slug'));
            }
        }

        $request->validate([

            'profile' => 'max:' . helper::imagesize() . '|' . helper::imageext(),
        ], [
            'profile.max' => trans('messages.image_size_message') . ' ' . helper::appdata('')->image_size . ' ' . 'MB',
        ]);

        $edituser->name = $request->name;
        $edituser->email = $request->email;
        $edituser->mobile = $request->mobile;
        $edituser->country_id = $request->country;
        $edituser->city_id = $request->city;
        $edituser->commission_on_off = $request->commission_on_off;
        $edituser->commission_type = $request->commission_type;
        $edituser->commission_amount = $request->commission_amount;
        if ($request->store != null && $request->store != "") {
            $edituser->store_id = $request->store;
        }
        if ($request->has('profile')) {
            if (file_exists(storage_path('app/public/admin-assets/images/profile/' . $edituser->image))) {
                unlink(storage_path('app/public/admin-assets/images/profile/' .  $edituser->image));
            }
            $edit_image = $request->file('profile');
            $profileImage = 'profile-' . uniqid() . "." . $edit_image->getClientOriginalExtension();
            $edit_image->move(storage_path('app/public/admin-assets/images/profile/'), $profileImage);
            $edituser->image = $profileImage;
        }
        if (!isset($request->allow_store_subscription)) {
            if (isset($request->plan_checkbox) && $request->plan != null && !empty($request->plan)) {

                $plan = PricingPlan::where('id', $request->plan)->first();
                $edituser->plan_id = $plan->id;
                $edituser->purchase_amount = $plan->price;
                $edituser->purchase_date = date("Y-m-d h:i:sa");
                $edituser->allow_without_subscription = 2;
                $transaction = new Transaction();
                $transaction->vendor_id = $edituser->id;
                $transaction->plan_id = $plan->id;
                $transaction->plan_name = $plan->name;
                if ($plan->tax != null && $plan->tax != "") {
                    $tax_detail = helper::gettax($plan->tax);
                    $tax_amount = [];
                    $tax_name = [];
                    $totaltax = 0;
                    foreach ($tax_detail as $tax) {
                        if ($tax->type == 1) {
                            $tax_amount[] = $tax->tax;
                        } else {
                            $tax_amount[] = ($tax->tax / 100) * $plan->price;
                        }

                        $tax_name[] = $tax->name;
                    }
                    foreach ($tax_amount as $item) {
                        $totaltax += (float)$item;
                    }
                }
                if (@$tax_amount > 0) {
                    $transaction->tax = implode('|', @$tax_amount);
                    $transaction->tax_name = implode('|', @$tax_name);
                }

                $transaction->payment_type = 1;
                $transaction->payment_id = "";
                $transaction->amount = $plan->price;
                $transaction->grand_total = $plan->price = 0 ? 0 : ($plan->price) + @$totaltax;
                $transaction->service_limit = $plan->order_limit;
                $transaction->appoinment_limit = $plan->appointment_limit;
                $transaction->status = 2;
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

                if ($plan->custom_domain == "2") {
                    Settings::where('vendor_id', Auth::user()->id)->update(['custom_domain' => "-"]);
                }
                if ($plan->custom_domain == "1") {
                    $checkdomain = Customdomain::where('vendor_id', Auth::user()->id)->first();
                    if (@$checkdomain->status == 2) {
                        Settings::where('vendor_id', Auth::user()->id)->update(['custom_domain' => $checkdomain->current_domain]);
                    }
                }
            }
        }
        if (Str::contains(request()->url(), 'users')) {
            if (isset($request->allow_store_subscription)) {
                $edituser->plan_id = "";
                $edituser->purchase_amount = "";
                $edituser->purchase_date = "";
            }
            $edituser->allow_without_subscription = isset($request->allow_store_subscription) ? 1 : 2;
            $edituser->available_on_landing = isset($request->show_landing_page) ? 1 : 2;
        }
        if (!empty($request->slug)) {
            $edituser->slug = $request->slug;
        }
        $edituser->update();
        return redirect('/admin/users')->with('success', trans('messages.success'));
    }
    public function change_status($id, $status)
    {
        $user = User::where('id', $id)->first();
        $user->is_available = $status;
        $user->update();
        if ($status == 2) {
            $emaildata = helper::emailconfigration(helper::appdata('')->id);
            Config::set('mail', $emaildata);
            helper::send_mail_vendor_block($user);
        }
        return redirect('/admin/users')->with('success', trans('messages.success'));
    }
    public function vendor_login(Request $request, $id)
    {
        $user = User::where('id', $id)->first();
        session()->put('vendor_login', 1);
        Auth::login($user);
        return redirect('/admin/dashboard');
    }
    public function admin_back(Request $request)
    {
        $getuser = User::where('type', '1')->first();
        Auth::login($getuser);
        session()->forget('vendor_login');
        return redirect('/admin/users');
    }
    public function deletevendor(Request $request)
    {
        $user = User::where('id', $request->id)->first();
        $user->is_deleted = 1;
        $user->slug = '';
        $user->update();
        $emaildata = helper::emailconfigration(helper::appdata("")->id);
        Config::set('mail', $emaildata);
        helper::send_mail_delete_account($user);
        return redirect('admin/users')->with('success', trans('messages.success'));
    }
}
