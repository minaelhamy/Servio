<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\CustomStatus;
use App\Models\SystemAddons;
use Illuminate\Support\Facades\Auth;
use App\helper\helper;
use App\helper\whatsapp_helper;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Config;

class OrderController extends Controller
{
   public function index(Request $request)
   {
      if (Auth::user()->type == 4) {
         $vendor_id = Auth::user()->vendor_id;
      } else {
         $vendor_id = Auth::user()->id;
      }

      $getorders = Order::where('vendor_id', $vendor_id);
      if (!empty($request->type)) {
         if ($request->type == "processing") {
            $getorders = $getorders->whereIn('status_type', [1, 2]);
         }
         if ($request->type == "completed") {
            $getorders = $getorders->where('status_type', 3);
         }
         if ($request->type == "cancelled") {
            $getorders = $getorders->where('status_type', 4);
         }
      }
      $getorders = $getorders->orderByDesc('id')->get();
      $totalorder = Order::where('vendor_id', $vendor_id)->count();
      $totalprocessing = Order::where('vendor_id', $vendor_id)->whereIn('status_type', [1, 2])->count();
      $totalcanceled = Order::where('vendor_id', $vendor_id)->where('status_type', 4)->count();
      $totalcompleted = Order::where('vendor_id', $vendor_id)->where('status_type', 3)->count();
      return view('admin.orders.orders', compact('getorders', 'totalprocessing', 'totalcompleted', 'totalorder', 'totalcanceled'));
   }

   public function order_invoice(Request $request)
   {
      if (Auth::user()->type == 4) {
         $vendor_id = Auth::user()->vendor_id;
      } else {
         $vendor_id = Auth::user()->id;
      }
      $getorderdata = Order::where('vendor_id', $vendor_id)->where('order_number', $request->order_number)->first();
      $getorderitemlist = OrderDetails::where('order_id', @$getorderdata->id)->get();
      return view('admin.orders.order_tracking', compact('getorderdata', 'getorderitemlist'));
   }

   public function print_invoice(Request $request)
   {
      $getorderdata = Order::where('order_number', $request->order_number)->first();
      $getorderitemlist = OrderDetails::where('order_id', @$getorderdata->id)->get();
      return view('admin.orders.print', compact('getorderdata', 'getorderitemlist'));
   }

