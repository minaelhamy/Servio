<?php

namespace App\Http\Controllers\admin;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\SystemAddons;
use App\helper\helper;
use App\Models\Booking;
use App\Models\PricingPlan;
use App\Models\Service;
use App\Models\City;
use App\Models\Country;
use App\Models\StoreCategory;
use App\Models\Transaction;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;
use Session;
use Lunaweb\RecaptchaV3\Facades\RecaptchaV3;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Services\HatchersOsSnapshotService;

class AdminController extends Controller
{
    public function __construct(private HatchersOsSnapshotService $snapshotService)
    {
    }

    public function login()
    {
        helper::language(1);
        return view('admin.auth.login');
    }
    public function check_admin_login(Request $request)
    {

        try {
            $request->validate([
                'login' => 'required|string',
                'password' => 'required',
            ]);

            $login = trim((string) $request->login);
            $userQuery = User::where('email', $login);
            if (Schema::hasColumn('users', 'username')) {
                $userQuery->orWhere('username', $login);
            }
            $user = $userQuery->first();

            session()->put('admin_login', 1);
            if (!empty($user) && Hash::check($request->password, (string) $user->password)) {
                Auth::login($user);
                if (!Auth::user()) {
                    return Redirect::to('/admin/verify')->with('error', Session::get('from_message'));
                }
                if (Auth::user()->type == 1) {
                    return redirect('/admin/dashboard');
                } else {
                    if (Auth::user()->type == 2 && Auth::user()->is_deleted == 2) {
                        if (Auth::user()->is_available == 1) {
                            return redirect('/admin/dashboard');
                        } else {
                            Auth::logout();
                            return redirect()->back()->with('error', trans('messages.block'));
                        }
                    } elseif (Auth::user()->type == 4 && Auth::user()->is_deleted == 2) {
                        if (Auth::user()->is_available == 1) {
                            return redirect('/admin/dashboard');
                        } else {
                            Auth::logout();
                            return redirect()->back()->with('error', trans('messages.block'));
                        }
                    } else {
                        Auth::logout();
                        return redirect()->back()->with('error', trans('messages.email_password_not_match'));
                    }
                }
            } else {
                return redirect()->back()->with('error', trans('messages.email_password_not_match'));
            }
        } catch (Exception $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }
    }
    public function forgot_password()
    {
        helper::language(1);
        return view('admin.auth.forgotpassword');
    }
    public function send_password(Request $request)
    {
        $request->validate([
            'email' => 'email',
        ], [
            'email.email' =>  trans('messages.invalid_email'),
        ]);
        $checkuser = User::where('email', $request->email)->where('is_available', 1)->whereIn('type', [1, 2])->first();
        if (!empty($checkuser)) {
            $password = substr(str_shuffle($checkuser->password), 1, 6);
            $emaildata = helper::emailconfigration(helper::appdata('')->id);
            Config::set('mail', $emaildata);
            $check_send_mail = helper::send_mail_forpassword($request->email, $checkuser->name, $password, helper::appdata('')->logo);
            if ($check_send_mail == 1) {
                $checkuser->password = Hash::make($password);
                $checkuser->save();
                return redirect('/admin')->with('success', trans('messages.success'));
            } else {
                return redirect('/admin/forgot_password')->with('error', trans('messages.wrong'));
            }
        } else {
            return redirect()->back()->with('error', trans('messages.invalid_user'));
        }
    }
    public function register()
    {
        helper::language(1);
        $countries = Country::where('Is_deleted', 2)->where('is_available', 1)->get();
        $stores = StoreCategory::where('is_available', 1)->where('is_deleted', 2)->orderBy('reorder_id')->get();
        return view('admin.auth.register', compact('countries', 'stores'));
    }
    public function register_vendor(Request $request)
    {

        $validatoremail = Validator::make(['email' => $request->email], [
            'email' => [
                'required',
                'email',
                Rule::unique('users')->whereIn('type', [1, 2, 4])->where('is_deleted', 2),
            ]
        ]);
        if ($validatoremail->fails()) {
            return redirect()->back()->with('error', trans('messages.unique_email'));
        }
        $validatormobile = Validator::make(['mobile' => $request->mobile], [
            'mobile' => [
                'required',
                'numeric',
                Rule::unique('users')->whereIn('type', [1, 2, 4])->where('is_deleted', 2),
            ]
        ]);
        if ($validatormobile->fails()) {
            return redirect()->back()->with('error', trans('messages.unique_mobile'));
        }
        if (
            SystemAddons::where('unique_identifier', 'unique_slug')->first() != null &&
            SystemAddons::where('unique_identifier', 'unique_slug')->first()->activated == 1
        ) {

            $validatorslug = Validator::make(['slug' => $request->slug], [
                'slug' => [
                    'required',
                    Rule::unique('users')->where('type', 2)->where('is_deleted', 2),
                ]
            ]);
            if ($validatorslug->fails()) {
                return redirect()->back()->with('error', trans('messages.unique_slug'));
            }
        }

        if (@Auth::user()->type != 1) {
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
        }
        $data = helper::vendor_register($request->name, $request->email, $request->mobile, hash::make($request->password), '', $request->slug, '', '', $request->country, $request->city, $request->store);
        $newuser = User::select('id', 'name', 'email', 'mobile', 'image')->where('id', $data)->first();
        if (Auth::user() && Auth::user()->type == 1) {
            session()->put('vendor_login', 1);
            return redirect('admin/users')->with('success', trans('messages.success'));
        } else {
            session()->put('user_login', 1);
            Auth::login($newuser);
            return redirect('admin/dashboard')->with('success', trans('messages.success'));
        }
    }
    public function index(Request $request)
    {
        // dd(123);
        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        if (empty($request->revenue_year)) {
            $request->revenue_year = date('Y');
        }
        if (empty($request->booking_year)) {
            $request->booking_year = date('Y');
        }
        if (Auth::user()->type == 1 || (Auth::user()->type == 4 && Auth::user()->vendor_id == 1)) {
            $getrevenue_data = Transaction::select(\DB::raw("SUM(amount) as count"), \DB::raw("MONTHNAME(purchase_date) as month"))->groupBy(\DB::raw("MONTHNAME(purchase_date)"))->where(\DB::raw("YEAR(purchase_date)"), $request->revenue_year)->orderby('purchase_date')->get();
            $getpiechart_data = User::select(\DB::raw("COUNT(id) as count"), \DB::raw("MONTHNAME(created_at) as month"))->groupBy(\DB::raw("MONTHNAME(created_at)"))->where('type', 2)->where(\DB::raw("YEAR(created_at)"), $request->booking_year)->orderby('created_at')->get();
            $getyears = Transaction::select(\DB::raw("YEAR(purchase_date) as year"))->groupBy(\DB::raw("YEAR(purchase_date)"))->orderby('purchase_date')->get();
            $totalrevenue = Transaction::select(\DB::raw("SUM(amount) as total"))->where('status', 2)->first();
            $getbookings = Transaction::with('vendor_info')->whereDate('created_at', Carbon::today())->where('transaction_type', null)->orderByDesc('id')->get();
            $topitems = [];
            $getbookingscount = [];
            $topusers = [];
        } else {

            $getrevenue_data = Booking::select(\DB::raw("SUM(grand_total) as count"), \DB::raw("MONTHNAME(booking_date) as month"))->groupBy(\DB::raw("MONTHNAME(booking_date)"))->where('vendor_id', $vendor_id)->where('payment_status', '2')->where('status_type', '3')->where(\DB::raw("YEAR(booking_date)"), $request->revenue_year)->orderby('booking_date')->get();
            $getpiechart_data = Booking::select(\DB::raw("COUNT(id) as count"), \DB::raw("MONTHNAME(booking_date) as month"))->groupBy(\DB::raw("MONTHNAME(booking_date)"))->where('vendor_id', $vendor_id)->where(\DB::raw("YEAR(booking_date)"), $request->booking_year)->orderby('booking_date')->get();
            $getyears = Booking::select(\DB::raw("YEAR(booking_date) as year"))->groupBy(\DB::raw("YEAR(booking_date)"))->where('vendor_id', $vendor_id)->orderby('booking_date')->get();
            $totalrevenue = Booking::select(\DB::raw("SUM(grand_total) as total"))->where('vendor_id', $vendor_id)->where('payment_status', '2')->where('status_type', '3')->first();
            $getbookings = Booking::whereDate('created_at', Carbon::today())->where('vendor_id', $vendor_id)->orderByDesc('id')->get();

            $topitems = Service::with('category_info', 'service_image')->join('bookings', 'bookings.service_id', 'services.id')
                ->select('services.id', 'services.category_id', 'services.name', 'services.slug', DB::raw('count(bookings.service_id) as service_book_counter'))
                ->groupBy('bookings.service_id')->having('service_book_counter', '>', 0)
                ->where('services.vendor_id', $vendor_id)->where('services.is_deleted', 2)->orderByDesc('service_book_counter')
                ->get()->take(5);
            $getbookingscount = Booking::where('vendor_id', $vendor_id)->count();

            $topusers = User::join('bookings', 'bookings.user_id', 'users.id')
                ->select('users.id', 'users.name', 'users.email', 'users.image', 'users.mobile', DB::raw('count(bookings.user_id) as user_booking_counter'))
                ->groupBy('bookings.user_id')
                ->having('user_booking_counter', '>', 0)
                ->where('bookings.vendor_id', $vendor_id)
                ->where('users.type', 3)
                ->where('users.is_available', 1)
                ->orderByDesc('user_booking_counter')
                ->get()->take(5);
        }
        $getuserYears = User::select(\DB::raw("YEAR(created_at) as year"))->groupBy(\DB::raw("YEAR(created_at)"))->orderby('created_at')->get();
        $userchart_year = explode('|', $getuserYears->implode('year', '|'));
        if (env('Environment') == 'sendbox') {
            $revenue_lables = ['January', 'February', 'March', 'April', 'May', 'June', 'July ', 'August', 'September', 'October', 'November', 'December'];
            $revenue_data = [636, 1269, 2810, 2843, 3637, 467, 902, 1296, 402, 1173, 1509, 413];
            if (Auth::user()->type == 1) {
                $piechart_lables = ['January', 'February', 'March', 'April', 'May', 'June', 'July ', 'August', 'September', 'October', 'November', 'December'];
                $piechart_data = [16, 14, 25, 28, 45, 31, 25, 35, 49, 21, 32, 31];
            } else {
                $piechart_lables = ['January', 'February', 'March', 'April', 'May', 'June', 'July ', 'August', 'September', 'October', 'November', 'December'];
                $piechart_data = [60, 42, 13, 83, 34, 97, 92, 62, 13, 99, 89, 94];
            }
        } else {
            $revenue_lables = explode('|', $getrevenue_data->implode('month', '|'));
            $revenue_data = explode('|', $getrevenue_data->implode('count', '|'));
            $piechart_lables = explode('|', $getpiechart_data->implode('month', '|'));
            $piechart_data = explode('|', $getpiechart_data->implode('count', '|'));
        }
        $revenue_year_list = explode('|', $getyears->implode('year', '|'));
        $totalusers = User::whereNotIn('id', [1])->where('is_available', 1)->where('is_deleted', 2)->where('type', 2)->count();
        $totalservices = Service::where('Vendor_id', $vendor_id)->count();
        $totalplans = PricingPlan::count();
        $currentplan = PricingPlan::select('name')->where('id', Auth::user()->plan_id)->first();
        $totalbookings = Booking::where('vendor_id', $vendor_id)->count();
        $totaladminbookings = Transaction::count();
        if ($request->ajax()) {
            if ($request->has('revenue_year')) {
                return response()->json(['revenue_lables' => $revenue_lables, 'revenue_data' => $revenue_data], 200);
            }
            if ($request->has('booking_year')) {
                return response()->json(['piechart_lables' => $piechart_lables, 'piechart_data' => $piechart_data], 200);
            }
        } else {
            if (Auth::user()->type == 4) {
                if (Auth::user()->role_type == 1) {
                    return view('admin.access_denied');
                } else {
                    if (helper::check_access('role_dashboard', Auth::user()->role_id, Auth::user()->vendor_id, 'manage') == 1) {
                        $founder = User::find($vendor_id);
                        if (!empty($founder)) {
                            $this->snapshotService->syncFounder($founder, 'vendor_dashboard');
                        }
                        return view('admin.index', compact('revenue_lables', 'revenue_year_list', 'revenue_data', 'piechart_lables', 'piechart_data', 'totalusers', 'totalplans', 'totalbookings', 'totalrevenue', 'userchart_year', 'totalservices', 'currentplan', 'totaladminbookings', 'getbookings', 'topitems', 'getbookingscount', 'topusers'));
                    } else {
                        return view('admin.access_denied');
                    }
                }
            } else {
                if ((int) Auth::user()->type === 2) {
                    $founder = User::find($vendor_id);
                    if (!empty($founder)) {
                        $this->snapshotService->syncFounder($founder, 'vendor_dashboard');
                    }
                }
                return view('admin.index', compact('revenue_lables', 'revenue_year_list', 'revenue_data', 'piechart_lables', 'piechart_data', 'totalusers', 'totalplans', 'totalbookings', 'totalrevenue', 'userchart_year', 'totalservices', 'currentplan', 'totaladminbookings', 'getbookings', 'topitems', 'getbookingscount', 'topusers'));
            }
        }
    }
    public function edit_profile(Request $request)
    {
        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        $edituser = User::where('id', Auth::user()->id)->first();
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
        if (Auth::user()->type != 4 && Auth::user()->type != 1) {
            $validatorslug = Validator::make(['slug' => $request->slug], [
                'slug' => [
                    'required',
                    Rule::unique('users')->where('type', 2)->where('is_deleted', 2)->ignore($edituser->id),
                ]
            ]);
            if ($validatorslug->fails()) {
                return redirect()->back()->with('error', trans('messages.unique_sluga'));
            }
        }

        $edituser->name = $request->name;
        $edituser->email = $request->email;
        $edituser->mobile = $request->mobile;
        if (Auth::user()->type != 4) {
            $edituser->country_id = $request->country;
            $edituser->city_id = $request->city;
            if ($request->slug != null && $request->slug != "") {
                $edituser->slug = $request->slug;
            }
        }
        if ($request->has('profile')) {
            $validator = Validator::make($request->all(), [
                'profile' => 'image|max:' . helper::imagesize() . '|' . helper::imageext(),
            ], [
                'profile.max' => trans('messages.image_size_message'),
            ]);
            if ($validator->fails()) {
                return redirect()->back()->with('error', trans('messages.image_size_message') . ' ' . helper::appdata('')->image_size . ' ' . 'MB');
            }
            if (file_exists(storage_path('app/public/admin-assets/images/profile/' .  $edituser->image))) {
                unlink(storage_path('app/public/admin-assets/images/profile/' .  $edituser->image));
            }
            $edit_image = $request->file('profile');
            $profileImage = 'profile-' . uniqid() . "." . $edit_image->getClientOriginalExtension();
            $edit_image->move(storage_path('app/public/admin-assets/images/profile/'), $profileImage);
            $edituser->image = $profileImage;
        }
        $edituser->update();
        return redirect()->back()->with('success', trans('messages.success'));
    }
    public function change_password(Request $request)
    {

        if ($request->type != "" || $request->type != null) {
            if ($request->new_password == $request->confirm_password) {
                $changepassword = User::where('id', $request->modal_vendor_id)->first();
                $changepassword->password = Hash::make($request->new_password);
                $changepassword->update();
                $emaildata = helper::emailconfigration(helper::appdata("")->id);
                Config::set('mail', $emaildata);
                helper::send_mail_forpassword($changepassword->email, $changepassword->name, $request->new_password, helper::appdata("")->logo);
                return redirect()->back()->with('success', trans('messages.success'));
            } else {
                return redirect()->back()->with('error', trans('messages.new_confirm_password_inccorect'));
            }
        } else {
            $request->validate([
                'current_password' => 'required',
                'new_password' => 'required',
                'confirm_password' => 'required',
            ], [
                'current_password.required' => trans('messages.cuurent_password_required'),
                'new_password.required' => trans('messages.new_password_required'),
                'confirm_password.required' =>  trans('messages.confirm_password_required'),
            ]);
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
        }
    }
    public function logout()
    {
        session()->flush();
        Auth::logout();
        return redirect('/admin');
    }
    public function systemverification(Request $request)
    {
        $client = new \GuzzleHttp\Client();
        $res = $client->request('POST', \Illuminate\Support\Facades\Crypt::decrypt('eyJpdiI6InFZNGJTNmxHZ20xTVZrTTJkcmxqV3c9PSIsInZhbHVlIjoiMjFyVHVxa2FTNkY0b3Rhc2NmM3JsUTVOdkF4eURua1NVZ1VsYjkyNUtoYkJQb1RwbFZaQUpmWXBtTEQvaVpRWSIsIm1hYyI6ImQ1MGNiM2U0NTFmYTQwYTQ0OGVmN2NlZGU4Mjg1NmM2NDAyODFiYmQwZWZiOGY1NTNmYjY0ZjhkZmJhMGU4Y2UiLCJ0YWciOiIifQ=='), [
            'form_params' => [
                \Illuminate\Support\Facades\Crypt::decrypt('eyJpdiI6IkhWSk1aZ2tqbjJvWm1aS3V4dm5tV2c9PSIsInZhbHVlIjoiZkRFeVdRbHkzOHUxRVN6UDh3QkxtN05yUVhOUC90bGRBU29VcXVsQXJMQT0iLCJtYWMiOiI3NTU1Zjc2YWQ4MTNhMTAzYTMyNGFhZTk5YmEyMTBlZDZhYTFhODY5ZmQyYjNlNDg0ODVkMDA0OGFhODI3Zjg3IiwidGFnIjoiIn0=') => $request->username,
                \Illuminate\Support\Facades\Crypt::decrypt('eyJpdiI6Imx1SkphYkdaVDJ3c3I0aWdMUDM1aHc9PSIsInZhbHVlIjoiMkE4Mjc3RDUyKzlFampqQkFiaGxxUT09IiwibWFjIjoiN2Q1MjI2NzIxODFmMDhiMWE5NTRjYTA5OTNjN2Y0YWIxNzA5M2IxZjI5YzBjODU1Y2ViZDI4MWM1NTRhMWU1YSIsInRhZyI6IiJ9') => $request->email,
                \Illuminate\Support\Facades\Crypt::decrypt('eyJpdiI6IjBOcG9rdzZIdXJCdjlMTHFKakc5bUE9PSIsInZhbHVlIjoiRkN0MlFOOTVCb2wxQnpBVGhQdVh4V0pDN0ZjT0VFSUxqeGpXa3l4ZWV0OD0iLCJtYWMiOiI4NDZhZmI1ZDZlNDE1MGU3YWViN2E3MWYzZjY3OGRiMmU3Zjg1NGUwM2M4OGEzMjgyYWM2ODg0NGZkODAwMjZjIiwidGFnIjoiIn0=') => $request->purchase_key,
                \Illuminate\Support\Facades\Crypt::decrypt('eyJpdiI6IldxRy9wNCtGZFZZcTVuOEJodGtPVkE9PSIsInZhbHVlIjoiSHF6cDEzR25ORHlFeHVuSHRTOFZJdz09IiwibWFjIjoiMTI4YjJiZmQ4YjcxY2E5YjZhMDIwMjAxODkyMzVhN2RjY2FkOGI1NmFlM2MyODMzMjkwYWMyNjU5ODExZTRmOCIsInRhZyI6IiJ9') => $request->domain,
                \Illuminate\Support\Facades\Crypt::decrypt('eyJpdiI6Ilcvc3E4bjlnQlFaVnhvcnhZaDBsOXc9PSIsInZhbHVlIjoiRGZMdTY4SFBJOE9VQVFja1NPc2VVSEZuZ1FBd3ZaOGJSUnJxZm55aHV4OD0iLCJtYWMiOiI3YmVjYjAzM2JiYWU3ZDZjYzM2NzU5NjkzYzgzMGNjYWFmNzZjNmI2ZmJiMGQxYzQzNWIwYzU3YWY4MGI1OTRmIiwidGFnIjoiIn0=') => \Illuminate\Support\Facades\Crypt::decrypt('eyJpdiI6Imw5eDR3VHNqL1FiaVdEcDU0WVpQMnc9PSIsInZhbHVlIjoiYmlCVTl6WVoxTVBLb01VV2MxTmloQT09IiwibWFjIjoiNmUzMDlhODU5ODZlZTkzY2M1MTY4NjY2ZDMyZmZmZDUyOTY0ZGVjNTFmZTAwOTZkOGI2Y2UwNGViNTJhOTgwOCIsInRhZyI6IiJ9'),
                \Illuminate\Support\Facades\Crypt::decrypt('eyJpdiI6Ik5jK2QrdXMwSnFFOWlRWkRjeUVzQlE9PSIsInZhbHVlIjoiNkUrdWhxSlRoOU5ySkhPNjFVV2dadz09IiwibWFjIjoiYzY3ZWM3ZmQyYjYwYzVmN2ExYTI0YzEzZmYyN2I4MGZlOWE5ODkxMTQwYjE1YmY0Y2ZiMzdmYjFjMmEyYzI3YiIsInRhZyI6IiJ9') => \Illuminate\Support\Facades\Crypt::decrypt('eyJpdiI6IktWQjBEcHhJRlA4UUtsUTRCNzYyS1E9PSIsInZhbHVlIjoiTCthS0U0MExna1NOUGZkbk5mTGtHQT09IiwibWFjIjoiZGY1NWMwNGQzMDkxYWY0YmVmMzJjY2ZlMGVkMTUwYzAxNmJkMjRmOGJlYzEwYWUwZjNlNjExZWZiYTMyZGE1MyIsInRhZyI6IiJ9'),
            ]
        ]);
        $obj = json_decode($res->getBody());
        if ($obj->status == '1') {
            User::where('id', 1)->update(['license_type' => $obj->license_type]);
            return Redirect::to('/admin')->with('success', 'You have successfully verified your License. Please try to Login now');
        } else {
            return Redirect::back()->with('error', $obj->message);
        }
    }
    public function getcity(Request $request)
    {
        try {
            $data['city'] = City::select("id", "city")->where('country_id', $request->country)->where('is_deleted', 2)->where('is_available', 1)->get();
            return response()->json($data);
        } catch (\Throwable $th) {
            return response()->json(['status' => 0, 'message' => trans('messages.wrong')], 200);
        }
    }

    public function sessionsave(Request $request)
    {
        session()->put('demo', $request->demo_type);

        return response()->json(['status' => 1, 'msg' => trans('messages.success')], 200);
    }
}
