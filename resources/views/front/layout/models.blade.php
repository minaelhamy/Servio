<!--stripe Payment  Modal -->
<div class="modal fade" id="stripemodel" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
    aria-labelledby="stripemodellable" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header justify-content-between">
                <h5 class="modal-title color-changer" id="stripemodellable">{{ trans('labels.payment') }}
                </h5>
                <button type="button" class="bg-transparent border-0 m-0" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa-regular fa-xmark fs-4 color-changer"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="stripe-form d-none">
                    <div id="card-element"></div>
                </div>
                <div class="text-danger stripe_error mb-2 d-none"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-submit rounded"
                    id="btnstripepayment">{{ trans('labels.pay_now') }}</button>
            </div>
        </div>
    </div>
</div>
<!-- Bank Details Modal -->
<div class="modal fade" id="modalbankdetails" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="modalbankdetailsLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header justify-content-between">
                <h5 class="modal-title color-changer" id="modalbankdetailsLabel">{{ trans('labels.bank_transfer') }}
                </h5>
                <button type="button" class="bg-transparent border-0 m-0" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa-regular fa-xmark fs-4 color-changer"></i>
                </button>
            </div>
            <form enctype="multipart/form-data" action="" method="POST" id="bankdetailmodalurl">
                <div class="modal-body">
                    @csrf
                    <input type="hidden" id="modal_booking_number" name="modal_booking_number" value="">
                    <input type="hidden" id="modal_payment_type" name="modal_payment_type" value="6">
                    <input type="hidden" name="modal_vendor_id" id="modal_vendor_id" value="">
                    <input type="hidden" name="modal_vendor_slug" id="modal_vendor_slug" value="">
                    <input type="hidden" name="modal_service_id" id="modal_service_id" value="">
                    <input type="hidden" name="modal_service_name" id="modal_service_name" value="">
                    <input type="hidden" name="modal_service_image" id="modal_service_image" value="">
                    <input type="hidden" name="modal_booking_date" id="modal_booking_date" value="">
                    <input type="hidden" name="modal_booking_time" id="modal_booking_time" value="">
                    <input type="hidden" name="modal_staff" id="modal_staff" value="">
                    <input type="hidden" name="modal_name" id="modal_name" value="">
                    <input type="hidden" name="modal_email" id="modal_email" value="">
                    <input type="hidden" name="modal_mobile" id="modal_mobile" value="">
                    <input type="hidden" name="modal_address" id="modal_address" value="">
                    <input type="hidden" name="modal_landmark" id="modal_landmark" value="">
                    <input type="hidden" name="modal_postal_code" id="modal_postal_code" value="">
                    <input type="hidden" name="modal_city" id="modal_city" value="">
                    <input type="hidden" name="modal_state" id="modal_state" value="">
                    <input type="hidden" name="modal_country" id="modal_country" value="">
                    <input type="hidden" name="modal_shipping_area" id="modal_shipping_area" value="">
                    <input type="hidden" name="modal_delivery_charge" id="modal_delivery_charge" value="">
                    <input type="hidden" name="modal_grand_total" id="modal_grand_total" value="">
                    <input type="hidden" name="modal_tips" id="modal_tips" value="">
                    <input type="hidden" name="modal_sub_total" id="modal_sub_total" value="">
                    <input type="hidden" name="modal_tax" id="modal_tax" value="">
                    <input type="hidden" name="modal_tax_name" id="modal_tax_name" value="">
                    <input type="hidden" name="modal_message" id="modal_message" value="">
                    <input type="hidden" name="modal_buynow" id="modal_buynow" value="">
                    <div class="card">
                        <div class="card-body">
                            <p id="bank_description" class="color-changer"></p>
                        </div>
                    </div>
                    <div class="form-group col-md-12 mt-2">
                        <label for="screenshot"> {{ trans('labels.screenshot') }} </label>
                        <div class="controls">
                            <input type="file" name="screenshot" id="screenshot"
                                class="form-control  @error('screenshot') is-invalid @enderror" required>
                            @error('screenshot')
                                <span class="text-danger"> {{ $message }} </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger px-sm-4"
                        data-bs-dismiss="modal">{{ trans('labels.close') }}</button>
                    <button type="submit" class="btn btn-primary px-sm-4"> {{ trans('labels.save') }} </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- question answer  Modal -->
