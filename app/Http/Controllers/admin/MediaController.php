<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\helper\helper;
use App\Models\Media;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class MediaController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        if ($request->is('admin/media')) {
            $media = Media::where('vendor_id', $vendor_id)->where('media_use', 1)->orderBy('id', 'DESC')->get();
        } elseif ($request->is('admin/productmedia')) {
            $media = Media::where('vendor_id', $vendor_id)->where('media_use', 2)->orderBy('id', 'DESC')->get();
        }
        return view('admin.media.index', compact("media"));
    }
    public function add_image(Request $request)
    {
        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        $validator = Validator::make($request->all(), [
            'image.*' => 'image|max:' . helper::imagesize() . '|' . helper::imageext(),
        ], [
            'image.max' => trans('messages.image_size_message'),
        ]);
        if ($validator->fails()) {
            return redirect()->back()->with('error', trans('messages.image_size_message') . ' ' . helper::appdata('')->image_size . ' ' . 'MB');
        }
        if ($request->has('image')) {
            if ($request->is('admin/media/add_image')) {
                foreach ($request->file('image') as $file) {
                    $filename = 'service-' . uniqid() . "." . $file->getClientOriginalExtension();
                    $imgname = helper::imageresize($file, storage_path('app/public/admin-assets/images/service/'), $filename);
                    $media = new Media();
                    $media->image = $imgname;
                    $media->vendor_id = $vendor_id;
                    $media->media_use = 1;
                    $media->save();
                }
            } elseif ($request->is('admin/productmedia/add_image')) {
                foreach ($request->file('image') as $file) {
                    $filename = 'product-' . uniqid() . "." . $file->getClientOriginalExtension();
                    $imgname = helper::imageresize($file, storage_path('app/public/admin-assets/images/product/'), $filename);
                    $media = new Media();
                    $media->image = $imgname;
                    $media->vendor_id = $vendor_id;
                    $media->media_use = 2;
                    $media->save();
                }
            }
        }
        return redirect()->back()->with('success', trans('messages.success'));
    }
    public function delete_media(Request $request)
    {
        try {
            $checkproduct = Media::where('id', $request->id)->first();
            if ($request->is('admin/media/*')) {
                if (file_exists(storage_path('app/public/admin-assets/images/service/' . $checkproduct->image))) {
                    unlink(storage_path('app/public/admin-assets/images/service/' . $checkproduct->image));
                }
            } elseif ($request->is('admin/productmedia/*')) {
                if (file_exists(storage_path('app/public/admin-assets/images/product/' . $checkproduct->image))) {
                    unlink(storage_path('app/public/admin-assets/images/product/' . $checkproduct->image));
                }
            }
            Media::where('id', $request->id)->delete();
            return redirect()->back()->with('success', trans('messages.success'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', trans('messages.wrong'));
        }
    }
    public function download(Request $request)
    {
        try {
            $checkproduct = Media::where('id', $request->id)->first();
            if ($request->is('admin/media/*')) {
                $filepath = storage_path('app/public/admin-assets/images/service/') . $checkproduct->image;
            } elseif ($request->is('admin/productmedia/*')) {
                $filepath = storage_path('app/public/admin-assets/images/product/') . $checkproduct->image;
            }
            return Response::download($filepath);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', trans('messages.wrong'));
        }
    }
}
