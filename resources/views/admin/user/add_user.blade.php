@extends('admin.layout.default')

@section('content')

    @include('admin.breadcrumb.breadcrumb')

    <div class="row">

        <div class="col-12">

            <div class="card border-0 box-shadow">

                <div class="card-body">

                    <form action="{{ URL::to('/admin/register_vendor') }}" method="POST">

                        @csrf
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="store" class="form-label">{{ trans('labels.store_categories') }}<span
                                        class="text-danger">
                                        * </span></label>
                                <select name="store" class="form-select" required>
                                    <option value="">{{ trans('labels.select') }}</option>
                                    @foreach ($stores as $store)
                                        <option value="{{ $store->id }}"
                                            {{ old('store') == $store->id ? 'selected' : '' }}>{{ $store->name }}
                                        </option>
                                    @endforeach
                                </select>
                               
                            </div>
                            <div class="form-group col-6">

                                <label for="name" class="form-label">{{ trans('labels.name') }}<span class="text-danger">
                                        *

                                    </span></label>

                                <input type="text" class="form-control" name="name" value="{{ old('name') }}"
                                    id="name" placeholder="{{ trans('labels.name') }}" required>



                            </div>

                            <div class="form-group col-6">

                                <label for="email" class="form-label">{{ trans('labels.email') }}<span
                                        class="text-danger"> *

                                    </span></label>

                                <input type="email" class="form-control" name="email" value="{{ old('email') }}"
                                    placeholder="{{ trans('labels.email') }}" required>



                            </div>

                            <div class="form-group col-6">

                                <label for="mobile" class="form-label">{{ trans('labels.mobile') }}<span
                                        class="text-danger">

                                        * </span></label>

                                <input type="text" class="form-control mobile-number" name="mobile"
                                    value="{{ old('mobile') }}" placeholder="{{ trans('labels.mobile') }}" required>



                            </div>

                            <div class="form-group col-6">

                                <label for="password" class="form-label">{{ trans('labels.password') }}<span
                                        class="text-danger"> * </span></label>

                                <input type="password" class="form-control" name="password" value="{{ old('password') }}"
                                    placeholder="{{ trans('labels.password') }}">



                            </div>
                            <div class="form-group col-6">
                                <label for="country" class="form-label">{{ trans('labels.country') }}<span
                                        class="text-danger"> * </span></label>
                                <select name="country" class="form-select" id="country" required>
                                    <option value="">{{ trans('labels.select') }}</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                                    @endforeach
                                </select>

                            </div>
                            <div class="form-group col-6">
                                <label for="city" class="form-label">{{ trans('labels.city') }}<span
                                        class="text-danger"> * </span></label>
                                <select name="city" class="form-select" id="city" required>
                                    <option value="">{{ trans('labels.select') }}</option>
                                </select>

                            </div>
                        </div>
                        @if (@helper::checkaddons('unique_slug'))
                            <div class="form-group">
                                <label for="basic-url" class="form-label">{{ trans('labels.personlized_link') }}<span
                                        class="text-danger"> * </span></label>
                                @if (env('Environment') == 'sendbox')
                                    <span class="badge badge bg-danger ms-2 mb-0">{{ trans('labels.addon') }}</span>
                                @endif
                                <div class="input-group ">
                                    <span
                                        class="input-group-text col-5 col-lg-auto overflow-x-auto">{{ URL::to('/') }}/</span>
                                    <input type="text" class="form-control" id="slug" name="slug"
                                        value="{{ old('slug') }}" required>
                                </div>

                            </div>
                        @endif

                        <div class="form-group text-{{ session()->get('direction') == '2' ? 'start' : 'end' }} m-0">

                            <a href="{{ URL::to('admin/users') }}"
                                class="btn btn-danger px-sm-4">{{ trans('labels.cancel') }}</a>

                            <button
                                @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif
                                class="btn btn-primary px-sm-4">{{ trans('labels.save') }}</button>

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
    <script>
        var cityurl = "{{ URL::to('admin/getcity') }}";
        var select = "{{ trans('labels.select') }}";
        var cityid = '0';
    </script>
    <script>
        $('#name').on('blur', function() {
            "use strict";
            $('#slug').val($('#name').val().split(" ").join("-").toLowerCase());
        });
    </script>
    <script src="{{ url(env('ASSETPATHURL') . '/admin-assets/js/user.js') }}"></script>
@endsection
