@extends('admin.layout.default')

@section('content')
    @include('admin.breadcrumb.breadcrumb')

    <div class="row">

        <div class="col-12">

            <div class="card border-0 box-shadow">

                <div class="card-body">

                    <form action="{{ URL::to('/admin/users/edit_vendorprofile') }}" method="post"
                        enctype="multipart/form-data">

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
                                            {{ $store->id == $user->store_id ? 'selected' : '' }}>
                                            {{ $store->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6">

                                <input type="hidden" value="{{ $user->id }}" name="id">

                                <label class="form-label">{{ trans('labels.name') }}<span class="text-danger"> *
                                    </span></label>

                                <input type="text" class="form-control" name="name" id="name"
                                    value="{{ $user->name }}" placeholder="name" required>


                            </div>

                            <div class="form-group col-md-6">

                                <label class="form-label">{{ trans('labels.email') }}<span class="text-danger"> *
                                    </span></label>

                                <input type="email" class="form-control" name="email" value="{{ $user->email }}"
                                    placeholder="email" required>


                            </div>
                            <div class="col-md-6">
                                <div class="form-group ">

                                    <label class="form-label">{{ trans('labels.mobile') }}<span class="text-danger"> *
                                        </span></label>

                                    <input type="text" class="form-control mobile-number" name="mobile"
                                        value="{{ $user->mobile }}" placeholder="mobile" required>



                                </div>

                            </div>
                            <div class="col-md-6 form-group">

                                <label class="form-label">{{ trans('labels.image') }} </label>

                                <input type="file" class="form-control" name="profile">

                                <img class="rounded-circle mt-2" src="{{ helper::image_path($user->image) }}"
                                    alt="" width="70" height="70">



                            </div>
                            <div class="form-group col-md-6">
                                <label for="country" class="form-label">{{ trans('labels.country') }}<span
                                        class="text-danger"> * </span></label>
                                <select name="country" class="form-select" id="country" required>
                                    <option value="">{{ trans('labels.select') }}</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}"
                                            {{ $country->id == $user->country_id ? 'selected' : '' }}>{{ $country->name }}
                                        </option>
                                    @endforeach
                                </select>

                            </div>
                            <div class="form-group col-md-6">
                                <label for="city" class="form-label">{{ trans('labels.city') }}<span
                                        class="text-danger"> * </span></label>
                                <select name="city" class="form-select" id="city" required>
                                    <option value="">{{ trans('labels.select') }}</option>
                                </select>

                            </div>

                            @if (@helper::checkaddons('commission_module'))
                                <div class="form-group col-md-12">
                                    <label class="form-label" for="">{{ trans('labels.commission') }}
                                    </label>
                                    <div class="text-center">
                                        <input id="commission_on_off" type="checkbox" class="checkbox-switch"
                                            name="commission_on_off" value="1"
                                            {{ $user->commission_on_off == 1 ? 'checked' : '' }}>
                                        <label for="commission_on_off" class="switch">
                                            <span
                                                class="{{ session()->get('direction') == 2 ? 'switch__circle-rtl' : 'switch__circle' }}"><span
                                                    class="switch__circle-inner"></span></span>
                                            <span
                                                class="switch__left {{ session()->get('direction') == 2 ? 'pe-2' : 'ps-2' }}">{{ trans('labels.off') }}</span>
                                            <span
                                                class="switch__right {{ session()->get('direction') == 2 ? 'ps-2' : 'pe-2' }}">{{ trans('labels.on') }}</span>
                                        </label>
                                    </div>
                                </div>

                                <div class="row commission_"
                                    @if ($user->commission_on_off != 1) style="display: none;" @endif>
                                    <div class="form-group col-md-6">
                                        <label class="form-label">{{ trans('labels.commission_type') }}</label>
                                        <select class="form-select commission_type" name="commission_type">
                                            <option value="1" {{ $user->commission_type == '1' ? 'selected' : '' }}>
                                                {{ trans('labels.fixed') }}
                                            </option>
                                            <option value="2" {{ $user->commission_type == '2' ? 'selected' : '' }}>
                                                {{ trans('labels.percentage') }}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label class="form-label">{{ trans('labels.commission_amount') }}<span
                                                class="text-danger">
                                                *</span></label>
                                        <input type="text" class="form-control numbers_only" name="commission_amount"
                                            value="{{ $user->commission_amount }}"
                                            placeholder="{{ trans('labels.commission_amount') }}">
                                    </div>
                                </div>
                            @endif
                            @if (@helper::checkaddons('unique_slug'))
                                @if (@helper::checkcustomdomain($user->id) == null)
                                    <div class="form-group">
                                        <label for="basic-url"
                                            class="form-label">{{ trans('labels.personlized_link') }}<span
                                                class="text-danger"> * </span></label>
                                        @if (env('Environment') == 'sendbox')
                                            <span
                                                class="badge badge bg-danger ms-2 mb-0">{{ trans('labels.addon') }}</span>
                                        @endif
                                        <div class="input-group ">
                                            <span
                                                class="input-group-text col-5 col-lg-auto overflow-x-auto">{{ URL::to('/') }}/</span>
                                            <input type="text" class="form-control" id="slug" name="slug"
                                                value="{{ $user->slug }}" required>
                                        </div>

                                    </div>
                                @endif
                            @endif
                            <div class="col-sm-6">
                                @if (@helper::checkaddons('allow_without_subscription'))
                                    <div class="form-group" id="plan">
                                        <div class="d-flex">
                                            <input class="form-check-input mx-1" type="checkbox" name="plan_checkbox"
                                                id="plan_checkbox">
                                            @php
                                                $plan = helper::plandetail(@$user->plan_id);
                                            @endphp
                                            <div>
                                                <label for="plan_checkbox"
                                                    class="form-label">{{ trans('labels.assign_plan') }}</label>&nbsp;
                                                <label class="form-label">({{ trans('labels.current_plan') }}&nbsp;:&nbsp;
                                                </label> <span class="fw-500">
                                                    {{ !empty($plan) ? $plan->name : '-' }})
                                                </span>
                                                @if (env('Environment') == 'sendbox')
                                                    <span
                                                        class="badge badge bg-danger ms-2">{{ trans('labels.addon') }}</span>
                                                @endif
                                            </div>



                                        </div>

                                        <select name="plan" id="selectplan" class="form-select" disabled required>
                                            <option value="">{{ trans('labels.select') }}</option>
                                            @foreach ($getplanlist as $plan)
                                                @if ($plan->vendor_id != '' && $plan->vendor_id != null)
                                                    @if (in_array($user->id, explode('|', $plan->vendor_id)))
                                                        <option value="{{ $plan->id }}">
                                                            {{ $plan->name }}
                                                        </option>
                                                    @endif
                                                @else
                                                    <option value="{{ $plan->id }}">
                                                        {{ $plan->name }}
                                                    </option>
                                                @endif
                                            @endforeach
                                        </select>

                                    </div>
                                    @if (@helper::checkaddons('subscription'))
                                        <div class="form-group">
                                            <input class="form-check-input mx-1" type="checkbox"
                                                name="allow_store_subscription" id="allow_store_subscription"
                                                @if ($user->allow_without_subscription == '1') checked @endif><label
                                                class="form-check-label"
                                                for="allow_store_subscription">{{ trans('labels.allow_store_without_subscription') }}</label>
                                            @if (env('Environment') == 'sendbox')
                                                <span
                                                    class="badge badge bg-danger ms-2">{{ trans('labels.addon') }}</span>
                                            @endif
                                        </div>
                                    @endif
                                @endif
                                <div class="form-group">
                                    <input class="form-check-input mx-1" type="checkbox" name="show_landing_page"
                                        id="show_landing_page" @if ($user->available_on_landing == '1') checked @endif><label
                                        class="form-check-label"
                                        for="show_landing_page">{{ trans('labels.display_store_on_landing') }}</label>

                                </div>
                            </div>
                            <div class="form-group text-{{ session()->get('direction') == '2' ? 'start' : 'end' }} m-0">

                                <a href="{{ URL::to('admin/users') }}"
                                    class="btn btn-danger px-sm-4">{{ trans('labels.cancel') }}</a>

                                <button
                                    @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif
                                    class="btn btn-primary px-sm-4">{{ trans('labels.save') }}</button>

                            </div>

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
        var cityid = "{{ $user->city_id }}";
    </script>
    <script>
        $('#name').on('blur', function() {
            "use strict";
            $('#slug').val($('#name').val().split(" ").join("-").toLowerCase());
        });
    </script>
    <script src="{{ url('storage/app/public/admin-assets/js/user.js') }}"></script>
    <script>
        // duration and custom selection for plan
        $('body').on('change', 'input[name=commission_on_off]', function() {
            "use strict";
            var mode = $(this).prop('checked');
            if (mode == true) {
                $(".commission_").show();
            } else {
                $(".commission_").hide();
            }
        }).change();
    </script>
@endsection
