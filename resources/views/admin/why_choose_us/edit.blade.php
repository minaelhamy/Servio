@extends('admin.layout.default')
@section('content')
       @include('admin.breadcrumb.breadcrumb')
        <div class="row">
            <div class="col-12">
                <div class="card border-0 box-shadow">
                    <div class="card-body">
                        <form action="{{URL::to('/admin/choose_us/update-'.$editwork->id)}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="form-label">{{trans('labels.title')}}<span class="text-danger"> * </span></label>
                                    <input type="text" class="form-control" name="title" value="{{$editwork->title}}" placeholder="{{trans('labels.title')}}" required>
                                   
                                </div>
                                <div class="col-md-6 form-group">
                                        <label class="form-label">{{trans('labels.image')}}<span class="text-danger"> * </span></label>
                                        <input type="file" class="form-control" name="image">
                                     
                                    <img src="{{helper::image_path($editwork->image)}}" class="img-fluid rounded hw-70 mt-1" alt="">
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-label">{{trans('labels.subtitle')}}<span class="text-danger"> * </span></label>
                                    <textarea class="form-control" name="description" placeholder="{{trans('labels.description')}}" rows="5">{{$editwork->description}}</textarea>
                                 
                                </div>
                            
                               
                            </div>
                            <div class="form-group text-{{ session()->get('direction') == '2' ? 'start' : 'end' }} m-0">
                                <a href="{{ URL::to('admin/choose_us') }}"
                                    class="btn btn-danger px-sm-4">{{ trans('labels.cancel') }}</a>
                                <button
                                    @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif
                                    class="btn btn-primary px-sm-4 {{ Auth::user()->type == 4 ? (helper::check_access('role_choose_us', Auth::user()->role_id, $vendor_id, 'edit') == 1 ? '' : 'd-none') : '' }}">{{ trans('labels.save') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
@endsection