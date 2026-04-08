<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
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

        if ($request->has('type') && $request->type != "") {
            if ($request->type == "bookings") {
                $getbookings = $getbookings;
            }
            if ($request->type == "processing") {
                $getbookings = $getbookings->whereIn('status_type', array(1, 2));
            }
            if ($request->type == "canceled") {
                $getbookings = $getbookings->where('status_type',  4);
            }

            if ($request->type == "completed") {
                $getbookings = $getbookings->where('status_type', 3);
            }
        }
        if (Auth::user()->type == 4 && Auth::user()->role_type == 1) {
            $totalbooking = Booking::where('vendor_id', $vendor_id)->where('staff_id', Auth::user()->id)->count();
            $totalprocessing = Booking::whereIn('status_type', [1, 2])->where('vendor_id', $vendor_id)->where('staff_id', Auth::user()->id)->count();
            $totalcompleted = Booking::where('status_type', 3)->where('vendor_id', $vendor_id)->where('staff_id', Auth::user()->id)->count();
            $totalcanceled = Booking::where('status_type', 4)->where('vendor_id', $vendor_id)->where('staff_id', Auth::user()->id)->count();
        } else {
            $totalbooking = Booking::where('vendor_id', $vendor_id)->count();
            $totalprocessing = Booking::whereIn('status_type', [1, 2])->where('vendor_id', $vendor_id)->count();
            $totalcompleted = Booking::where('status_type', 3)->where('vendor_id', $vendor_id)->count();
            $totalcanceled = Booking::where('status_type', 4)->where('vendor_id', $vendor_id)->count();
        }

        if (!empty($request->customer_id) && !empty($request->startdate) && !empty($request->enddate)) {
            if (Auth::user()->type == 4 && Auth::user()->role_type == 1) {
                $getbookings = $getbookings->whereBetween('booking_date', [$request->startdate, $request->enddate])->where('staff_id', Auth::user()->id)->where('user_id', $request->customer_id);
                $totalbooking = Booking::where('vendor_id', $vendor_id)->whereBetween('booking_date', [$request->startdate, $request->enddate])->where('staff_id', Auth::user()->id)->where('user_id', $request->customer_id)->count();
                $totalprocessing = Booking::whereIn('status_type', [1, 2])->where('vendor_id', $vendor_id)->whereBetween('booking_date', [$request->startdate, $request->enddate])->where('staff_id', Auth::user()->id)->where('user_id', $request->customer_id)->count();
                $totalcompleted = Booking::where('status_type', 3)->where('vendor_id', $vendor_id)->whereBetween('booking_date', [$request->startdate, $request->enddate])->where('staff_id', Auth::user()->id)->where('user_id', $request->customer_id)->count();
                $totalcanceled = Booking::where('status_type', 4)->where('vendor_id', $vendor_id)->whereBetween('booking_date', [$request->startdate, $request->enddate])->where('staff_id', Auth::user()->id)->where('user_id', $request->customer_id)->count();
            } else {
                $getbookings = $getbookings->whereBetween('booking_date', [$request->startdate, $request->enddate])->where('user_id', $request->customer_id);
                $totalbooking = Booking::where('vendor_id', $vendor_id)->whereBetween('booking_date', [$request->startdate, $request->enddate])->where('user_id', $request->customer_id)->count();
                $totalprocessing = Booking::whereIn('status_type', [1, 2])->where('vendor_id', $vendor_id)->whereBetween('booking_date', [$request->startdate, $request->enddate])->where('user_id', $request->customer_id)->count();
                $totalcompleted = Booking::where('status_type', 3)->where('vendor_id', $vendor_id)->whereBetween('booking_date', [$request->startdate, $request->enddate])->where('user_id', $request->customer_id)->count();
                $totalcanceled = Booking::where('status_type',  4)->where('vendor_id', $vendor_id)->whereBetween('booking_date', [$request->startdate, $request->enddate])->where('user_id', $request->customer_id)->count();
            }
        } else if (!empty($request->startdate) && !empty($request->enddate)) {
            if (Auth::user()->type == 4 && Auth::user()->role_type == 1) {
                $getbookings = $getbookings->whereBetween('booking_date', [$request->startdate, $request->enddate])->where('staff_id', Auth::user()->id);
                $totalbooking = Booking::where('vendor_id', $vendor_id)->whereBetween('booking_date', [$request->startdate, $request->enddate])->where('staff_id', Auth::user()->id)->count();
                $totalprocessing = Booking::whereIn('status_type', [1, 2])->where('vendor_id', $vendor_id)->whereBetween('booking_date', [$request->startdate, $request->enddate])->where('staff_id', Auth::user()->id)->count();
                $totalcompleted = Booking::where('status_type', 3)->where('vendor_id', $vendor_id)->whereBetween('booking_date', [$request->startdate, $request->enddate])->where('staff_id', Auth::user()->id)->count();
                $totalcanceled = Booking::where('status_type', 4)->where('vendor_id', $vendor_id)->whereBetween('booking_date', [$request->startdate, $request->enddate])->where('staff_id', Auth::user()->id)->count();
            } else {
                $getbookings = $getbookings->whereBetween('booking_date', [$request->startdate, $request->enddate]);
                $totalbooking = Booking::where('vendor_id', $vendor_id)->whereBetween('booking_date', [$request->startdate, $request->enddate])->count();
                $totalprocessing = Booking::whereIn('status_type', [1, 2])->where('vendor_id', $vendor_id)->whereBetween('booking_date', [$request->startdate, $request->enddate])->count();
                $totalcompleted = Booking::where('status_type', 3)->where('vendor_id', $vendor_id)->whereBetween('booking_date', [$request->startdate, $request->enddate])->count();
                $totalcanceled = Booking::where('status_type',  4)->where('vendor_id', $vendor_id)->whereBetween('booking_date', [$request->startdate, $request->enddate])->count();
            }
        }
        $getbookings = $getbookings->orderByDesc('id')->get();
        $getcustomerslist = User::where('type', 3)
            ->where('vendor_id', $vendor_id)
            ->where('is_available', 1)
            ->where('is_deleted', 2)
            ->get();
        return view('admin.booking.report', compact('getbookings', 'totalprocessing', 'totalcanceled', 'totalcompleted', 'totalbooking', 'getcustomerslist'));
    }

    public function orderindex(Request $request)
    {
        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        $getorders = Order::where('vendor_id', $vendor_id);

        if ($request->has('type') && $request->type != "") {
            if ($request->type == "processing") {
                $getorders = $getorders->whereIn('status_type', array(1, 2));
            }
            if ($request->type == "cancelled") {
                $getorders = $getorders->where('status_type',  4);
            }

            if ($request->type == "completed") {
                $getorders = $getorders->where('status_type', 3);
            }
        }
        $totalorder = Order::where('vendor_id', $vendor_id)->count();
        $totalprocessing = Order::whereIn('status_type', [1, 2])->where('vendor_id', $vendor_id)->count();
        $totalcompleted = Order::where('status_type', 3)->where('vendor_id', $vendor_id)->count();
        $totalcanceled = Order::where('status_type', 4)->where('vendor_id', $vendor_id)->count();

        if (!empty($request->customer_id) && !empty($request->startdate) && !empty($request->enddate)) {
            $getorders = $getorders->whereBetween('created_at', [$request->startdate, $request->enddate])->where('user_id', $request->customer_id);
            $totalorder = Order::where('vendor_id', $vendor_id)->whereBetween('created_at', [$request->startdate, $request->enddate])->where('user_id', $request->customer_id)->count();
            $totalprocessing = Order::whereIn('status_type', [1, 2])->where('vendor_id', $vendor_id)->whereBetween('created_at', [$request->startdate, $request->enddate])->where('user_id', $request->customer_id)->count();
            $totalcompleted = Order::where('status_type', 3)->where('vendor_id', $vendor_id)->whereBetween('created_at', [$request->startdate, $request->enddate])->where('user_id', $request->customer_id)->count();
            $totalcanceled = Order::where('status_type',  4)->where('vendor_id', $vendor_id)->whereBetween('created_at', [$request->startdate, $request->enddate])->where('user_id', $request->customer_id)->count();
        } else if (!empty($request->startdate) && !empty($request->enddate)) {
            $getorders = $getorders->whereBetween('created_at', [$request->startdate, $request->enddate]);
            $totalorder = Order::where('vendor_id', $vendor_id)->whereBetween('created_at', [$request->startdate, $request->enddate])->count();
            $totalprocessing = Order::whereIn('status_type', [1, 2])->where('vendor_id', $vendor_id)->whereBetween('created_at', [$request->startdate, $request->enddate])->count();
            $totalcompleted = Order::where('status_type', 3)->where('vendor_id', $vendor_id)->whereBetween('created_at', [$request->startdate, $request->enddate])->count();
            $totalcanceled = Order::where('status_type',  4)->where('vendor_id', $vendor_id)->whereBetween('created_at', [$request->startdate, $request->enddate])->count();
        }
        $getorders = $getorders->orderByDesc('id')->get();
        $getcustomerslist = User::where('type', 3)
            ->where('vendor_id', $vendor_id)
            ->where('is_available', 1)
            ->where('is_deleted', 2)
            ->get();
        return view('admin.orders.report', compact('getorders', 'totalprocessing', 'totalcanceled', 'totalcompleted', 'totalorder', 'getcustomerslist'));
    }
}
