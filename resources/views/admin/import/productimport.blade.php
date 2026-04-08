@extends('admin.layout.default')
@section('content')
    <div class="mb-3 d-flex flex-wrap justify-content-between align-items-center">
        <h5 class="text-capitalize fw-600 text-dark fs-4 color-changer">{{ trans('labels.product_s_upload') }}</h5>
        <a href="{{ URL::to('/admin/productmedia') }}"
            class="btn btn-secondary col-12 mt-2 mt-sm-0 justify-content-center gap-1 col-sm-auto px-sm-4 d-flex  {{ Auth::user()->type == 4 ? (helper::check_access('role_products_bulk_import', Auth::user()->role_id, Auth::user()->vendor_id, 'add') == 1 ? '' : 'd-none') : '' }}">
            <i class="fa-regular fa-plus mx-1"></i>{{ trans('labels.add_media') }}
        </a>
    </div>
    <div class="row">
        <div class="col-12 mb-3">
            <div class="card border-0 box-shadow mb-3">
                <div class="card-header p-3 bg-transparent border-bottom">
                    <h6 class="text-dark fs-600 color-changer">{{ trans('labels.step_1') }} :</h6>
                </div>
                <div class="card-body">
                    <ul class="fs-7 d-flex text-dark flex-column gap-2 fw-500">
                        <li class="d-flex gap-1 color-changer"><b>1.</b> {{ trans('labels.download_file') }}</li>
                        <li class="d-flex gap-1 color-changer"><b>2.</b> {{ trans('labels.download_example_file_to_understand') }}</li>
                        <li class="d-flex gap-1 color-changer"><b>3.</b> {{ trans('labels.upload_submit') }}</li>
                        <li class="d-flex gap-1 color-changer"><b>4.</b> {{ trans('labels.after_uploading_products') }}</li>
                    </ul>
                </div>
            </div>
            <a href="{{ url(env('ASSETPATHURL') . 'admin-assets/productsample.xlsx') }}"
                class="btn btn-primary px-sm-4 mb-3">{{ trans('labels.download_CSV') }}</a>
            <div class="card border-0 box-shadow mb-3">
                <div class="card-header p-3 bg-transparent border-bottom">
                    <h6 class="text-dark fs-600 color-changer">{{ trans('labels.step_2') }} :</h6>
                </div>
                <div class="card-body">
                    <ul class="fs-7 d-flex text-dark flex-column gap-2 fw-500">
                        <li class="d-flex gap-1 color-changer"><b>1.</b> {{ trans('labels.category_numeric') }}</li>
                        <li class="d-flex gap-1 color-changer"><b>2.</b> {{ trans('labels.download_pdf') }}</li>
                    </ul>
                </div>
            </div>
            <a href="{{ URL::to('/admin/productgeneratepdf') }}"
                class="btn btn-primary px-sm-4 mb-3">{{ trans('labels.download_category') }}</a>
            <div class="card border-0 box-shadow mb-3">
                <div class="card-header p-3 bg-transparent border-bottom">
                    <h6 class="text-dark fs-600 color-changer">{{ trans('labels.step_3') }} :</h6>
                </div>
                <div class="card-body">
                    <ul class="fs-7 d-flex text-dark flex-column gap-2 fw-500">
                        <li class="d-flex gap-1 color-changer"><b>1.</b> {{ trans('labels.tax_numeric') }}</li>
                        <li class="d-flex gap-1 color-changer"><b>2.</b> {{ trans('labels.download_taxpdf') }}</li>
                        <li class="d-flex gap-1 color-changer"><b>3.</b> {{ trans('labels.multiple_tax_msg') }}</li>
                    </ul>
                </div>
            </div>
            <a href="{{ URL::to('/admin/generatetaxpdf') }}"
                class="btn btn-primary px-sm-4 mb-3">{{ trans('labels.download_tax') }}</a>
            <div class="card border-0 box-shadow">
                <div class="card-body">
                    <form action="{{ URL::to('/admin/importproducts') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="col-12 form-group">
                            <label class="form-label">{{ trans('labels.product_s_upload') }}
                                <span class="text-danger"> * </span></label>
                            <input type="file" class="form-control" name="importfile" id="importfile" multiple=""
                                required>
                        </div>
                        <button class="btn btn-primary px-sm-4">{{ trans('labels.import') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
