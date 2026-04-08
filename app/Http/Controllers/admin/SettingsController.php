<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Country;
use App\Models\Pixcel;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Footerfeatures;
use App\helper\helper;
use App\Models\Bank;
use App\Models\Order;
use App\Models\OtherSettings;
use App\Models\Payment;
use Config;

class SettingsController extends Controller
{
    public function index()
    {
        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        $vendordata = User::where('id', $vendor_id)->first();
        $settingdata = Settings::where('vendor_id', $vendor_id)->first();
        $othersettingdata = OtherSettings::where('vendor_id', $vendor_id)->first();
        $bank_details = Bank::where('vendor_id', $vendor_id)->first();
        $theme = Transaction::select('themes_id')->where('vendor_id', $vendor_id)->orderByDesc('id')->first();
        $countries = Country::where('Is_deleted', 2)->where('is_available', 1)->get();
        $pixelsettings = Pixcel::where('vendor_id', $vendor_id)->first();
        $booking = Booking::where('vendor_id', $vendor_id)->get();
        $order = Order::where('vendor_id', $vendor_id)->get();
        $getpayment = Payment::where('is_available', '1')->where('vendor_id', $vendor_id)->whereNotIn('payment_type', ['1'])->where('is_activate', '1')->orderBy('reorder_id')->get();
        return view('admin.settings.settings', compact('settingdata', 'othersettingdata', 'bank_details', 'theme', 'countries', 'vendordata', 'pixelsettings', 'booking', 'order', 'getpayment'));
    }
    public function store(Request $request)
    {
        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        $request->validate([
            'timezone' => 'required',

        ], [
            "timezone.required" => trans('messages.timezone_required'),
            'slug.required_if' => trans('messages.slug_required'),

        ]);
        $settingsdata = Settings::where('vendor_id', $vendor_id)->first();
        if ($request->hasfile('notification_sound')) {
            $request->validate([
                'notification_sound' => 'mimes:mp3',
            ]);
            if (file_exists(storage_path('app/public/admin-assets/notification/' . $settingsdata->notification_sound))) {
                @unlink(storage_path('app/public/admin-assets/notification/' . $settingsdata->notification_sound));
            }
            $sound = 'audio-' . uniqid() . '.' . $request->notification_sound->getClientOriginalExtension();
            $request->notification_sound->move(storage_path('app/public/admin-assets/notification/'), $sound);
            $settingsdata->notification_sound = $sound;
        }
        $settingsdata->referral_amount = $request->referral_amount;
        $settingsdata->min_order_amount = $request->min_order_amount;
        $settingsdata->timezone = $request->timezone;
        if (Auth::user()->type == 1 || (Auth::user()->type == 4 && Auth::user()->vendor_id == 1)) {
            $settingsdata->image_size = $request->image_size;
        }
        $settingsdata->vendor_register = isset($request->vendor_register) ? 1 : 2;
        if (Auth::user()->type == 2 || (Auth::user()->type == 4 && Auth::user()->vendor_id != 1)) {
            $settingsdata->checkout_login_required = isset($request->checkout_login_required) ? 1 : 2;
            $settingsdata->is_checkout_login_required = isset($request->is_checkout_login_required) ? 1 : 2;
        }
        $settingsdata->time_format = $request->time_format;
        $settingsdata->date_format = $request->date_format;
        $settingsdata->order_prefix = $request->order_prefix;
        $settingsdata->product_order_prefix = $request->product_order_prefix;
        $booking = Booking::where('vendor_id', $vendor_id)->get();
        if ($booking->count() == 0 && $request->order_number_start != null && $request->order_number_start != "") {
            $settingsdata->order_number_start = $request->order_number_start;
        }
        $order = Order::where('vendor_id', $vendor_id)->get();
        if ($order->count() == 0 && $request->product_order_number_start != null && $request->product_order_number_start != "") {
            $settingsdata->product_order_number_start = $request->product_order_number_start;
        }
        if (Auth::user()->type == 1 || (Auth::user()->type == 4 && Auth::user()->vendor_id == 1)) {
            $settingsdata->primary_color = $request->primary_color;
            $settingsdata->secondary_color = $request->secondary_color;
        }
        $settingsdata->save();
        return redirect()->back()->with('success', trans('messages.success'));
    }

