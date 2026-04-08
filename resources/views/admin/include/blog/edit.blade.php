@extends('admin.layout.default')

@section('content')

    @include('admin.breadcrumb.breadcrumb')

    <div class="row">

        <div class="col-12">

            <div class="card border-0 box-shadow">

                <div class="card-body">

                    <form action="{{ URL::to('/admin/blogs/update-' . $getblog->slug) }}" method="POST"

                        enctype="multipart/form-data">

                        @csrf

                        <div class="row">

                            <div class="form-group">

                                <label class="form-label">{{ trans('labels.title') }}<span class="text-danger"> *

                                    </span></label>

                                <input type="text" class="form-control" name="title" value="{{ $getblog->title }}"

                                    placeholder="{{ trans('labels.title') }}" required>

                               

                            </div>

                            <div class="form-group">

                                <label class="form-label">{{ trans('labels.description') }}<span class="text-danger"> *

                                    </span></label>
                                <textarea class="form-control" id="ckeditor" name="description" required>{!! $getblog->description !!}</textarea>
                            

                            </div>

                            <div class="form-group">

                                <label class="form-label">{{ trans('labels.image') }}<span class="text-danger"> *

                                    </span></label>

                                <input type="file" class="form-control" name="image">
                                <img src="{{ helper::image_path($getblog->image) }}" class="img-fluid rounded hw-50 mt-1"

                                    alt="">

                            </div>

                        </div>

                        <div class="form-group text-{{ session()->get('direction') == '2' ? 'start' : 'end' }} m-0">

                            <a href="{{ URL::to('admin/blogs') }}"

                                class="btn btn-danger px-sm-4">{{ trans('labels.cancel') }}</a>

                            <button

                                @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif

                                class="btn btn-primary px-sm-4 {{ Auth::user()->type == 4 ? (helper::check_access('role_blogs', Auth::user()->role_id, Auth::user()->vendor_id, 'edit') == 1 ? '' : 'd-none') : '' }}">{{ trans('labels.save') }}</button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

@endsection
@section('scripts')
<script>
    @if (count($errors) > 0)
        @foreach ($errors->all() as $error)
            toastr.error("{{ $error }}");
        @endforeach
    @endif
</script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.12.1/ckeditor.js"></script>

    <script src="{{ url(env('ASSETPATHURL') . 'admin-assets/js/editor.js') }}"></script>

@endsection

