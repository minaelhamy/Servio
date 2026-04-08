<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;

class POSController extends Controller
{
    public function index()
    {
        if (Auth::user()->type  == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        $service = Service::with('service_image')->where('vendor_id', $vendor_id)->where('is_deleted', "2")->orderBy('reorder_id')->get();
        return view('admin.product.pos', compact('service'));
    }
}
