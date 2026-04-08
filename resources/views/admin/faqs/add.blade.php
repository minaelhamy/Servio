@extends('admin.layout.default')
@section('content')
    @include('admin.breadcrumb.breadcrumb')
    <div class="row">
        <div class="col-12">
            <div class="card border-0 box-shadow">
                <div class="card-body">
                    <form action="{{ URL::to('/admin/faqs/save') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="form-group">
                                <label class="form-label">{{ trans('labels.question') }}<span class="text-danger"> *
                                    </span></label>
                                <input type="text" class="form-control" name="question" value="{{ old('question') }}"
                                    placeholder="{{ trans('labels.question') }}" required>

                            </div>
                            <div class="form-group">
                                <label class="form-label">{{ trans('labels.answer') }}<span class="text-danger"> *
                                    </span></label>
                                <textarea class="form-control" name="answer" placeholder="{{ trans('labels.answer') }}" rows="5" required>{{ old('answer') }}</textarea>

                            </div>

                        </div>
                        <div class="form-group text-{{ session()->get('direction') == '2' ? 'start' : 'end' }} m-0">
                            <a href="{{ URL::to('admin/faqs') }}"
                                class="btn btn-danger px-sm-4">{{ trans('labels.cancel') }}</a>
                            <button
                                @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif
                                class="btn btn-primary px-sm-4 {{ Auth::user()->type == 4 ? (helper::check_access('role_faqs', Auth::user()->role_id, Auth::user()->vendor_id, 'add') == 1 ? '' : 'd-none') : '' }}">{{ trans('labels.save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
