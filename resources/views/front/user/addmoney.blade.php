@extends('front.layout.master')
@section('content')
    <!------ breadcrumb ------>
    <section class="breadcrumb-div pt-4">

        <div class="container">

            <nav aria-label="breadcrumb">

                <ol class="breadcrumb">

                    <li class="breadcrumb-item text-dark">
                        <a class="text-primary-color" href="{{ URL::to($vendordata->slug . '/') }}">
                            <i class="fa-solid fa-house fs-7 {{ session()->get('direction') == 2 ? 'ms-2' : 'me-2' }}"></i>
                            {{ trans('labels.home') }}
                        </a>
                    </li>

                    <li class="breadcrumb-item  active {{ session()->get('direction') == '2' ? 'breadcrumb-item-right' : 'breadcrumb-item-left' }}" aria-current="page">
                        {{ trans('labels.add_money') }}
                    </li>

                </ol>

            </nav>

        </div>

    </section>

    <section class="product-prev-sec product-list-sec">
        <div class="container">
            <h2 class="section-title fw-600">{{ trans('labels.account_details') }}</h2>
            <div class="user-bg-color mb-4">
                <div class="row g-3">
                    @include('front.user.commonmenu')
                    <div class="col-xl-9 col-lg-8 col-xxl-9 col-12">
                        <div class="card p-0 border rounded-4 user-form">
                            <div class="settings-box">
                                <div class="settings-box-header flex-wrap border-bottom p-3">
                                    <div class="mb-0 d-flex align-items-center color-changer">
                                        <i class="fa-light fa-hand-holding-dollar fs-4"></i>
                                        <span class="fs-5 fw-500 px-3">
                                            {{ trans('labels.add_money') }}
                                        </span>
                                    </div>
                                </div>
                                <div class="settings-box-body p-3 dashboard-section">
                                    <p class="mb-2 fw-500 color-changer">{{ trans('labels.add_amount') }}</p>
                                    <div class="mb-3">
                                        <div class="input-group">
                                            <span
                                                class="input-group-text fw-500 fs-15">{{ helper::appdata($vendordata->id)->currency }}</span>
                                            <input type="number" name="amount" id="amount" class="form-control fs-15"
                                                placeholder="{{ trans('labels.add_amount') }}">
                                        </div>
                                    </div>
                                    <div class="row justify-content-between border-bottom">
                                        <div class="col-xl-6 col-12">
                                            <p class="mb-0 fw-500 color-changer">{{ trans('labels.notes') }} :</p>
                                            <ul class="p-0 mt-1">
                                                <li class="text-muted fs-7 d-flex gap-2 align-items-center">
                                                    <i class="fa-regular fa-circle-check text-success"></i>
                                                    {{ trans('labels.wallet_note_1') }}
                                                </li>
                                                <li class="text-muted fs-7 d-flex gap-2 align-items-center">
                                                    <i class="fa-regular fa-circle-check text-success"></i>
                                                    {{ trans('labels.wallet_note_2') }}
                                                </li>
                                            </ul>
                                        </div>
                                        @if (@helper::checkaddons('safe_secure_checkout'))
                                            @if (@helper::otherappdata($vendordata->id)->safe_secure_checkout_payment_selection)
                                                <div class="col-xl-6 col-12">
                                                    @include('front.service.sevirce-trued')
                                                </div>
                                            @endif
                                        @endif
                                    </div>
                                    <p class="my-3 fw-500 color-changer">{{ trans('labels.payment_option') }}</p>
                                    <div class="recharge_payment_option row g-3">
                                        @foreach ($getpaymentmethods as $key => $payment)
                                            @php
                                                // Check if the current $payment is a system addon and activated
                                                $systemAddonActivated = false;

                                                $addon = App\Models\SystemAddons::where(
                                                    'unique_identifier',
                                                    $payment->unique_identifier,
                                                )->first();
                                                if ($addon != null && $addon->activated == 1) {
                                                    $systemAddonActivated = true;
                                                }
                                            @endphp
                                            @if ($systemAddonActivated)
                                                <label class="form-check-label col-md-6 cp"
                                                    for="{{ $payment->payment_type }}">
                                                    <div class="payment-check w-100">
                                                        <img src="{{ helper::image_path($payment->image) }}"
                                                            class="img-fluid" alt="" width="40px" />
                                                        @if (strtolower($payment->payment_type) == '2')
                                                            <input type="hidden" name="razorpay" id="razorpay"
                                                                value="{{ $payment->public_key }}">
                                                        @endif
                                                        @if (strtolower($payment->payment_type) == '3')
                                                            <input type="hidden" name="stripe" id="stripe"
                                                                value="{{ $payment->public_key }}">
                                                        @endif
                                                        @if (strtolower($payment->payment_type) == '4')
                                                            <input type="hidden" name="flutterwavekey" id="flutterwavekey"
                                                                value="{{ $payment->public_key }}">
                                                        @endif
                                                        @if (strtolower($payment->payment_type) == '5')
                                                            <input type="hidden" name="paystackkey" id="paystackkey"
                                                                value="{{ $payment->public_key }}">
                                                        @endif

                                                        <p class="m-0 color-changer">{{ $payment->payment_name }}</p>
                                                        <input
                                                            class="form-check-input payment_radio payment-input {{ session()->get('direction') == '2' ? 'me-auto' : 'ms-auto' }}"
                                                            type="radio" name="transaction_type"
                                                            value="{{ $payment->payment_type }}"
                                                            data-currency="{{ $payment->currency }}"
                                                            {{ $key == 0 ? 'checked' : '' }}
                                                            id="{{ $payment->payment_type }}"
                                                            data-payment_type="{{ strtolower($payment->payment_type) }}"
                                                            style="">

                                                        @if (strtolower($payment->payment_type) == '6')
                                                            <input type="hidden"
                                                                value="{{ $payment->payment_description }}"
                                                                id="bank_payment">
                                                        @endif
                                                    </div>
                                                </label>
                                                @if ($payment->payment_type == 3)
                                                    <div class="my-3 d-none" id="card-element"></div>
                                                @endif
                                            @endif
                                        @endforeach
                                    </div>

                                    <div class="col-12 d-flex gap-2 mt-3 justify-content-end">
                                        <button class="btn btn-primary btn-submit rounded wallet_recharge"
                                            onclick="addmoney()">{{ trans('labels.proceed_pay') }}</button>
                                    </div>

                                    <input type="hidden" name="walleturl" id="walleturl"
                                        value="{{ URL::to($vendordata->slug . '/wallet/recharge') }}">
                                    <input type="hidden" name="successurl" id="successurl"
                                        value="{{ URL::to($vendordata->slug . '/wallet') }}">
                                    <input type="hidden" name="user_name" id="user_name" value="{{ Auth::user()->name }}">
                                    <input type="hidden" name="user_email" id="user_email"
                                        value="{{ Auth::user()->email }}">
                                    <input type="hidden" name="user_mobile" id="user_mobile"
                                        value="{{ Auth::user()->mobile }}">
                                    <input type="hidden" name="vendor_id" id="vendor_id"
                                        value="{{ $vendordata->id }}">
                                    <input type="hidden" name="title" id="title"
                                        value="{{ helper::appdata($vendordata->id)->website_title }}">
                                    <input type="hidden" name="logo" id="logo"
                                        value="{{ helper::appdata(@$vendordata->id)->image }}">

                                    <input type="hidden" name="addsuccessurl" id="addsuccessurl"
                                        value="{{ URL::to($vendordata->slug . '/addwalletsuccess') }}">
                                    <input type="hidden" name="addfailurl" id="addfailurl"
                                        value="{{ URL::to($vendordata->slug . '/addfail') }}">

                                    <input type="hidden" name="myfatoorahurl" id="myfatoorahurl"
                                        value="{{ URL::to($vendordata->slug . '/myfatoorahrequest') }}">
                                    <input type="hidden" name="mercadopagourl" id="mercadopagourl"
                                        value="{{ URL::to($vendordata->slug . '/mercadoorder') }}">
                                    <input type="hidden" name="paypalurl" id="paypalurl"
                                        value="{{ URL::to($vendordata->slug . '/paypalrequest') }}">
                                    <input type="hidden" name="toyyibpayurl" id="toyyibpayurl"
                                        value="{{ URL::to($vendordata->slug . '/toyyibpayrequest') }}">
                                    <input type="hidden" name="paytaburl" id="paytaburl"
                                        value="{{ URL::to($vendordata->slug . '/paytabrequest') }}">
                                    <input type="hidden" name="phonepeurl" id="phonepeurl"
                                        value="{{ URL::to($vendordata->slug . '/phoneperequest') }}">
                                    <input type="hidden" name="mollieurl" id="mollieurl"
                                        value="{{ URL::to($vendordata->slug . '/mollierequest') }}">
                                    <input type="hidden" name="khaltiurl" id="khaltiurl"
                                        value="{{ URL::to($vendordata->slug . '/khaltirequest') }}">
                                    <input type="hidden" name="xenditurl" id="xenditurl"
                                        value="{{ URL::to($vendordata->slug . '/xenditrequest') }}">

                                    <input type="hidden" name="slug" id="slug"
                                        value="{{ $vendordata->slug }}">

                                    <input type="hidden" value="{{ trans('messages.payment_selection_required') }}"
                                        name="payment_type_message" id="payment_type_message">

                                    <input type="hidden" value="{{ trans('messages.enter_amount') }}"
                                        name="amount_message" id="amount_message">

                                    <form action="{{ url($vendordata->slug . '/paypalrequest') }}" method="post"
                                        class="d-none">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="return" value="2">
                                        <input type="submit" class="callpaypal" name="submit">
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- newsletter -->
            @include('front.contact.index')
        </div>
    </section>
@endsection
@section('scripts')
    <script src="https://checkout.stripe.com/v2/checkout.js"></script>
    <script src="https://js.stripe.com/v3/"></script>
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script src="https://checkout.flutterwave.com/v3.js"></script>
    <script src="https://js.paystack.co/v1/inline.js"></script>
    <script src="{{ url(env('ASSETPATHURL') . 'front/js/wallet.js') }}"></script>
@endsection