<div class="modal fade" id="qustions_answer" tabindex="-1" aria-labelledby="qustions_answerLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header justify-content-between">
                <h1 class="modal-title fs-5 fw-600 m-0 color-changer" id="qustions_answer">
                    {{ trans('labels.ask_a_question') }}</h1>
                <button type="button" class="bg-transparent border-0 m-0" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i class="fa-regular fa-xmark fs-4 color-changer"></i>
                </button>
            </div>
            @php

                if (request()->is($vendordata->slug . '/service-*')) {
                    $url = URL::to($vendordata->slug . '/service_question_answer');
                    $image = helper::image_path(@$serviceimage->image_name);
                    $name = @$service->name;
                } else {
                    $url = URL::to($vendordata->slug . '/product_question_answer');
                    $image = helper::image_path(@$productimage->image_name);
                    $name = @$product->name;
                }
            @endphp
            <form action="{{ $url }}" method="post" class="border-top mt-3 pt-2">
                @csrf
                <div class="modal-body">
                    <div class="d-flex align-items-center gap-2">
                        <div class="col-auto">
                            <img src="{{@$image}}" alt=""
                                class="qustion_img_model rounded">
                        </div>
                        <div class="w-100">
                            <h6 class="line-2 fs-15 fw-500 color-changer">
                                {{$name}}
                            </h6>
                            <div class="d-flex flex-wrap gap-1 align-items-center">
                                <p class="fs-6 fw-500 color-changer">
                                    {{ helper::currency_formate(@$price, $vendordata->id) }}</p>
                                <del class="fw-500 text-muted fs-13">
                                    {{ helper::currency_formate(@$original_price, $vendordata->id) }}</del>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label for="exampleFormControlTextarea1" class="form-label d-flex gap-1">
                            {{ trans('labels.your_question') }}
                            <div aria-hidden="true" class="text-danger">*</div>
                        </label>
                        <input type="hidden" name="id" value="{{ @$service->id }}">
                        <input type="hidden" name="product_id" value="{{ @$product->id }}">
                        <textarea class="form-control m-0 fs-7" id="question" name="question" placeholder="Your Questions" rows="3"
                            required=""></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger fs-7  fw-500" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary fs-7 fw-500">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>



