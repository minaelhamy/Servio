<?php

namespace App\Http\Controllers\Api\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Service;
use Illuminate\Support\Facades\Hash;
use App\helper\helper;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Config;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function register_customer(Request $request)
    {
        $checkemail = User::where('email', $request->email)->first();
        $checkmobile = User::where('mobile', $request->mobile)->first();
        if ($request->name == "") {
            return response()->json(["status" => 0, "message" => trans('messages.name_required')], 200);
        }
        if ($request->email == "") {
            return response()->json(["status" => 0, "message" => trans('messages.email_required')], 200);
        }
        if ($request->mobile == "") {
            return response()->json(["status" => 0, "message" => trans('messages.mobile_required')], 200);
        }
        if ($request->password == "") {
            return response()->json(["status" => 0, "message" => trans('messages.password_required')], 200);
        }
        if (!empty($checkemail)) {
            return response()->json(['status' => 0, 'message' => trans('messages.unique_email')], 200);
        }
        if (!empty($checkmobile)) {
            return response()->json(['status' => 0, 'message' => trans('messages.unique_mobile')], 200);
        }

        $newuser = new User();
        $newuser->name = $request->name;
        $newuser->email = $request->email;
        $newuser->password = hash::make($request->password);
        $newuser->mobile = $request->mobile;
        $newuser->type = "3";
        $newuser->login_type = "email";
        $newuser->image = "default.png";
        $newuser->is_available = "1";
        $newuser->is_verified = "1";
        $newuser->wallet = 0;
        $newuser->save();

        return response()->json(['status' => 1, 'message' => trans('messages.success'), 'data' => $newuser], 200);
    }

    public function login_customer(Request $request)
    {
        if ($request->email == "") {
            return response()->json(["status" => 0, "message" => trans('messages.email_required')], 200);
        }
        if ($request->password == "") {
            return response()->json(["status" => 0, "message" => trans('messages.password_required')], 200);
        }
        $checkuser = User::where('email', $request->email)->where('type', '3')->first();
        if (!empty($checkuser)) {
            if (Hash::check($request->password, $checkuser->password)) {
                if ($checkuser->is_available == '1') {
                    $checkuser->token = $request->token;
                    $checkuser->save();
                    $checkuser = $checkuser::select('id', 'name', 'email', 'mobile', 'image')->where('id', $checkuser->id)->first();
                    $checkuser->image = helper::image_path($checkuser->image);
                    return response()->json(['status' => 1, 'message' => trans('messages.success'), 'data' => $checkuser], 200);
                } else {
                    return response()->json(['status' => 0, 'message' => trans('messages.blocked')], 200);
                }
            } else {
                return response()->json(['status' => 0, 'message' => trans('messages.email_password_not_match')], 200);
            }
        } else {
            return response()->json(['status' => 0, 'message' => trans('messages.email_password_not_match')], 200);
        }
    }

    public function forgotpassword(Request $request)
    {
        if ($request->email == "") {
            return response()->json(["status" => 0, "message" => trans('messages.email_required')], 200);
        }
        $checkuser = User::where('email', $request->email)->where('is_available', 1)->first();
        if (!empty($checkuser)) {
            $password = substr(str_shuffle($checkuser->password), 1, 6);
            $emaildata = helper::emailconfigration(helper::appdata('')->id);
            Config::set('mail', $emaildata);
            $check_send_mail = helper::send_mail_forpassword($request->email, $checkuser->name, $password, helper::appdata('')->logo);
            if ($check_send_mail == 1) {
                $checkuser->password = Hash::make($password);
                $checkuser->save();
                return response()->json(['status' => 1, 'message' => trans('messages.success')], 200);
            } else {
                return response()->json(['status' => 0, 'message' => trans('messages.wrong')], 200);
            }
        } else {
            return response()->json(['status' => 0, 'message' => trans('messages.invalid_user')], 200);
        }
    }

    public function edit_profile(Request $request)
    {
        if ($request->user_id == "") {
            return response()->json(["status" => 0, "message" => trans('messages.user_id_required')], 400);
        }
        if ($request->name == "") {
            return response()->json(["status" => 0, "message" => trans('messages.name_required')], 200);
        }
        if ($request->email == "") {
            return response()->json(["status" => 0, "message" => trans('messages.email_required')], 200);
        }
        if ($request->mobile == "") {
            return response()->json(["status" => 0, "message" => trans('messages.mobile_required')], 200);
        }
        $check_slug = User::where('slug', Str::slug($request->name, '-'))->first();
        if (!empty($check_slug)) {
            $last_id = User::select('id')->orderByDesc('id')->first();
            $slug = Str::slug($request->name . ' ' . $last_id->id, '-');
        } else {
            $slug = Str::slug($request->name, '-');
        }
        $edituser = User::where('id', $request->user_id)->first();
        $edituser->slug = $slug;
        $edituser->name = $request->name;
        $edituser->email = $request->email;
        $edituser->mobile = $request->mobile;
        if ($request->has('profile')) {
            $validator = Validator::make($request->all(), [
                'profile' => 'image|max:' . helper::imagesize() . '|' . helper::imageext(),
            ], [
                'profile.max' => trans('messages.image_size_message'),
            ]);
            if ($validator->fails()) {
                return redirect()->back()->with('error', trans('messages.image_size_message'));
            }
            if (file_exists(storage_path('app/public/admin-assets/images/profile/' . $edituser->image))) {
                unlink(storage_path('app/public/admin-assets/images/profile/' .  $edituser->image));
            }
            $edit_image = $request->file('profile');
            $profileImage = 'profile-' . uniqid() . "." . $edit_image->getClientOriginalExtension();
            $edit_image->move(storage_path('app/public/admin-assets/images/profile/'), $profileImage);
            $edituser->image = $profileImage;
        }
        $edituser->update();
        return response()->json(['status' => 1, 'message' => trans('messages.success'), "name" => $request->name, "email" => $request->email, "mobile" => $request->mobile, "image" => helper::image_path($edituser->image)], 200);
    }

    public function change_password(Request $request)
    {
        if ($request->user_id == "") {
            return response()->json(["status" => 0, "message" => trans('messages.user_id_required')], 400);
        }
        if ($request->current_password == "") {
            return response()->json(["status" => 0, "message" => trans('messages.cuurent_password_required')], 200);
        }
        if ($request->new_password == "") {
            return response()->json(["status" => 0, "message" => trans('messages.new_password_required')], 200);
        }
        if ($request->confirm_password == "") {
            return response()->json(["status" => 0, "message" => trans('messages.confirm_password_required')], 200);
        }
        $user = User::where('id', $request->user_id)->first();
        if (Hash::check($request->current_password, $user->password)) {
            if ($request->current_password == $request->new_password) {
                return redirect()->back()->with('error', trans('messages.new_old_password_diffrent'));
            } else {
                if ($request->new_password == $request->confirm_password) {
                    $user->password = Hash::make($request->new_password);
                    $user->update();
                    return response()->json(['status' => 1, 'message' => trans('messages.success')], 200);
                } else {
                    return response()->json(['status' => 0, 'message' => trans('messages.new_confirm_password_inccorect')], 200);
                }
            }
        } else {
            return response()->json(['status' => 0, 'message' => trans('messages.old_password_incorect')], 200);
        }
    }
    public function wishlist_product(Request $request)
    {
        $userid = "";
        if ($request->user_id == "") {
            return response()->json(["status" => 0, "message" => trans('messages.user_id_required')], 400);
        }
        if ($request->vendor_id == "") {
            return response()->json(["status" => 0, "message" => trans('messages.vendor_id_required')], 400);
        }
        if ($request->user_id != "") {
            $userid = $request->user_id;
        }
        $getfavourite = Service::with('service_image_api','reviews')->select('services.*', DB::raw('(case when favorite.service_id is null then 0 else 1 end) as is_favorite'), DB::raw('ROUND(AVG(testimonials.star),1) as ratings_average'),\DB::raw("categories.name as category_name"))->leftJoin('favorite', function ($query) use ($userid) {
            $query->on('favorite.service_id', '=', 'services.id')
                ->where('favorite.user_id', '=', $userid);
        })->join("categories",\DB::raw("FIND_IN_SET(categories.id,replace(services.category_id, '|', ','))"),">",\DB::raw("'0'"))->leftJoin('testimonials', 'testimonials.service_id', '=', 'services.id')->groupBy('services.id')->where('favorite.vendor_id', $request->vendor_id)->where('services.vendor_id', $request->vendor_id)
            ->where('favorite.user_id', $request->user_id)
            ->where('services.is_available', 1)->where('services.is_deleted', 2)->paginate(9);
        return response()->json(['status' => 1, 'message' => trans('messages.success'), 'data' => $getfavourite], 200);
    }

    public function deleteuseraccount(Request $request)
    {
        if ($request->user_id == "") {
            return response()->json(["status" => 0, "message" => trans('messages.user_id_required')], 400);
        }
        if ($request->vendor_id == "") {
            return response()->json(["status" => 0, "message" => trans('messages.vendor_id_required')], 400);
        }
        $user = User::where('id', $request->user_id)->first();
        if ($user->is_available == 2) {
            return response()->json(['status' => 0, 'message' => trans('messages.account_blocked_by_admin')], 200);
        }
        $user->is_available = 2;
        $user->update();
        $emaildata = helper::emailconfigration(helper::appdata($request->vendor_id)->id);
        Config::set('mail', $emaildata);
        helper::send_mail_delete_account($user);
        return response()->json(['status' => 1, 'message' => trans('messages.success')], 200);
    }
}