   public function status_change(Request $request)
   {
      try {
         if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
         } else {
            $vendor_id = Auth::user()->id;
         }
         $orderdata = Order::where('order_number', $request->order_number)->where('vendor_id', $vendor_id)->first();
         $title = "";
         $message_text = "";
         $defaultsatus = CustomStatus::where('vendor_id', $vendor_id)->where('type', $request->type)->where('id', $request->status)->where('status_use', 2)->where('is_available', 1)->where('is_deleted', 2)->first();
         if (empty($defaultsatus)) {
            return redirect()->back()->with('error', trans('messages.wrong'));
         }
         if ($request->type == "2") {
            $title = trans('labels.order_') . ' ' . $defaultsatus->name;
            $message_text = 'Your Order ' . $orderdata->order_number . ' has been ' . $defaultsatus->name . ' by Admin';
         }
         if ($request->type == "3") {
            $title = trans('labels.order_') . ' ' . $defaultsatus->name;
            $message_text = 'Your Order ' . $orderdata->order_number . ' has been ' . $defaultsatus->name . '.';
         }
         if ($request->type == "4") {
            if ($orderdata->transaction_type == 16) {
               $walletuser = User::where('id', $orderdata->user_id)->first();
               $walletuser->wallet += $orderdata->grand_total;
               $walletuser->save();

               $transaction = new Transaction();
               $transaction->vendor_id = $orderdata->vendor_id;
               $transaction->user_id = $orderdata->user_id;
               $transaction->order_id = $orderdata->id;
               $transaction->payment_id = $orderdata->payment_id;
               $transaction->product_type = 2;
               $transaction->transaction_type = 3;
               $transaction->amount = $orderdata->grand_total;
               $transaction->order_number = $orderdata->order_number;
               $transaction->save();
               if (
                  SystemAddons::where('unique_identifier', 'commission_module')->first() != null &&
                  SystemAddons::where('unique_identifier', 'commission_module')->first()->activated == 1
               ) {
                  $currentbalance = helper::getslug($orderdata->vendor_id)->wallet;

                  $updatebalance = $currentbalance - $orderdata->grand_total;

                  User::where('id', $orderdata->vendor_id)->update(['wallet' => $updatebalance]);
               }
            }
            $title = trans('labels.order_') . ' ' . $defaultsatus->name;
            $message_text = 'Your Order ' . $orderdata->order_number . ' has been ' . $defaultsatus->name . ' by Admin.';
         }
         $vendor = User::select('id', 'name')->where('id', $orderdata->vendor_id)->first();
         $emaildata = helper::emailconfigration($vendor->id);
         Config::set('mail', $emaildata);
         helper::order_status_email($orderdata->user_email, $orderdata->user_name, $title, $message_text, $vendor);
         $orderdata->status = $defaultsatus->id;
         $orderdata->status_type = $defaultsatus->type;
         if (@helper::checkaddons('whatsapp_message')) {
            if (@whatsapp_helper::whatsapp_message_config($vendor_id)->order_status_change == 1) {
               whatsapp_helper::orderstatusupdatemessage($orderdata->order_number, $title, $vendor_id);
            }
         }
         $orderdata->update();
         return redirect()->back()->with('success', trans('messages.success'));
      } catch (\Throwable $th) {
         return $th;
      }
   }
   public function payment_status(Request $request)
   {
      if (Auth::user()->type == 4) {
         $vendor_id = Auth::user()->vendor_id;
      } else {
         $vendor_id = Auth::user()->id;
      }

      $payment_type = $request->payment_type;
      if ($request->ramin_amount > 0) {
         return redirect()->back()->with('error', trans('messages.amount_validation_msg'));
      }
      if ($request->payment_type == "") {
         $payment_type = 1;
      }
      $paymentstatus = Order::where('order_number', $request->order_number)->where('vendor_id', $vendor_id)->first();
      $paymentstatus->payment_status = $request->status;
      $paymentstatus->transaction_type = $payment_type;
      $paymentstatus->update();

      if (
         SystemAddons::where('unique_identifier', 'commission_module')->first() != null &&
         SystemAddons::where('unique_identifier', 'commission_module')->first()->activated == 1
      ) {
         $currentbalance = helper::getslug($vendor_id)->wallet;
         $currentcommission = helper::getslug($vendor_id)->commission;

         $updatebalance = $currentbalance + $paymentstatus->grand_total - @$paymentstatus->commission;
         $updatecommission = $currentcommission + @$paymentstatus->commission;

         User::where('id', $vendor_id)->update(['wallet' => $updatebalance, 'commission' => $updatecommission]);
      }

      return redirect(url()->previous())->with('success', trans('messages.success'));
   }

   public function order_generatepdf(Request $request)
   {
      $getorderdata = Order::where('order_number', $request->order_number)->first();
      $getorderitemlist = OrderDetails::where('order_id', @$getorderdata->id)->get();
      $pdf = Pdf::loadView('admin.orders.invoicepdf', compact('getorderdata', 'getorderitemlist'));
      return $pdf->download('orderinvoice.pdf');
   }

   public function customerinfo(Request $request)
   {
      if (Auth::user()->type == 4) {
         $vendor_id = Auth::user()->vendor_id;
      } else {
         $vendor_id = Auth::user()->id;
      }
      $customerinfo = Order::where('order_number', $request->order_number)->where('vendor_id', $vendor_id)->first();
      if ($request->edit_type == "customer_info") {
         $customerinfo->user_name = $request->customer_name;
         $customerinfo->user_mobile = $request->customer_mobile;
         $customerinfo->user_email = $request->customer_email;
      }
      if ($request->edit_type == "delivery_info") {
         $customerinfo->address = $request->customer_address;
         $customerinfo->city = $request->customer_city;
         $customerinfo->state = $request->customer_state;
         $customerinfo->country = $request->customer_country;
         $customerinfo->landmark = $request->customer_landmark;
         $customerinfo->postal_code = $request->customer_pincode;
      }
      $customerinfo->update();
      return redirect()->back()->with('success', trans('messages.success'));
   }

   public function vendor_note(Request $request)
   {
      if (Auth::user()->type == 4) {
         $vendor_id = Auth::user()->vendor_id;
      } else {
         $vendor_id = Auth::user()->id;
      }
      $updatenote = Order::where('order_number', $request->order_number)->where('vendor_id', $vendor_id)->first();

      $updatenote->vendor_note = $request->vendor_note;
      $updatenote->update();
      return redirect()->back()->with('success', trans('messages.success'));
   }
}
