<div id="email_template">
    <div class="row mb-5">
        <div class="col-12">
            <form method="POST" action="{{ URL::to('admin/emailmessagesettings') }}">
                @csrf
                <div class="card border-0 box-shadow">
                    <div class="card-header p-3 bg-secondary">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="text-capitalize fw-600 settings-color col-6 color-changer">
                                {{ trans('labels.email_template') }}
                            </h5>
                            <select name="template_type" id="template_type" class="form-select">
                                @if (Auth::user()->type == 1 || (Auth::user()->type == 4 && Auth::user()->vendor_id == 1))
                                    <option value="1" data-attribute="forgotpassword">
                                        {{ trans('labels.forgotpassword') }}
                                    </option>
                                    <option value="2" data-attribute="delete_account">
                                        {{ trans('labels.delete_profile') }}
                                    </option>
                                    <option value="3" data-attribute="banktransfer_request">
                                        {{ trans('labels.banktransfer_request') }}</option>
                                    <option value="4" data-attribute="cod_request">
                                        {{ trans('labels.cod_request') }}
                                    </option>
                                    <option value="5" data-attribute="subscription_reject">
                                        {{ trans('labels.subscription_reject') }}</option>
                                    <option value="6" data-attribute="subscription_success">
                                        {{ trans('labels.subscription_success') }}</option>
                                    <option value="7" data-attribute="admin_subscription_request">
                                        {{ trans('labels.admin_subscription_request') }}</option>
                                    <option value="8" data-attribute="admin_subscription_success">
                                        {{ trans('labels.admin_subscription_success') }}</option>

                                    <option value="9" data-attribute="vendor_register">
                                        {{ trans('labels.vendor_register') }}</option>
                                    <option value="10" data-attribute="admin_vendor_register">
                                        {{ trans('labels.admin_vendor_register') }}</option>
                                    <option value="11" data-attribute="vendor_status_change">
                                        {{ trans('labels.vendor_status_change') }}</option>
                                @endif
                                <option value="12" data-attribute="contact_email">
                                    {{ trans('labels.contact_email') }}
                                </option>
                                @if (Auth::user()->type == 2 || (Auth::user()->type == 4 && Auth::user()->vendor_id != 1))
                                    <option value="13" data-attribute="new_booking_invoice">
                                        {{ trans('labels.new_booking_invoice') }}</option>
                                    <option value="14" data-attribute="vendor_new_booking">
                                        {{ trans('labels.vendor_new_booking') }}</option>
                                    <option value="15" data-attribute="booking_status">
                                        {{ trans('labels.booking_status') }}
                                    </option>
                                    <option value="16" data-attribute="referral_earning">
                                        {{ trans('labels.referral_earning') }}
                                    </option>
                                    @if (@helper::checkaddons('product_shop'))
                                        <option value="17" data-attribute="new_order_invoice">
                                            {{ trans('labels.new_order_invoice') }}</option>
                                        <option value="18" data-attribute="vendor_new_order">
                                            {{ trans('labels.vendor_new_order') }}</option>
                                        <option value="19" data-attribute="order_status">
                                            {{ trans('labels.order_status') }}
                                        </option>
                                    @endif
                                @endif
                                @if (Auth::user()->type == 1 || (Auth::user()->type == 4 && Auth::user()->vendor_id == 1))
                                    <option value="20" data-attribute="payout_request">
                                        {{ trans('labels.payout_request') }}</option>
                                    <option value="21" data-attribute="admin_payout_request">
                                        {{ trans('labels.admin_payout_request') }}
                                    </option>
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div id="templatemenuContent">
                                @if (Auth::user()->type == 1 || (Auth::user()->type == 4 && Auth::user()->vendor_id == 1))
                                    <div id="forgotpassword" class="hidechild">
                                        <div class="col-12">
                                            <h5 class="color-changer pb-3 border-bottom mb-3">
                                                {{ trans('labels.forgotpassword') }} {{ trans('labels.variable') }}
                                            </h5>
                                            
                                            <p class="mb-1 text-muted">{{ trans('labels.username') }} :
                                                <span class="pull-right text-primary color-changer">{user}</span>
                                            </p>
                                            <p class="mb-1 text-muted">{{ trans('labels.password') }} :
                                                <span class="pull-right text-primary color-changer">{password}</span>
                                            </p>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label fw-bold">{{ trans('labels.email_message') }}
                                                    <span class="text-danger"> * </span> </label>
                                                <textarea class="form-control" name="forget_password_email_message" cols="50" rows="10">{{ @$settingdata->forget_password_email_message }}</textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="delete_account" class="hidechild">
                                        <div class="col-12">
                                            <h5 class="color-changer pb-3 border-bottom mb-3">
                                                {{ trans('labels.delete_profile') }} {{ trans('labels.variable') }}
                                            </h5>
                                            <p class="mb-1 color-changer">{{ trans('labels.vendorname') }} :
                                                <span class="pull-right text-primary text-muted">{vendorname}</span>
                                            </p>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label fw-bold">{{ trans('labels.email_message') }}
                                                    <span class="text-danger"> * </span> </label>
                                                <textarea class="form-control" name="delete_account_email_message" cols="50" rows="10">{{ @$settingdata->delete_account_email_message }}</textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="banktransfer_request" class="hidechild">
                                        <div class="col-12">
                                            <h5 class="color-changer pb-3 border-bottom mb-3">
                                                {{ trans('labels.banktransfer_request') }}
                                                {{ trans('labels.variable') }}
                                            </h5>
                                            <p class="mb-1 color-changer">{{ trans('labels.vendorname') }} :
                                                <span class="pull-right text-primary text-muted">{vendorname}</span>
                                            </p>
                                            <p class="mb-1 color-changer">{{ trans('labels.adminname') }} :
                                                <span class="pull-right text-primary text-muted">{adminname}</span>
                                            </p>
                                            <p class="mb-1 color-changer">{{ trans('labels.adminemail') }} :
                                                <span class="pull-right text-primary text-muted">{adminemail}</span>
                                            </p>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label fw-bold">{{ trans('labels.email_message') }}
                                                    <span class="text-danger"> * </span> </label>
                                                <textarea class="form-control" name="banktransfer_request_email_message" cols="50" rows="10">{{ @$settingdata->banktransfer_request_email_message }}</textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="cod_request" class="hidechild">
                                        <div class="col-12">
                                            <h5 class="color-changer pb-3 border-bottom mb-3">
                                                {{ trans('labels.cod_request') }} {{ trans('labels.variable') }}
                                            </h5>
                                            <p class="mb-1 color-changer">{{ trans('labels.vendorname') }} :
                                                <span class="pull-right text-primary text-muted">{vendorname}</span>
                                            </p>
                                            <p class="mb-1 color-changer">{{ trans('labels.adminname') }} :
                                                <span class="pull-right text-primary text-muted">{adminname}</span>
                                            </p>
                                            <p class="mb-1 color-changer">{{ trans('labels.adminemail') }} :
                                                <span class="pull-right text-primary text-muted">{adminemail}</span>
                                            </p>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label fw-bold">{{ trans('labels.email_message') }}
                                                    <span class="text-danger"> * </span> </label>
                                                <textarea class="form-control" name="cod_request_email_message" cols="50" rows="10">{{ @$settingdata->cod_request_email_message }}</textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="subscription_reject" class="hidechild">
                                        <div class="col-12">
                                            <h5 class="color-changer pb-3 border-bottom mb-3">
                                                {{ trans('labels.subscription_reject') }}
                                                {{ trans('labels.variable') }}
                                            </h5>
                                            <p class="mb-1 color-changer">{{ trans('labels.vendorname') }} :
                                                <span class="pull-right text-primary text-muted">{vendorname}</span>
                                            </p>
                                            <p class="mb-1 color-changer">{{ trans('labels.payment_type') }} :
                                                <span class="pull-right text-primary text-muted">{payment_type}</span>
                                            </p>
                                            <p class="mb-1 color-changer">{{ trans('labels.plan_name') }} :
                                                <span class="pull-right text-primary text-muted">{plan_name}</span>
                                            </p>
                                            <p class="mb-1 color-changer">{{ trans('labels.adminname') }} :
                                                <span class="pull-right text-primary text-muted">{adminname}</span>
                                            </p>
                                            <p class="mb-1 color-changer">{{ trans('labels.adminemail') }} :
                                                <span class="pull-right text-primary text-muted">{adminemail}</span>
                                            </p>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label fw-bold">{{ trans('labels.email_message') }}
                                                    <span class="text-danger"> * </span> </label>
                                                <textarea class="form-control" name="subscription_reject_email_message" cols="50" rows="10">{{ @$settingdata->subscription_reject_email_message }}</textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="subscription_success" class="hidechild">
                                        <div class="col-12">
                                            <h5 class="color-changer pb-3 border-bottom mb-3">
                                                {{ trans('labels.subscription_success') }}
                                                {{ trans('labels.variable') }}
                                            </h5>
                                            <p class="mb-1 color-changer">{{ trans('labels.vendorname') }} :
                                                <span class="pull-right text-primary text-muted">{vendorname}</span>
                                            </p>
                                            <p class="mb-1 color-changer">{{ trans('labels.payment_type') }} :
                                                <span class="pull-right text-primary text-muted">{payment_type}</span>
                                            </p>
                                            <p class="mb-1 color-changer">{{ trans('labels.subscription_duration') }} :
                                                <span class="pull-right text-primary text-muted">{subscription_duration}</span>
                                            </p>
                                            <p class="mb-1 color-changer">{{ trans('labels.subscription_cost') }} :
                                                <span class="pull-right text-primary text-muted">{subscription_price}</span>
                                            </p>
                                            <p class="mb-1 color-changer">{{ trans('labels.plan_name') }} :
                                                <span class="pull-right text-primary text-muted">{plan_name}</span>
                                            </p>
                                            <p class="mb-1 color-changer">{{ trans('labels.adminname') }} :
                                                <span class="pull-right text-primary text-muted">{adminname}</span>
                                            </p>
                                            <p class="mb-1 color-changer">{{ trans('labels.adminemail') }} :
                                                <span class="pull-right text-primary text-muted">{adminemail}</span>
                                            </p>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label fw-bold">{{ trans('labels.email_message') }}
                                                    <span class="text-danger"> * </span> </label>
                                                <textarea class="form-control" name="subscription_success_email_message" cols="50" rows="10">{{ @$settingdata->subscription_success_email_message }}</textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="admin_subscription_request" class="hidechild">
                                        <div class="col-12">
                                            <h5 class="color-changer pb-3 border-bottom mb-3">
                                                {{ trans('labels.admin_subscription_request') }}
                                                {{ trans('labels.variable') }}
                                            </h5>
                                            <p class="mb-1 color-changer">{{ trans('labels.adminname') }} :
                                                <span class="pull-right text-primary text-muted">{adminname}</span>
                                            </p>
                                            <p class="mb-1 color-changer">{{ trans('labels.vendorname') }} :
                                                <span class="pull-right text-primary text-muted">{vendorname}</span>
                                            </p>
                                            <p class="mb-1 color-changer">{{ trans('labels.vendoremail') }} :
                                                <span class="pull-right text-primary text-muted">{vendoremail}</span>
                                            </p>
                                            <p class="mb-1 color-changer">{{ trans('labels.plan_name') }} :
                                                <span class="pull-right text-primary text-muted">{plan_name}</span>
                                            </p>
                                            <p class="mb-1 color-changer">{{ trans('labels.subscription_duration') }} :
                                                <span class="pull-right text-primary text-muted">{subscription_duration}</span>
                                            </p>
                                            <p class="mb-1 color-changer">{{ trans('labels.subscription_cost') }} :
                                                <span class="pull-right text-primary text-muted">{subscription_price}</span>
                                            </p>
                                            <p class="mb-1 color-changer">{{ trans('labels.payment_type') }} :
                                                <span class="pull-right text-primary text-muted">{payment_type}</span>
                                            </p>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label fw-bold">{{ trans('labels.email_message') }}
                                                    <span class="text-danger"> * </span> </label>
                                                <textarea class="form-control" name="admin_subscription_request_email_message" cols="50" rows="10">{{ @$settingdata->admin_subscription_request_email_message }}</textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="admin_subscription_success" class="hidechild">
                                        <div class="col-12">
                                            <h5 class="color-changer pb-3 border-bottom mb-3">
                                                {{ trans('labels.admin_subscription_success') }}
                                                {{ trans('labels.variable') }}
                                            </h5>
                                            <p class="mb-1 color-changer">{{ trans('labels.adminname') }} :
                                                <span class="pull-right text-primary text-muted">{adminname}</span>
                                            </p>
                                            <p class="mb-1 color-changer">{{ trans('labels.vendorname') }} :
                                                <span class="pull-right text-primary text-muted">{vendorname}</span>
                                            </p>
                                            <p class="mb-1 color-changer">{{ trans('labels.vendoremail') }} :
                                                <span class="pull-right text-primary text-muted">{vendoremail}</span>
                                            </p>
                                            <p class="mb-1 color-changer">{{ trans('labels.plan_name') }} :
                                                <span class="pull-right text-primary text-muted">{plan_name}</span>
                                            </p>
                                            <p class="mb-1 color-changer">{{ trans('labels.subscription_duration') }} :
                                                <span class="pull-right text-primary text-muted">{subscription_duration}</span>
                                            </p>
                                            <p class="mb-1 color-changer">{{ trans('labels.subscription_cost') }} :
                                                <span class="pull-right text-primary text-muted">{subscription_price}</span>
                                            </p>
                                            <p class="mb-1 color-changer">{{ trans('labels.payment_type') }} :
                                                <span class="pull-right text-primary text-muted">{payment_type}</span>
                                            </p>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label fw-bold">{{ trans('labels.email_message') }}
                                                    <span class="text-danger"> * </span> </label>
                                                <textarea class="form-control" name="admin_subscription_success_email_message" cols="50" rows="10">{{ @$settingdata->admin_subscription_success_email_message }}</textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="vendor_register" class="hidechild">
                                        <div class="col-12">
                                            <h5 class="color-changer pb-3 border-bottom mb-3">
                                                {{ trans('labels.vendor_register') }} {{ trans('labels.variable') }}
                                            </h5>
                                            <p class="mb-1 color-changer">{{ trans('labels.vendorname') }} :
                                                <span class="pull-right text-primary text-muted">{vendorname}</span>
                                            </p>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label fw-bold">{{ trans('labels.email_message') }}
                                                    <span class="text-danger"> * </span> </label>
                                                <textarea class="form-control" name="vendor_register_email_message" cols="50" rows="10">{{ @$settingdata->vendor_register_email_message }}</textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="admin_vendor_register" class="hidechild">
                                        <div class="col-12">
                                            <h5 class="color-changer pb-3 border-bottom mb-3">
                                                {{ trans('labels.admin_vendor_register') }}
                                                {{ trans('labels.variable') }}
                                            </h5>
                                            <p class="mb-1 color-changer">{{ trans('labels.adminname') }} :
                                                <span class="pull-right text-primary text-muted">{adminname}</span>
                                            </p>
                                            <p class="mb-1 color-changer">{{ trans('labels.vendorname') }} :
                                                <span class="pull-right text-primary text-muted">{vendorname}</span>
                                            </p>
                                            <p class="mb-1 color-changer">{{ trans('labels.vendoremail') }} :
                                                <span class="pull-right text-primary text-muted">{vendoremail}</span>
                                            </p>
                                            <p class="mb-1 color-changer">{{ trans('labels.vendormobile') }} :
                                                <span class="pull-right text-primary text-muted">{vendormobile}</span>
                                            </p>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label fw-bold">{{ trans('labels.email_message') }}
                                                    <span class="text-danger"> * </span> </label>
                                                <textarea class="form-control" name="admin_vendor_register_email_message" cols="50" rows="10">{{ @$settingdata->admin_vendor_register_email_message }}</textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="vendor_status_change" class="hidechild">
                                        <div class="col-12">
                                            <h5 class="color-changer pb-3 border-bottom mb-3">
                                                {{ trans('labels.vendor_status_change') }}
                                                {{ trans('labels.variable') }}
                                            </h5>
                                            <p class="mb-1 color-changer">{{ trans('labels.vendorname') }} :
                                                <span class="pull-right text-primary text-muted">{vendorname}</span>
                                            </p>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label fw-bold">{{ trans('labels.email_message') }}
                                                    <span class="text-danger"> * </span> </label>
                                                <textarea class="form-control" name="vendor_status_change_email_message" cols="50" rows="10">{{ @$settingdata->vendor_status_change_email_message }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div id="contact_email" class="hidechild">
                                    <div class="col-12">
                                        <h5 class="color-changer pb-3 border-bottom mb-3">
                                            {{ trans('labels.contact_email') }} {{ trans('labels.variable') }}
                                        </h5>
                                        <p class="mb-1 color-changer">{{ trans('labels.vendorname') }} :
                                            <span class="pull-right text-primary text-muted">{vendorname}</span>
                                        </p>
                                        <p class="mb-1 color-changer">{{ trans('labels.username') }} :
                                            <span class="pull-right text-primary text-muted">{username}</span>
                                        </p>
                                        <p class="mb-1 color-changer">{{ trans('labels.useremail') }} :
                                            <span class="pull-right text-primary text-muted">{useremail}</span>
                                        </p>
                                        <p class="mb-1 color-changer">{{ trans('labels.usermobile') }} :
                                            <span class="pull-right text-primary text-muted">{usermobile}</span>
                                        </p>
                                        <p class="mb-1 color-changer">{{ trans('labels.usermessage') }} :
                                            <span class="pull-right text-primary text-muted">{usermessage}</span>
                                        </p>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-label fw-bold">{{ trans('labels.email_message') }}
                                                <span class="text-danger"> * </span> </label>
                                            <textarea class="form-control" name="contact_email_message" cols="50" rows="10">{{ @$settingdata->contact_email_message }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                @if (Auth::user()->type == 2 || (Auth::user()->type == 4 && Auth::user()->vendor_id != 1))
                                    <div id="new_booking_invoice" class="hidechild">
                                        <div class="col-12">
                                            <h5 class="color-changer pb-3 border-bottom mb-3">
                                                {{ trans('labels.new_booking_invoice') }}
                                                {{ trans('labels.variable') }}
                                            </h5>
                                            <p class="mb-1 color-changer">{{ trans('labels.customer_name') }} :
                                                <span class="pull-right text-primary text-muted">{customername}</span>
                                            </p>
                                            <p class="mb-1 color-changer">{{ trans('labels.booking_number') }} :
                                                <span class="pull-right text-primary text-muted">{booking_number}</span>
                                            </p>
                                            <p class="mb-1 color-changer">{{ trans('labels.booking_date') }} :
                                                <span class="pull-right text-primary text-muted">{booking_date}</span>
                                            </p>
                                            <p class="mb-1 color-changer">{{ trans('labels.booking_time') }} :
                                                <span class="pull-right text-primary text-muted">{booking_starttime}</span> -
                                                <span class="pull-right text-primary text-muted">{booking_endtime}</span>
                                            </p>
                                            <p class="mb-1 color-changer">{{ trans('labels.grand_total') }} :
                                                <span class="pull-right text-primary text-muted">{grandtotal}</span>
                                            </p>
                                            <p class="mb-1 color-changer">{{ trans('labels.track_booking_url') }} :
                                                <span class="pull-right text-primary text-muted">{track_booking_url}</span>
                                            </p>
                                            <p class="mb-1 color-changer">{{ trans('labels.vendorname') }} :
                                                <span class="pull-right text-primary text-muted">{vendorname}</span>
                                            </p>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label fw-bold">{{ trans('labels.email_message') }}
                                                    <span class="text-danger"> * </span> </label>
                                                <textarea class="form-control" name="new_order_invoice_email_message" cols="50" rows="10">{{ @$settingdata->new_order_invoice_email_message }}</textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="vendor_new_booking" class="hidechild">
                                        <div class="col-12">
                                            <h5 class="color-changer pb-3 border-bottom mb-3">
                                                {{ trans('labels.vendor_new_booking') }}
                                                {{ trans('labels.variable') }}
                                            </h5>
                                            <p class="mb-1 color-changer">{{ trans('labels.vendorname') }} :
                                                <span class="pull-right text-primary text-muted">{vendorname}</span>
                                            </p>
                                            <p class="mb-1 color-changer">{{ trans('labels.booking_number') }} :
                                                <span class="pull-right text-primary text-muted">{booking_number}</span>
                                            </p>
                                            <p class="mb-1 color-changer">{{ trans('labels.booking_date') }} :
                                                <span class="pull-right text-primary text-muted">{booking_date}</span>
                                            </p>
                                            <p class="mb-1 color-changer">{{ trans('labels.booking_time') }} :
                                                <span class="pull-right text-primary text-muted">{booking_starttime}</span> -
                                                <span class="pull-right text-primary text-muted">{booking_endtime}</span>
                                            </p>
                                            <p class="mb-1 color-changer">{{ trans('labels.grand_total') }} :
                                                <span class="pull-right text-primary text-muted">{grandtotal}</span>
                                            </p>
                                            <p class="mb-1 color-changer">{{ trans('labels.customer_name') }} :
                                                <span class="pull-right text-primary text-muted">{customername}</span>
                                            </p>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label fw-bold">{{ trans('labels.email_message') }}
                                                    <span class="text-danger"> * </span> </label>
                                                <textarea class="form-control" name="vendor_new_order_email_message" cols="50" rows="10">{{ @$settingdata->vendor_new_order_email_message }}</textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="booking_status" class="hidechild">
                                        <div class="col-12">
                                            <h5 class="color-changer pb-3 border-bottom mb-3">
                                                {{ trans('labels.booking_status') }} {{ trans('labels.variable') }}
                                            </h5>
                                            <p class="mb-1 color-changer">{{ trans('labels.customer_name') }} :
                                                <span class="pull-right text-primary text-muted">{customername}</span>
                                            </p>
                                            <p class="mb-1 color-changer">{{ trans('labels.status_message') }} :
                                                <span class="pull-right text-primary text-muted">{status_message}</span>
                                            </p>
                                            <p class="mb-1 color-changer">{{ trans('labels.vendorname') }} :
                                                <span class="pull-right text-primary text-muted">{vendorname}</span>
                                            </p>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label fw-bold">{{ trans('labels.email_message') }}
                                                    <span class="text-danger"> * </span> </label>
                                                <textarea class="form-control" name="order_status_email_message" cols="50" rows="10">{{ @$settingdata->order_status_email_message }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    @if (@helper::checkaddons('product_shop'))
                                        <div id="new_order_invoice" class="hidechild">
                                            <div class="col-12">
                                                <h5 class="color-changer pb-3 border-bottom mb-3">
                                                    {{ trans('labels.new_order_invoice') }}
                                                    {{ trans('labels.variable') }}
                                                </h5>

                                                <p class="mb-1 color-changer">{{ trans('labels.customer_name') }} :
                                                    <span class="pull-right text-primary text-muted">{customername}</span>
                                                </p>
                                                <p class="mb-1 color-changer">{{ trans('labels.order_number') }} :
                                                    <span class="pull-right text-primary text-muted">{order_number}</span>
                                                </p>
                                                <p class="mb-1 color-changer">{{ trans('labels.order_date') }} :
                                                    <span class="pull-right text-primary text-muted">{order_date}</span>
                                                </p>
                                                <p class="mb-1 color-changer">{{ trans('labels.grand_total') }} :
                                                    <span class="pull-right text-primary text-muted">{grandtotal}</span>
                                                </p>
                                                <p class="mb-1 color-changer">{{ trans('labels.track_order_url') }} :
                                                    <span class="pull-right text-primary text-muted">{track_order_url}</span>
                                                </p>
                                                <p class="mb-1 color-changer">{{ trans('labels.vendorname') }} :
                                                    <span class="pull-right text-primary text-muted">{vendorname}</span>
                                                </p>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label
                                                        class="form-label fw-bold">{{ trans('labels.email_message') }}
                                                        <span class="text-danger"> * </span> </label>
                                                    <textarea class="form-control" name="new_product_order_invoice_email_message" cols="50" rows="10">{{ @$settingdata->new_product_order_invoice_email_message }}</textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="vendor_new_order" class="hidechild">
                                            <div class="col-12">
                                                <h5 class="color-changer pb-3 border-bottom mb-3">
                                                    {{ trans('labels.vendor_new_order') }}
                                                    {{ trans('labels.variable') }}
                                                </h5>

                                                <p class="mb-1 color-changer">{{ trans('labels.vendorname') }} :
                                                    <span class="pull-right text-primary text-muted">{vendorname}</span>
                                                </p>
                                                <p class="mb-1 color-changer">{{ trans('labels.order_number') }} :
                                                    <span class="pull-right text-primary text-muted">{order_number}</span>
                                                </p>
                                                <p class="mb-1 color-changer">{{ trans('labels.order_date') }} :
                                                    <span class="pull-right text-primary text-muted">{order_date}</span>
                                                </p>
                                                <p class="mb-1 color-changer">{{ trans('labels.grand_total') }} :
                                                    <span class="pull-right text-primary text-muted">{grandtotal}</span>
                                                </p>
                                                <p class="mb-1 color-changer">{{ trans('labels.customer_name') }} :
                                                    <span class="pull-right text-primary text-muted">{customername}</span>
                                                </p>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label
                                                        class="form-label fw-bold">{{ trans('labels.email_message') }}
                                                        <span class="text-danger"> * </span> </label>
                                                    <textarea class="form-control" name="vendor_new_product_order_email_message" cols="50" rows="10">{{ @$settingdata->vendor_new_product_order_email_message }}</textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <div id="order_status" class="hidechild">
                                            <div class="col-12">
                                                <h5 class="color-changer pb-3 border-bottom mb-3">
                                                    {{ trans('labels.order_status') }}
                                                    {{ trans('labels.variable') }}
                                                </h5>

                                                <p class="mb-1 color-changer">{{ trans('labels.customer_name') }} :
                                                    <span class="pull-right text-primary text-muted">{customername}</span>
                                                </p>
                                                <p class="mb-1 color-changer">{{ trans('labels.status_message') }} :
                                                    <span class="pull-right text-primary text-muted">{status_message}</span>
                                                </p>
                                                <p class="mb-1 color-changer">{{ trans('labels.vendorname') }} :
                                                    <span class="pull-right text-primary text-muted">{vendorname}</span>
                                                </p>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label
                                                        class="form-label fw-bold">{{ trans('labels.email_message') }}
                                                        <span class="text-danger"> * </span> </label>
                                                    <textarea class="form-control" name="product_order_status_email_message" cols="50" rows="10">{{ @$settingdata->product_order_status_email_message }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    <div id="referral_earning" class="hidechild">
                                        <div class="col-12">
                                            <h5 class="color-changer pb-3 border-bottom mb-3">
                                                {{ trans('labels.referral_earning') }}
                                                {{ trans('labels.variable') }}
                                            </h5>
                                            <p class="mb-1 color-changer">{{ trans('labels.referral_user') }} :
                                                <span class="pull-right text-primary text-muted">{referral_user}</span>
                                            </p>
                                            <p class="mb-1 color-changer">{{ trans('labels.new_user') }} :
                                                <span class="pull-right text-primary text-muted">{new_user}</span>
                                            </p>
                                            <p class="mb-1 color-changer">{{ trans('labels.company_name') }} :
                                                <span class="pull-right text-primary text-muted">{company_name}</span>
                                            </p>
                                            <p class="mb-1 color-changer">{{ trans('labels.referral_amount') }} :
                                                <span class="pull-right text-primary text-muted">{referral_amount}</span>
                                            </p>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label fw-bold">{{ trans('labels.email_message') }}
                                                    <span class="text-danger"> * </span> </label>
                                                <textarea class="form-control" name="referral_earning_email_message" cols="50" rows="10">{{ @$settingdata->referral_earning_email_message }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @if (Auth::user()->type == 1 || (Auth::user()->type == 4 && Auth::user()->vendor_id == 1))
                                    <div id="payout_request" class="hidechild">
                                        <div class="col-12">
                                            <h5 class="color-changer pb-3 border-bottom mb-3">
                                                {{ trans('labels.payout_request') }} {{ trans('labels.variable') }}
                                            </h5>
                                            <p class="mb-1 color-changer">{{ trans('labels.vendorname') }} :
                                                <span class="pull-right text-primary text-muted">{vendorname}</span>
                                            </p>
                                            <p class="mb-1 color-changer">{{ trans('labels.earning_amt') }} :
                                                <span class="pull-right text-primary text-muted">{earning_amt}</span>
                                            </p>
                                            <p class="mb-1 color-changer">{{ trans('labels.admin_commission') }} :
                                                <span class="pull-right text-primary text-muted">{commission}</span>
                                            </p>
                                            <p class="mb-1 color-changer">{{ trans('labels.payout_amount') }} :
                                                <span class="pull-right text-primary text-muted">{payable_amt}</span>
                                            </p>
                                            <p class="mb-1 color-changer">{{ trans('labels.adminname') }} :
                                                <span class="pull-right text-primary text-muted">{adminname}</span>
                                            </p>
                                            <p class="mb-1 color-changer">{{ trans('labels.adminemail') }} :
                                                <span class="pull-right text-primary text-muted">{adminemail}</span>
                                            </p>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label fw-bold">{{ trans('labels.email_message') }}
                                                    <span class="text-danger"> * </span> </label>
                                                <textarea class="form-control" name="payout_request_email_message" cols="50" rows="10">{{ @$settingdata->payout_request_email_message }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="admin_payout_request" class="hidechild">
                                        <div class="col-12">
                                            <h5 class="color-changer pb-3 border-bottom mb-3">
                                                {{ trans('labels.admin_payout_request') }}
                                                {{ trans('labels.variable') }}
                                            </h5>
                                            <p class="mb-1 color-changer">{{ trans('labels.adminname') }} :
                                                <span class="pull-right text-primary text-muted">{adminname}</span>
                                            </p>
                                            <p class="mb-1 color-changer">{{ trans('labels.earning_amt') }} :
                                                <span class="pull-right text-primary text-muted">{earning_amt}</span>
                                            </p>
                                            <p class="mb-1 color-changer">{{ trans('labels.admin_commission') }} :
                                                <span class="pull-right text-primary text-muted">{commission}</span>
                                            </p>
                                            <p class="mb-1 color-changer">{{ trans('labels.payout_amount') }} :
                                                <span class="pull-right text-primary text-muted">{payable_amt}</span>
                                            </p>
                                            <p class="mb-1 color-changer">{{ trans('labels.vendorname') }} :
                                                <span class="pull-right text-primary text-muted">{vendorname}</span>
                                            </p>
                                            <p class="mb-1 color-changer">{{ trans('labels.vendoremail') }} :
                                                <span class="pull-right text-primary text-muted">{vendoremail}</span>
                                            </p>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label fw-bold">{{ trans('labels.email_message') }}
                                                    <span class="text-danger"> * </span> </label>
                                                <textarea class="form-control" name="admin_payout_request_email_message" cols="50" rows="10">{{ @$settingdata->admin_payout_request_email_message }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="form-group text-{{ session()->get('direction') == '2' ? 'start' : 'end' }} m-0">
                                <button
                                    class="btn btn-primary px-sm-4 {{ Auth::user()->type == 4 ? (helper::check_access('role_general_settings', Auth::user()->role_id, Auth::user()->vendor_id, 'edit') == 1 ? '' : 'd-none') : '' }}"
                                    @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif>{{ trans('labels.save') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
