@extends('admin.layout.default')
@section('content')
    @php
        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        $user = App\Models\User::where('id', $vendor_id)->first();
    @endphp
    @include('admin.breadcrumb.breadcrumb')
    <div class="row">
        <div class="col-12">
            <div class="card border-0 box-shadow">
                <div class="card-body">
                    <form action="{{ URL::to('/admin/products/save') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6 form-group">
                                <label class="form-label">{{ trans('labels.category') }}<span class="text-danger"> *
                                    </span></label>
                                <select class="form-select" name="category_name" id="categry" required>
                                    <option value="">{{ trans('labels.select') }}</option>
                                    @if (!empty($category))
                                        @foreach ($category as $category_name)
                                            <option value="{{ $category_name->id }}"
                                                {{ old('category_name') == $category_name->id ? 'selected' : '' }}>
                                                {{ $category_name->name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-sm-6 form-group">
                                <label class="form-label">{{ trans('labels.name') }}<span class="text-danger"> *
                                    </span></label>
                                <input type="text" class="form-control" name="product_name"
                                    value="{{ old('product_name') }}" placeholder="{{ trans('labels.name') }}" required>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">
                                        {{ trans('labels.original_price') }}<span class="text-danger">*</span>
                                    </label>
                                    <input type="text" step="any" class="form-control numbers_only"
                                        name="original_price" value=""
                                        placeholder="{{ trans('labels.original_price') }}" id="original_price"
                                        required="">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">
                                        {{ trans('labels.selling_price') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" step="any" class="form-control numbers_only" name="price"
                                        value="" placeholder="{{ trans('labels.selling_price') }}" id="price"
                                        required="">
                                </div>
                            </div>

                            <div class="col-sm-4 form-group">
                                <label class="form-label">{{ trans('labels.tax') }}</label>
                                <select name="tax[]" class="form-control selectpicker" multiple data-live-search="true">
                                    @if (!empty($gettaxlist))
                                        @foreach ($gettaxlist as $tax)
                                            <option value="{{ $tax->id }}"> {{ $tax->name }} </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-sm-4 form-group">
                                <label class="form-label">{{ trans('labels.image') }}
                                    <span class="text-danger">*</span></label>
                                <input type="file" class="form-control" name="product_image[]" multiple="" required>
                            </div>

                            <div class="col-md-4 mb-lg-0">
                                <div class="form-group">
                                    <label class="form-label">{{ trans('labels.video_url') }}</label>
                                    <input type="text" class="form-control" name="video_url"
                                        placeholder="{{ trans('labels.video_url') }}" value="{{ old('video_url') }}">
                                </div>
                            </div>



                            <div class="col-12">
                                <div class="row" id="price_row">
                                    <div class="col-12 d-flex align-items-center justify-content-between">
                                        <div class="form-group">
                                            <label for="has_stock"
                                                class="form-label">{{ trans('labels.stock_management') }}</label>
                                            <div class="col-md-12">
                                                <div class="form-check-inline">
                                                    <input class="form-check-input me-0 has_stock" type="radio"
                                                        name="has_stock" id="stock_no" value="2" checked="">
                                                    <label class="form-check-label"
                                                        for="stock_no">{{ trans('labels.no') }}</label>
                                                </div>
                                                <div class="form-check-inline">
                                                    <input class="form-check-input me-0 has_stock" type="radio"
                                                        name="has_stock" id="stock_yes" value="1">
                                                    <label class="form-check-label"
                                                        for="stock_yes">{{ trans('labels.yes') }}</label>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3" id="block_stock_qty">
                                        <div class="form-group">
                                            <label class="form-label">{{ trans('labels.stock_qty') }}<span
                                                    class="text-danger"> * </span></label>
                                            <input type="text" class="form-control numbers_decimal" name="qty"
                                                value="" placeholder="Stock Qty" id="qty">
                                        </div>
                                    </div>
                                    <div class="col-md-3" id="block_min_order">
                                        <div class="form-group">
                                            <label class="form-label">
                                                {{ trans('labels.min_order_qty') }}
                                                <span class="text-danger"> * </span>
                                            </label>
                                            <input type="text" class="form-control numbers_decimal" name="min_order"
                                                value="" placeholder="{{ trans('labels.min_order_qty') }}"
                                                id="min_order">

                                        </div>
                                    </div>
                                    <div class="col-md-3" id="block_max_order">
                                        <div class="form-group">
                                            <label class="form-label">
                                                {{ trans('labels.max_order_qty') }}
                                                <span class="text-danger"> * </span>
                                            </label>
                                            <input type="text" class="form-control numbers_decimal" name="max_order"
                                                value="" placeholder="{{ trans('labels.max_order_qty') }}"
                                                id="max_order">

                                        </div>
                                    </div>
                                    <div class="col-md-3" id="block_product_low_qty_warning">
                                        <div class="form-group">
                                            <label class="form-label">
                                                {{ trans('labels.low_order_qty') }}
                                                <span class="text-danger"> * </span>
                                            </label>
                                            <input type="text" class="form-control numbers_decimal" name="low_qty"
                                                id="low_qty" value="0"
                                                placeholder="{{ trans('labels.low_order_qty') }}">

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 form-group">
                                <label class="form-label">{{ trans('labels.description') }}</label>
                                <textarea name="description" class="form-control" id="ckeditor" placeholder="{{ trans('labels.description') }}">{{ old('description') }}
                                </textarea>
                            </div>
                        </div>
                        <div class="form-group text-{{ session()->get('direction') == '2' ? 'start' : 'end' }} m-0">
                            <a href="{{ URL::to('admin/products') }}"
                                class="btn btn-danger px-sm-4">{{ trans('labels.cancel') }}</a>
                            <button
                                @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif
                                class="btn btn-primary px-sm-4 {{ Auth::user()->type == 4 ? (helper::check_access('role_products', Auth::user()->role_id, Auth::user()->vendor_id, 'add') == 1 ? '' : 'd-none') : '' }}">{{ trans('labels.save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.12.1/ckeditor.js"></script>
    <script src="{{ url(env('ASSETPATHURL') . 'admin-assets/js/editor.js') }}"></script>
    <script src="{{ url(env('ASSETPATHURL') . 'admin-assets/js/product.js') }}"></script>
@endsection
