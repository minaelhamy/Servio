<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AppSettings;
use App\Models\Settings;
use App\Models\Transaction;
use App\Models\Footerfeatures;
use App\Models\SocialLinks;
use App\Models\LandingSettings;
use App\Models\SubscriptionSettings;
use App\Models\FunFact;
use App\helper\helper;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class WebsiteSettingsController extends Controller
{
    public function basic_settings()
    {
        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        $settingdata =  Settings::where('vendor_id', $vendor_id)->first();
        $theme = Transaction::select('themes_id')->where('vendor_id', $vendor_id)->orderByDesc('id')->first();
        $appsettings = AppSettings::where('vendor_id', $vendor_id)->first();
        $getfooterfeatures = Footerfeatures::where('vendor_id', $vendor_id)->get();
        $getsociallinks = SocialLinks::where('vendor_id', $vendor_id)->get();
        $subscription = SubscriptionSettings::where('vendor_id', $vendor_id)->first();
        $funfacts = FunFact::where('vendor_id', $vendor_id)->get();
        $landingdata = LandingSettings::where('vendor_id', $vendor_id)->first();
        return view('admin.basic_settings.index', compact('settingdata', 'theme', 'appsettings', 'getfooterfeatures', 'subscription', 'getsociallinks', 'funfacts', 'landingdata'));
    }
    public function save(Request $request)
    {
        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        $settingsdata = Settings::where('vendor_id', $vendor_id)->first();
        $appsection = AppSettings::where('vendor_id', $vendor_id)->first();
        if (empty($appsection)) {
            $appsection = new AppSettings();
        }
        $appsection->vendor_id = $vendor_id;
        if (Auth::user()->type == 2 || Auth::user()->type == 4) {
            $appsection->title = $request->title;
            $appsection->subtitle = $request->subtitle;
        }
        $settingsdata->firebase = $request->firebase_server_key;
        $settingsdata->update();
        $appsection->android_link = $request->android_link;
        $appsection->ios_link = $request->ios_link;
        $appsection->mobile_app_on_off = isset($request->mobile_app_on_off) ? 1 : 2;
        if ($request->has('image')) {
            $validator = Validator::make($request->all(), [
                'image' => 'max:' . helper::imagesize(),
            ], [
                'image.max' => trans('messages.image_size_message'),
            ]);
            if ($validator->fails()) {
                return redirect()->back()->with('error', trans('messages.image_size_message') . ' ' . helper::appdata('')->image_size . ' ' . 'MB');
            }
            if (!empty($appsection->image)) {
                if (file_exists(storage_path('app/public/admin-assets/images/index/' .  $appsection->image))) {
                    unlink(storage_path('app/public/admin-assets/images/index/' .  $appsection->image));
                }
            }
            $image = 'appsection-' . uniqid() . "." . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(storage_path('app/public/admin-assets/images/index/'), $image);
            $appsection->image = $image;
        }
        $appsection->save();
        return redirect()->back()->with('success', trans('messages.success'));
    }
    public function themeupdate(Request $request)
    {
        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        $request->validate([
            'web_layout' => 'required_if:Auth::user()->type(),2',
        ], [
            'web_layout.required_if' => trans('messages.web_layout_required'),
        ]);
        $settingsdata = Settings::where('vendor_id', $vendor_id)->first();
        if (Auth::user()->type == 1) {
            $landingsettings = LandingSettings::where('vendor_id', 1)->first();
            $landingsettings->primary_color = $request->landing_primary_color;
            $landingsettings->secondary_color = $request->landing_secondary_color;
            $landingsettings->update();
        } else {
            $settingsdata->primary_color = $request->landing_primary_color;
            $settingsdata->secondary_color = $request->landing_secondary_color;
        }
        $settingsdata->theme = !empty($request->template) ? $request->template : 1;
        $settingsdata->web_title = $request->web_title;
        $settingsdata->landing_page =  isset($request->landing) ? 1 : 2;
        $settingsdata->copyright = $request->copyright;
        if ($request->hasfile('logo')) {
            $validator = Validator::make($request->all(), [
                'logo' => 'max:' . helper::imagesize(),
            ], [
                'logo.max' => trans('messages.image_size_message'),
            ]);
            if ($validator->fails()) {
                return redirect()->back()->with('error', trans('messages.image_size_message') . ' ' . helper::appdata('')->image_size . ' ' . 'MB');
            }
            if (Auth::user()->type == 1) {
                if ($settingsdata->logo != "defaultlogo.png" && file_exists(storage_path('app/public/admin-assets/images/defaultimages/' . $settingsdata->logo))) {
                    @unlink(storage_path('app/public/admin-assets/images/defaultimages/' . $settingsdata->logo));
                }
                $logo_name = 'logo-' . uniqid() . '.' . $request->logo->getClientOriginalExtension();
                $request->file('logo')->move(storage_path('app/public/admin-assets/images/defaultimages/'), $logo_name);
            } else {
                if ($settingsdata->logo != "defaultlogo.png" && file_exists(storage_path('app/public/admin-assets/images/about/logo/' . $settingsdata->logo))) {
                    @unlink(storage_path('app/public/admin-assets/images/about/logo/' . $settingsdata->logo));
                }
                $logo_name = 'logo-' . uniqid() . '.' . $request->logo->getClientOriginalExtension();
                $request->file('logo')->move(storage_path('app/public/admin-assets/images/about/logo/'), $logo_name);
            }

            $settingsdata->logo = $logo_name;
        }
        if ($request->hasfile('darklogo')) {
            $validator = Validator::make($request->all(), [
                'darklogo' => 'max:' . helper::imagesize(),
            ], [
                'darklogo.max' => trans('messages.image_size_message'),
            ]);
            if ($validator->fails()) {
                return redirect()->back()->with('error', trans('messages.image_size_message') . ' ' . helper::appdata('')->image_size . ' ' . 'MB');
            }
            if (Auth::user()->type == 1) {
                if ($settingsdata->darklogo != "defaultlogo.png" && file_exists(storage_path('app/public/admin-assets/images/defaultimages/' . $settingsdata->darklogo))) {
                    @unlink(storage_path('app/public/admin-assets/images/defaultimages/' . $settingsdata->darklogo));
                }
                $darklogo_name = 'darklogo-' . uniqid() . '.' . $request->darklogo->getClientOriginalExtension();
                $request->file('darklogo')->move(storage_path('app/public/admin-assets/images/defaultimages/'), $darklogo_name);
            } else {
                if ($settingsdata->darklogo != "defaultlogo.png" && file_exists(storage_path('app/public/admin-assets/images/about/logo/' . $settingsdata->darklogo))) {
                    @unlink(storage_path('app/public/admin-assets/images/about/logo/' . $settingsdata->darklogo));
                }
                $darklogo_name = 'darklogo-' . uniqid() . '.' . $request->darklogo->getClientOriginalExtension();
                $request->file('darklogo')->move(storage_path('app/public/admin-assets/images/about/logo/'), $darklogo_name);
            }

            $settingsdata->darklogo = $darklogo_name;
        }
        if ($request->hasfile('favicon')) {
            $validator = Validator::make($request->all(), [
                'favicon' => 'max:' . helper::imagesize(),
            ], [
                'favicon.max' => trans('messages.image_size_message'),
            ]);
            if ($validator->fails()) {
                return redirect()->back()->with('error', trans('messages.image_size_message') . ' ' . helper::appdata('')->image_size . ' ' . 'MB');
            }
            if (Auth::user()->type == 1) {
                if ($settingsdata->favicon != "defaultfavicon.png" && file_exists(storage_path('app/public/admin-assets/images/defaultimages/' . $settingsdata->favicon))) {
                    @unlink(storage_path('app/public/admin-assets/images/defaultimages/' . $settingsdata->favicon));
                }
                $favicon_name = 'favicon-' . uniqid() . '.' . $request->favicon->getClientOriginalExtension();
                $request->favicon->move(storage_path('app/public/admin-assets/images/defaultimages/'), $favicon_name);
            } else {
                if ($settingsdata->favicon != "defaultfavicon.png" && file_exists(storage_path('app/public/admin-assets/images/about/favicon/' . $settingsdata->favicon))) {
                    @unlink(storage_path('app/public/admin-assets/images/about/favicon/' . $settingsdata->favicon));
                }
                $favicon_name = 'favicon-' . uniqid() . '.' . $request->favicon->getClientOriginalExtension();
                $request->favicon->move(storage_path('app/public/admin-assets/images/about/favicon/'), $favicon_name);
            }

            $settingsdata->favicon = $favicon_name;
        }
        $settingsdata->save();
        return redirect()->back()->with('success', trans('messages.success'));
    }
    public function contact_settings(Request $request)
    {
        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        $settingdata =  Settings::where('vendor_id', $vendor_id)->first();
        if (empty($settingdata)) {
            $settingdata = new Settings();
        }
        $settingdata->email = $request->contact_email;
        $settingdata->contact = $request->contact_mobile;
        $settingdata->address = $request->address;
        $settingdata->save();
        return redirect()->back()->with('success', trans('messages.success'));
    }
    public function footer_features(Request $request)
    {
        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        if (!empty($request->feature_icon)) {
            foreach ($request->feature_icon as $key => $icon) {
                if (!empty($icon) && !empty($request->feature_title[$key]) && !empty($request->feature_description[$key])) {
                    $feature = new Footerfeatures;
                    $feature->vendor_id = $vendor_id;
                    $feature->icon = $icon;
                    $feature->title = $request->feature_title[$key];
                    $feature->description = $request->feature_description[$key];
                    $feature->save();
                }
            }
        }
        if (!empty($request->edit_icon_key)) {
            foreach ($request->edit_icon_key as $key => $id) {
                $feature = Footerfeatures::find($id);
                $feature->icon = $request->edi_feature_icon[$id];
                $feature->title = $request->edi_feature_title[$id];
                $feature->description = $request->edi_feature_description[$id];
                $feature->save();
            }
        }
        return redirect()->back()->with('success', trans('messages.success'));
    }
    public function other_settings(Request $request)
    {

        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        if (Auth::user()->type == 1) {
            $landingsettings = LandingSettings::where('vendor_id', $vendor_id)->first();
            $adminsetting = Settings::where('vendor_id', 1)->first();
            if (empty($landingsettings)) {
                $landingsettings = new LandingSettings();
            }
            if ($request->hasfile('landing_home_banner')) {
                $validator = Validator::make($request->all(), [
                    'landing_home_banner' => 'max:' . helper::imagesize(),
                ], [
                    'landing_home_banner.max' => trans('messages.image_size_message'),
                ]);
                if ($validator->fails()) {
                    return redirect()->back()->with('error', trans('messages.image_size_message') . ' ' . helper::appdata('')->image_size . ' ' . 'MB');
                }

                if (file_exists(storage_path('app/public/admin-assets/images/banner/' . $landingsettings->landing_home_banner))) {
                    @unlink(storage_path('app/public/admin-assets/images/banner/' . $landingsettings->landing_home_banner));
                }
                $bannerimage = 'banner-' . uniqid() . '.' . $request->landing_home_banner->getClientOriginalExtension();
                $request->landing_home_banner->move(storage_path('app/public/admin-assets/images/banner/'), $bannerimage);

                $landingsettings->landing_home_banner = $bannerimage;
            }
            if ($request->hasfile('subscribe_image')) {
                $validator = Validator::make($request->all(), [
                    'subscribe_image' => 'max:' . helper::imagesize(),
                ], [
                    'subscribe_image.max' => trans('messages.image_size_message'),
                ]);
                if ($validator->fails()) {
                    return redirect()->back()->with('error', trans('messages.image_size_message') . ' ' . helper::appdata('')->image_size . ' ' . 'MB');
                }

                if (file_exists(storage_path('app/public/admin-assets/images/index/' . $landingsettings->subscribe_image))) {
                    @unlink(storage_path('app/public/admin-assets/images/index/' . $landingsettings->subscribe_image));
                }
                $subscribeimage = 'subscribe-' . uniqid() . '.' . $request->subscribe_image->getClientOriginalExtension();
                $request->subscribe_image->move(storage_path('app/public/admin-assets/images/index/'), $subscribeimage);
                $landingsettings->subscribe_image = $subscribeimage;
            }
            if ($request->hasfile('faq_image')) {
                $validator = Validator::make($request->all(), [
                    'faq_image' => 'max:' . helper::imagesize(),
                ], [
                    'faq_image.max' => trans('messages.image_size_message'),
                ]);
                if ($validator->fails()) {
                    return redirect()->back()->with('error', trans('messages.image_size_message') . ' ' . helper::appdata('')->image_size . ' ' . 'MB');
                }

                if (file_exists(storage_path('app/public/admin-assets/images/index/' . $landingsettings->faq_image))) {
                    @unlink(storage_path('app/public/admin-assets/images/index/' . $landingsettings->faq_image));
                }
                $faqimage = 'faq-' . uniqid() . '.' . $request->faq_image->getClientOriginalExtension();
                $request->faq_image->move(storage_path('app/public/admin-assets/images/index/'), $faqimage);
                $landingsettings->faq_image = $faqimage;
            }
            if ($request->hasfile('admin_auth_image')) {
                $validator = Validator::make($request->all(), [
                    'auth_image' => 'max:' . helper::imagesize(),
                ], [
                    'auth_image.max' => trans('messages.image_size_message'),
                ]);
                if ($validator->fails()) {
                    return redirect()->back()->with('error', trans('messages.image_size_message') . ' ' . helper::appdata('')->image_size . ' ' . 'MB');
                }

                if (file_exists(storage_path('app/public/admin-assets/images/index/' . $adminsetting->admin_auth_image))) {
                    @unlink(storage_path('app/public/admin-assets/images/index/' . $adminsetting->admin_auth_image));
                }
                $admin_auth_image = 'auth-' . uniqid() . '.' . $request->admin_auth_image->getClientOriginalExtension();
                $request->admin_auth_image->move(storage_path('app/public/admin-assets/images/index/'), $admin_auth_image);
                $adminsetting->admin_auth_image = $admin_auth_image;
                $adminsetting->save();
            }

            if ($request->hasfile('store_unavailable_image')) {
                $validator = Validator::make($request->all(), [
                    'store_unavailable_image' => 'max:' . helper::imagesize(),
                ], [
                    "store_unavailable_image.image" => trans('messages.enter_image_file'),
                ]);
                if ($validator->fails()) {
                    return redirect()->back()->with('error', trans('messages.image_size_message') . ' ' . helper::appdata('')->image_size . ' ' . 'MB');
                }
                if (file_exists(storage_path('app/public/admin-assets/images/index/' . $adminsetting->store_unavailable_image))) {
                    @unlink(storage_path('app/public/admin-assets/images/index/' . $adminsetting->store_unavailable_image));
                }
                $maintenanceimage = 'store_unavailable-' . uniqid() . '.' . $request->store_unavailable_image->getClientOriginalExtension();
                $request->store_unavailable_image->move(storage_path('app/public/admin-assets/images/index/'), $maintenanceimage);
                $adminsetting->store_unavailable_image = $maintenanceimage;
                $adminsetting->save();
            }
            $landingsettings->vendor_id = $vendor_id;
            $landingsettings->save();
        }
        if (Auth::user()->type == 2 || Auth::user()->type == 4) {
            $settingdata = Settings::where('vendor_id', $vendor_id)->first();
            if ($request->hasfile('landin_page_cover_image')) {
                $validator = Validator::make($request->all(), [
                    'landin_page_cover_image' => 'max:' . helper::imagesize(),
                ], [
                    'landin_page_cover_image.max' => trans('messages.image_size_message'),
                ]);
                if ($validator->fails()) {
                    return redirect()->back()->with('error', trans('messages.image_size_message') . ' ' . helper::appdata('')->image_size . ' ' . 'MB');
                }
                if ($settingdata->cover_image != "cover.png" && file_exists(storage_path('app/public/admin-assets/images/coverimage/' . $settingdata->cover_image))) {
                    @unlink(storage_path('app/public/admin-assets/images/about/coverimage/' . $settingdata->cover_image));
                }
                $coverimage = 'cover-' . uniqid() . '.' . $request->landin_page_cover_image->getClientOriginalExtension();
                $request->landin_page_cover_image->move(storage_path('app/public/admin-assets/images/coverimage/'), $coverimage);
                $settingdata->cover_image = $coverimage;
            }
            if ($request->hasfile('contact_us_image')) {
                $validator = Validator::make($request->all(), [
                    'contact_us_image' => 'max:' . helper::imagesize(),
                ], [
                    'contact_us_image.max' => trans('messages.image_size_message'),
                ]);
                if ($validator->fails()) {
                    return redirect()->back()->with('error', trans('messages.image_size_message') . ' ' . helper::appdata('')->image_size . ' ' . 'MB');
                }

                if (file_exists(storage_path('app/public/admin-assets/images/contact/' . $settingdata->contact_image))) {
                    @unlink(storage_path('app/public/admin-assets/images/contact/' . $settingdata->contact_image));
                }
                $contact_image = 'contact-' . uniqid() . '.' . $request->contact_us_image->getClientOriginalExtension();
                $request->contact_us_image->move(storage_path('app/public/admin-assets/images/contact/'), $contact_image);
                $settingdata->contact_image = $contact_image;
            }
            if ($request->hasfile('auth_image')) {
                $validator = Validator::make($request->all(), [
                    'auth_image' => 'max:' . helper::imagesize(),
                ], [
                    'auth_image.max' => trans('messages.image_size_message'),
                ]);
                if ($validator->fails()) {
                    return redirect()->back()->with('error', trans('messages.image_size_message') . ' ' . helper::appdata('')->image_size . ' ' . 'MB');
                }

                if (file_exists(storage_path('app/public/admin-assets/images/form/' . $settingdata->auth_image))) {
                    @unlink(storage_path('app/public/admin-assets/images/form/' . $settingdata->auth_image));
                }
                $auth_image = 'auth-' . uniqid() . '.' . $request->auth_image->getClientOriginalExtension();
                $request->auth_image->move(storage_path('app/public/admin-assets/images/form/'), $auth_image);
                $settingdata->auth_image = $auth_image;
            }
            if ($request->hasfile('referral_image')) {
                $validator = Validator::make($request->all(), [
                    'referral_image' => 'max:' . helper::imagesize(),
                ], [
                    'referral_image.max' => trans('messages.image_size_message'),
                ]);
                if ($validator->fails()) {
                    return redirect()->back()->with('error', trans('messages.image_size_message') . ' ' . helper::appdata('')->image_size . ' ' . 'MB');
                }

                if (file_exists(storage_path('app/public/admin-assets/images/index/' . $settingdata->referral_image))) {
                    @unlink(storage_path('app/public/admin-assets/images/index/' . $settingdata->referral_image));
                }
                $referral_image = 'referral-' . uniqid() . '.' . $request->referral_image->getClientOriginalExtension();
                $request->referral_image->move(storage_path('app/public/admin-assets/images/index/'), $referral_image);
                $settingdata->referral_image = $referral_image;
            }
            $settingdata->homepage_title = $request->homepage_title;
            $settingdata->homepage_subtitle = $request->homepage_subtitle;
            if ($request->hasfile('homepage_banner')) {
                $validator = Validator::make($request->all(), [
                    'homepage_banner' => 'max:' . helper::imagesize(),
                ], [
                    'homepage_banner.max' => trans('messages.image_size_message'),
                ]);
                if ($validator->fails()) {
                    return redirect()->back()->with('error', trans('messages.image_size_message') . ' ' . helper::appdata('')->image_size . ' ' . 'MB');
                }

                if ($settingdata->home_banner != "homebanner.png" && file_exists(storage_path('app/public/admin-assets/images/banner/' . $settingdata->home_banner))) {
                    @unlink(storage_path('app/public/admin-assets/images/about/banner/' . $settingdata->home_banner));
                }
                $homebanner = 'banner-' . uniqid() . '.' . $request->homepage_banner->getClientOriginalExtension();
                $request->homepage_banner->move(storage_path('app/public/admin-assets/images/banner/'), $homebanner);
                $settingdata->home_banner = $homebanner;
            }
            if ($request->hasfile('order_success_image')) {
                $validator = Validator::make($request->all(), [
                    'order_success_image' => 'max:' . helper::imagesize(),
                ], [
                    "order_success_image.image" => trans('messages.enter_image_file'),
                ]);
                if ($validator->fails()) {
                    return redirect()->back()->with('error', trans('messages.image_size_message') . ' ' . helper::appdata('')->image_size . ' ' . 'MB');
                }
                if (file_exists(storage_path('app/public/admin-assets/images/index/' . $settingdata->order_success_image))) {
                    @unlink(storage_path('app/public/admin-assets/images/index/' . $settingdata->order_success_image));
                }
                $ordersuccess = 'order_success-' . uniqid() . '.' . $request->order_success_image->getClientOriginalExtension();
                $request->order_success_image->move(storage_path('app/public/admin-assets/images/index/'), $ordersuccess);
                $settingdata->order_success_image = $ordersuccess;
            }
            if ($request->hasfile('no_data_image')) {
                $validator = Validator::make($request->all(), [
                    'no_data_image' => 'max:' . helper::imagesize(),
                ], [
                    "no_data_image.image" => trans('messages.enter_image_file'),
                ]);
                if ($validator->fails()) {
                    return redirect()->back()->with('error', trans('messages.image_size_message') . ' ' . helper::appdata('')->image_size . ' ' . 'MB');
                }
                if (file_exists(storage_path('app/public/admin-assets/images/index/' . $settingdata->no_data_image))) {
                    @unlink(storage_path('app/public/admin-assets/images/index/' . $settingdata->no_data_image));
                }
                $ordersuccess = 'no_data-' . uniqid() . '.' . $request->no_data_image->getClientOriginalExtension();
                $request->no_data_image->move(storage_path('app/public/admin-assets/images/index/'), $ordersuccess);
                $settingdata->no_data_image = $ordersuccess;
            }
            $settingdata->footer_description = $request->footer_description;
            $newsubscription = SubscriptionSettings::where('vendor_id', $vendor_id)->first();
            if (empty($newsubscription)) {
                $newsubscription = new SubscriptionSettings();
            }
            $newsubscription->vendor_id = $vendor_id;
            $newsubscription->title = $request->title;
            $newsubscription->subtitle = $request->subtitle;
            if ($request->has('image')) {
                if (!empty($newsubscription->image)) {
                    if (file_exists(storage_path('app/public/admin-assets/images/index/' .  $newsubscription->image))) {
                        unlink(storage_path('app/public/admin-assets/images/index/' .  $newsubscription->image));
                    }
                }
                $image = 'subscription-' . uniqid() . "." . $request->file('image')->getClientOriginalExtension();
                $request->file('image')->move(storage_path('app/public/admin-assets/images/index/'), $image);
                $newsubscription->image = $image;
            }
            $settingdata->product_ratting_switch = isset($request->product_ratting_switch) ? 1 : 2;
            $settingdata->online_order = isset($request->online_order_switch) ? 1 : 2;
            $settingdata->service_on_off = isset($request->service_on_off) ? 1 : 2;
            $settingdata->shop_on_off = isset($request->shop_on_off) ? 1 : 2;
            $settingdata->google_review = $request->google_review_url;
            $settingdata->payment_process_options = $request->payment_process_options;
            $newsubscription->save();
            $settingdata->save();
        }
        return redirect()->back()->with('success', trans('messages.success'));
    }
    public function fun_fact_update(Request $request)
    {
        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        if (!empty($request->funfact_icon)) {
            foreach ($request->funfact_icon as $key => $icon) {
                if (!empty($icon) && !empty($request->funfact_title[$key]) && !empty($request->funfact_subtitle[$key])) {
                    $funfact = new FunFact;
                    $funfact->vendor_id = $vendor_id;
                    $funfact->icon = $icon;
                    $funfact->title = $request->funfact_title[$key];
                    $funfact->description = $request->funfact_subtitle[$key];
                    $funfact->save();
                }
            }
        }
        if (!empty($request->edit_icon_key)) {
            foreach ($request->edit_icon_key as $key => $id) {
                $funfact = FunFact::find($id);
                $funfact->icon = $request->edi_funfact_icon[$id];
                $funfact->title = $request->edi_funfact_title[$id];
                $funfact->description = $request->edi_funfact_subtitle[$id];
                $funfact->save();
            }
        }
        return redirect()->back()->with('success', trans('messages.success'));
    }
    public function fun_fact_delete(Request $request)
    {
        FunFact::where('id', $request->id)->delete();
        return redirect()->back()->with('success', trans('messages.success'));
    }
    public function social_links_update(Request $request)
    {
        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        if (!empty($request->social_icon)) {
            foreach ($request->social_icon as $key => $icon) {
                if (!empty($icon) && !empty($request->social_link[$key])) {
                    $sociallink = new SocialLinks;
                    $sociallink->vendor_id = $vendor_id;
                    $sociallink->icon = $icon;
                    $sociallink->link = $request->social_link[$key];
                    $sociallink->save();
                }
            }
        }
        if (!empty($request->edit_icon_key)) {
            foreach ($request->edit_icon_key as $key => $id) {
                $sociallink = SocialLinks::find($id);
                $sociallink->icon = $request->edi_sociallink_icon[$id];
                $sociallink->link = $request->edi_sociallink_link[$id];
                $sociallink->save();
            }
        }
        return redirect()->back()->with('success', trans('messages.success'));
    }
    public function delete_sociallinks(Request $request)
    {
        SocialLinks::where('id', $request->id)->delete();
        return redirect()->back()->with('success', trans('messages.success'));
    }
    public function save_seo(Request $request)
    {
        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        $settingsdata = Settings::where('vendor_id', $vendor_id)->first();
        $settingsdata->meta_title = $request->meta_title;
        $settingsdata->meta_description = $request->meta_description;
        if ($request->hasfile('og_image')) {
            $validator = Validator::make($request->all(), [
                'og_image' => 'max:' . helper::imagesize(),
            ], [
                'og_image.max' => trans('messages.image_size_message'),
            ]);
            if ($validator->fails()) {
                return redirect()->back()->with('error', trans('messages.image_size_message') . ' ' . helper::appdata('')->image_size . ' ' . 'MB');
            }

            if (Auth::user()->type == 1) {
                if ($settingsdata->og_image != " ")
                    if (file_exists(storage_path('app/public/admin-assets/images/defaultimages/' .  $settingsdata->og_image))) {
                        unlink(storage_path('app/public/admin-assets/images/defaultimages/' .  $settingsdata->og_image));
                    }
                $image = 'og_image-' . uniqid() . '.' . $request->og_image->getClientOriginalExtension();
                $request->og_image->move(storage_path('app/public/admin-assets/images/defaultimages/'), $image);
            } else {
                if (file_exists(storage_path('app/public/admin-assets/images/about/og_image/' .  $settingsdata->og_image))) {
                    unlink(storage_path('app/public/admin-assets/images/about/og_image/' .  $settingsdata->og_image));
                }
                $image = 'og_image-' . uniqid() . '.' . $request->og_image->getClientOriginalExtension();
                $request->og_image->move(storage_path('app/public/admin-assets/images/about/og_image/'), $image);
            }
            $settingsdata->og_image = $image;
        }
        $settingsdata->save();
        return redirect()->back()->with('success', trans('messages.success'));
    }
}
