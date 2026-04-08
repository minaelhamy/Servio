<?php

namespace App\Http\Controllers\addons\include;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\User;
use App\Models\Settings;
use Illuminate\Http\Request;
use App\helper\helper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function index()
    {
        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        $blog = Blog::where('vendor_id', $vendor_id)->orderBy('reorder_id')->get();
        return view('admin.include.blog.blog', compact('blog'));
    }
    public function add()
    {
        return view('admin.include.blog.add');
    }
    public function save(Request $request)
    {
        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        $request->validate([
            'description' => 'required',
            'image' => 'image|max:' . helper::imagesize() . '|' . helper::imageext(),
        ], [
            'description.required' => trans('messages.description_required'),
            'image.max' => trans('messages.image_size_message') . ' ' . helper::appdata('')->image_size . ' ' . 'MB',
        ]);

        $check_slug = Blog::where('slug', Str::slug($request->title, '-'))->first();
        if (!empty($check_slug)) {
            $last_id = Blog::select('id')->orderByDesc('id')->first();
            $slug = Str::slug($request->title . ' ' . $last_id->id, '-');
        } else {
            $slug = Str::slug($request->title, '-');
        }
        $blog = new Blog();
        $blog->vendor_id =  $vendor_id;
        $blog->title = $request->title;
        $blog->slug = $slug;
        $blog->description = $request->description;
        if ($request->has('image')) {

            $blogimage = 'blog-' . uniqid() . "." . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(storage_path('app/public/admin-assets/images/blog/'), $blogimage);
            $blog->image = $blogimage;
        }
        $blog->save();
        return redirect('admin/blogs')->with('success', trans('messages.success'));
    }
    public function edit($slug)
    {
        $getblog = Blog::where('slug', $slug)->first();
        if (!empty($getblog)) {
            return view('admin.include.blog.edit', compact('getblog'));
        }
        return redirect('admin/blogs');
    }
    public function update(Request $request, $slug)
    {

        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        $request->validate([
            'description' => 'required',
            'image' => 'image|max:' . helper::imagesize() . '|' . helper::imageext(),
        ], [
            'description.required' => trans('messages.description_required'),
            'image.max' => trans('messages.image_size_message') . ' ' . helper::appdata('')->image_size . ' ' . 'MB',
        ]);
        $blog = Blog::where('slug', $slug)->first();
        $check_slug = Blog::where('slug', Str::slug($request->title, '-'))->first();
        if (!empty($check_slug)) {
            $slug = Str::slug($request->title . ' ' . $blog->id, '-');
        } else {
            $slug = Str::slug($request->title, '-');
        }
        $blog->vendor_id = $vendor_id;
        $blog->slug = $slug;
        $blog->title = $request->title;
        $blog->description = $request->description;
        if ($request->has('image')) {

            if (file_exists(storage_path('app/public/admin-assets/images/blog/' . $blog->image))) {
                unlink(storage_path('app/public/admin-assets/images/blog/' . $blog->image));
            }
            $blogimage = 'blog-' . uniqid() . "." . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(storage_path('app/public/admin-assets/images/blog/'), $blogimage);
            $blog->image = $blogimage;
        }
        $blog->update();
        return redirect('admin/blogs')->with('success', trans('messages.success'));
    }
    public function delete($slug)
    {
        $blog = Blog::where('slug', $slug)->first();
        if (file_exists(storage_path('app/public/admin-assets/images/blog/' . $blog->image))) {
            unlink(storage_path('app/public/admin-assets/images/blog/' . $blog->image));
        }
        $blog->delete();
        return redirect()->back()->with('success', trans('messages.success'));
    }
    public function bulk_delete(Request $request)
    {
        foreach ($request->id as $id) {
            $blog = Blog::where('id', $id)->where('vendor_id',Auth::user()->type)->first();
            if (file_exists(storage_path('app/public/admin-assets/images/blog/' . $blog->image))) {
                unlink(storage_path('app/public/admin-assets/images/blog/' . $blog->image));
            }
            $blog->delete();
        }
        return response()->json(['status' => 1, 'msg' => trans('messages.success')], 200);
        
    }
    public function reorder_blogs(Request $request)
    {
        if (Auth::user()->type  == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        $getblogs = Blog::where('vendor_id', $vendor_id)->get();
        foreach ($getblogs as $blog) {
            foreach ($request->order as $order) {
                $blog = Blog::where('id', $order['id'])->first();
                $blog->reorder_id = $order['position'];
                $blog->save();
            }
        }
        return response()->json(['status' => 1, 'msg' => trans('messages.success')], 200);
    }

    // ------------front blogs functions----------
    public function front_index(Request $request)
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
        $getblog = Blog::where('vendor_id', $vendordata->id)->orderBy('reorder_id')->paginate(6);
        return view('front.include.blog.blog', compact('getblog', 'vendordata','vdata'));
    }
    public function front_blogdetails(Request $request)
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
        $blogdetail = Blog::where('slug', $request->blogslug)->first();
        $getblog = Blog::where('vendor_id', $vendordata->id)->orderBy('reorder_id')->take(3)->get();
        return view('front.include.blog.blog-detail', compact('getblog', 'blogdetail', 'vendordata','vdata'));
    }
    // ----------landing page blog function-------------
    public function allblogs()
    {   
        $admindata = User::where('type', 1)->first();
        $blogs = Blog::where('vendor_id', $admindata->id)->orderBy('reorder_id')->paginate(12);
        return view('landing.bloglist', compact('blogs'));
    }
    public function pageblogdetail(Request $request)
    {
        $admindata = User::where('type', 1)->first();
        $getblog = Blog::where('slug', $request->slug)->first();
        $blogs = Blog::where('vendor_id', $admindata->id)->orderBy('reorder_id')->take(5)->get();
        return view('landing.blogdetail', compact('getblog', 'blogs'));
    }
}
