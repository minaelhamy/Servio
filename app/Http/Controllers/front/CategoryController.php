<?php
namespace App\Http\Controllers\front;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\helper\helper;
use App\Models\Settings;
use App\Models\User;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $host = $_SERVER['HTTP_HOST'];
        if ($host  ==  env('WEBSITE_HOST')) {
            $vendordata = User::where('slug', $request->vendor)->first();
            $vdata = $vendordata->id;
        }
        // if the current host doesn't contain the website domain (meaning, custom domain)
        else {
            $vendordata = Settings::where('custom_domain', $host)->first();
            $vdata = $vendordata->vendor_id;
        }
        $categories = Category::where('is_available', "1")->where('is_deleted', "2")->where('vendor_id',$vendordata->id)->orderBY('reorder_id')->get();
        return view('front.category.index',compact('categories','vendordata','vdata'));
    }
}
