<?php
namespace App\Http\Controllers\Api\user;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Blog;

class BlogController extends Controller
{
    public function blogs(Request $request)
    {
        if ($request->vendor_id == "") {
            return response()->json(["status" => 0, "message" => trans('messages.vendor_id_required')], 200);
        }
        $getblogs = Blog::select('id','title','description',DB::raw("CONCAT('".url(env('ASSETPATHURL').'admin-assets/images/blog')."/', image) AS image"),'created_at')->where('vendor_id',$request->vendor_id)->orderByDesc('id')->paginate(6);
    
        return response()->json(['status' => 1, 'message' => trans('messages.success'), 'blogs' => $getblogs], 200);
    }
}