<?php
namespace App\Http\Controllers\front;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\helper\helper;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $vendordata = helper::currentStoreUser($request->route('vendor'));

        if (empty($vendordata)) {
            abort(404);
        }

        $vdata = $vendordata->id;
        $categories = Category::where('is_available', "1")->where('is_deleted', "2")->where('vendor_id',$vendordata->id)->orderBY('reorder_id')->get();
        return view('front.category.index',compact('categories','vendordata','vdata'));
    }
}
