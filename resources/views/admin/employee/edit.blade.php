@extends('admin.layout.default')
@php
    if (Auth::user()->type == 4) {
        $vendor_id = Auth::user()->vendor_id;
    } else {
        $vendor_id = Auth::user()->id;
    }
@endphp


@section('content')
    @include('admin.breadcrumb.breadcrumb')



    <div class="row">

        <div class="col-12">

            <div class="card border-0 box-shadow">

                <div class="card-body">

                    <form action="{{ URL::to('/admin/employees/update-' . $editemployee->id) }}" method="post"
                        enctype="multipart/form-data">

                        @csrf

                        <div class="row">

                            <div class="form-group col-md-6">



                                <input type="hidden" value="{{ $editemployee->id }}" name="id">



                                <label class="form-label">{{ trans('labels.name') }}<span class="text-danger"> *

                                    </span></label>



                                <input type="text" class="form-control" name="name" value="{{ $editemployee->name }}"
                                    placeholder="name" required>



                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror



                            </div>



                            <div class="form-group col-md-6">



                                <label class="form-label">{{ trans('labels.email') }}<span class="text-danger"> *

                                    </span></label>



                                <input type="email" class="form-control" name="email" value="{{ $editemployee->email }}"
                                    placeholder="email" required>



                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror



                            </div>

                            <div class="col-md-6">

                                <div class="form-group ">



                                    <label class="form-label">{{ trans('labels.mobile') }}<span class="text-danger"> *

                                        </span></label>



                                    <input type="number" class="form-control" name="mobile"
                                        value="{{ $editemployee->mobile }}" placeholder="mobile" required>



                                    @error('mobile')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror



                                </div>



                            </div>

                            <div class="col-md-6 form-group">



                                <label class="form-label">{{ trans('labels.image') }} (250 x 250) </label>



                                <input type="file" class="form-control" name="profile">



                                <img class="rounded-circle mt-2" src="{{ helper::image_path($editemployee->image) }}"
                                    alt="" width="70" height="70">



                                @error('profile')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            @if (Auth::user()->type == 2 || (Auth::user()->type == 4 && Auth::user()->vendor_id != 1))
                                <div class="form-group col-6">
                                    <label for="role_selection" class="form-label">{{ trans('labels.type') }}<span
                                            class="text-danger"> * </span></label>
                                    <select name="role_selection" class="form-select" id="role_selection" required>
                                        <option value="">{{ trans('labels.select') }}</option>
                                        <option value="1" {{ $editemployee->role_type == 1 ? 'selected' : '' }}>
                                            {{ trans('labels.staff') }}</option>
                                        <option value="2" {{ $editemployee->role_type == 2 ? 'selected' : '' }}>
                                            {{ trans('labels.employees') }}</option>
                                    </select>
                                </div>
                            @endif
                            <div class="form-group col-6 {{ Auth::user()->type == 2 || (Auth::user()->type == 4 && Auth::user()->vendor_id != 1) ? 'd-none' : '' }}"
                                id="role_employee">
                                <label for="role" class="form-label">{{ trans('labels.role') }}<span
                                        class="text-danger"> * </span></label>

                                <select name="role" class="form-select" id="role" required>

                                    <option value="">{{ trans('labels.select') }}</option>

                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}"
                                            {{ $role->id == $editemployee->role_id ? 'selected' : '' }}>
                                            {{ $role->role }}

                                        </option>
                                    @endforeach

                                </select>

                            </div>

                            <div class="form-group text-{{ session()->get('direction') == '2' ? 'start' : 'end' }} m-0">



                                <a href="{{ URL::to('admin/employees') }}"
                                    class="btn btn-danger px-sm-4">{{ trans('labels.cancel') }}</a>



                                <button
                                    @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif
                                    class="btn btn-primary px-sm-4 {{ Auth::user()->type == 4 ? (helper::check_access('role_employees', Auth::user()->role_id, $vendor_id, 'edit') == 1 ? '' : 'd-none') : '' }}">{{ trans('labels.save') }}</button>



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
        $('#role_selection').on('change', function() {
            if ($('#role_selection').val() == 2) {
                $('#role_employee').removeClass('d-none');
                $('#role').prop('required', true);
            } else {
                $('#role_employee').addClass('d-none');
                $('#role').prop('required', false);
            }
        }).change();
    </script>
@endsection
