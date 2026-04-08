<form action="{{ URL::to('admin/settings/commission') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div id="commission_module">
        <div class="row mb-5">
            <div class="col-12">
                <div class="card border-0 box-shadow">
                    <div class="card-header p-3 bg-secondary">

                        <h5 class="text-capitalize fw-600 text-dark color-changer">{{ trans('labels.default_commission') }}
                        </h5>

                    </div>
                    <div class="card-body">

                        <div class="row">
                            <div class="form-group">
                                <label class="form-label">{{ trans('labels.commission_type') }}</label>
                                <select class="form-select commission_type" name="commission_type">
                                    <option value="1" {{ Auth::user()->commission_type == '1' ? 'selected' : '' }}>
                                        {{ trans('labels.fixed') }}
                                    </option>
                                    <option value="2" {{ Auth::user()->commission_type == '2' ? 'selected' : '' }}>
                                        {{ trans('labels.percentage') }}
                                    </option>
                                </select>
                            </div>
                            <div class="form-group 1 commission_amount">
                                <label class="form-label">{{ trans('labels.commission_amount') }}<span
                                        class="text-danger">
                                        *</span></label>
                                <input type="text" class="form-control numbers_only" name="commission_amount"
                                    value="{{ Auth::user()->commission_amount }}"
                                    placeholder="{{ trans('labels.commission_amount') }}">
                            </div>
                            <div class="form-group">
                                <label class="form-label">{{ trans('labels.min_amount_for_payout') }}<span
                                        class="text-danger">
                                        *</span></label>
                                <input type="text" class="form-control numbers_only" name="min_amount_for_payout"
                                    value="{{ Auth::user()->min_amount_for_payout }}"
                                    placeholder="{{ trans('labels.min_amount_for_payout') }}">
                            </div>
                        </div>
                        <div class="text-{{ session()->get('direction') == '2' ? 'start' : 'end' }}">
                            <button
                                @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif
                                class="btn btn-primary px-sm-4 {{ Auth::user()->type == 4 ? (helper::check_access('role_general_settings', Auth::user()->role_id, Auth::user()->vendor_id, 'edit') == 1 ? '' : 'd-none') : '' }}">{{ trans('labels.save') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
