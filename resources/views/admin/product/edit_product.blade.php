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
            <div class="card border-0 box-shadow mb-3">
                <div class="card-body">
                    <form action="{{ URL::to('/admin/products/update-' . $product->slug) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6 form-group">
                                <label class="form-label">{{ trans('labels.category') }}
                                    <span class="text-danger"> *</span></label>
                                <select class="form-select" name="category_name" id="categry" required>
                                    <option value="">{{ trans('labels.select') }}</option>
                                    @if (!empty($category))
                                        @foreach ($category as $category_name)
                                            <option value="{{ $category_name->id }}"
                                                {{ $category_name->id == $product->category_id ? 'selected' : '' }}>
                                                {{ $category_name->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-sm-6 form-group">
                                <label class="form-label">{{ trans('labels.name') }}
                                    <span class="text-danger"> *</span></label>
                                <input type="text" class="form-control" name="product_name" value="{{ $product->name }}"
                                    placeholder="{{ trans('labels.name') }}" required>

                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">
                                        {{ trans('labels.original_price') }}
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" step="any" class="form-control numbers_only"
                                        name="original_price" value="{{ $product->original_price }}"
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
                                        value="{{ $product->price }}" placeholder="{{ trans('labels.selling_price') }}"
                                        id="price" required="">
                                </div>
                            </div>
                            <div class="col-sm-6 form-group">
                                <label class="form-label">{{ trans('labels.tax') }}</label>
                                <select name="tax[]" class="form-control selectpicker" multiple data-live-search="true">
                                    @if (!empty($gettaxlist))
                                        @foreach ($gettaxlist as $tax)
                                            <option value="{{ $tax->id }}"
                                                {{ in_array($tax->id, explode('|', $product->tax)) ? 'selected' : '' }}>
                                                {{ $tax->name }} </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-md-6 mb-lg-0">
                                <div class="form-group">
                                    <label class="form-label">{{ trans('labels.video_url') }}</label>
                                    <input type="text" class="form-control"
                                        name="video_url"placeholder="{{ trans('labels.video_url') }}"
                                        value="{{ $product->video_url }}">
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
                                                        name="has_stock" id="stock_no" value="2"
                                                        {{ $product->stock_management == 2 ? 'checked' : '' }}>
                                                    <label class="form-check-label"
                                                        for="stock_no">{{ trans('labels.no') }}</label>
                                                </div>
                                                <div class="form-check-inline">
                                                    <input class="form-check-input me-0 has_stock" type="radio"
                                                        name="has_stock" id="stock_yes" value="1"
                                                        {{ $product->stock_management == 1 ? 'checked' : '' }}>
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
                                                value="{{ $product->qty }}" placeholder="Stock Qty" id="qty">
                                        </div>
                                    </div>
                                    <div class="col-md-3" id="block_min_order">
                                        <div class="form-group">
                                            <label class="form-label">
                                                {{ trans('labels.min_order_qty') }}
                                                <span class="text-danger"> * </span>
                                            </label>
                                            <input type="text" class="form-control numbers_decimal" name="min_order"
                                                value="{{ $product->min_order }}"
                                                placeholder="{{ trans('labels.min_order_qty') }}" id="min_order">

                                        </div>
                                    </div>
                                    <div class="col-md-3" id="block_max_order">
                                        <div class="form-group">
                                            <label class="form-label">
                                                {{ trans('labels.max_order_qty') }}
                                                <span class="text-danger"> * </span>
                                            </label>
                                            <input type="text" class="form-control numbers_decimal" name="max_order"
                                                value="{{ $product->max_order }}"
                                                placeholder="{{ trans('labels.max_order_qty') }}" id="max_order">

                                        </div>
                                    </div>
                                    <div class="col-md-3" id="block_product_low_qty_warning">
                                        <div class="form-group">
                                            <label class="form-label">
                                                {{ trans('labels.low_order_qty') }}
                                                <span class="text-danger"> * </span>
                                            </label>
                                            <input type="text" class="form-control numbers_decimal" name="low_qty"
                                                id="low_qty" value="{{ $product->low_qty }}"
                                                placeholder="{{ trans('labels.low_order_qty') }}">

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <label class="form-label">{{ trans('labels.description') }}</label>
                                <textarea name="description" class="form-control" id="ckeditor" placeholder="{{ trans('labels.description') }}">{{ $product->description }}</textarea>
                            </div>
                        </div>
                        <div class="form-group d-flex justify-content-end m-0">
                            <a href="{{ URL::to('admin/products') }}"
                                class="btn btn-danger px-sm-4 mx-2">{{ trans('labels.cancel') }}</a>
                            <button
                                @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif
                                class="btn btn-primary px-sm-4">{{ trans('labels.save') }}</button>
                        </div>
                    </form>
                </div>
            </div>

            @if ($product['multi_image']->count() > 0)
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="card border-0 box-shadow mb-3">
                            <div class="card-body">
                                <div class="row g-3 sort_menu"
                                    data-url="{{ url('admin/products/reorder_image-' . $product->id) }}"
                                    id="carddetails">
                                    <div class="col-12 d-flex flex-wrap justify-content-between align-items-center mb-2">
                                        <h5 class="text-capitalize fw-600 text-dark color-changer">
                                            {{ trans('labels.products_images') }}
                                        </h5>
                                        <a href="javascript:void(0)" onclick="addimage('{{ $product->id }}')"
                                            class="btn btn-primary mt-2 mt-sm-0 col-sm-auto col-12 px-sm-4">
                                            <i class="fa-regular fa-plus mx-1"></i>{{ trans('labels.add_new') }}
                                        </a>
                                    </div>
                                    @foreach ($product['multi_image'] as $productimage)
                                        <div class="col-xl-2 col-lg-3 col-md-4 col-6" data-id="{{ $productimage->id }}">
                                            <div class="card h-100 border-0 handle">
                                                <img src="{{ helper::image_path($productimage->image_name) }}"
                                                    class="rounded-3 w-100 object" height="200px">
                                                <div class="d-flex gap-1 my-2 justify-content-center">
                                                    <a tooltip="{{ trans('labels.move') }}"
                                                        class="btn btn-secondary hov btn-sm">
                                                        <i class="fa-light fa-up-down-left-right"></i>
                                                    </a>
                                                    img_id
                                                    <a href="javascript:void(0)"
                                                        onclick="statusupdate('{{ URL::to('/admin/products/delete_image-' . $productimage->id . '/' . $productimage->product_id) }}')"
                                                        class="btn btn-danger hov btn-sm @if ($product['multi_image']->count() == 1) d-none @else '' @endif">
                                                        <i class="fa-regular fa-trash"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif


            <div class="card border-0 mb-3 box-shadow">
                <div class="card-body">
                    <div class="table-responsive">
                        <table
                            class="table table-striped table-bordered py-3 zero-configuration w-100 dataTable no-footer">
                            <thead>
                                <tr class="text-capitalize fw-500 fs-15">
                                    <td>{{ trans('labels.srno') }}</td>
                                    <td>{{ trans('labels.image') }}</td>
                                    <td>{{ trans('labels.name') }}</td>
                                    <td>{{ trans('labels.description') }}</td>
                                    <td>{{ trans('labels.ratting') }}</td>
                                    <td>{{ trans('labels.action') }}</td>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 1;
                                @endphp
                                @foreach ($productreview as $item)
                                    <tr class="fs-7 row1 align-middle" id="dataid{{ $item->id }}"
                                        data-id="{{ $item->id }}">
                                        <td>@php echo $i++;@endphp</td>
                                        <td>
                                            <img src="{{ @helper::image_path($item->user_info->image) }}"
                                                class="img-fluid rounded hw-50" alt="">
                                        </td>
                                        <td>{{ @$item->user_info->name }}</td>
                                        <td>{{ $item->description }}</td>
                                        <td>{{ $item->star }} </td>
                                        <td>
                                            <a href="javascript:void(0)"
                                                @if (env('Environment') == 'sendbox') onclick="myFunction()" @else onclick="statusupdate('{{ URL::to('/admin/products/review/delete-' . $item->id) }}')" @endif
                                                class="btn btn-danger btn-sm hov {{ Auth::user()->type == 4 ? (helper::check_access('role_products', Auth::user()->role_id, Auth::user()->vendor_id, 'edit') == 1 ? '' : 'd-none') : '' }}">
                                                <i class="fa-regular fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- add Modal --}}
    <div class="modal modal-fade-transform" id="addModal" tabindex="-1" aria-labelledby="addModallable"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header justify-content-between">
                    <h5 class="modal-title" id="addModallable">
                        <span class="color-changer">
                            {{ trans('labels.image') }}
                        </span>
                        <span class="text-danger"> * </span>
                    </h5>
                    <button type="button" class="bg-transparent border-0 color-changer" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="fa-regular fa-xmark fs-4"></i>
                    </button>
                </div>
                <form action=" {{ URL::to('/admin/products/add_image') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" id="product_id" name="product_id">
                        <input type="file" name="image[]" multiple="" class="form-control" id="">
                    </div>
                    <div class="modal-footer">
                        <button
                            @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif
                            class="btn btn-primary px-sm-4">{{ trans('labels.save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- edit Modal --}}
    <div class="modal modal-fade-transform" id="editModal" tabindex="-1" aria-labelledby="editModallable"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header justify-content-between">
                    <h5 class="modal-title" id="editModallable">
                        <span class="color-changer">
                            {{ trans('labels.image') }}
                        </span>
                        <span class="text-danger"> * </span>
                    </h5>
                    <button type="button" class="bg-transparent border-0 color-changer" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="fa-regular fa-xmark fs-4"></i>
                    </button>
                </div>
                <form action=" {{ URL::to('/admin/products/update') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" id="img_id" name="id">
                        <input type="hidden" id="img_name" name="image">
                        <input type="file" name="product_image" class="form-control" id="">
                    </div>
                    <div class="modal-footer">
                        <button
                            @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif
                            class="btn btn-primary px-sm-4">{{ trans('labels.save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.12.1/ckeditor.js"></script>
    <script src="{{ url(env('ASSETPATHURL') . 'admin-assets/js/editor.js') }}"></script>
    <script src="{{ url(env('ASSETPATHURL') . 'admin-assets/js/product.js') }}"></script>
@endsection
