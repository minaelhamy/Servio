<div id="email_settings">
    <div class="row mb-5">
        <div class="col-12">
            <div class="card border-0 box-shadow">
                <div class="card-header p-3 bg-secondary">
                    <h5 class="text-capitalize fw-600 text-dark color-changer">{{ trans('labels.email_settings') }}
                    </h5>
                </div>
                <div class="card-body">

                    @if (env('Environment') == 'sendbox')
                        <form action="" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label class="form-label">{{ trans('labels.mail_driver') }}<span
                                            class="text-danger"> *
                                        </span></label>
                                    <input type="text" class="form-control demo_hide_text" name="mail_driver"
                                        pattern="*" value="*****************************"
                                        placeholder="{{ trans('labels.mail_driver') }}" required>
                                    @error('mail_driver')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-sm-6">
                                    <label class="form-label">{{ trans('labels.mail_host') }}<span class="text-danger">
                                            *
                                        </span></label>
                                    <input type="text" class="form-control demo_hide_text" name="mail_host"
                                        pattern="*" value="*****************************"
                                        placeholder="{{ trans('labels.mail_host') }}" required>
                                    @error('mail_host')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-sm-6">
                                    <label class="form-label">{{ trans('labels.mail_port') }}<span class="text-danger">
                                            *
                                        </span></label>
                                    <input type="text" class="form-control demo_hide_text" name="mail_port"
                                        pattern="*" value="*****************************"
                                        placeholder="{{ trans('labels.mail_port') }}" required>
                                    @error('mail_port')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-sm-6">
                                    <label class="form-label">{{ trans('labels.mail_username') }}<span
                                            class="text-danger">
                                            *
                                        </span></label>
                                    <input type="text" class="form-control demo_hide_text" name="mail_username"
                                        pattern="*" value="*****************************"
                                        placeholder="{{ trans('labels.mail_username') }}" required>
                                    @error('mail_username')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-sm-6">
                                    <label class="form-label">{{ trans('labels.mail_password') }}<span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control demo_hide_text" name="mail_password"
                                        pattern="*" value="*****************************"
                                        placeholder="{{ trans('labels.mail_password') }}" required>
                                    @error('mail_password')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-sm-6">
                                    <label class="form-label">{{ trans('labels.mail_encryption') }}<span
                                            class="text-danger"> *
                                        </span></label>
                                    <input type="text" class="form-control demo_hide_text" name="mail_encryption"
                                        pattern="*" value="*****************************"
                                        placeholder="{{ trans('labels.mail_encryption') }}" required>
                                    @error('mail_encryption')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-sm-6">
                                    <label class="form-label">{{ trans('labels.mail_fromaddress') }}<span
                                            class="text-danger">
                                            * </span></label>
                                    <input type="text" class="form-control demo_hide_text" name="mail_fromaddress"
                                        pattern="*" value="*****************************"
                                        placeholder="{{ trans('labels.mail_fromaddress') }}" required>
                                    @error('mail_fromaddress')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-sm-6">
                                    <label class="form-label">{{ trans('labels.mail_fromname') }}<span
                                            class="text-danger">
                                            *
                                        </span></label>
                                    <input type="text" class="form-control demo_hide_text" name="mail_fromname"
                                        pattern="*" value="*****************************"
                                        placeholder="{{ trans('labels.mail_fromname') }}" required>
                                    @error('mail_fromname')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <button type="button" onclick="myFunction()"
                                    class="btn btn-secondary px-sm-4">{{ trans('labels.send_test_mail') }}</button>
                                <button type="button" onclick="myFunction()"
                                    class="btn btn-primary px-sm-4">{{ trans('labels.save') }}</button>
                            </div>
                        </form>
                    @else
                        <form action="{{ URL::to('/admin/emailsettings') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="form-group col-sm-6">
                                    <label class="form-label">{{ trans('labels.mail_driver') }}<span
                                            class="text-danger"> *
                                        </span></label>
                                    <input type="text" class="form-control" name="mail_driver" pattern="*"
                                        value="{{ @$settingdata->mail_driver }}"
                                        placeholder="{{ trans('labels.mail_driver') }}" required>
                                    @error('mail_driver')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-sm-6">
                                    <label class="form-label">{{ trans('labels.mail_host') }}<span
                                            class="text-danger"> *
                                        </span></label>
                                    <input type="text" class="form-control" name="mail_host" pattern="*"
                                        value="{{ @$settingdata->mail_host }}"
                                        placeholder="{{ trans('labels.mail_host') }}" required>
                                    @error('mail_host')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-sm-6">
                                    <label class="form-label">{{ trans('labels.mail_port') }}<span
                                            class="text-danger"> *
                                        </span></label>
                                    <input type="text" class="form-control" name="mail_port" pattern="*"
                                        value="{{ @$settingdata->mail_port }}"
                                        placeholder="{{ trans('labels.mail_port') }}" required>
                                    @error('mail_port')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-sm-6">
                                    <label class="form-label">{{ trans('labels.mail_username') }}<span
                                            class="text-danger">
                                            *
                                        </span></label>
                                    <input type="text" class="form-control" name="mail_username" pattern="*"
                                        value="{{ @$settingdata->mail_username }}"
                                        placeholder="{{ trans('labels.mail_username') }}" required>
                                    @error('mail_username')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-sm-6">
                                    <label class="form-label">{{ trans('labels.mail_password') }}<span
                                            class="text-danger">
                                            *
                                        </span></label>
                                    <input type="text" class="form-control" name="mail_password" pattern="*"
                                        value="{{ @$settingdata->mail_password }}"
                                        placeholder="{{ trans('labels.mail_password') }}" required>
                                    @error('mail_password')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-sm-6">
                                    <label class="form-label">{{ trans('labels.mail_encryption') }}<span
                                            class="text-danger"> *
                                        </span></label>
                                    <input type="text" class="form-control" name="mail_encryption" pattern="*"
                                        value="{{ @$settingdata->mail_encryption }}"
                                        placeholder="{{ trans('labels.mail_encryption') }}" required>
                                    @error('mail_encryption')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-sm-6">
                                    <label class="form-label">{{ trans('labels.mail_fromaddress') }}<span
                                            class="text-danger">
                                            * </span></label>
                                    <input type="text" class="form-control" name="mail_fromaddress"
                                        pattern="*" value="{{ @$settingdata->mail_fromaddress }}"
                                        placeholder="{{ trans('labels.mail_fromaddress') }}" required>
                                    @error('mail_fromaddress')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group col-sm-6">
                                    <label class="form-label">{{ trans('labels.mail_fromname') }}<span
                                            class="text-danger">
                                            *
                                        </span></label>
                                    <input type="text" class="form-control" name="mail_fromname" pattern="*"
                                        value="{{ @$settingdata->mail_fromname }}"
                                        placeholder="{{ trans('labels.mail_fromname') }}" required>
                                    @error('mail_fromname')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <button
                                    @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="button" @endif
                                    data-bs-toggle="modal" data-bs-target="#testmailmodal"
                                    class="btn btn-primary px-sm-4 {{ Auth::user()->type == 4 ? (helper::check_access('role_general_settings', Auth::user()->role_id, Auth::user()->vendor_id, 'edit') == 1 ? '' : 'd-none') : '' }}">{{ trans('labels.send_test_mail') }}</button>
                                <button
                                    @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif
                                    class="btn btn-primary px-sm-4 {{ Auth::user()->type == 4 ? (helper::check_access('role_general_settings', Auth::user()->role_id, Auth::user()->vendor_id, 'edit') == 1 ? '' : 'd-none') : '' }}">{{ trans('labels.save') }}</button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="testmailmodal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="testmailmodalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ URL::to('/admin/testmail') }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header justify-content-between">
                        <h5 class="modal-title color-changer" id="testmailmodalLabel">{{ trans('labels.send_test_mail') }}</h5>
                        <button type="button" class="bg-transparent border-0 color-changer" data-bs-dismiss="modal"
                            aria-label="Close">
                            <i class="fa-regular fa-xmark fs-4"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <label class="form-label">{{ trans('labels.email_address') }}<span class="text-danger"> *
                            </span></label>
                        <input type="text" class="form-control" name="email_address"
                            value="{{ @$settingdata->email_address }}"
                            placeholder="{{ trans('labels.email_address') }}" required>
                    </div>
                    <div class="modal-footer">
                        <button type="submit"
                            class="btn btn-secondary">{{ trans('labels.send_test_mail') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
