@extends('admin.layout.default')
@section('content')
    @include('admin.breadcrumb.breadcrumb')
    <div class="row">
        <div class="col-12">
            <div class="card border-0 box-shadow">
                <div class="card-body">
                    <form action="{{ URL::to('/admin/promocode/update-' . $promocode->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6 form-group">
                                <label class="form-label">{{ trans('labels.coupon_name') }}<span class="text-danger">
                                        * </span></label>
                                <input type="text" class="form-control" name="offer_name"
                                    value="{{ $promocode->offer_name }}" placeholder="{{ trans('labels.coupon_name') }}"
                                    required>
                                
                            </div>
                            <div class="col-sm-6 form-group">
                                <label class="form-label">{{ trans('labels.coupon_code') }}<span class="text-danger">
                                        *
                                    </span></label>
                                <input type="text" class="form-control" name="offer_code"
                                    value="{{ $promocode->offer_code }}" placeholder="{{ trans('labels.coupon_code') }}"
                                    required>
                              
                            </div>
                            <div class="col-md-6 form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="form-label">{{ trans('labels.discount_type') }}<span
                                                class="text-danger">
                                                * </span></label>
                                        <select class="form-select" name="offer_type" required>
                                            <option value="0">{{ trans('labels.select') }}</option>
                                            <option value="1" {{ $promocode->offer_type == '1' ? 'selected' : '' }}>
                                                {{ trans('labels.fixed') }}</option>
                                            <option value="2" {{ $promocode->offer_type == '2' ? 'selected' : '' }}>
                                                {{ trans('labels.percentage') }}</option>
                                        </select>
                                       
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">{{ trans('labels.discount') }}<span class="text-danger">
                                                *
                                            </span></label>
                                        <input type="number" class="form-control numbers_decimal" name="amount"
                                            value="{{ $promocode->offer_amount }}"
                                            placeholder="{{ trans('labels.discount') }}" required>
                                       
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 form-group">
                                <label class="form-label">{{ trans('labels.min_order_amount') }}<span class="text-danger">
                                        * </span></label>
                                <input type="number" class="form-control numbers_decimal" name="order_amount"
                                    value="{{ $promocode->min_amount }}"
                                    placeholder="{{ trans('labels.min_order_amount') }}" required>
                              
                            </div>
                            <div class="col-sm-6">

                                <div class="row">

                                    <div class="col-sm-6 form-group">
                                        <label class="form-label">{{ trans('labels.start_date') }}<span
                                                class="text-danger"> *
                                            </span></label>
                                        <input type="date" class="form-control" name="start_date"
                                            value="{{ $promocode->start_date }}"
                                            placeholder="{{ trans('labels.start_date') }}" required>
                                       
                                    </div>
                                    <div class="col-sm-6 form-group">
                                        <label class="form-label">{{ trans('labels.end_date') }}<span class="text-danger">
                                                *
                                            </span></label>
                                        <input type="date" class="form-control" name="end_date"
                                            value="{{ $promocode->exp_date }}"
                                            placeholder="{{ trans('labels.end_date') }}" required>
                                        
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">{{ trans('labels.usage_type') }}<span class="text-danger"> *
                                        </span></label>
                                    <select class="form-select type" name="usage_type">
                                        <option value="0">Select</option>
                                        <option value="1" {{ $promocode->usage_type == '1' ? 'selected' : '' }}>
                                            {{ trans('labels.limited') }}</option>
                                        <option value="2" {{ $promocode->usage_type == '2' ? 'selected' : '' }}>
                                            {{ trans('labels.unlimited') }}</option>
                                    </select>
                                    
                                </div>

                                <div class="form-group" id="usage_limit_input">
                                    <label class="form-label">{{ trans('labels.usage_limit') }}<span class="text-danger">
                                            * </span></label>
                                    <input type="text" class="form-control numbers_only" name="usage_limit"
                                        value="{{ $promocode->usage_limit }}"
                                        placeholder="{{ trans('labels.usage_limit') }}">
                                   
                                </div>


                            </div>
                            <div class="col-sm-6">
                                <label class="form-label">{{ trans('labels.description') }}<span class="text-danger"> *
                                    </span></label>
                                <textarea name="description" class="form-control" rows="4" placeholder="{{ trans('labels.description') }}"
                                    required>{{ $promocode->description }}</textarea>
                                
                            </div>
                        </div>
                        <div class="form-group text-{{ session()->get('direction') == '2' ? 'start' : 'end' }} m-0">
                            <a href="{{ URL::to('admin/promocode') }}"
                                class="btn btn-danger px-sm-4">{{ trans('labels.cancel') }}</a>
                            <button
                                @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif
                                class="btn btn-primary px-sm-4 {{ Auth::user()->type == 4 ? (helper::check_access('role_coupons', Auth::user()->role_id, $vendor_id, 'edit') == 1 ? '' : 'd-none') : '' }}">{{ trans('labels.save') }}</button>
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
    <script src="{{ url(env('ASSETPATHURL') . 'admin-assets/js/promocode.js') }}"></script>
@endsection
