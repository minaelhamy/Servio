<?php

namespace App\Http\Controllers\addons\include;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Promocode;
use App\Models\Booking;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use App\helper\helper;
use App\Models\Order;

class PromocodeController extends Controller
{
    public function index()
    {
        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        $promocodes = Promocode::where('vendor_id', $vendor_id)->get();
        return view('admin.include.promocode.index', compact('promocodes'));
    }
    public function add()
    {
        return view('admin.include.promocode.add');
    }
    public function save(Request $request)
    {
        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        $request->validate([

            'usage_limit' => 'required_if:usage_type,1',

        ], [

            'usage_limit.required_if' => trans('messages.usage_limit_required'),

        ]);
        $promocode = new Promocode();
        $promocode->vendor_id = $vendor_id;
        $promocode->offer_name = $request->offer_name;
        $promocode->offer_type = $request->offer_type;
        $promocode->usage_type = $request->usage_type;
        if ($request->usage_type == 1) {
            $promocode->usage_limit = $request->usage_limit;
        }
        if ($request->usage_type == 2) {
            $promocode->usage_limit = 0;
        }
        $promocode->offer_code = $request->offer_code;
        $promocode->start_date = $request->start_date;
        $promocode->exp_date = $request->end_date;
        $promocode->offer_amount = $request->amount;
        $promocode->min_amount = $request->order_amount;
        $promocode->description = $request->description;
        $promocode->save();
        return redirect('/admin/promocode')->with('success', trans(('messages.success')));
    }
    public function edit($id)
    {
        $promocode = Promocode::where('id', $id)->first();
        return view('admin.include.promocode.edit', compact('promocode'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'usage_limit' => 'required_if:usage_type,1',
        ], [
            'usage_limit.required_if' => trans('messages.usage_limit_required'),
        ]);
        $editpromocode = Promocode::where('id', $id)->first();
        $editpromocode->offer_name = $request->offer_name;
        $editpromocode->offer_type = $request->offer_type;
        $editpromocode->usage_type = $request->usage_type;
        $editpromocode->usage_limit = $request->usage_limit;
        $editpromocode->offer_code = $request->offer_code;
        $editpromocode->start_date = $request->start_date;
        $editpromocode->exp_date = $request->end_date;
        $editpromocode->offer_amount = $request->amount;
        $editpromocode->min_amount = $request->order_amount;
        $editpromocode->description = $request->description;
        $editpromocode->update();
        return redirect('/admin/promocode')->with('success', trans(('messages.success')));
    }
    public function status_change($id, $status)
    {
        Promocode::where('id', $id)->update(['is_available' => $status]);
        return redirect('/admin/promocode')->with('success', trans('messages.success'));
    }
    public function vendorapplypromocode(Request $request)
    {
        date_default_timezone_set(helper::appdata('')->timezone);
        $checkoffercode = Promocode::where('offer_code', $request->promocode)->where('vendor_id', 1)->where('is_available', 1)->first();
        if (!empty($checkoffercode)) {
            if ((date('Y-m-d') >= $checkoffercode->start_date) && (date('Y-m-d') <= $checkoffercode->exp_date)) {
                if ($request->sub_total >= $checkoffercode->min_amount) {
                    if ($checkoffercode->usage_type == 1) {
                        if (Auth::user() && (Auth::user()->type == 2 || Auth::user()->type == 4)) {
                            $checkcount = Transaction::select('offer_code')->where('offer_code', $request->promocode)->count();
                        }
                        if ($checkcount >= $checkoffercode->usage_limit) {
                            return redirect()->back()->with('error', trans('messages.usage_limit_exceeded'))->withInput();
                        }
                    }
                    $offer_amount = $checkoffercode->offer_amount;
                    if ($checkoffercode->offer_type == 2) {
                        $offer_amount = $request->sub_total * $checkoffercode->offer_amount / 100;
                    }
                    $arr = array(
                        "offer_code" => $checkoffercode->offer_code,
                        "offer_amount" => $offer_amount,
                        'offer_type' => @$checkoffercode->usage_type,
                    );
                    session()->put('discount_data', $arr);
                    return response()->json(['status' => 1, 'message' => trans('messages.success')], 200);
                } else {
                    return response()->json(['status' => 0, 'message' => trans('messages.order_amount_greater_then') . ' ' . helper::currency_formate($checkoffercode->min_amount, '')], 200);
                }
            } else {
                return response()->json(['status' => 0, 'message' => trans('messages.invalid_promocode')], 200);
            }
        } else {
            return response()->json(['status' => 0, 'message' => trans('messages.invalid_promocode')], 200);
        }
    }
    public function vendorremovepromocode()
    {
        if (session()->has('discount_data')) {
            session()->forget('discount_data');
            return response()->json(['status' => 1, 'message' => trans('messages.success')], 200);
        }
        abort(404);
    }
    public function delete(Request $request)
    {
        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        $getcoupon = Promocode::where('id', $request->id)->where('vendor_id', $vendor_id)->first();
        $getcoupon->delete();
        return redirect('/admin/promocode')->with('success', trans('messages.success'));
    }
    public function bulk_delete(Request $request)
    {
        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        try {
            foreach ($request->id as $id) {
                $getcoupon = Promocode::where('id', $id)->where('vendor_id', $vendor_id)->first();
                $getcoupon->delete();
            }
          return response()->json(['status' => 1, 'msg' => trans('messages.success')], 200);
           
        } catch (\Exception $th) {
            return redirect()->back()->with('error', trans('messages.wrong'));
        }
    }

