<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use App\Models\Category;
use App\Models\Service;
use App\Models\Promotionalbanner;
use App\Models\User;
use App\helper\helper;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class BannerController extends Controller
{
    public function index()
    {
        if (Auth::user()->type  == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        $getbanner = Banner::where('vendor_id', $vendor_id)->orderBy('reorder_id')->get();
        return view('admin.banner.banner', compact('getbanner'));
    }
    public function add()
    {
        if (Auth::user()->type  == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        $category = Category::where('is_deleted', "2")->where('vendor_id', $vendor_id)->get();
        $service = Service::where('is_deleted', "2")->where('vendor_id', $vendor_id)->get();
        return view('admin.banner.add', compact('category', 'service'));
    }
    public function edit($id)
    {
        if (Auth::user()->type  == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        $category = Category::where('is_deleted', "2")->where('vendor_id', $vendor_id)->get();
        $service = Service::where('is_deleted', "2")->where('vendor_id', $vendor_id)->get();
        $banner = Banner::where('id', $id)->first();
        return view('admin.banner.edit', compact('category', 'service', 'banner'));
    }
    public function save_banner(Request $request)
    {
        if (Auth::user()->type  == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        $request->validate([
            'category' => 'required_if:type,1',
            'service' => 'required_if:type,2',
            'image' => 'max:' . helper::imagesize(),
        ], [
            'category.required_if' => trans('messages.category_required'),
            'service.required_if' => trans('messages.service_required'),
            'image.max' => trans('messages.image_size_message') . ' ' . helper::appdata('')->image_size . ' ' . 'MB',
        ]);
        $banner = new Banner();
        $banner->vendor_id = $vendor_id;
        if ($request->type == "1") {
            $banner->category_id = $request->category;
            $banner->service_id = null;
        }
        if ($request->type == "2") {
            $banner->service_id = $request->service;
            $banner->category_id = null;
        }
        $banner->type = $request->type;
        $banner->section = $request->section;
      
        if ($request->has('image')) {
            $reimage = 'banner-' . uniqid() . "." . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(storage_path('app/public/admin-assets/images/banner/'), $reimage);
            $banner->image = $reimage;
        }
        $banner->save();
        return redirect('admin/bannersection-' . $request->section)->with('success', trans('messages.success'));
    }
    public function edit_banner(Request $request, $id)
    {
        $request->validate([
            'category' => 'required_if:type,1',
            'service' => 'required_if:type,2',
            'image' => 'max:' . helper::imagesize(),
        ], [
            'category.required_if' => trans('messages.category_required'),
            'service.required_if' => trans('messages.service_required'),
            'image.max' => trans('messages.image_size_message') . ' ' . helper::appdata('')->image_size . ' ' . 'MB',
        ]);
        if (Auth::user()->type  == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        $banner = Banner::where('id', $id)->first();
        $banner->vendor_id = $vendor_id;
        if ($request->type == "1") {
            $banner->category_id = $request->category;
            $banner->service_id = null;
        }
        if ($request->type == "2") {
            $banner->service_id = $request->service;
            $banner->category_id = null;
        }
        $banner->type = $request->type;
        $banner->section = $request->section;
      
        if ($request->has('image')) {
            if (file_exists(storage_path('app/public/admin-assets/images/banner/' . $banner->image))) {
                unlink(storage_path('app/public/admin-assets/images/banner/' . $banner->image));
            }
            $reimage = 'banner-' . uniqid() . "." . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(storage_path('app/public/admin-assets/images/banner/'), $reimage);
            $banner->image = $reimage;
        }
        $banner->update();
        return redirect('/admin/bannersection-' . $request->section)->with('success', trans('messages.success'));
    }
    public function status_update($id, $status)
    {
        Banner::where('id', $id)->update(['is_available' => $status]);
        return redirect()->back()->with('success', trans('messages.success'));
    }
    public function delete($id)
    {
        $banner = Banner::where('id', $id)->first();
        if (file_exists(storage_path('app/public/admin-assets/images/banner/' . $banner->image))) {
            unlink(storage_path('app/public/admin-assets/images/banner/' . $banner->image));
        }
        $banner->delete();
        return redirect()->back()->with('success', trans('messages.success'));
    }
    public function bulk_delete(Request $request)
    { 
        foreach ($request->id as $id) {
            $banner = Banner::where('id', $id)->first();
            if (file_exists(storage_path('app/public/admin-assets/images/banners/' . $banner->banner_image))) {
                unlink(storage_path('app/public/admin-assets/images/banners/' . $banner->banner_image));
            }
            $banner->delete();
        }
        return response()->json(['status' => 1, 'msg' => trans('messages.success')], 200);
    }
    public function promotional_banner()
    {
        $getbannerlist = Promotionalbanner::with('vendor_info')->orderBy('reorder_id')->get();
        return view('admin.promotionalbanners.index', compact('getbannerlist'));
    }
    public function promotional_banneradd()
    {
        $vendors = User::where('type', 2)->where('is_available', 1)->where('is_deleted', 2)->get();
        return view('admin.promotionalbanners.add', compact('vendors'));
    }
    public function promotional_bannersave_banner(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'max:' . helper::imagesize(),
        ], [
            'image.max' => trans('messages.image_size_message'),
        ]);
        if ($validator->fails()) {
            return redirect()->back()->with('error', trans('messages.image_size_message') . ' ' . helper::appdata('')->image_size . ' ' . 'MB');
        }
        $banner = new Promotionalbanner();
        if ($request->has('image')) {
            $image = 'promotion-' . uniqid() . "." . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(storage_path('app/public/admin-assets/images/banner/'), $image);
            $banner->image = $image;
        }
        $banner->vendor_id = $request->vendor;
        $banner->save();
        return redirect('admin/promotionalbanners')->with('success', trans('messages.success'));
    }
    public function promotional_banneredit(Request $request)
    {
        $vendors = User::where('is_available', 1)->where('is_verified', 1)->where('type', 2)->get();
        $banner = Promotionalbanner::where('id', $request->id)->first();
        return view('admin.promotionalbanners.edit', compact('vendors', 'banner'));
    }
    public function promotional_bannerupdate(Request $request)
    {
        $banner = Promotionalbanner::where('id', $request->id)->first();
        if ($request->has('image')) {
            $validator = Validator::make($request->all(), [
                'image' => 'max:' . helper::imagesize(),
            ], [
                'image.max' => trans('messages.image_size_message'),
            ]);
            if ($validator->fails()) {
                return redirect()->back()->with('error', trans('messages.image_size_message') . ' ' . helper::appdata('')->image_size . ' ' . 'MB');
            }
            if (file_exists(storage_path('app/public/admin-assets/images/banner/' . $banner->image))) {
                unlink(storage_path('app/public/admin-assets/images/banner/' . $banner->image));
            }
            $image = 'promotion-' . uniqid() . "." . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(storage_path('app/public/admin-assets/images/banner/'), $image);
            $banner->image = $image;
        }
        $banner->vendor_id = $request->vendor;
        $banner->update();
        return redirect('admin/promotionalbanners')->with('success', trans('messages.success'));
    }
    public function promotional_bannerdelete(Request $request)
    {
        $banner = Promotionalbanner::where('id', $request->id)->first();
        if (file_exists(storage_path('app/public/admin-assets/images/banner/' . $banner->image))) {
            unlink(storage_path('app/public/admin-assets/images/banner/' . $banner->image));
        }
        $banner->delete();
        return redirect()->back()->with('success', trans('messages.success'));
    }
    public function promotional_bulkdelete(Request $request)
    {
        foreach ($request->id as $id) {
            $banner = Promotionalbanner::where('id', $id)->first();
            if (file_exists(storage_path('app/public/admin-assets/images/banners/' . $banner->image))) {
                unlink(storage_path('app/public/admin-assets/images/banners/' . $banner->image));
            }
            $banner->delete();
        }
        return response()->json(['status' => 1, 'msg' => trans('messages.success')], 200);

    }
    public function reorder_promotionalbanners(Request $request)
    {
        $getbanners = Promotionalbanner::get();

        foreach ($getbanners as $banners) {
            foreach ($request->order as $order) {
                $banners = Promotionalbanner::where('id', $order['id'])->first();
                $banners->reorder_id = $order['position'];
                $banners->save();
            }
        }
        return response()->json(['status' => 1, 'msg' => trans('messages.success')], 200);
    }
    public function reorder_banner(Request $request)
    {
        if (Auth::user()->type  == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        $getbanners = Banner::where('vendor_id', $vendor_id)->get();
        foreach ($getbanners as $banners) {
            foreach ($request->order as $order) {
                $banners = Banner::where('id', $order['id'])->first();
                $banners->reorder_id = $order['position'];
                $banners->save();
            }
        }
        return response()->json(['status' => 1, 'msg' => trans('messages.success')], 200);
    }
}
