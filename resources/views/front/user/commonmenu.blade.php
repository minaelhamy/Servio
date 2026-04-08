<!--------------------- new design --------------------->
<div class=" col-xl-3 col-lg-4 col-xxl-3 mb-3 mb-lg-0">
    <div class="card border-0 bg-lights rounded-4 position-relative">
        <div class="card-body">
            <!------------ Avatar ------------>
            <div class="text-center mb-3">
                <div class="avatar avatar-xl mb-2">
                    <img class="avatar-img rounded-circle border border-2 border-white"
                        src="{{ helper::image_path(Auth::user()->image) }}" alt="">
                </div>
                <h6 class="mb-0 fw-600 color-changer">{{ Auth::user()->name }}</h6>
                <a href="#" class="text-muted fw-normal"><small>{{ Auth::user()->email }}</small></a>
                <hr class="text-muted">
            </div>
            <!----------- side menu ----------->
           
            <div class="user-sidebar p-0 bg-transparent border-0 rounded-0">
                <li>
                    <a class="{{ request()->is('*profile') ? 'active' : '' }}"
                        href="{{ URL::To($vendordata->slug . '/profile') }}">
                        <i class="mx-2 fa-regular fa-user"></i>{{ trans('labels.edit_profile') }}</a>
                </li>
                @if (@Auth::user()->google_id == '' && @Auth::user()->facebook_id == '')
                    <li>
                        <a class="{{ request()->is('*changepassword') ? 'active' : '' }}"
                            href="{{ URL::To($vendordata->slug . '/changepassword') }}">
                            <i class="mx-2 fa fa-key fw-normal"></i>{{ trans('labels.change_password') }}</a>
                    </li>
                @endif
                @php
                    $booking = helper::getbooking($vendordata->id, Auth::user()->id);
                @endphp
                @if (helper::appdata($vendordata->id)->online_order == 1 || $booking->count() > 0)
                    <li>
                        <a class="{{ request()->is('*mybookings') ? 'active' : '' }}"
                            href="{{ URL::To($vendordata->slug . '/mybookings') }}">
                            <i class="mx-2 fa fa-list-check"></i>{{ trans('labels.booking_list') }}
                        </a>
                    </li>
                @endif
                @if (@helper::checkaddons('product_shop'))
                    @php
                        $order = helper::getorder($vendordata->id, Auth::user()->id);
                    @endphp
                    @if (helper::appdata($vendordata->id)->online_order == 1 || $order->count() > 0)
                        <li>
                            <a class="{{ request()->is('*myorders') ? 'active' : '' }}"
                                href="{{ URL::To($vendordata->slug . '/myorders') }}">
                                <i class="mx-2 fa fa-bag-shopping"></i> {{ trans('labels.order_list') }}</a>
                        </li>
                    @endif
                @endif
                @if (helper::allpaymentcheckaddons($vendordata->id))
                    <li>
                        <a class="{{ request()->is('*wallet') || request()->is($vendordata->slug . '/addmoneywallet') ? 'active' : '' }}"
                            href="{{ URL::To($vendordata->slug . '/wallet') }}">
                            <i class="fa-light fa-wallet mx-2"></i>
                            {{ trans('labels.wallet') }}</a>
                    </li>
                @endif
                <li>
                    <a class="{{ request()->is('*wishlist') || request()->is('*productwishlist') ? 'active' : '' }}"
                        href="{{ URL::To($vendordata->slug . '/wishlist') }}">
                        <i class="mx-2 fa-regular fa-heart"></i>{{ trans('labels.wishlist') }} </a>
                </li>
                <li>
                    <a class="{{ request()->is('*refer-earn') ? 'active' : '' }}"
                        href="{{ URL::To($vendordata->slug . '/refer-earn') }}">
                        <i class="mx-2 fa-regular fa-share-nodes"></i>{{ trans('labels.refer_earn') }} </a>
                </li>
                <li>
                    <a class="{{ request()->is('*deleteprofile') ? 'active' : '' }}"
                        href="{{ URL::To($vendordata->slug . '/deleteprofile') }}">
                        <i class="fa-solid fa-trash-can fw-normal mx-2"></i>{{ trans('labels.delete_account') }} </a>
                </li>
                <li>
                    <a href="javascript:void(0)" class="text-danger"
                        onclick="statusupdate('{{ URL::to($vendordata->slug . '/logout') }}')">
                        <i class="mx-2 fa fa-arrow-right-from-bracket"></i>{{ trans('labels.logout') }} </a>
                </li>
            </div>
        </div>
    </div>
</div>
