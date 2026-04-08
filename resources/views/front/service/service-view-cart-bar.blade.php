<div class="view-cart-bar-2">
    <section class="view-cart-bar d-none">
        <div class="container">
            <div class="row g-2 align-items-center">
                <div class="col-xl-6 col-md-6">
                    <div class="d-flex gap-3 align-items-center">
                        <div class="product-img">
                            <img src="{{ helper::image_path($service['service_image']->image) }}" class="rounded">
                        </div>
                        <div>
                            <h6 class="text-dark line-2 fw-600 my-1">
                                {{ $service->name }}
                            </h6>
                            <div class="woo_pr_price">
                                <div class="woo_pr_offer_price d-flex align-items-center gap-2">
                                    <span
                                        class="price fw-600 fs-6">{{ helper::currency_formate($price, $vendordata->id) }}</span>
                                    <del class="org_price fs-8 text-muted fw-500">
                                        @if ($original_price > 0 && $original_price > $price)
                                            {{ helper::currency_formate($original_price, $vendordata->id) }}
                                        @endif
                                    </del>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-md-6">
                    <div class="row g-2 justify-content-end">
                        <div class="col-xl-4 col-lg-5 col-12">
                            @if (@helper::checkaddons('subscription'))
                                @if (@helper::checkaddons('whatsapp_message'))
                                    @php
                                        $checkplan = App\Models\Transaction::where('vendor_id',$vdata)
                                            ->orderByDesc('id')
                                            ->first();
                                        $user = App\Models\User::where('id',$vdata)->first();
                                        if (@$user->allow_without_subscription == 1) {
                                            $whatsapp_message = 1;
                                        } else {
                                            $whatsapp_message = @$checkplan->whatsapp_message;
                                        }
                                    @endphp
                                    @if (
                                        $whatsapp_message == 1 &&
                                            @whatsapp_helper::whatsapp_message_config($vendordata->id)->whatsapp_number != '' &&
                                            @whatsapp_helper::whatsapp_message_config($vendordata->id)->whatsapp_number != null)
                                        <a class="btn btn-outline-secondary mb-0 fw-semibold btn-submit rounded w-100"
                                            href="https://api.whatsapp.com/send?phone= {{ @whatsapp_helper::whatsapp_message_config($vendordata->id)->whatsapp_number }} &text=  {{ trans('labels.item_inquiry_msg') }} {{ $service->name }}"
                                            target="_blank"><i
                                                class="fa-brands fa-whatsapp {{ session()->get('direction') == 2 ? 'ms-2' : 'me-2' }}"></i>{{ trans('labels.whatsapp') }}</a>
                                    @endif
                                @endif
                            @else
                                @if (@helper::checkaddons('whatsapp_message'))
                                    @if (
                                        @whatsapp_helper::whatsapp_message_config($vendordata->id)->whatsapp_number != '' &&
                                            @whatsapp_helper::whatsapp_message_config($vendordata->id)->whatsapp_number != null)
                                        <a class="btn btn-outline-secondary mb-0 fw-semibold btn-submit rounded w-100"
                                            href="https://api.whatsapp.com/send?phone= {{ @whatsapp_helper::whatsapp_message_config($vendordata->id)->whatsapp_number }} &text={{ trans('labels.item_inquiry_msg') }} {{ $service->name }}"
                                            target="_blank"><i
                                                class="fa-brands fa-whatsapp {{ session()->get('direction') == 2 ? 'ms-2' : 'me-2' }}"></i>{{ trans('labels.whatsapp') }}</a>
                                    @endif
                                @endif
                            @endif
                        </div>
                        @if (helper::appdata($vendordata->id)->online_order == 1)
                            <div class="col-xl-4 col-lg-5 col-12">
                                <a class="btn btn-primary fw-semibold btn-submit rounded w-100"
                                    href="{{ URL::to($vendordata->slug . '/booking-' . $service->id) }}">
                                    <i
                                        class="fa-regular fa-bookmark {{ session()->get('direction') == 2 ? 'ms-2' : 'me-2' }}"></i>
                                    {{ trans('labels.book_now') }}
                                </a>
                            </div>
                        @endif
                        <div class="col-md-1 col-12">
                            <button class="border border-dark m-0 h-100 rounded close-btn-view" id="close-btn2">
                                <i class="fa-regular fa-xmark fs-4"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
