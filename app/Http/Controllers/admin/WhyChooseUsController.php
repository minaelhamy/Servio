<?php
namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Settings;
use App\Models\WhyChooseUs;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\helper\helper;
class WhyChooseUsController extends Controller
{
    public function index(Request $request)
    {
        if(Auth::user()->type == 4)
        {
            $vendor_id = Auth::user()->vendor_id;
        }else{
            $vendor_id = Auth::user()->id;
        }
        $content = Settings::where('vendor_id',$vendor_id)->first();
        $allworkcontent = WhyChooseUs::where('vendor_id',$vendor_id)->orderBy('reorder_id')->get();
        return view('admin.why_choose_us.index',compact('content','allworkcontent'));
    }
    public function savecontent(Request $request)
    {
        if(Auth::user()->type == 4)
        {
            $vendor_id = Auth::user()->vendor_id;
        }else{
            $vendor_id = Auth::user()->id;
        }
      
       
        $newcontent = Settings::where('vendor_id',$vendor_id)->first();
        $newcontent->why_choose_title = $request->title;
        $newcontent->why_choose_subtitle = $request->subtitle;
        if ($request->has('image')) {
            $validator = Validator::make($request->all(), [
                'image' => 'image|max:'.helper::imagesize().'|'.helper::imageext(),
            ], [
                'image.max' => trans('messages.image_size_message'),
            ]);
            if ($validator->fails()) {
                return redirect()->back()->with('error', trans('messages.image_size_message') . ' ' . helper::appdata('')->image_size . ' ' . 'MB');
            }
            if($newcontent->why_choose_image != null || $newcontent->why_choose_image !="")
            {
                if (file_exists(storage_path('app/public/admin-assets/images/index/' .  $newcontent->why_choose_image))) {
                    unlink(storage_path('app/public/admin-assets/images/index/' .  $newcontent->why_choose_image));
                }
            } 
            $image = 'choose-' . uniqid() . "." . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(storage_path('app/public/admin-assets/images/index/'), $image);
            $newcontent->why_choose_image = $image;
        }
        $newcontent->save();
        return redirect('admin/choose_us')->with('success', trans('messages.success'));
    }
    public function add(Request $request)
    {
        return view('admin.why_choose_us.add');
    }
    public function save(Request $request)
    {
        if(Auth::user()->type == 4)
        {
            $vendor_id = Auth::user()->vendor_id;
        }else{
            $vendor_id = Auth::user()->id;
        }
       
        $newwork = new WhyChooseUs();
        $newwork->vendor_id = $vendor_id;
        $newwork->title = $request->title;
        $newwork->description = $request->description;
        if ($request->has('image')) {
            $validator = Validator::make($request->all(), [
                'image' => 'image|max:'.helper::imagesize().'|'.helper::imageext(),
            ], [
                'image.max' => trans('messages.image_size_message'),
            ]);
            if ($validator->fails()) {
                return redirect()->back()->with('error', trans('messages.image_size_message') . ' ' . helper::appdata('')->image_size . ' ' . 'MB');
            }
            $image = 'choose-' . uniqid() . "." . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(storage_path('app/public/admin-assets/images/index/'), $image);
            $newwork->image = $image;
        }
        $newwork->save();
        return redirect('admin/choose_us')->with('success', trans('messages.success'));
    }
    public function edit(Request $request)
    {
        if(Auth::user()->type == 4)
        {
            $vendor_id = Auth::user()->vendor_id;
        }else{
            $vendor_id = Auth::user()->id;
        }
        $editwork = WhyChooseUs::where('id',$request->id)->where('vendor_id', $vendor_id)->first();
        return view('admin.why_choose_us.edit',compact('editwork'));
    }
    public function update(Request $request)
    {
        if(Auth::user()->type == 4)
        {
            $vendor_id = Auth::user()->vendor_id;
        }else{
            $vendor_id = Auth::user()->id;
        }
        $editwork = WhyChooseUs::where('id',$request->id)->where('vendor_id', $vendor_id)->first();
        if ($request->has('image')) {
            if($editwork->image != null || $editwork->image !="")
            {
                $validator = Validator::make($request->all(), [
                    'image' => 'image|max:'.helper::imagesize().'|'.helper::imageext(),
                ], [
                    'image.max' => trans('messages.image_size_message'),
                ]);
                if ($validator->fails()) {
                    return redirect()->back()->with('error', trans('messages.image_size_message') . ' ' . helper::appdata('')->image_size . ' ' . 'MB');
                }
                if (file_exists(storage_path('app/public/admin-assets/images/index/' .  $editwork->image))) {
                    unlink(storage_path('app/public/admin-assets/images/index/' .  $editwork->image));
                }
            } 
            $image = 'choose-' . uniqid() . "." . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(storage_path('app/public/admin-assets/images/index/'), $image);
            $editwork->image = $image;
        }
        $editwork->title = $request->title;
        $editwork->description = $request->description;
        $editwork->update();
        return redirect('admin/choose_us')->with('success', trans('messages.success'));
    }
    public function delete(Request $request)
    {
        if(Auth::user()->type == 4)
        {
            $vendor_id = Auth::user()->vendor_id;
        }else{
            $vendor_id = Auth::user()->id;
        }
        $deletework = WhyChooseUs::where('id',$request->id)->where('vendor_id', $vendor_id)->first();
        if (file_exists(storage_path('app/public/admin-assets/images/index/' .  $deletework->image))) {
            unlink(storage_path('app/public/admin-assets/images/index/' .  $deletework->image));
        }
        $deletework->delete();
        return redirect('admin/choose_us')->with('success', trans('messages.success'));
    }
    public function reorder_choose_us(Request $request)
    {
        if(Auth::user()->type == 4)
        {
            $vendor_id = Auth::user()->vendor_id;
        }else{
            $vendor_id = Auth::user()->id;
        }
        $getchooseus = WhyChooseUs::where('vendor_id',$vendor_id)->get();
        foreach ($getchooseus as $chooseus) {
            foreach ($request->order as $order) {
               $chooseus = WhyChooseUs::where('id',$order['id'])->first();
               $chooseus->reorder_id = $order['position'];
               $chooseus->save();
            }
        }
        return response()->json(['status' => 1,'msg' => trans('messages.success')], 200);
    }
}
