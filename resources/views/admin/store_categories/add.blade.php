@extends('admin.layout.default')

@section('content')
    @include('admin.breadcrumb.breadcrumb')

    <div class="row">

        <div class="col-12">

            <div class="card border-0 box-shadow">

                <div class="card-body">

                    <form action="{{ URL::to('admin/store_categories/save') }}" method="POST">

                        @csrf

                        <div class="row">

                            <div class="form-group">

                                <label class="form-label">{{ trans('labels.name') }}<span class="text-danger"> *

                                    </span></label>

                                <input type="text" class="form-control" name="category_name"
                                    value="{{ old('category_name') }}" placeholder="{{ trans('labels.name') }}" required>



                            </div>

                            <div class="form-group text-{{ session()->get('direction') == '2' ? 'start' : 'end' }} m-0">

                                <a href="{{ URL::to('admin/store_categories') }}"
                                    class="btn btn-danger px-sm-4">{{ trans('labels.cancel') }}</a>

                                <button class="btn btn-primary px-sm-4"
                                    @if (env('Environment') == 'sendbox') type="button"

                                    onclick="myFunction()" @else type="submit" @endif>{{ trans('labels.save') }}</button>

                            </div>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>
@endsection