    public function safe_secure_store(Request $request)
    {
        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        $settingsdata = OtherSettings::where('vendor_id', $vendor_id)->first();
        if (empty($settingsdata)) {
            $settingsdata = new OtherSettings();
            $settingsdata->vendor_id = $vendor_id;
        }
        if ($request->trusted_badges == 1) {
            // Handle image 1
            if ($request->hasFile('trusted_badge_image_1')) {
                if ($settingsdata->trusted_badge_image_1 != "trusted_badge_image_1.png" && file_exists(storage_path('app/public/admin-assets/images/about/trusted_badge/' . $settingsdata->trusted_badge_image_1))) {
                    @unlink(storage_path('app/public/admin-assets/images/about/trusted_badge/' . $settingsdata->trusted_badge_image_1));
                }
                $image1 = $request->file('trusted_badge_image_1');
                $imageName1 = 'trusted_badge-' . uniqid() . '.' . $image1->getClientOriginalExtension();
                $image1->move(storage_path('app/public/admin-assets/images/about/trusted_badge/'), $imageName1);
                $settingsdata->trusted_badge_image_1 = $imageName1;
            }

            // Handle image 2
            if ($request->hasFile('trusted_badge_image_2')) {
                if ($settingsdata->trusted_badge_image_2 != "trusted_badge_image_2.png" && file_exists(storage_path('app/public/admin-assets/images/about/trusted_badge/' . $settingsdata->trusted_badge_image_2))) {
                    @unlink(storage_path('app/public/admin-assets/images/about/trusted_badge/' . $settingsdata->trusted_badge_image_2));
                }
                $image2 = $request->file('trusted_badge_image_2');
                $imageName2 = 'trusted_badge-' . uniqid() . '.' . $image2->getClientOriginalExtension();
                $image2->move(storage_path('app/public/admin-assets/images/about/trusted_badge/'), $imageName2);
                $settingsdata->trusted_badge_image_2 = $imageName2;
            }

            // Handle image 3
            if ($request->hasFile('trusted_badge_image_3')) {
                if ($settingsdata->trusted_badge_image_3 != "trusted_badge_image_3.png" && file_exists(storage_path('app/public/admin-assets/images/about/trusted_badge/' . $settingsdata->trusted_badge_image_3))) {
                    @unlink(storage_path('app/public/admin-assets/images/about/trusted_badge/' . $settingsdata->trusted_badge_image_3));
                }
                $image3 = $request->file('trusted_badge_image_3');
                $imageName3 = 'trusted_badge-' . uniqid() . '.' . $image3->getClientOriginalExtension();
                $image3->move(storage_path('app/public/admin-assets/images/about/trusted_badge/'), $imageName3);
                $settingsdata->trusted_badge_image_3 = $imageName3;
            }

            // Handle image 4
            if ($request->hasFile('trusted_badge_image_4')) {
                if ($settingsdata->trusted_badge_image_4 != "trusted_badge_image_4.png" && file_exists(storage_path('app/public/admin-assets/images/about/trusted_badge/' . $settingsdata->trusted_badge_image_4))) {
                    @unlink(storage_path('app/public/admin-assets/images/about/trusted_badge/' . $settingsdata->trusted_badge_image_4));
                }
                $image4 = $request->file('trusted_badge_image_4');
                $imageName4 = 'trusted_badge-' . uniqid() . '.' . $image4->getClientOriginalExtension();
                $image4->move(storage_path('app/public/admin-assets/images/about/trusted_badge/'), $imageName4);
                $settingsdata->trusted_badge_image_4 = $imageName4;
            }
        }
        if ($request->safe_secure == 1) {
            $settingsdata->safe_secure_checkout_payment_selection = $request->safe_secure_checkout_payment_selection == null ? null : implode(',', $request->safe_secure_checkout_payment_selection);
            $settingsdata->safe_secure_checkout_text = $request->safe_secure_checkout_text;
            $settingsdata->safe_secure_checkout_text_color = $request->safe_secure_checkout_text_color;
        }
        $settingsdata->save();
        return redirect()->back()->with('success', trans('messages.success'));
    }
    public function delete_feature(Request $request)
    {
        Footerfeatures::where('id', $request->id)->delete();
        return redirect()->back()->with('success', trans('messages.success'));
    }
    public function deleteaccount(Request $request)
    {
        try {
            $user = User::where('id', $request->id)->first();
            if ($user->is_available == 2) {
                return redirect('admin/settings')->with('error', trans('messages.account_blocked_by_admin'));
            }
            $user->is_available = 2;
            $user->update();
            $emaildata = helper::emailconfigration(helper::appdata("")->id);
            Config::set('mail', $emaildata);
            helper::send_mail_delete_account($user);
            session()->flush();
            Auth::logout();
            return redirect('admin');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', trans('messages.wrong'));
        }
    }

    public function notice_update(Request $request)
    {
        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        $settingsdata = OtherSettings::where('vendor_id', $vendor_id)->first();
        if (empty($settingsdata)) {
            $settingsdata = new OtherSettings();
            $settingsdata->vendor_id = $vendor_id;
        }
        $settingsdata->notice_title = $request->notice_title;
        $settingsdata->notice_description = $request->notice_description;
        $settingsdata->notice_on_off = isset($request->notice_on_off) ? 1 : 2;

        $settingsdata->save();
        return redirect()->back()->with('success', trans('messages.success'));
    }

    public function maintenance_update(Request $request)
    {
        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        $settingsdata = OtherSettings::where('vendor_id', $vendor_id)->first();
        if (empty($settingsdata)) {
            $settingsdata = new OtherSettings();
            $settingsdata->vendor_id = $vendor_id;
        }
        $settingsdata->maintenance_title = $request->maintenance_title;
        $settingsdata->maintenance_description = $request->maintenance_description;
        $settingsdata->maintenance_on_off = isset($request->maintenance_on_off) ? 1 : 2;

        if ($request->hasFile('maintenance_image')) {
            if ($settingsdata->maintenance_image  && file_exists(storage_path('app/public/admin-assets/images/index/' . $settingsdata->maintenance_image))) {
                @unlink(storage_path('app/public/admin-assets/images/index/' . $settingsdata->maintenance_image));
            }
            $image3 = $request->file('maintenance_image');
            $imageName3 = 'maintenance_image-' . uniqid() . '.' . $image3->getClientOriginalExtension();
            $image3->move(storage_path('app/public/admin-assets/images/index/'), $imageName3);
            $settingsdata->maintenance_image = $imageName3;
        } 
        $settingsdata->save();
         return redirect()->back()->with('success', trans('messages.success'));
    }

    public function tips_update(Request $request)
    {
        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        $settingsdata = OtherSettings::where('vendor_id', $vendor_id)->first();
        if (empty($settingsdata)) {
            $settingsdata = new OtherSettings();
            $settingsdata->vendor_id = $vendor_id;
        }
        $settingsdata->tips_on_off=isset($request->tips_on_off) ? 1 : 2;
        $settingsdata->save();
         return redirect()->back()->with('success', trans('messages.success'));
    }
}
