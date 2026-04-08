<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Service;
use App\Models\User;
use App\Models\CustomStatus;
use App\Models\SystemAddons;
use Illuminate\Support\Facades\Auth;
use App\helper\helper;
use App\helper\whatsapp_helper;
use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Config;

class BookingsController extends Controller
{
   public function index(Request $request)
   {
      if (Auth::user()->type == 4) {
         $vendor_id = Auth::user()->vendor_id;
      } else {
         $vendor_id = Auth::user()->id;
      }
      if (Auth::user()->type == 4 && Auth::user()->role_type == 1) {
         $getbookings = Booking::where('vendor_id', $vendor_id)->where('staff_id', Auth::user()->id);
      } else {
         $getbookings = Booking::where('vendor_id', $vendor_id);
      }
      if (!empty($request->type)) {
         if ($request->type == "bookings") {
            $getbookings = $getbookings;
         }
         if ($request->type == "canceled") {
            $getbookings = $getbookings->where('status_type', 4);
         }
         if ($request->type == "processing") {
            $getbookings = $getbookings->whereIn('status_type', [1, 2]);
         }
         if ($request->type == "completed") {
            $getbookings = $getbookings->where('status_type', 3);
         }
      }
      $getbookings = $getbookings->orderByDesc('id')->get();
      if (Auth::user()->type == 4 && Auth::user()->role_type == 1) {
         $totalbooking = Booking::where('vendor_id', $vendor_id)->where('staff_id', Auth::user()->id)->count();
         $totalprocessing = Booking::where('vendor_id', $vendor_id)->where('staff_id', Auth::user()->id)->whereIn('status_type', [1, 2])->count();
         $totalcanceled = Booking::where('vendor_id', $vendor_id)->where('staff_id', Auth::user()->id)->where('status_type', 4)->count();
         $totalcompleted = Booking::where('vendor_id', $vendor_id)->where('staff_id', Auth::user()->id)->where('status_type', 3)->count();
      } else {
         $totalbooking = Booking::where('vendor_id', $vendor_id)->count();
         $totalprocessing = Booking::where('vendor_id', $vendor_id)->whereIn('status_type', [1, 2])->count();
         $totalcanceled = Booking::where('vendor_id', $vendor_id)->where('status_type', 4)->count();
         $totalcompleted = Booking::where('vendor_id', $vendor_id)->where('status_type', 3)->count();
      }

      return view('admin.booking.bookings', compact('getbookings', 'totalprocessing', 'totalcompleted', 'totalbooking', 'totalcanceled'));
   }
   public function booking_invoice(Request $request)
   {

      if (Auth::user()->type == 4) {
         $vendor_id = Auth::user()->vendor_id;
      } else {
         $vendor_id = Auth::user()->id;
      }
      $invoice = Booking::where('booking_number', $request->booking_number)->where('vendor_id', $request->vendor_id)->first();
      $service = Service::where('id', $invoice->service_id)->first();
      $staff_assign = $service->staff_id != null && $service->staff_id != "" ? 1 : 2;
      $getstaflist = User::where('type', 4)->where('vendor_id', $vendor_id)->whereIn('id', explode('|', $service->staff_id))->where('is_available', 1)->get();
      return view('admin.booking.booking_tracking', compact('invoice', 'getstaflist', 'staff_assign'));
   }
   public function status_change(Request $request)
   {

      try {
         if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
         } else {
            $vendor_id = Auth::user()->id;
         }
         $bookingdata = Booking::where('booking_number', $request->booking_number)->where('vendor_id', $vendor_id)->first();
         $title = "";
         $message_text = "";
         $defaultsatus = CustomStatus::where('vendor_id', $vendor_id)->where('type', $request->type)->where('id', $request->status)->where('status_use', 1)->where('is_available', 1)->where('is_deleted', 2)->first();
         if (empty($defaultsatus)) {
            return redirect()->back()->with('error', trans('messages.wrong'));
         }
         if ($request->type == "2") {
            $title = trans('labels.booking') . ' ' . $defaultsatus->name;
            $message_text = 'Your Booking ' . $bookingdata->booking_number . ' has been ' . $defaultsatus->name . ' by Admin';
         }
         if ($request->type == "3") {
            $title = trans('labels.booking') . ' ' . $defaultsatus->name;
            $message_text = 'Your Booking ' . $bookingdata->booking_number . ' has been ' . $defaultsatus->name . '.';
         }
         if ($request->type == "4") {
            if ($bookingdata->transaction_type == 16) {
               $walletuser = User::where('id', $bookingdata->user_id)->first();
               $walletuser->wallet += $bookingdata->grand_total;
               $walletuser->save();

               $transaction = new Transaction();
               $transaction->vendor_id = $bookingdata->vendor_id;
               $transaction->user_id = $bookingdata->user_id;
               $transaction->order_id = $bookingdata->id;
               $transaction->payment_id = $bookingdata->payment_id;
               $transaction->product_type = 1;
               $transaction->transaction_type = 3;
               $transaction->amount = $bookingdata->grand_total;
               $transaction->order_number = $bookingdata->booking_number;
               $transaction->save();
               if (
                  SystemAddons::where('unique_identifier', 'commission_module')->first() != null &&
                  SystemAddons::where('unique_identifier', 'commission_module')->first()->activated == 1
               ) {
                  $currentbalance = helper::getslug($bookingdata->vendor_id)->wallet;

                  $updatebalance = $currentbalance - $bookingdata->grand_total;

                  User::where('id', $bookingdata->vendor_id)->update(['wallet' => $updatebalance]);
               }
            }
            $title = trans('labels.booking') . ' ' . $defaultsatus->name;
            $message_text = 'Your Booking ' . $bookingdata->booking_number . ' has been ' . $defaultsatus->name . ' by Admin.';
         }
         $vendor = User::select('id', 'name')->where('id', $bookingdata->vendor_id)->first();
         $emaildata = helper::emailconfigration($vendor->id);
         Config::set('mail', $emaildata);
         $checkmail = helper::booking_status_email($bookingdata->email, $bookingdata->customer_name, $title, $message_text, $vendor);
         $bookingdata->status = $defaultsatus->id;
         $bookingdata->status_type = $defaultsatus->type;

         if (@helper::checkaddons('whatsapp_message')) {
            if (@whatsapp_helper::whatsapp_message_config($vendor_id)->status_change == 1) {
               whatsapp_helper::bookingstatusupdatemessage($bookingdata->booking_number, $title, $vendor_id);
            }
         }
         $bookingdata->update();
         return redirect()->back()->with('success', trans('messages.success'));
      } catch (\Throwable $th) {
         dd($th);
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
      $paymentstatus = Booking::where('booking_number', $request->booking_number)->where('vendor_id', $vendor_id)->first();
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
   public function generatepdf(Request $request)
   {
      $getorderdata = Booking::where('booking_number', $request->booking_number)->where('vendor_id', $request->vendor_id)->first();
      $pdf = Pdf::loadView('admin.booking.invoicepdf', ['getorderdata' => $getorderdata]);
      // return view('admin.booking.invoicepdf', compact('getorderdata'));
      return $pdf->download('bookinginvoice.pdf');
   }
   public function staff_member(Request $request)
   {
      try {
         $booking = Booking::where('booking_number', $request->booking_number)->where('vendor_id', $request->vendor_id)->first();
         if ($request->staff_id != "" && $request->staff_id != null) {
            $checkbooking = Booking::where('staff_id', $request->staff_id)->where('booking_time', $booking->booking_time)->where('booking_endtime', $booking->booking_endtime)->where('booking_date', $booking->booking_date)->whereNotIn('status', [3, 4, 5])->get();
            if ($checkbooking->count() > 0) {
               return response()->json(['status' => 0, 'message' => trans('messages.staff_booked_message')], 200);
            }
         }

         $booking->staff_id = $request->staff_id;
         $booking->update();
         return response()->json(['status' => 1, 'message' => trans('messages.success')], 200);
      } catch (\Throwable $th) {
         return response()->json(['status' => 0, 'message' => trans('messages.wrong')], 200);
      }
   }
   public function customerinfo(Request $request)
   {
      if (Auth::user()->type == 4) {
         $vendor_id = Auth::user()->vendor_id;
      } else {
         $vendor_id = Auth::user()->id;
      }
      $customerinfo = Booking::where('booking_number', $request->order_id)->where('vendor_id', $vendor_id)->first();
      if ($request->edit_type == "customer_info") {
         $customerinfo->customer_name = $request->customer_name;
         $customerinfo->mobile = $request->customer_mobile;
         $customerinfo->email = $request->customer_email;
      }
      if ($request->edit_type == "delivery_info") {
         $customerinfo->address = $request->customer_address;
         $customerinfo->city = $request->customer_city;
         $customerinfo->state = $request->customer_state;
         $customerinfo->country = $request->customer_country;
         $customerinfo->landmark = $request->customer_landmark;
         $customerinfo->postalcode = $request->customer_pincode;
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
      $updatenote = Booking::where('booking_number', $request->order_id)->where('vendor_id', $vendor_id)->first();

      $updatenote->vendor_note = $request->vendor_note;
      $updatenote->update();
      return redirect()->back()->with('success', trans('messages.success'));
   }
}
