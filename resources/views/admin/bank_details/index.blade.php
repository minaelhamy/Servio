<form action="{{ URL::to('admin/settings/bank_details') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div id="bank_details">
        <div class="row mb-5">
            <div class="col-12">
                <div class="card border-0 box-shadow">
                    <div class="card-header p-3 bg-secondary">
                        <h5 class="text-capitalize fw-600 text-dark color-changer">
                            {{ trans('labels.bank_details') }}</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label class="form-label">{{ trans('labels.name') }}
                                    <span class="text-danger"> *</span></label>
                                <input type="text" class="form-control" name="name"
                                    value="{{ @$bank_details->name }}" placeholder="{{ trans('labels.name') }}"
                                    required>
                            </div>
                            <div class="form-group col-sm-6">
                                <label class="form-label">{{ trans('labels.bank_account_number') }}
                                    <span class="text-danger"> * </span></label>
                                <input type="text" class="form-control" name="bank_account_number"
                                    value="{{ @$bank_details->bank_account_number }}"
                                    placeholder="{{ trans('labels.bank_account_number') }}" required>
                            </div>
                            <div class="form-group col-sm-6">
                                <label class="form-label">{{ trans('labels.email') }}
                                    <span class="text-danger"> *</span></label>
                                <input type="text" class="form-control" name="email"
                                    value="{{ @$bank_details->email }}" placeholder="{{ trans('labels.email') }}"
                                    required>
                            </div>
                            <div class="form-group col-sm-6">
                                <label class="form-label">{{ trans('labels.type_of_account') }}
                                    <span class="text-danger"> * </span></label>
                                <input type="text" class="form-control" name="type_of_account"
                                    value="{{ @$bank_details->type_of_account }}"
                                    placeholder="{{ trans('labels.type_of_account') }}" required>
                            </div>
                        </div>
                        <div class="text-{{ session()->get('direction') == '2' ? 'start' : 'end' }}">
                            <button
                                @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif
                                class="btn btn-primary px-sm-4  {{ Auth::user()->type == 4 ? (helper::check_access('role_general_settings', Auth::user()->role_id, Auth::user()->vendor_id, 'edit') == 1 ? '' : 'd-none') : '' }}">{{ trans('labels.save') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
