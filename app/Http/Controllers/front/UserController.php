<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Booking;
use App\Models\Settings;
use App\Models\Service;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\helper\helper;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use Illuminate\Support\Str;
use App\Models\SystemAddons;
use App\Models\Testimonials;
use App\Models\Transaction;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;
use Lunaweb\RecaptchaV3\Facades\RecaptchaV3;
use Stripe;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function login(Request $request)
    {
        session()->put('previous_url', url()->previous());
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

        return view('front.auth.login', compact('vendordata','vdata'));
    }
    public function check_login(Request $request)
    {

        $host = $_SERVER['HTTP_HOST'];
        if ($host  ==  env('WEBSITE_HOST')) {
            if ($request->vendor == null) {
                $vendor = User::where('slug', session()->get('slug'))->first();
            } else {
                $vendor = User::where('slug', $request->vendor)->first();
            }
        }
        // if the current host doesn't contain the website domain (meaning, custom domain)
        else {
            $vendor = Settings::where('custom_domain', $host)->first();
        }

        try {
            if ($request->logintype == "normal") {
                $request->validate([
                    'email' => 'required|email',
                    'password' => 'required',
                ], [
                    'email.required' => trans('messages.email_required'),
                    'email.email' =>  trans('messages.invalid_email'),
                    'password.required' => trans('messages.password_required'),
                ]);
                $old_sid = session()->getId();
                session()->put('user_login', 1);
                if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'vendor_id' => $vendor->id, 'is_deleted' => 2, 'type' => 3])) {
                    if (Auth::user()->type == 3 && Auth::user()->is_deleted == 2) {
                        if (Auth::user()->is_available == 1) {
                            if (Str::contains(session()->get('previous_url'), 'service-')) {
                                $previous_url = session()->get('previous_url');
                            } else {
                                $previous_url = URL::to($vendor->slug);
                            }
                            session()->forget("previous_url");
                            session()->put('old_sid', $old_sid);
                            if (Auth::user() && Auth::user()->type == 3) {
                                Cart::where('session_id', $old_sid)->update(['user_id' => Auth::user()->id, 'session_id' => NULL]);
                            }
                            return redirect($previous_url)->with('sucess', trans('messages.success'));
                        } else {
                            Auth::logout();
                            return redirect()->back()->with('error', trans('messages.block'));
                        }
                    } else {
                        Auth::logout();
                        return redirect()->back()->with('error', trans('messages.email_password_not_match'));
                    }
                } else {
                    return redirect()->back()->with('error', trans('messages.email_password_not_match'));
                }
            }
        } catch (\Exception $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }
    }
    public function register(Request $request)
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
        return view('front.auth.register', compact('vendordata','vdata'));
    }
    public function forgot_password(Request $request)
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
        return view('front.auth.forgotpassword', compact('vendordata','vdata'));
    }
    public function register_customer(Request $request)
    {
        $storeinfo = helper::vendor_data($request->vendor);
        $validatoremail = Validator::make(['email' => $request->email], [
            'email' => [
                'required',
                'email',
                Rule::unique('users')->where('vendor_id', $storeinfo->id)->where('is_deleted', 2)->where('type', 3),
            ]
        ]);
        if ($validatoremail->fails()) {
            return redirect()->back()->with('error', trans('messages.unique_email'));
        }
        $validatormobile = Validator::make(['mobile' => $request->mobile], [
            'mobile' => [
                'required',
                'numeric',
                Rule::unique('users')->where('vendor_id', $storeinfo->id)->where('is_deleted', 2)->where('type', 3),
            ]
        ]);
        if ($validatormobile->fails()) {
            return redirect()->back()->with('error', trans('messages.unique_mobile'));
        }

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
        $checkreferral = User::select('id', 'name', 'referral_code', 'wallet', 'email', 'token')->where('referral_code', $request->referral_code)->where('type', 3)->where('is_available', 1)->where('is_deleted', 2)->first();
        $newuser = new User();
        $newuser->name = $request->name;
        $newuser->email = $request->email;
        $newuser->password = Hash::make($request->password);
        $newuser->mobile = $request->mobile;
        $newuser->type = "3";
        $newuser->referral_code = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890abcdefghijklmnopqrstuvwxyz'), 0, 10);
        $newuser->login_type = "email";
        $newuser->image = "default.png";
        $newuser->is_available = "1";
        $newuser->is_verified = "1";
        $newuser->wallet = 0;
        $newuser->vendor_id = $storeinfo->id;
        $newuser->save();
        if ($request->referral_code != "") {
            $checkuser = User::where('email', $checkreferral->email)->where('type', 3)->first();

            // ---- for referral user ------
            $checkreferraluser = User::find($checkuser->id);

            $checkreferraluser->wallet += helper::appdata($storeinfo->id)->referral_amount;
            $checkreferraluser->update();
            $referral_tr = new Transaction();
            $referral_tr->vendor_id = $storeinfo->id;
            $referral_tr->user_id = $checkreferraluser->id;
            $referral_tr->amount = helper::appdata($storeinfo->id)->referral_amount;
            $referral_tr->transaction_type = 4;
            $referral_tr->username = $newuser->name;
            $referral_tr->save();
            // ---- for new user ------
            $checkusernew = User::where('email', $request->email)->first();

            $checkusernew->wallet = helper::appdata($storeinfo->id)->referral_amount;
            $checkusernew->update();
            $new_user_tr = new Transaction();
            $new_user_tr->vendor_id = $storeinfo->id;
            $new_user_tr->user_id = $checkusernew->id;
            $new_user_tr->amount = helper::appdata($storeinfo->id)->referral_amount;
            $new_user_tr->transaction_type = 4;
            $new_user_tr->username = $checkreferraluser->name;
            $new_user_tr->save();


            $title = trans('labels.referral_earning');
            $body = 'Your friend "' . $checkusernew->name . '" has used your referral code to register with ' . helper::appdata($storeinfo->id)->web_title . '. You have earned "' . helper::currency_formate(helper::appdata($storeinfo->id)->referral_amount, $storeinfo->id) . '" referral amount in your wallet.';
            helper::push_notification($checkreferraluser->token, $title, $body, "wallet", "");

            $var = ["{referral_user}", "{new_user}", "{company_name}", "{referral_amount}"];
            $newvar = [$checkreferraluser->name, $checkusernew->name, helper::appdata($storeinfo->id)->web_title, helper::currency_formate(helper::appdata($storeinfo->id)->referral_amount, $storeinfo->id)];
            $referralmessage = str_replace($var, $newvar, nl2br(helper::appdata($storeinfo->id)->referral_earning_email_message));

            $emaildata = helper::emailconfigration(helper::appdata($storeinfo->id)->id);
            Config::set('mail', $emaildata);
            helper::referral($checkreferraluser->email, $referralmessage);
        }
        return redirect($request->vendor . '/login')->with('success', trans('messages.success'));
    }
    public function send_password(Request $request)
    {
        $host = $_SERVER['HTTP_HOST'];
        if ($host  ==  env('WEBSITE_HOST')) {
            $vendordata = helper::vendor_data($request->vendor);
        }
        // if the current host doesn't contain the website domain (meaning, custom domain)
        else {
            $vendordata = Settings::where('custom_domain', $host)->first();
        }
        $checkuser = User::where('email', $request->email)->where('is_available', 1)->where('is_deleted', 2)->where('vendor_id', $vendordata->id)->where('type', 3)->first();
        if (!empty($checkuser)) {
            $password = substr(str_shuffle($checkuser->password), 1, 6);
            $emaildata = helper::emailconfigration(helper::appdata('')->id);
            Config::set('mail', $emaildata);
            $check_send_mail = helper::send_mail_forpassword($request->email, $checkuser->name, $password, helper::appdata('')->logo);
            if ($check_send_mail == 1) {
                $checkuser->password = Hash::make($password);
                $checkuser->save();
                return redirect($request->vendor . '/login')->with('success', trans('messages.success'));
            } else {
                return redirect($request->vendor . '/forgot_password')->with('error', trans('messages.wrong'));
            }
        } else {
            return redirect()->back()->with('error', trans('messages.invalid_user'));
        }
    }
    public function logout(Request $request)
    {

        if (Auth::user()->type == 3) {
            Auth::logout();
        }
        return redirect('/' . $request->vendor);
    }
    public function my_profile(Request $request)
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
        
        $getprofile = User::where('id', Auth::user()->id)->first();
        $reviewimage = Testimonials::where('vendor_id', $vdata)->where('user_id', null)->where('service_id', null)->orderByDesc('id')->take(5)->get();
        return view('web.user.profile', compact('vendordata', 'getprofile','vdata'));
    }
    public function edit_profile(Request $request)
    {
        $edituser = User::where('id', $request->id)->first();
        $host = $_SERVER['HTTP_HOST'];
        if ($host  ==  env('WEBSITE_HOST')) {
            $vendordata = helper::vendor_data($request->vendor);
            $vendor_id = $vendordata->id;
        }
        // if the current host doesn't contain the website domain (meaning, custom domain)
        else {
            $vendordata = Settings::where('custom_domain', $host)->first();
            $vendor_id = $vendordata->vendor_id;
        }
        $validatoremail = Validator::make(['email' => $request->email], [
            'email' => [
                'required',
                'email',
                Rule::unique('users')->where('vendor_id', $vendor_id)->where('is_deleted', 2)->where('type', 3)->ignore($edituser->id),
            ]
        ]);
        if ($validatoremail->fails()) {
            return redirect()->back()->with('error', trans('messages.unique_email'));
        }
        $validatormobile = Validator::make(['mobile' => $request->mobile], [
            'mobile' => [
                'required',
                'numeric',
                Rule::unique('users')->where('vendor_id', $vendor_id)->where('is_deleted', 2)->where('type', 3)->ignore($edituser->id),
            ]
        ]);
        if ($validatormobile->fails()) {
            return redirect()->back()->with('error', trans('messages.unique_mobile'));
        }

        $request->validate([

            'profileimage' => 'max:' . helper::imagesize() . '|' . helper::imageext(),
        ], [

            'profileimage.max' => trans('messages.image_size_message') . ' ' . helper::appdata('')->image_size . ' ' . 'MB',
        ]);

        $user = User::where('id', $request->id)->first();

        if ($request->has('profileimage')) {
            if (file_exists(storage_path('app/public/admin-assets/images/profile/' . Auth::user()->image))) {
                unlink(storage_path('app/public/admin-assets/images/profile/' .  Auth::user()->image));
            }
            $edit_image = $request->file('profileimage');
            $profileImage = 'profile-' . uniqid() . "." . $edit_image->getClientOriginalExtension();
            $edit_image->move(storage_path('app/public/admin-assets/images/profile/'), $profileImage);
            $user->image = $profileImage;
        }
        $user->name = $request->name;
        $user->mobile = $request->mobile;
        $user->save();
        return redirect()->back()->with('success', trans('messages.success'));
    }
    public function mybookings(Request $request)
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
        $bookings = Booking::where('user_id', Auth::user()->id)->where('vendor_id', $vendordata->id);
        if (!empty($request->type)) {
            if ($request->type == "cancelled") {
                $bookings = $bookings->where('status_type', 4);
            }
            if ($request->type == "processing") {
                $bookings = $bookings->whereIn('status_type', [1, 2]);
            }
            if ($request->type == "completed") {
                $bookings = $bookings->where('status_type', 3);
            }
        }
        $bookings = $bookings->orderByDesc('id')->paginate(10);
        $totalprocessing = Booking::where('user_id', Auth::user()->id)->where('vendor_id', $vendordata->id)->whereIn('status_type', [1, 2])->count();
        $totalcancelled = Booking::where('user_id', Auth::user()->id)->where('vendor_id', $vendordata->id)->where('status_type', 4)->count();
        $totalcompleted = Booking::where('user_id', Auth::user()->id)->where('vendor_id', $vendordata->id)->where('status_type', 3)->count();
        $reviewimage = Testimonials::where('vendor_id', $vendordata->id)->where('user_id', null)->where('service_id', null)->orderByDesc('id')->take(5)->get();
        return view('front.user.booking', compact('vendordata','vdata', 'bookings', 'totalprocessing', 'totalcancelled', 'totalcompleted', 'reviewimage'));
    }

    public function myorders(Request $request)
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
        $orders = Order::where('user_id', Auth::user()->id)->where('vendor_id', $vendordata->id);
        if (!empty($request->type)) {
            if ($request->type == "cancelled") {
                $orders = $orders->where('status_type', 4);
            }
            if ($request->type == "processing") {
                $orders = $orders->whereIn('status_type', [1, 2]);
            }
            if ($request->type == "completed") {
                $orders = $orders->where('status_type', 3);
            }
        }
        $orders = $orders->orderByDesc('id')->paginate(10);
        $totalprocessingorder = Order::where('user_id', Auth::user()->id)->where('vendor_id', $vendordata->id)->whereIn('status_type', [1, 2])->count();
        $totalcancelledorder = Order::where('user_id', Auth::user()->id)->where('vendor_id', $vendordata->id)->where('status_type', 4)->count();
        $totalcompletedorder = Order::where('user_id', Auth::user()->id)->where('vendor_id', $vendordata->id)->where('status_type', 3)->count();
        $reviewimage = Testimonials::where('vendor_id', $vendordata->id)->where('user_id', null)->where('service_id', null)->orderByDesc('id')->take(5)->get();
        return view('front.user.order', compact('vendordata','vdata', 'orders', 'totalprocessingorder', 'totalcancelledorder', 'totalcompletedorder', 'reviewimage'));
    }
    public function changepassword(Request $request)
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
        $reviewimage = Testimonials::where('vendor_id', $vendordata->id)->where('user_id', null)->where('service_id', null)->orderByDesc('id')->take(5)->get();
        return view('front.user.changepassword', compact('vendordata','vdata', 'reviewimage'));
    }
    public function updatepassword(Request $request)
    {
        $user = User::where('id', Auth::user()->id)->first();
        if (Hash::check($request->current_password, Auth::user()->password)) {
            if ($request->current_password == $request->new_password) {
                return redirect()->back()->with('error', trans('messages.new_old_password_diffrent'));
            } else {
                if ($request->new_password == $request->confirm_password) {
                    $changepassword = User::where('id', Auth::user()->id)->first();
                    $changepassword->password = Hash::make($request->new_password);
                    $changepassword->update();
                    return redirect()->back()->with('success',  trans('messages.success'));
                } else {
                    return redirect()->back()->with('error', trans('messages.new_confirm_password_inccorect'));
                }
            }
        } else {
            return redirect()->back()->with('error', trans('messages.old_password_incorect'));
        }
        return view('front.user.changepassword', compact('vendordata'));
    }
    public function referearn(Request $request)
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
        $reviewimage = Testimonials::where('vendor_id', $vendordata->id)->where('user_id', null)->where('service_id', null)->orderByDesc('id')->take(5)->get();
        return view('front.user.referearn', compact('vendordata','vdata', 'reviewimage'));
    }
    public function deleteprofile(Request $request)
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
        $reviewimage = Testimonials::where('vendor_id', $vendordata->id)->where('user_id', null)->where('service_id', null)->orderByDesc('id')->take(5)->get();
        return view('front.user.deleteprofile', compact('vendordata','vdata', 'reviewimage'));
    }
    public function wishlist(Request $request)
    {
        $vendordata = helper::vendordata();
        $getservices = Service::with('service_image', 'category_info', 'reviews')->select('services.*')
            ->join('favorite', 'favorite.service_id', '=', 'services.id')
            ->groupBy('services.id')
            ->where('favorite.vendor_id', $vendordata->id)
            ->where('services.vendor_id', $vendordata->id)
            ->where('favorite.user_id', Auth::user()->id)
            ->where('services.is_available', 1)
            ->where('services.is_deleted', 2)
            ->paginate(6);
        
        $getproducts = Product::with('product_image')->select('products.*')
            ->join('favorite', 'favorite.product_id', '=', 'products.id')
            ->groupBy('products.id')
            ->where('favorite.vendor_id', $vendordata->id)
            ->where('products.vendor_id', $vendordata->id)
            ->where('favorite.user_id', Auth::user()->id)
            ->where('products.is_available', 1)
            ->paginate(6);
        $reviewimage = Testimonials::where('vendor_id', $vendordata->id)->where('user_id', null)->where('service_id', null)->orderByDesc('id')->take(5)->get();
        return view('front.user.favouritelist', compact('vendordata', 'getservices', 'getproducts', 'reviewimage'));
    }
    public function wallet(Request $request)
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
        $reviewimage = Testimonials::where('vendor_id', $vendordata->id)->where('user_id', null)->where('service_id', null)->orderByDesc('id')->take(5)->get();
        if (empty($vendordata)) {
            abort(404);
        }
        if (
            SystemAddons::where('unique_identifier', 'customer_login')->first() != null &&
            SystemAddons::where('unique_identifier', 'customer_login')->first()->activated == 1
        ) {
            if (helper::appdata($vdata)->checkout_login_required == 1) {
                $gettransactions = Transaction::where('user_id', Auth::user()->id)->orderByDesc('id')->paginate(10);
                return view('front.user.wallet', compact('vendordata','vdata', 'gettransactions', 'reviewimage'));
            } else {
                abort(404);
            }
        }
    }
    public function addmoneywallet(Request $request)
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
        if (empty($vendordata)) {
            abort(404);
        }
        if (
            SystemAddons::where('unique_identifier', 'customer_login')->first() != null &&
            SystemAddons::where('unique_identifier', 'customer_login')->first()->activated == 1
        ) {
            if (helper::appdata($vdata)->checkout_login_required == 1) {
                $getpaymentmethods = Payment::select('id', 'unique_identifier', 'environment', 'payment_name', 'payment_type', 'currency', 'public_key', 'secret_key', 'encryption_key', 'image')
                    ->whereNotIn('payment_type', array(1, 6, 16))->where('vendor_id', $vendordata->id)->where('is_available', 1)->where('is_activate', '1')->orderBy('reorder_id')->get();
                $reviewimage = Testimonials::where('vendor_id', $vendordata->id)->where('user_id', null)->where('service_id', null)->orderByDesc('id')->take(5)->get();
                return view('front.user.addmoney', compact('vendordata','vdata', 'getpaymentmethods', 'reviewimage'));
            } else {
                abort(404);
            }
        }
    }

    public function addwallet(Request $request)
    {
        if (empty($request->transaction_type) && empty($request->amount)) {
            $amount = Session::get('grand_total');
            $transaction_type = Session::get('payment_type');
        } else {
            Session::forget('mdata');
            $amount = $request->amount;
            $transaction_type = $request->payment_type;
        }

        try {
            $checkuser = User::where('id', Auth::user()->id)->where('is_available', 1)->where('is_deleted', 2)->where('type', 3)->first();
            if (empty($checkuser)) {
                return response()->json(["status" => 0, "message" => trans('messages.invalid_user')], 200);
            }
            if ($transaction_type == "") {
                return response()->json(["status" => 0, "message" => trans('messages.payment_selection_required')], 200);
            }
            if ($amount == "") {
                return response()->json(["status" => 0, "message" => trans('messages.enter_amount')], 200);
            }
            if ($transaction_type == 3) {
                $getstripe = Payment::select('environment', 'secret_key', 'currency')->where('payment_type', 3)->where('vendor_id', $request->vendor_id)->first();
                $skey = $getstripe->secret_key;
                $token = $request->transaction_id;
                try {
                    Stripe\Stripe::setApiKey($skey);
                    $charge = Stripe\Charge::create([
                        'amount' => $amount * 100,
                        'currency' => $getstripe->currency,
                        'description' => 'BookingDo',
                        'source' => $token,
                    ]);
                    $transaction_id = $charge['id'];
                } catch (\Throwable $th) {
                    dd($th);
                    return response()->json(['status' => 0, 'message' => trans('messages.unable_to_complete_payment')], 200);
                }
            } else {
                if ($request->transaction_id == "") {
                    return response()->json(["status" => 0, "message" => trans('messages.enter_transaction_id')], 200);
                }
                $transaction_id = $request->transaction_id;
            }
            $checkuser->wallet += $amount;
            $checkuser->save();
            // 2 = added-money-wallet-using- Razorpay 
            // 3 = added-money-wallet-using- Stripe 
            // 4 = added-money-wallet-using- Flutterwave 
            // 5 = added-money-wallet-using- Paystack
            // 7 = added-money-wallet-using- mercadopago
            // 8 = added-money-wallet-using- paypal
            // 9 = added-money-wallet-using- myfatoorah
            // 10 = added-money-wallet-using- toyyibpay
            // 11 = added-money-wallet-using- phonepe
            // 12 = added-money-wallet-using- paytab
            // 13 = added-money-wallet-using- mollie
            // 14 = added-money-wallet-using- khalti
            // 15 = added-money-wallet-using- xendit

            $transaction = new Transaction();
            $transaction->vendor_id = $checkuser->vendor_id;
            $transaction->user_id = $checkuser->id;
            $transaction->payment_id = $transaction_id;
            $transaction->payment_type = $transaction_type;
            $transaction->transaction_type = 1;
            $transaction->amount = $amount;
            $transaction->save();

            if ($transaction_type == 7 || $transaction_type == 8 || $transaction_type == 9 || $transaction_type == 10 || $transaction_type == 11 || $transaction_type == 12 || $transaction_type == 13 || $transaction_type == 14 || $transaction_type == 15) {
                return redirect(helper::getslug(Session::get('vendor_id'))->slug . '/' . 'wallet')->with('success', trans('messages.add_money_success'));
            }
            return response()->json(['status' => 1, 'message' => trans('messages.success')], 200);
        } catch (\Throwable $th) {
            dd($th);
            return response()->json(['status' => 0, 'message' => trans('messages.wrong')], 200);
        }
    }

    public function addsuccess(Request $request)
    {
        try {
            if ($request->has('paymentId')) {
                $paymentId = request('paymentId');
                $response = ['status' => 1, 'msg' => 'paid', 'transaction_id' => $paymentId];
            }
            if ($request->has('payment_id')) {
                $paymentId = request('payment_id');
                $response = ['status' => 1, 'msg' => 'paid', 'transaction_id' => $paymentId];
            }

            if ($request->has('transaction_id')) {
                $paymentId = request('transaction_id');
                $response = ['status' => 1, 'msg' => 'paid', 'transaction_id' => $paymentId];
            }
            if (session()->get('payment_type') == "11") {
                if ($request->code == "PAYMENT_SUCCESS") {
                    $paymentId = $request->transactionId;
                    $response = ['status' => 1, 'msg' => 'paid', 'transaction_id' => $paymentId];
                } else {
                    return redirect(helper::getslug(Session::get('vendor_id'))->slug . '/' . ' wallet')->with('error', trans('messages.unable_to_complete_payment'));
                }
            }
            if (session()->get('payment_type') == "12") {
                $checkstatus = app('App\Http\Controllers\addons\PayTabController')->checkpaymentstatus(Session::get('tran_ref'), Session::get('vendor_id'));
                if ($checkstatus == "A") {
                    $paymentId = Session::get('tran_ref');
                    $response = ['status' => '1', 'msg' => 'paid', 'transaction_id' => $paymentId];
                } else {
                    return redirect(Session::get('failureurl'))->with('error', session()->get('paytab_response'));
                }
            }


            if (session()->get('payment_type') == "13") {
                $checkstatus = app('App\Http\Controllers\addons\MollieController')->checkpaymentstatus(Session::get('tran_ref'), Session::get('vendor_id'));

                if ($checkstatus == "A") {
                    $paymentId = Session::get('tran_ref');
                    $response = ['status' => 1, 'msg' => 'paid', 'transaction_id' => $paymentId];
                } else {
                    return redirect(Session::get('failureurl'))->with('error', session()->get('paytab_response'));
                }
            }

            if (session()->get('payment_type') == "14") {

                if ($request->status == "Completed") {
                    $paymentId = $request->transaction_id;
                    $response = ['status' => 1, 'msg' => 'paid', 'transaction_id' => $paymentId];
                } else {
                    return redirect(Session::get('failureurl'))->with('error', session()->get('paytab_response'));
                }
            }

            if (session()->get('payment_type') == "15") {

                $checkstatus = app('App\Http\Controllers\addons\XenditController')->checkpaymentstatus(Session::get('tran_ref'), Session::get('vendor_id'));

                if ($checkstatus == "PAID") {
                    $paymentId = Session::get('payment_id');
                    $response = ['status' => 1, 'msg' => 'paid', 'transaction_id' => $paymentId];
                } else {
                    return redirect(Session::get('failureurl'))->with('error', session()->get('paytab_response'));
                }
            }
        } catch (\Exception $e) {
            $response = ['status' => 0, 'msg' => $e->getMessage()];
        }

        $request = new Request($response);
        return $this->addwallet($request);
    }

    public function addfail(Request $request)
    {
        if (count(request()->all()) > 0) {
            return redirect(helper::getslug(Session::get('vendor_id'))->slug . '/' . 'wallet')->with('error', trans('messages.unable_to_complete_payment'));
        } else {
            return redirect(helper::getslug(Session::get('vendor_id'))->slug . '/' . 'wallet');
        }
    }

    public function deleteuseraccount(Request $request)
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
            $user = User::where('id', $request->id)->first();
            if ($user->is_deleted == 1) {
                return redirect('admin/settings')->with('error', trans('messages.account_blocked_by_admin'));
            }
            $user->is_deleted = 1;
            $user->update();
            $emaildata = helper::emailconfigration(helper::appdata($vendordata->id)->id);
            Config::set('mail', $emaildata);
            helper::send_mail_delete_account($user);
            session()->flush();
            Auth::logout();
            return redirect('/' . $vendordata->slug);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', trans('messages.wrong'));
        }
    }
}
