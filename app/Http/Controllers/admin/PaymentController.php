<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\SystemAddons;
use App\helper\helper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    public function index()
    {

        if (SystemAddons::where('unique_identifier', 'subscription')->first() == null && Auth::user()->type == 1) {
            return redirect()->back()->with(['error' => 'You can not charge your end customers in regular license. Please purchase extended license to charge your end customers']);
        } else {
            if (Auth::user()->type == 2) {
                $getpayment = Payment::where('vendor_id', Auth::user()->id)->where('is_activate', '1')->orderBy('reorder_id')->get();
            } else {
                $getpayment = Payment::where('vendor_id', '1')->where('is_activate', '1')->orderBy('reorder_id')->get();
            }
            return view('admin.payment.payment', compact("getpayment"));
        }
    }
    public function update(Request $request)
    {

        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        if (Auth::user()->type == 2 || Auth::user()->type == 4) {
            $pay_data = Payment::where('payment_type', $request->payment_id)->where('vendor_id', $vendor_id)->first();
        } else {
            $pay_data = Payment::where('payment_type', $request->payment_id)->where('vendor_id', 1)->first();
        }
        $pay_data->is_available = $request->is_available != null ? $request->is_available[$pay_data->payment_type] : '2';
        $pay_data->payment_name = $request->name;
        if (
            $request->payment_id == 2 ||
            $request->payment_id == 3 ||
            $request->payment_id == 4 ||
            $request->payment_id == 5 ||
            $request->payment_id == 7 ||
            $request->payment_id == 8 ||
            $request->payment_id == 9 ||
            $request->payment_id == 10 ||
            $request->payment_id == 11 ||
            $request->payment_id == 12 ||
            $request->payment_id == 13 ||
            $request->payment_id == 14 ||
            $request->payment_id == 15
        ) {
            $pay_data->environment = $request->environment[$pay_data->payment_type];
            $pay_data->public_key = $request->public_key[$pay_data->payment_type];
            $pay_data->secret_key = $request->secret_key[$pay_data->payment_type];
            $pay_data->currency = $request->currency[$pay_data->payment_type];
            if ($request->payment_id == 4) {
                $pay_data->encryption_key = $request->encryption_key;
            }
            if ($request->payment_id == 12) {
                $pay_data->base_url_by_region = $request->base_url_by_region;
            }
        }
        if ($request->payment_id == 6) {
            $pay_data->payment_description = $request->payment_description;
        }
        if ($request->has('image')) {
            $validator = Validator::make($request->all(), [
                'image' => 'image|max:' . helper::imagesize() . '|' . helper::imageext(),
            ], [
                'image.max' => trans('messages.image_size_message'),
            ]);
            if ($validator->fails()) {
                return redirect()->back()->with('error', trans('messages.image_size_message') . ' ' . helper::appdata('')->image_size . ' ' . 'MB');
            }
            if ($pay_data->image != strtolower($pay_data->payment_name) . ".png" && file_exists(env('ASSETPATHURL') . 'admin-assets/images/about/payment/' . $pay_data->image)) {
                unlink(env('ASSETPATHURL') . 'admin-assets/images/about/payment/' . $pay_data->image);
            }
            $image1 = 'payment-' . uniqid() . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(env('ASSETPATHURL') . 'admin-assets/images/about/payment/', $image1);
            $pay_data->image = $image1;
        }
        $pay_data->save();
        return redirect()->back()->with('success', trans('messages.success'));
    }
    public function reorder_payment(Request $request)
    {

        if ($request->has('ids')) {
            $arr = explode('|', $request->input('ids'));
            foreach ($arr as $sortOrder => $id) {
                $menu = Payment::find($id);
                $menu->reorder_id = $sortOrder;
                $menu->save();
            }
        }
        return response()->json(['status' => 1, 'msg' => trans('messages.success')], 200);
    }
}
