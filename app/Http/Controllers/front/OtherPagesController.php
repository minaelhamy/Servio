<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\helper\helper;
use App\Models\Contact;
use App\Models\Settings;
use App\Models\Subscriber;
use App\Models\User;
use App\Models\Timing;
use App\Models\Gallery;
use App\Models\Faq;
use App\Models\SystemAddons;
use App\Models\Testimonials;
use Illuminate\Support\Facades\Config;
use Lunaweb\RecaptchaV3\Facades\RecaptchaV3;

class OtherPagesController extends Controller
{
    public function index(Request $request)
    {
        $host = $_SERVER['HTTP_HOST'];
        if ($host  ==  env('WEBSITE_HOST')) {
            $vendordata = helper::vendor_data($request->vendor);
            $vdata = $vendordata->id;
        }
        // if the current host doesn't contain the website domain (meaning, custom domain)
        else {
            $vendordata = Settings::where('custom_domain', $host)->first();
            $vdata = $vendordata->vendor_id;
        }
        $getworkinghours = Timing::where('vendor_id', $vdata)->get();
        $day = date('l', time());
        $todayworktime = Timing::where('vendor_id', $vdata)->where('day', $day)->first();
        $contactinfo = Settings::where('vendor_id', $vdata)->first();

        return view('front.contact.contact', compact('vendordata','vdata', 'getworkinghours', 'todayworktime', 'contactinfo'));
    }
    public function save_contact(Request $request)
    {
        $request->validate([
            'fname' => 'required',
            'lname' => 'required',
            'email' => 'required|email',
            'mobile' => 'required',
            'message' => 'required',
        ], [
            'fname.required' => trans('messages.first_name_required'),
            'lname.required' => trans('messages.last_name_required'),
            'email.required' => trans('messages.email_required'),
            'email.email' => trans('messages.invalid_email'),
            'mobile.required' => trans('messages.mobile_required'),
            'message.required' => trans('messages.message_required'),
        ]);
        if (
            SystemAddons::where('unique_identifier', 'google_recaptcha')->first() != null &&
            SystemAddons::where('unique_identifier', 'google_recaptcha')->first()->activated == 1
        ) {

            if (helper::appdata('')->recaptcha_version == 'v2') {
                $request->validate([
                    'g-recaptcha-response' => 'required'
                ], [
                    'g-recaptcha-response.required' => 'The g-recaptcha-response field is required.'
                ]);
            }
            if (helper::appdata('')->recaptcha_version == 'v3') {
                $score = RecaptchaV3::verify($request->get('g-recaptcha-response'), 'contact');
                if ($score <= helper::appdata('')->score_threshold) {
                    return redirect()->back()->with('error', 'You are most likely a bot');
                }
            }
        }

        $newcontact = new Contact();
        $newcontact->vendor_id = $request->vendor_id;
        $newcontact->name = $request->fname . $request->lname;
        $newcontact->email = $request->email;
        $newcontact->mobile = $request->mobile;
        $newcontact->message = $request->message;
        $newcontact->save();
        $vendordata = User::where('id', $request->vendor_id)->first();
        $emaildata = helper::emailconfigration($vendordata->id);
        Config::set('mail', $emaildata);
        helper::vendor_contact_data($vendordata->id, $vendordata->name, $vendordata->email, $request->fname . $request->lname, $request->email, $request->mobile, $request->message);
        return redirect()->back()->with('success', trans('messages.success'));
    }
    public function gallery(Request $request)
    {
        $host = $_SERVER['HTTP_HOST'];
        if ($host  ==  env('WEBSITE_HOST')) {
            $vendordata = helper::vendor_data($request->vendor);
            $vdata = $vendordata->id;
        }
        // if the current host doesn't contain the website domain (meaning, custom domain)
        else {
            $vendordata = Settings::where('custom_domain', $host)->first();
            $vdata = $vendordata->vendor_id;
        }
        $allgallery = Gallery::where('vendor_id', $vendordata->id)->orderBy('reorder_id')->get();
        $reviewimage = Testimonials::where('vendor_id', $vendordata->id)->where('user_id', null)->where('service_id', null)->orderByDesc('reorder_id')->take(5)->get();
        return view('front.gallery.gallery', compact('vendordata','vdata', 'allgallery', 'reviewimage'));
    }
    public function faq(Request $request)
    {
        $host = $_SERVER['HTTP_HOST'];
        if ($host  ==  env('WEBSITE_HOST')) {
            $vendordata = helper::vendor_data($request->vendor);
            $vdata = $vendordata->id;
        }
        // if the current host doesn't contain the website domain (meaning, custom domain)
        else {
            $vendordata = Settings::where('custom_domain', $host)->first();
            $vdata = $vendordata->vendor_id;
        }
        $faqs = Faq::where('vendor_id', $vendordata->id)->orderBy('reorder_id')->get();
        $reviewimage = Testimonials::where('vendor_id', $vendordata->id)->where('user_id', null)->where('service_id', null)->orderBy('reorder_id')->take(5)->get();
        return view('front.faq.faq', compact('vendordata','vdata', 'faqs', 'reviewimage'));
    }
    public function aboutus(Request $request)
    {
       $host = $_SERVER['HTTP_HOST'];
        if ($host  ==  env('WEBSITE_HOST')) {
            $vendordata = helper::vendor_data($request->vendor);
            $vdata = $vendordata->id;
        }
        // if the current host doesn't contain the website domain (meaning, custom domain)
        else {
            $vendordata = Settings::where('custom_domain', $host)->first();
            $vdata = $vendordata->vendor_id;
        }
        $getaboutus = helper::appdata($vendordata->id)->about_content;
        $reviewimage = Testimonials::where('vendor_id', $vendordata->id)->where('user_id', null)->where('service_id', null)->orderBy('reorder_id')->take(5)->get();
        return view('front.other.aboutus', compact('vendordata','vdata', 'getaboutus', 'reviewimage'));
    }
    public function termscondition(Request $request)
    {
        $host = $_SERVER['HTTP_HOST'];
        if ($host  ==  env('WEBSITE_HOST')) {
            $vendordata = helper::vendor_data($request->vendor);
            $vdata = $vendordata->id;
        }
        // if the current host doesn't contain the website domain (meaning, custom domain)
        else {
            $vendordata = Settings::where('custom_domain', $host)->first();
            $vdata = $vendordata->vendor_id;
        }
        $gettermscondition = helper::appdata($vendordata->id)->terms_content;
        $reviewimage = Testimonials::where('vendor_id', $vendordata->id)->where('user_id', null)->where('service_id', null)->orderBy('reorder_id')->take(5)->get();
        return view('front.other.terms', compact('vendordata','vdata', 'gettermscondition', 'reviewimage'));
    }
    public function privacypolicy(Request $request)
    {
        $host = $_SERVER['HTTP_HOST'];
        if ($host  ==  env('WEBSITE_HOST')) {
            $vendordata = helper::vendor_data($request->vendor);
            $vdata = $vendordata->id;
        }
        // if the current host doesn't contain the website domain (meaning, custom domain)
        else {
            $vendordata = Settings::where('custom_domain', $host)->first();
            $vdata = $vendordata->vendor_id;
        }
        $getprivacypolicy = helper::appdata($vendordata->id)->privacy_content;
        $reviewimage = Testimonials::where('vendor_id', $vendordata->id)->where('user_id', null)->where('service_id', null)->orderBy('reorder_id')->take(5)->get();
        return view('front.other.privacypolicy', compact('vendordata','vdata', 'getprivacypolicy', 'reviewimage'));
    }
    public function service_unavailable(Request $request)
    {
        $host = $_SERVER['HTTP_HOST'];
        if ($host  ==  env('WEBSITE_HOST')) {
            $vendordata = helper::vendor_data($request->vendor);
            $vdata = $vendordata->id;
        }
        // if the current host doesn't contain the website domain (meaning, custom domain)
        else {
            $vendordata = Settings::where('custom_domain', $host)->first();
            $vdata = $vendordata->vendor_id;
        }
        return view('front.other.service_unavailable', compact('vendordata','vdata'));
    }
    public function subscribe(Request $request)
    {
        try {
            $host = $_SERVER['HTTP_HOST'];
            if ($host  ==  env('WEBSITE_HOST')) {
                $vendordata = helper::vendor_data($request->vendor);
            }
            // if the current host doesn't contain the website domain (meaning, custom domain)
            else {
                $vendordata = Settings::where('custom_domain', $host)->first();
            }
            $subscribe = new Subscriber();
            $subscribe->vendor_id = $vendordata->id;
            $subscribe->email = $request->email;
            $subscribe->save();
            return redirect()->back()->with('success', trans('messages.success'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', trans('messages.wrong'));
        }
    }
    public function refund_policy(Request $request)
    {
        $host = $_SERVER['HTTP_HOST'];
        if ($host  ==  env('WEBSITE_HOST')) {
            $vendordata = helper::vendor_data($request->vendor);
            $vdata = $vendordata->id;
        }
        // if the current host doesn't contain the website domain (meaning, custom domain)
        else {
            $vendordata = Settings::where('custom_domain', $host)->first();
            $vdata = $vendordata->vendor_id;
        }
        $policy = Settings::where('vendor_id', $vendordata->id)->first();
        $reviewimage = Testimonials::where('vendor_id', $vendordata->id)->where('user_id', null)->where('service_id', null)->orderBy('reorder_id')->take(5)->get();
        return view('front.other.refund_policy', compact('policy', 'vendordata','vdata', 'reviewimage'));
    }
}