<!-- Promocode  Modal -->
<div class="modal fade" id="promocodemodal" tabindex="-1" aria-labelledby="promocodemodellable"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header justify-content-between">
                <h5 class="modal-title color-changer" id="promocodemodellable">{{ trans('labels.apply_coupon') }}
                </h5>
                <button type="button" class="bg-transparent border-0 m-0" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i class="fa-regular fa-xmark fs-4 color-changer"></i>
                </button>
            </div>
            <div class="modal-body py-0">
                @foreach (helper::promocode($vendordata->id) as $promocode)
                    <div class="card my-4 border-0 bg-lights">
                        <div class="card-body p-0 px-4 position-relative">
                            <div class="coupon rounded d-flex align-items-center justify-content-between">
                                <div class="left-side py-4 px-2 d-flex w-100 justify-content-start">
                                    <div>
                                        <h6 class="fw-600">{{ $promocode->offer_name }}</h6>
                                        <p class="text-muted m-0 fs-7">{{ $promocode->description }}</p>
                                    </div>
                                </div>
                                <div class="right-side {{ session()->get('direction') == 2 ? 'rtl' : '' }}">
                                    <div class="info m-4 d-flex align-items-center">
                                        <div class="w-100 d-flex flex-column align-items-center">
                                            <div class="block">

                                                <p class="dark_color mb-0 fw-600 mb-3 fs-15">
                                                    <span
                                                        class="text-decoration-underline text-uppercase text-primary">
                                                        {{ $promocode->offer_code }}
                                                    </span>
                                                </p>
                                            </div>
                                            <button
                                                class="btn btn-sm btn-outline-primary rounded btn-submit btn-block copy"
                                                data-code="{{ $promocode->offer_code }}"
                                                data-bs-dismiss="modal">{{ trans('labels.copy') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
<!-- Booking Option Selection modal -->
<div class="modal fade" id="loginmodal" tabindex="-1" aria-labelledby="loginmodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content p-2">
            <div class="modal-body text-center">
                <div class="row align-items-center justify-content-center">
                    <div class="col-lg-4 d-none d-lg-block p-0">
                        <img src="{{ helper::image_path(helper::appdata($vendordata->id)->auth_image) }}"
                            alt="" class="w-100 object-fit-cover rounded-4">
                    </div>
                    <div class="col-lg-8 col-12 px-md-4">
                        <h3 class="m-0 text-start fw-semibold color-changer">{{ trans('labels.checkout_as_guest') }}
                        </h3>
                        <p class="mb-3 text-start mt-2 fs-7 color-changer">{{ trans('labels.checkout_model_title') }}
                        </p>
                        <ul class="text-start mb-4">
                            <li><i class="fa-solid fa-circle-check text-success me-2"></i><span
                                    class="text-muted fs-7">{{ trans('labels.get_access_to_booking') }}</span>
                            </li>
                            <li><i class="fa-solid fa-circle-check text-success me-2"></i><span
                                    class="text-muted fs-7">{{ trans('labels.faster_booking') }}</span></li>
                            <li><i class="fa-solid fa-circle-check text-success me-2"></i><span
                                    class="text-muted fs-7">{{ trans('labels.manage_your_booking') }}</span></li>
                        </ul>
                        <div class="d-lg-flex gap-2 justify-content-between align-items-center">
                            <a href="{{ URL::to($vendordata->slug . '/login') }}"
                                class="btn btn-outline-primary w-100 btn-submit rounded-4 mb-2 mb-lg-0 {{ session()->get('direction') == 2 ? 'mx-2' : '' }}">{{ trans('labels.login_with_your_account') }}</a>
                            <button id="btnguest" class="btn bg-primary text-white w-100 btn-submit rounded-4 m-0"
                                data-bs-dismiss="modal">{{ trans('labels.continue_as_guest') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Order Option Selection modal -->
<div class="modal fade" id="orderloginmodal" tabindex="-1" aria-labelledby="loginmodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content p-2">
            <div class="modal-body text-center">
                <div class="row align-items-center justify-content-center">
                    <div class="col-lg-4 d-none d-lg-block p-0">
                        <img src="{{ helper::image_path(helper::appdata($vendordata->id)->auth_image) }}"
                            alt="" class="w-100 object-fit-cover rounded-4">
                    </div>
                    <div class="col-lg-8 col-12 px-md-4">
                        <h3 class="m-0 text-start fw-semibold color-changer">{{ trans('labels.checkout_as_guest') }}
                        </h3>
                        <p class="mb-3 text-start mt-2 fs-7 color-changer">{{ trans('labels.checkout_model_title') }}
                        </p>
                        <ul class="text-start mb-4">
                            <li>
                                <i class="fa-solid fa-circle-check text-success me-2"></i>
                                <span class="text-muted fs-7">{{ trans('labels.get_access_to_order') }}</span>
                            </li>
                            <li>
                                <i class="fa-solid fa-circle-check text-success me-2"></i>
                                <span class="text-muted fs-7">{{ trans('labels.faster_order') }}</span>
                            </li>
                            <li>
                                <i class="fa-solid fa-circle-check text-success me-2"></i>
                                <span class="text-muted fs-7">{{ trans('labels.manage_your_order') }}</span>
                            </li>
                        </ul>
                        <div class="d-lg-flex gap-2 justify-content-between align-items-center">
                            <a href="{{ URL::to($vendordata->slug . '/login') }}"
                                class="btn btn-outline-primary w-100 btn-submit rounded-4 mb-2 mb-lg-0 {{ session()->get('direction') == 2 ? 'mx-2' : '' }}">{{ trans('labels.login_with_your_account') }}</a>
                            <button onclick="checkout()"
                                class="btn bg-primary text-white w-100 btn-submit rounded-4 m-0">{{ trans('labels.continue_as_guest') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
