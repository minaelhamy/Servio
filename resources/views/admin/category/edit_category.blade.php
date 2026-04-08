@extends('admin.layout.default')
@section('content')
        @include('admin.breadcrumb.breadcrumb')
        <div class="row">
            <div class="col-12">
                <div class="card border-0 box-shadow">
                    <div class="card-body">
                        <form action="{{URL::to('/admin/categories/update-'.$editcategory->slug)}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="form-group">
                                    <label class="form-label">{{trans('labels.name')}}<span class="text-danger"> * </span></label>
                                    <input type="text" class="form-control" name="category_name" value="{{$editcategory->name}}" placeholder="{{trans('labels.name')}}" required>
                                </div>
                                 <div class="form-group">
                                    <label class="form-label">{{trans('labels.image')}}</label>
                                    <input type="file" class="form-control" name="category_image">
                                    <img src="{{helper::image_path($editcategory->image)}}" class="img-fluid rounded hw-50 mt-1" alt="">
                                </div>
                            </div>
                            <div class="form-group text-{{ session()->get('direction') == '2' ? 'start' : 'end' }} m-0">
                                <a href="{{URL::to('admin/categories')}}" class="btn btn-danger px-sm-4">{{ trans('labels.cancel') }}</a>
                                <button @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif class="btn btn-primary px-sm-4 {{ Auth::user()->type == 4 ? (helper::check_access('role_categories', Auth::user()->role_id, Auth::user()->vendor_id, 'edit') == 1 ? '' : 'd-none') : '' }}">{{ trans('labels.save') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
@endsection