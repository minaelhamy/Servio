<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Service;
use App\Models\Banner;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\helper\helper;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\Validator;
use DB;

class CategoryController extends Controller
{
    /*=================================================================================*/
    /*================================= Service Category ==============================*/
    /*=================================================================================*/
    public function view_category()
    {
        if (Auth::user()->type  == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        $allcategories = Category::orderBy('reorder_id')->where('vendor_id', $vendor_id)->where('is_deleted', "2")->get();
        return view('admin.category.category', compact("allcategories"));
    }
    public function add_category(Request $request)
    {
        return view('admin.category.add_category');
    }
    public function save_category(Request $request)
    {
        if (Auth::user()->type  == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        $check_slug = Category::where('slug', Str::slug($request->category_name, '-'))->first();
        if (!empty($check_slug)) {
            $last_id = Category::select('id')->orderByDesc('id')->first();
            $slug = Str::slug($request->category_name . ' ' . $last_id->id, '-');
        } else {
            $slug = Str::slug($request->category_name, '-');
        }
        $savecategory = new Category();
        $savecategory->vendor_id = $vendor_id;
        $savecategory->name = $request->category_name;
        $savecategory->slug = $slug;
        if ($request->has('category_image')) {
            $validator = Validator::make($request->all(), [
                'category_image' => 'image|max:' . helper::imagesize() . '|' . helper::imageext(),
            ], [
                'category_image.max' => trans('messages.image_size_message'),
            ]);
            if ($validator->fails()) {
                return redirect()->back()->with('error', trans('messages.image_size_message') . ' ' . helper::appdata('')->image_size . ' ' . 'MB');
            }
            $image = 'category-' . uniqid() . "." . $request->file('category_image')->getClientOriginalExtension();
            $request->file('category_image')->move(storage_path('app/public/admin-assets/images/categories/'), $image);
            $savecategory->image = $image;
        }
        $savecategory->save();
        return redirect('/admin/categories/')->with('success', trans('messages.success'));
    }
    public function edit_category($slug)
    {
        $editcategory = Category::where('slug', $slug)->first();
        return view('admin.category.edit_category', compact("editcategory"));
    }
    public function update_category(Request $request, $slug)
    {
        if (Auth::user()->type  == 4) {
            $user = User::where('id', Auth::user()->vendor_id)->first();
        } else {
            $user = User::where('id', Auth::user()->id)->first();
        }
        $editcategory = Category::where('slug', $slug)->first();

        $check_slug = Category::where('slug', Str::slug($request->category_name, '-'))->first();
        if (!empty($check_slug)) {
            $last_id = Category::select('id')->orderByDesc('id')->first();
            $slug = Str::slug($request->category_name . ' ' . $last_id->id, '-');
        } else {
            $slug = Str::slug($request->category_name, '-');
        }
        $editcategory->name = $request->category_name;
        $editcategory->slug = $slug;
        if ($request->has('category_image')) {
            $validator = Validator::make($request->all(), [
                'category_image' => 'image|max:' . helper::imagesize() . '|' . helper::imageext(),
            ], [
                'category_image.max' => trans('messages.image_size_message'),
            ]);
            if ($validator->fails()) {
                return redirect()->back()->with('error', trans('messages.image_size_message') . ' ' . helper::appdata('')->image_size . ' ' . 'MB');
            }
            if (file_exists(storage_path('app/public/admin-assets/images/categories/' . $user->image))) {
                unlink(storage_path('app/public/admin-assets/images/categories/' . $user->image));
            }
            $edit_image = $request->file('category_image');
            $profileImage = 'category-' . uniqid() . "." . $edit_image->getClientOriginalExtension();
            $edit_image->move(storage_path('app/public/admin-assets/images/categories/'), $profileImage);
            $editcategory->image = $profileImage;
        }
        $editcategory->update();
        return redirect('/admin/categories')->with('success', trans('messages.success'));
    }
    public function change_status($slug, $status)
    {
        $checkcategory = Category::where('slug', $slug)->first();
        if (!empty($checkcategory)) {
            Service::where('category_id', $checkcategory->id)->update(['is_available' => $status]);
            Category::where('slug', $slug)->update(['is_available' => $status]);
            return redirect('/admin/categories')->with('success', trans('messages.success'));
        } else {
            return redirect()->back()->with('error', trans('messages.wrong'));
        }
    }
    public function delete_category($slug)
    {

        try {
            if (Auth::user()->type  == 4) {
                $vendor_id = Auth::user()->vendor_id;
            } else {
                $vendor_id = Auth::user()->id;
            }
            $checkcategory = Category::where('slug', $slug)->first();
            $getservice =   Service::where(DB::Raw("FIND_IN_SET($checkcategory->id, replace(category_id, '|', ','))"), '>', 0)->get();
            $getbanner = Banner::where('category_id', $checkcategory->id)->where('vendor_id', $vendor_id)->get();
            foreach ($getservice as $service) {
                $cat_id = explode('|', $service->category_id);
                $key = array_search($checkcategory->id, $cat_id);
                if ($key !== false) {
                    unset($cat_id[$key]);
                    Service::where('vendor_id', $vendor_id)->update(array('category_id' => implode('|', $cat_id)));
                }
            }
            foreach ($getbanner as $banner) {
                $banner->type = "";
                $banner->category_id = "";
                $banner->update();
            }
            $checkcategory->delete();
            return redirect('/admin/categories')->with('success', trans('messages.success'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', trans('messages.wrong'));
        }
    }
    public function bulk_delete_category(Request $request)
    {

        try {
            if (Auth::user()->type  == 4) {
                $vendor_id = Auth::user()->vendor_id;
            } else {
                $vendor_id = Auth::user()->id;
            }
            foreach ($request->id as $id) {
                $checkcategory = Category::where('id', $id)->first();
                $getservice =   Service::where(DB::Raw("FIND_IN_SET($checkcategory->id, replace(category_id, '|', ','))"), '>', 0)->get();
                $getbanner = Banner::where('category_id', $checkcategory->id)->where('vendor_id', $vendor_id)->get();
                foreach ($getservice as $service) {
                    $cat_id = explode('|', $service->category_id);
                    $key = array_search($checkcategory->id, $cat_id);
                    if ($key !== false) {
                        unset($cat_id[$key]);
                        Service::where('vendor_id', $vendor_id)->update(array('category_id' => implode('|', $cat_id)));
                    }
                }
                foreach ($getbanner as $banner) {
                    $banner->type = "";
                    $banner->category_id = "";
                    $banner->update();
                }
                $checkcategory->delete();
            }
            return response()->json(['status' => 1, 'msg' => trans('messages.success')], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => 0, 'msg' => trans('messages.wrong')], 200);
        }
    }
    public function reorder_category(Request $request)
    {
        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        $getcategory = Category::where('vendor_id', $vendor_id)->get();
        foreach ($getcategory as $category) {
            foreach ($request->order as $order) {
                $category = Category::where('id', $order['id'])->first();
                $category->reorder_id = $order['position'];
                $category->save();
            }
        }
        return response()->json(['status' => 1, 'msg' => trans('messages.success')], 200);
    }


    /*=================================================================================*/
    /*================================= Product Category ==============================*/
    /*=================================================================================*/
    public function view_product_category()
    {
        if (Auth::user()->type  == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        $allcategories = ProductCategory::orderBy('reorder_id')->where('vendor_id', $vendor_id)->get();
        return view('admin.product_category.category', compact("allcategories"));
    }

    public function add_product_category()
    {
        return view('admin.product_category.add_category');
    }

    public function save_product_category(Request $request)
    {
        if (Auth::user()->type  == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        $check_slug = ProductCategory::where('slug', Str::slug($request->category_name, '-'))->first();
        if (!empty($check_slug)) {
            $last_id = ProductCategory::select('id')->orderByDesc('id')->first();
            $slug = Str::slug($request->category_name . ' ' . $last_id->id, '-');
        } else {
            $slug = Str::slug($request->category_name, '-');
        }
        $savecategory = new ProductCategory();
        $savecategory->vendor_id = $vendor_id;
        $savecategory->name = $request->category_name;
        $savecategory->slug = $slug;
        $savecategory->save();
        return redirect('/admin/product-category/')->with('success', trans('messages.success'));
    }

    public function edit_product_category($slug)
    {
        $editcategory = ProductCategory::where('slug', $slug)->first();
        return view('admin.product_category.edit_category', compact("editcategory"));
    }

    public function update_product_category(Request $request, $slug)
    {
        $editcategory = ProductCategory::where('slug', $slug)->first();
        $editcategory->name = $request->category_name;
        $editcategory->update();
        return redirect('/admin/product-category')->with('success', trans('messages.success'));
    }

    public function change_product_category_status($slug, $status)
    {
        $checkcategory = ProductCategory::where('slug', $slug)->first();
        if (!empty($checkcategory)) {
            Service::where('category_id', $checkcategory->id)->update(['is_available' => $status]);
            ProductCategory::where('slug', $slug)->update(['is_available' => $status]);
            return redirect('/admin/product-category')->with('success', trans('messages.success'));
        } else {
            return redirect()->back()->with('error', trans('messages.wrong'));
        }
    }

    public function delete_product_category($slug)
    {

        try {
            if (Auth::user()->type  == 4) {
                $vendor_id = Auth::user()->vendor_id;
            } else {
                $vendor_id = Auth::user()->id;
            }
            $checkcategory = ProductCategory::where('slug', $slug)->first();
            Product::where('vendor_id', $vendor_id)->update(array('category_id' => null));
            $checkcategory->delete();
            return redirect('/admin/product-category')->with('success', trans('messages.success'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', trans('messages.wrong'));
        }
    }
    public function bulk_delete_product_category(Request $request)
    {

        try {
            if (Auth::user()->type  == 4) {
                $vendor_id = Auth::user()->vendor_id;
            } else {
                $vendor_id = Auth::user()->id;
            }
            foreach ($request->id as $id) {
                $checkcategory = ProductCategory::where('id', $id)->first();
                Product::where('vendor_id', $vendor_id)->update(array('category_id' => null));
                $checkcategory->delete();
            }
           return response()->json(['status' => 1, 'msg' => trans('messages.success')], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => 0, 'msg' => trans('messages.wrong')], 200);
        }
    }
    
    public function reorder_product_category(Request $request)
    {
        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        $getcategory = ProductCategory::where('vendor_id', $vendor_id)->get();
        foreach ($getcategory as $category) {
            foreach ($request->order as $order) {
                $category = ProductCategory::where('id', $order['id'])->first();
                $category->reorder_id = $order['position'];
                $category->save();
            }
        }
        return response()->json(['status' => 1, 'msg' => trans('messages.success')], 200);
    }
}
