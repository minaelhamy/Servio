<div class="view-cart-bar-2">
    <section class="view-cart-bar d-none">
        <div class="container">
            <div class="row g-2 align-items-center">
                <div class="col-xl-6 col-md-6">
                    <div class="d-flex gap-3 align-items-center">
                        <div class="product-img">
                            <img src="{{ @helper::image_path($product['product_image']->image) }}" class="rounded">
                        </div>
                        <div>
                            <h6 class="text-dark line-2 fw-600 my-1">
                                {{ $product->name }}
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
                        @if (helper::appdata($vendordata->id)->online_order == 1)
                            <div class="col-xl-4 col-lg-5 col-12">
                                <button
                                    onclick="addtocart('{{ $product->id }}','{{ URL::to($vendordata->slug . '/cart/add') }}',0)"
                                    class="btn btn-primary mb-0 fw-semibold d-flex gap-2 align-items-center justify-content-center btn-submit rounded w-100 add_to_cart_{{ $product->id }}">
                                    <div class="add_to_cart_icon_{{ $product->id }}">
                                        <i class="fa-regular fa-cart-shopping"></i>
                                        {{ trans('labels.add_to_cart') }}
                                    </div>
                                    <div class="load d-none add_to_cart_loader_{{ $product->id }}"></div>
                                </button>
                            </div>
                            <div class="col-xl-4 col-lg-5 col-12">
                                <button
                                    onclick="addtocart('{{ $product->id }}','{{ URL::to($vendordata->slug . '/cart/add') }}',1)"
                                    class="btn btn-outline-primary fw-semibold d-flex gap-2 align-items-center justify-content-center btn-submit rounded w-100 buy_now_{{ $product->id }}">
                                    <div class="buy_now_icon_{{ $product->id }}">
                                        <i class="fa-regular fa-bag-shopping"></i>
                                        {{ trans('labels.buy_now') }}
                                    </div>
                                    <div class="load d-none buy_now_loader_{{ $product->id }}"></div>
                                </button>
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
