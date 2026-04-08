@if (request()->is($vendordata->slug . '/service-*') || request()->is($vendordata->slug . '/product-*'))
    @if (@helper::checkaddons('trusted_badges'))
        <div class="col-12 p-3">
            <div class="row g-3 product-detile">
                @if (@helper::otherappdata($vendordata->id)->trusted_badge_image_1)
                    <div class="col-6">
                        <div class="service-content">
                            <img src="{{ helper::image_path(@helper::otherappdata($vendordata->id)->trusted_badge_image_1) }}"
                                alt="">
                        </div>
                    </div>
                @endif
                @if (@helper::otherappdata($vendordata->id)->trusted_badge_image_2)
                    <div class="col-6">
                        <div class="service-content">
                            <img src="{{ helper::image_path(@helper::otherappdata($vendordata->id)->trusted_badge_image_2) }}"
                                alt="">
                        </div>
                    </div>
                @endif
                @if (@helper::otherappdata($vendordata->id)->trusted_badge_image_3)
                    <div class="col-6">
                        <div class="service-content">
                            <img src="{{ helper::image_path(@helper::otherappdata($vendordata->id)->trusted_badge_image_3) }}"
                                alt="">
                        </div>
                    </div>
                @endif
                @if (@helper::otherappdata($vendordata->id)->trusted_badge_image_4)
                    <div class="col-6">
                        <div class="service-content">
                            <img src="{{ helper::image_path(@helper::otherappdata($vendordata->id)->trusted_badge_image_4) }}"
                                alt="">
                        </div>
                    </div>
                @endif
            </div>
        </div>
    @endif
@endif

@if (@helper::checkaddons('safe_secure_checkout'))
    @if (@helper::otherappdata($vendordata->id)->safe_secure_checkout_payment_selection)
        @if (request()->is($vendordata->slug . '/service-*') || request()->is($vendordata->slug . '/product-*'))
            <div class="col-12 py-4 p-3 sevirce-trued mt-3 rounded">
            @else
                <div class="col-12 py-4 p-3 my-3 rounded-4 border">
        @endif
        <div class="d-flex mb-2 pb-1 flex-wrap gap-2 justify-content-center aling-items-center">
            @foreach (helper::paymentlist($vendordata->id) as $stpayment)
                @if (
                    @in_array(
                        $stpayment->payment_type,
                        explode(',', helper::otherappdata($vendordata->id)->safe_secure_checkout_payment_selection)))
                    <div class="sevirce-tru">
                        <div class="img">
                            <img class="border rounded-2" src="{{ helper::image_path($stpayment->image) }}"
                                alt="">
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
        <h6 class="fs-15 text-center fw-normal color-changer"
            style="color: {{ @helper::otherappdata($vendordata->id)->safe_secure_checkout_text_color }}">
            {{ @helper::otherappdata($vendordata->id)->safe_secure_checkout_text }}
        </h6>
        </div>
    @endif
@endif
