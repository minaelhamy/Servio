<?php
namespace App\Http\Controllers\Api\user;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Promocode;
use App\Models\Booking;
use App\helper\helper;

class PromocodeController extends Controller
{
    public function promocode(Request $request)
    {
        if ($request->vendor_id == "") {
            return response()->json(["status" => 0, "message" => trans('messages.vendor_id_required')], 200);
        }
        $promocodes = Promocode::where('vendor_id',$request->vendor_id)->get();
    
        return response()->json(['status' => 1, 'message' => trans('messages.success'), 'promocodes' => $promocodes], 200);
    }
    
    public function applypromocode(Request $request)
    {
        if ($request->vendor_id == "") {
            return response()->json(["status" => 0, "message" => trans('messages.vendor_id_required')], 200);
        }
        if ($request->offer_code == "") {
            return response()->json(["status" => 0, "message" => trans('messages.offer_code_required')], 200);
        }
        if ($request->service_price == "") {
            return response()->json(["status" => 0, "message" => trans('messages.service_price_required')], 200);
        }
        
        $getcoupon = Promocode::where('offer_code', $request->offer_code)->where('is_available', '1')->where('vendor_id', $request->vendor_id)->first();
        
        if (!empty($getcoupon->usage_limit)) {
            $totalcoupon = Booking::where('offer_code', $request->offer_code)->where('vendor_id', $request->vendor_id)->count();
            if ($totalcoupon >= $getcoupon->usage_limit) {
                return response()->json(["status" => 0, "message" => trans('Coupon Limit Exceed')], 200);
            }
        }
        $currentdate = date('Y-m-d');
        if ($request->service_price < $getcoupon->min_amount) {
            $min_amount = helper::currency_formate($getcoupon->min_amount, $request->vendor_id);
            return response()->json(["status" => 0, "message" => trans('messages.service_amount_greter_min_amount') . $min_amount], 200);
        } else {
            if ($currentdate > $getcoupon->exp_date) {
                return response()->json(["status" => 0, "message" => trans('messages.coupon_code_expire')], 200);
            } else {
                if ($getcoupon->offer_type == 1) {
                    $offer_amount = $getcoupon->offer_amount;
                } else {
                    $offer_amount = $request->service_price * $getcoupon->offer_amount / 100;
                }
                $arr = array(
                    "offer_code" => $getcoupon->offer_code,
                    "offer_amount" => $offer_amount,
                );
                return response()->json(["status" => 1, "message" => trans('messages.success'),'data'=>$arr], 200);
            }
        }
    }
}