@extends('admin.layout.default')
@section('content')
    @php
        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
    @endphp
    @include('admin.breadcrumb.breadcrumb')
    <div class="row">
        <div class="col-12">
            <div class="card border-0 box-shadow">
                <div class="card-body">
                    <form action="{{ URL::to('/admin/employees/save') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="form-group col-6">
                                <label for="name" class="form-label">{{ trans('labels.name') }}<span class="text-danger">
                                        *

                                    </span></label>

                                <input type="text" class="form-control" name="name" value="{{ old('name') }}"
                                    placeholder="{{ trans('labels.name') }}" required>

                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror

                            </div>

                            <div class="form-group col-6">

                                <label for="email" class="form-label">{{ trans('labels.email') }}<span
                                        class="text-danger"> *

                                    </span></label>

                                <input type="email" class="form-control" name="email" value="{{ old('email') }}"
                                    placeholder="{{ trans('labels.email') }}" required>

                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror

                            </div>

                            <div class="form-group col-6">

                                <label for="mobile" class="form-label">{{ trans('labels.mobile') }}<span
                                        class="text-danger">

                                        * </span></label>

                                <input type="number" class="form-control" name="mobile" value="{{ old('mobile') }}"
                                    placeholder="{{ trans('labels.mobile') }}" required>

                                @error('mobile')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror

                            </div>

                            <div class="form-group col-6">

                                <label for="password" class="form-label">{{ trans('labels.password') }}<span
                                        class="text-danger"> * </span></label>

                                <input type="password" class="form-control" name="password" value="{{ old('password') }}"
                                    placeholder="{{ trans('labels.password') }}" required>

                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror

                            </div>
                            @if (Auth::user()->type == 2 || (Auth::user()->type == 4 && Auth::user()->vendor_id != 1))
                                <div class="form-group col-6">
                                    <label for="role_selection" class="form-label">{{ trans('labels.type') }}<span
                                            class="text-danger"> * </span></label>
                                    <select name="role_selection" class="form-select" id="role_selection" required>
                                        <option value="">{{ trans('labels.select') }}</option>
                                        <option value="1">{{ trans('labels.staff') }}</option>
                                        <option value="2">{{ trans('labels.employees') }}</option>
                                    </select>
                                </div>
                            @endif
                            <div class="form-group col-6 {{ Auth::user()->type == 2 || (Auth::user()->type == 4 && Auth::user()->vendor_id != 1) ? 'd-none' : '' }}"
                                id="role_employee">
                                <label for="role" class="form-label">{{ trans('labels.role') }}<span
                                        class="text-danger"> * </span></label>
                                <select name="role" class="form-select " id="role" required>
                                    <option value="">{{ trans('labels.select') }}</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->role }}</option>
                                    @endforeach
                                </select>

                            </div>

                        </div>

                        <div class="form-group text-{{ session()->get('direction') == '2' ? 'start' : 'end' }} m-0">
                            <a href="{{ URL::to('admin/employees') }}"
                                class="btn btn-danger px-sm-4">{{ trans('labels.cancel') }}</a>
                            <button
                                @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif
                                class="btn btn-primary px-sm-4 {{ Auth::user()->type == 4 ? (helper::check_access('role_employees', Auth::user()->role_id, $vendor_id, 'add') == 1 ? '' : 'd-none') : '' }}">{{ trans('labels.save') }}</button>
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