    //Book Service Promocode
    public function applypromocode(Request $request)
    {
        if ($request->offer_code == "") {
            return response()->json(['status' => 0, 'message' => trans('messages.offer_code_required')]);
        }
        
        $getcoupon = Promocode::where('offer_code', $request->offer_code)->where('is_available', '1')->where('vendor_id', $request->vendor_id)->first();
        if (!empty($getcoupon->usage_limit)) {
            $totalcoupon = Booking::where('offer_code', $request->offer_code)->where('vendor_id', $request->vendor_id)->count();
            if ($totalcoupon >= $getcoupon->usage_limit) {
                return response()->json(['status' => 0, 'message' => trans('Coupon Limit Exceed')]);
            }
        }
        $currentdate = date('Y-m-d');
        if ($request->price < $getcoupon->min_amount) {
            $min_amount = helper::currency_formate($getcoupon->min_amount, $request->vendor_id);
            return response()->json(['status' => 0, 'message' => trans('messages.order_amount_greter_min_amount') . $min_amount]);
        } else {
            if ($currentdate > $getcoupon->exp_date) {
                return response()->json(['status' => 0, 'message' => trans('messages.coupon_code_expire')]);
            } else {
                if ($getcoupon->offer_type == 1) {
                    $offer_amount = $getcoupon->offer_amount;
                } else {
                    $offer_amount = $request->price * $getcoupon->offer_amount / 100;
                }
                $arr = array(
                    "offer_code" => $getcoupon->offer_code,
                    "offer_amount" => $offer_amount,
                );
                session()->put('discount_data', $arr);
                return response()->json(['status' => 1, 'message' => trans('messages.success'), 'data' => $arr]);
            }
        }
    }
    public function removepromocode()
    {
        $remove = session()->forget('discount_data');
        if (!$remove) {
            return response()->json(['status' => 1, 'message' => trans('messages.success')], 200);
        } else {
            return response()->json(['status' => 0, 'message' => trans('messages.wrong')], 200);
        }
    }

    //Product Order Pormocode
    public function orderapplypromocode(Request $request)
    {
        if ($request->offer_code == "") {
            return response()->json(['status' => 0, 'message' => trans('messages.offer_code_required')]);
        }
        $getcoupon = Promocode::where('offer_code', $request->offer_code)->where('is_available', '1')->where('vendor_id', $request->vendor_id)->first();
        if (!empty($getcoupon->usage_limit)) {
            $totalcoupon = Order::where('offer_code', $request->offer_code)->where('vendor_id', $request->vendor_id)->count();
            if ($totalcoupon >= $getcoupon->usage_limit) {
                return response()->json(['status' => 0, 'message' => trans('Coupon Limit Exceed')]);
            }
        }
        $currentdate = date('Y-m-d');
        if ($request->subtotal < $getcoupon->min_amount) {
            $min_amount = helper::currency_formate($getcoupon->min_amount, $request->vendor_id);
            return response()->json(['status' => 0, 'message' => trans('messages.order_amount_greter_min_amount') . $min_amount]);
        } else {
            if ($currentdate > $getcoupon->exp_date) {
                return response()->json(['status' => 0, 'message' => trans('messages.coupon_code_expire')]);
            } else {
                if ($getcoupon->offer_type == 1) {
                    $offer_amount = $getcoupon->offer_amount;
                } else {
                    $offer_amount = $request->subtotal * $getcoupon->offer_amount / 100;
                }
                $arr = array(
                    "offer_code" => $getcoupon->offer_code,
                    "offer_amount" => $offer_amount,
                );
                session()->put('order_discount_data', $arr);
                return response()->json(['status' => 1, 'message' => trans('messages.success'), 'data' => $arr]);
            }
        }
    }
    public function orderremovepromocode()
    {
        $remove = session()->forget('order_discount_data');
        if (!$remove) {
            return response()->json(['status' => 1, 'message' => trans('messages.success')], 200);
        } else {
            return response()->json(['status' => 0, 'message' => trans('messages.wrong')], 200);
        }
    }
}
