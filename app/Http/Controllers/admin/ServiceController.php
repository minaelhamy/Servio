<?php

namespace App\Http\Controllers\admin;

use App\helper\helper;
use App\Http\Controllers\Controller;
use App\Models\AdditionalService;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Service;
use App\Models\ServiceImage;
use App\Models\User;
use App\Models\Tax;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Models\Testimonials;
use App\Models\Timing;
use App\Models\Banner;
use Spatie\FlareClient\FlareMiddleware\AddDocumentationLinks;

class ServiceController extends Controller
{
    public function index()
    {
        if (Auth::user()->type  == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        $service = Service::with('service_image')->where('vendor_id', $vendor_id)->where('is_deleted', "2")->orderBy('reorder_id')->get();
        return view('admin.service.service', compact('service'));
    }
    public function add()
    {
        if (Auth::user()->type  == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        $checkplan = helper::checkplan($vendor_id, "");
        $v = json_decode(json_encode($checkplan));
        if (@$v->original->status == 2) {
            return redirect()->back()->with('error', @$v->original->message);
        }
        $category = Category::where('is_deleted', "2")->where('is_available', 1)->where('vendor_id', $vendor_id)->orderBy('reorder_id')->get();
        $getstaflist = User::where('type', 4)->where('vendor_id', $vendor_id)->where('is_available', 1)->where('role_type', 1)->orderBy('reorder_id')->get();
        $gettaxlist = Tax::where('vendor_id', $vendor_id)->where('is_deleted', 2)->where('is_available', 1)->orderBy('reorder_id')->get();
        return view('admin.service.add_service', compact("category", 'getstaflist', 'gettaxlist'));
    }
    public function save(Request $request)
    {
        if (Auth::user()->type  == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        $checkplan = helper::checkplan($vendor_id, "");
        $v = json_decode(json_encode($checkplan));
        if (@$v->original->status == 2) {
            return redirect()->back()->with('error', $v->original->message);
        }
        $check_slug = Service::where('slug', Str::slug($request->service_name, '-'))->first();
        if (!empty($check_slug)) {
            $last_id = Service::select('id')->orderByDesc('id')->first();
            $slug = Str::slug($request->service_name . ' ' . $last_id->id, '-');
        } else {
            $slug = Str::slug($request->service_name, '-');
        }
        $saveservice = new Service();
        $saveservice->vendor_id = $vendor_id;
        $saveservice->category_id = implode('|', $request->category_name);
        $saveservice->name = $request->service_name;
        $saveservice->slug = $slug;
        $saveservice->price = $request->price;
        $saveservice->original_price = $request->original_price;
        $saveservice->discount_percentage = $request->original_price > 0 ? number_format(100 - ($request->price * 100) / $request->original_price, 1) : 0;
        $saveservice->tax = $request->tax != "" && $request->tax != null ? implode('|', $request->tax) : '';
        $saveservice->description = $request->description;
        $saveservice->interval_time = $request->interval_time;
        $saveservice->interval_type = $request->interval_type;
        $saveservice->per_slot_limit = $request->slot_limit;
        $saveservice->video_url = $request->video_url;
        $saveservice->additional_services = $request->additional_services;
        if (isset($request->staff_assign)) {
            $saveservice->staff_id =   $request->staff != null &&  $request->staff != "" ? implode('|', $request->staff) : '';
        } else {
            $saveservice->staff_id =  '';
        }
        $saveservice->staff_assign = isset($request->staff_assign) ? 1 : 2;
        if ($saveservice->save()) {
            if ($request->additional_services == 1 && $request->additional_service_name != "") {
                foreach ($request->additional_service_name as $key => $no) {
                    if (@$no != "" && @$request->additional_service_price[$key] != "" && @$request->additional_service_image[$key] != "") {
                        $additional_service = new AdditionalService();
                        $additional_service->service_id = $saveservice->id;
                        $additional_service->name = $no;
                        $additional_service->price = $request->additional_service_price[$key];

                        $image = 'additional_service-' . uniqid() . "." . $request->additional_service_image[$key]->getClientOriginalExtension();
                        $request->additional_service_image[$key]->move(storage_path('app/public/admin-assets/images/additional_service/'), $image);
                        $additional_service->image = $image;

                        $additional_service->save();
                    }
                }
            }
        }
        if ($request->has('service_image')) {
            $validator = Validator::make($request->all(), [
                'service_image.*' => 'image|max:' . helper::imagesize() . '|' . helper::imageext(),
            ]);
            if ($validator->fails()) {
                return redirect()->back()->with('error', trans('messages.image_size_message') . ' ' . helper::appdata('')->image_size . ' ' . 'MB');
            }
            foreach ($request->file('service_image') as $file) {
                $reimage = 'service-' . uniqid() . "." . $file->getClientOriginalExtension();
                $file->move(storage_path('app/public/admin-assets/images/service/'), $reimage);
                $image = new ServiceImage();
                $image->service_id = $saveservice->id;
                $image->image = $reimage;
                $image->is_imported = 2;
                $image->save();
            }
        }
        $days = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];
        foreach ($days as $day) {
            $time = Timing::where('vendor_id', $vendor_id)->where('day', $day)->first();
            $timedata = new Timing;
            $timedata->vendor_id = $vendor_id;
            $timedata->day = $day;
            $timedata->open_time = $time->open_time;
            $timedata->break_start = $time->break_start;
            $timedata->break_end = $time->break_end;
            $timedata->close_time = $time->close_time;
            $timedata->is_always_close = '2';
            $timedata->service_id = $saveservice->id;
            $timedata->save();
        }
        return redirect('/admin/services/')->with('success', trans('messages.success'));
    }
    public function edit($slug)
    {
        if (Auth::user()->type  == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        $category = Category::where('is_deleted', "2")->where('is_available', 1)->where('vendor_id', $vendor_id)->get();
        $service = Service::with('multi_image', 'additional_service')->where('slug', $slug)->where('vendor_id', $vendor_id)->orderBy('reorder_id')->first();
        $servicereview = Testimonials::with('user_info')->where('service_id', $service->id)->where('vendor_id', $vendor_id)->orderBy('reorder_id')->get();
        $getstaflist = User::where('type', 4)->where('vendor_id', $vendor_id)->where('is_available', 1)->where('role_type', 1)->orderBy('reorder_id')->get();
        $gettaxlist = Tax::where('vendor_id', $vendor_id)->where('is_deleted', 2)->where('is_available', 1)->orderBy('reorder_id')->get();
        $timingdata = Timing::where('vendor_id', $vendor_id)->where('service_id', $service->id)->get();
        $additional_service = AdditionalService::where('service_id', $service->id)->get();
        if ($timingdata->count() == 0) {
            $timingdata = Timing::where('vendor_id', $vendor_id)->get();
        }
        return view('admin.service.edit_service', compact('service', 'category', 'servicereview', 'getstaflist', 'gettaxlist', 'timingdata', 'additional_service'));
    }
    public function update_service(Request $request, $slug)
    {
        try {
            $service = Service::where('slug', $slug)->first();
            $service->category_id =  implode('|', $request->category_name);
            $service->name = $request->service_name;
            $service->price = $request->price;
            $service->original_price = $request->original_price;
            $service->discount_percentage = $request->original_price > 0 ? number_format(100 - ($request->price * 100) / $request->original_price, 1) : 0;
            $service->tax = $request->tax != "" && $request->tax != null ? implode('|', $request->tax) : '';
            $service->description = $request->description;
            $service->interval_time = $request->interval_time;
            $service->interval_type = $request->interval_type;
            $service->per_slot_limit = $request->slot_limit;
            $service->video_url = $request->video_url;
            $service->additional_services = $request->additional_services;
            if (isset($request->staff_assign)) {
                $service->staff_id =  $request->staff != null && $request->staff != "" ? implode('|', $request->staff) : '';
            } else {
                $service->staff_id =  '';
            }
            $service->staff_assign = isset($request->staff_assign) ? 1 : 2;
            $service->update();
            if ($request->additional_services == 1 && $request->additional_service_name != "") {
                $additional_service_id = $request->additional_service_id;
                foreach ($request->additional_service_name as $key => $no) {
                    if (@$additional_service_id[$key] == "") {
                        if (@$no != "" && @$request->additional_service_price[$key] != "" && @$request->additional_service_image[$key] != "") {
                            $additional_service = new AdditionalService();
                            $additional_service->service_id = $service->id;
                            $additional_service->name = $no;
                            $additional_service->price = $request->additional_service_price[$key];

                            $image = 'additional_service-' . uniqid() . "." . $request->additional_service_image[$key]->getClientOriginalExtension();
                            $request->additional_service_image[$key]->move(storage_path('app/public/admin-assets/images/additional_service/'), $image);
                            $additional_service->image = $image;

                            $additional_service->save();
                        }
                    } else if (@$additional_service_id[$key] != "") {
                        $additional_service = AdditionalService::where('id', @$additional_service_id[$key])->first();
                        if (!empty($request->additional_service_image[$key])) {

                            $image = 'additional_service-' . uniqid() . "." . $request->additional_service_image[$key]->getClientOriginalExtension();
                            if (file_exists(storage_path('app/public/admin-assets/images/additional_service/' . $additional_service->image))) {
                                unlink(storage_path('app/public/admin-assets/images/additional_service/' .  $additional_service->image));
                            }
                            $request->additional_service_image[$key]->move(storage_path('app/public/admin-assets/images/additional_service/'), $image);
                            $additional_service->image = $image;
                        }
                        $additional_service->name = $no;
                        $additional_service->price = $request->additional_service_price[$key];
                        $additional_service->save();
                    }
                }
            }
            if ($request->additional_services == 2) {

                $additional_service = AdditionalService::where('service_id', $service->id)->get();
                foreach ($additional_service as $image) {
                    if (file_exists(storage_path('app/public/admin-assets/images/additional_service/' . $image->image))) {
                        unlink(storage_path('app/public/admin-assets/images/additional_service/' .  $image->image));
                    }
                    $image->delete();
                }
            }
            return redirect('admin/services')->with('success', trans('messages.success'));
        } catch (\Throwable $th) {
            dd($th);
            return redirect()->back()->with('error', trans('messages.wrong'));
        }
    }
    public function update_image(Request $request)
    {
        if ($request->has('service_image')) {
            $validator = Validator::make($request->all(), [
                'service_image' => 'image|max:' . helper::imagesize() . '|' . helper::imageext(),
            ], [
                'service_image.max' => trans('messages.image_size_message'),
            ]);
            if ($validator->fails()) {
                return redirect()->back()->with('error', trans('messages.image_size_message') . ' ' . helper::appdata('')->image_size . ' ' . 'MB');
            }
            $image =  ServiceImage::where('id', $request->id)->first();
            if ($image->is_imported == 2) {
                if (file_exists(storage_path('app/public/admin-assets/images/service/' . $request->image))) {
                    unlink(storage_path('app/public/admin-assets/images/service/' .  $request->image));
                }
            }
            $serviceimage = 'service-' . uniqid() . "." . $request->file('service_image')->getClientOriginalExtension();
            $request->file('service_image')->move(storage_path('app/public/admin-assets/images/service/'), $serviceimage);
            $image->image = $serviceimage;
            $image->is_imported = 2;
            $image->update();
            return redirect()->back()->with('success', trans('messages.success'));
        } else {
            return redirect()->back()->with('error', trans('messages.wrong'));
        }
    }
    public function delete_service($slug)
    {
        if (Auth::user()->type  == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        try {
            $checkservice = Service::where('slug', $slug)->where('vendor_id', $vendor_id)->first();
            $serviceimage = ServiceImage::where('service_id', $checkservice->id)->get();
            $getbanner = Banner::where('service_id', $checkservice->id)->where('vendor_id', $checkservice->vendor_id)->get();
            $additional_service = AdditionalService::where('service_id', $checkservice->id)->delete();
            Testimonials::where('service_id', $checkservice->id)->where('vendor_id', $checkservice->vendor_id)->delete();
            foreach ($getbanner as $banner) {
                $banner->type = "";
                $banner->service_id = "";
                $banner->update();
            }
            foreach ($serviceimage as $image) {
                if ($image->is_imported == 2) {
                    if ($image->image != "" && $image->image != null && file_exists(storage_path('app/public/admin-assets/images/service/' . $image->image))) {
                        unlink(storage_path('app/public/admin-assets/images/service/' . $image->image));
                    }
                }
                $image->delete();
            }
            $checkservice->delete();

            return redirect()->back()->with('success', trans('messages.success'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', trans('messages.wrong'));
        }
    }public function bulk_delete_service(Request $request)
    {
        if (Auth::user()->type  == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        try {
            foreach ($request->id as $id) {
                $checkservice = Service::where('id', $id)->where('vendor_id', $vendor_id)->first();
                $serviceimage = ServiceImage::where('service_id', $checkservice->id)->get();
                $getbanner = Banner::where('service_id', $checkservice->id)->where('vendor_id', $checkservice->vendor_id)->get();
                $additional_service = AdditionalService::where('service_id', $checkservice->id)->delete();
                Testimonials::where('service_id', $checkservice->id)->where('vendor_id', $checkservice->vendor_id)->delete();
                foreach ($getbanner as $banner) {
                    $banner->type = "";
                    $banner->service_id = "";
                    $banner->update();
                }
                foreach ($serviceimage as $image) {
                    if ($image->is_imported == 2) {
                        if ($image->image != "" && $image->image != null && file_exists(storage_path('app/public/admin-assets/images/service/' . $image->image))) {
                            unlink(storage_path('app/public/admin-assets/images/service/' . $image->image));
                        }
                    }
                    $image->delete();
                }
                $checkservice->delete();
            }
           return response()->json(['status' => 1, 'msg' => trans('messages.success')], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => 0, 'msg' => trans('messages.wrong')], 200);
        }
    }
    
    public function delete_image($id, $service_id)
    {
        $count = ServiceImage::where('service_id', $service_id)->count();
        if ($count > 1) {
            $image = ServiceImage::where('id', $id)->first();
            if ($image->is_imported == 2) {
                if ($image->image != "" && $image->image != null && file_exists(storage_path('app/public/admin-assets/images/service/' . $image->image))) {
                    unlink(storage_path('app/public/admin-assets/images/service/' . $image->image));
                }
            }
            $image->delete();
            return redirect()->back()->with('success', trans('messages.success'));
        } else {
            return redirect()->back()->with('error', trans('messages.last_image'));
        }
    }
    public function add_image(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image.*' => 'image|max:' . helper::imagesize() . '|' . helper::imageext(),
        ], [
            'image.max' => trans('messages.image_size_message'),
        ]);
        if ($validator->fails()) {
            return redirect()->back()->with('error', trans('messages.image_size_message') . ' ' . helper::appdata('')->image_size . ' ' . 'MB');
        } else {
            if ($request->has('image')) {
                foreach ($request->file('image') as $file) {
                    $reimage = 'service-' . uniqid() . "." . $file->getClientOriginalExtension();
                    $file->move(storage_path('app/public/admin-assets/images/service/'), $reimage);
                    $serviceimage = new ServiceImage();
                    $serviceimage->service_id = $request->service_id;
                    $serviceimage->is_imported = 2;
                    $serviceimage->image = $reimage;
                    $serviceimage->save();
                }
            }
            return redirect()->back()->with('success', trans('messages.success'));
        }
    }
    public function status_change($slug, $status)
    {
        if (Auth::user()->type  == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        Service::where('slug', $slug)->where('vendor_id', $vendor_id)->update(['is_available' => $status]);
        return redirect('/admin/services')->with('success', trans('messages.success'));
    }
    public function reorder_service(Request $request)
    {
        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        $getservices = Service::where('vendor_id', $vendor_id)->get();
        foreach ($getservices as $service) {
            foreach ($request->order as $order) {
                $service = Service::where('id', $order['id'])->first();
                $service->reorder_id = $order['position'];
                $service->save();
            }
        }
        return response()->json(['status' => 1, 'msg' => trans('messages.success')], 200);
    }
    public function review_delete(Request $request)
    {
        $deletereview = Testimonials::where('id', $request->id)->first();
        $deletereview->delete();
        return redirect()->back()->with('success', trans('messages.success'));
    }
    public function reorder_image(Request $request)
    {
        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        $getservice = ServiceImage::where('service_id', $request->item_id)->get();
        $arr = explode('|', $request->input('ids'));
        foreach ($arr as $sortOrder => $id) {
            if ($id != "" && $id != null) {
                $menu = ServiceImage::find($id);
                $menu->reorder_id = $sortOrder;
                $menu->save();
            }
        }
        return response()->json(['status' => 1, 'msg' => trans('messages.success')], 200);
    }
    public function update_working_hours(Request $request)
    {
        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        $day = $request->day;
        $open_time = $request->open_time;
        $close_time = $request->close_time;
        $break_start = $request->break_start;
        $break_end = $request->break_end;
        $is_always_close = $request->is_always_close;
        foreach ($day as $key => $no) {
            $timing = Timing::where('service_id', $request->service_id)->where('vendor_id', $vendor_id)->where('day', $no)->get();
            if ($timing->count() == 0) {
                $time = new Timing();
                $time->service_id = $request->service_id;
                $time->vendor_id = $vendor_id;
                $time->day = $no;
                if ($is_always_close[$key] == "2") {
                    if ($open_time[$key] == "Closed") {
                        $time->open_time = "12:00 AM";
                    } else {
                        $time->open_time = $open_time[$key];
                    }
                } else {
                    $time->open_time = "12:00 AM";
                }
                if ($is_always_close[$key] == "2") {
                    if ($break_start[$key] == "Closed") {
                        $time->break_start = "12:00 AM";
                    } else {
                        $time->break_start = $break_start[$key];
                    }
                } else {
                    $time->break_start = "12:00 AM";
                }
                if ($is_always_close[$key] == "2") {
                    if ($break_end[$key] == "Closed") {
                        $time->break_end = "12:00 AM";
                    } else {
                        $time->break_end  = $break_end[$key];
                    }
                } else {
                    $time->break_end  = "12:00 AM";
                }
                if ($is_always_close[$key] == "2") {
                    if ($close_time[$key] == "Closed") {
                        $time->close_time = "11:59 PM";
                    } else {
                        $time->close_time = $close_time[$key];
                    }
                } else {
                    $time->close_time = "11:59 PM";
                }
                $time->is_always_close = $is_always_close[$key];
                $time->save();
            } else {
                $input['service_id'] = $request->service_id;
                $input['day'] = $no;
                if ($is_always_close[$key] == "2") {
                    if ($open_time[$key] == "Closed") {
                        $input['open_time'] = "12:00 AM";
                    } else {
                        $input['open_time'] = $open_time[$key];
                    }
                } else {
                    $input['open_time'] = "12:00 AM";
                }

                if ($is_always_close[$key] == "2") {
                    if ($break_start[$key] == "Closed") {
                        $input['break_start'] = "12:00 AM";
                    } else {
                        $input['break_start'] = $break_start[$key];
                    }
                } else {
                    $input['break_start'] = "12:00 AM";
                }
                if ($is_always_close[$key] == "2") {
                    if ($break_end[$key] == "Closed") {
                        $input['break_end'] = "12:00 AM";
                    } else {
                        $input['break_end'] = $break_end[$key];
                    }
                } else {
                    $input['break_end'] = "12:00 AM";
                }
                if ($is_always_close[$key] == "2") {
                    if ($close_time[$key] == "Closed") {
                        $input['close_time'] = "11:59 PM";
                    } else {
                        $input['close_time'] = $close_time[$key];
                    }
                } else {
                    $input['close_time'] = "11:59 PM";
                }
                $input['is_always_close'] = $is_always_close[$key];
                Timing::where('vendor_id', $vendor_id)->where('day', $no)->where('service_id', $request->service_id)->update($input);
            }
        }

        return redirect()->back()->with('success', trans('messages.success'));
    }


    public function deleteadditional($id)
    {
        if (Auth::user()->type  == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        try {

            $additional_service = AdditionalService::where('id', $id)->first();
            if (file_exists(storage_path('app/public/admin-assets/images/additional_service/' . $additional_service->image))) {
                unlink(storage_path('app/public/admin-assets/images/additional_service/' .  $additional_service->image));
            }
            $additional_service->delete();
            return redirect()->back()->with('success', trans('messages.success'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', trans('messages.wrong'));
        }
    }
}
