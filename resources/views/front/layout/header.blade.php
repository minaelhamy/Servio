<!-- offer banner -->
<div class="{{ request()->is($vendordata->slug) ? 'd-lg-block d-none' : 'd-block' }}">
    @if (!request()->is($vendordata->slug . '/service-*'))
        @include('front.layout.timmer')
    @endif
</div>
@if (@helper::checkaddons('coupon'))
    @php
        $coupons = App\Models\Promocode::where('vendor_id', $vendordata->id)->where('is_available', 1)->get();
    @endphp
    @if ($coupons->count() > 0)
        <div class="top-bar bg-primary d-flex align-items-center py-2">
            <marquee direction="{{ session()->get('direction') == 2 ? 'left' : 'right' }}" behavior="scroll"
                onmouseover="this.stop();" onmouseout="this.start();">
                @foreach (helper::promocode($vendordata->id) as $coupon)
                    <span>{{ $coupon->offer_name }} : {{ $coupon->offer_code }}</span>
                @endforeach
            </marquee>
        </div>
    @endif
@endif
<!-- offer banner -->
<nav id="navbar_top" class="navbar navbar-expand-lg navbar-background sticky-top shadow-sm">
    <div class="container container-position py-2">
        <div class="d-flex gap-2 h-100 flex-wrap align-content-center justify-content-center">
            <div class="d-lg-none">
                <button class="btn bg-transparent btn-group border-0 change-light color-changer m-0" type="button"
                    data-bs-toggle="offcanvas" data-bs-target="#footer_sidebar" aria-controls="footer_sidebar">
                    <i class="fa-solid fa-bars fs-3"></i>
                </button>
            </div>
            <script>
                document.addEventListener("DOMContentLoaded", function(event) {
                    if (localStorage.getItem('theme') === 'dark') {
                        var logo = "{{ helper::image_path(helper::appdata($vendordata->id)->darklogo) }}";
                    } else {
                        var logo = "{{ helper::image_path(helper::appdata($vendordata->id)->logo) }}";
                    }
                    $('#logoimage').attr('src', logo);
                });
            </script>

            <a class="navbar-brand p-0 m-0" href="{{ URL::to($vendordata->slug) }}">
                <img src="" class="logoimage m-0" alt="" id="logoimage">
            </a>

        </div>
        <div class="d-flex gap-2 align-items-center {{ session()->get('direction') == 2 ? 'me-auto' : 'ms-auto' }}">
            <!--------- new tablet language button --------->
            @php
                $languages = explode('|', helper::appdata($vendordata->id)->languages);
            @endphp
            @if (@helper::checkaddons('language'))
                @if (count($languages) > 1)
                    <div class="dropdown lag-btn d-flex gap-2 d-lg-none btn-group">
                        <a class="dropdown-toggle open-btn btn-group bg-transparent p-0 border-0 m-0" type="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{ helper::image_path(session()->get('flag')) }}" alt=""
                                class="language-dropdown-image">
                        </a>
                        <ul
                            class="dropdown-menu border-0 p-0 bg-body-secondary shadow {{ session()->get('direction') == 2 ? 'min-dropdown-rtl' : 'min-dropdown-ltr' }}">
                            @foreach (helper::available_language($vendordata->id) as $languagelist)
                                @if (in_array($languagelist->code, explode('|', helper::appdata($vendordata->id)->languages)))
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center gap-2 p-2"
                                            href="{{ URL::to('/lang/change?lang=' . $languagelist->code) }}">
                                            <img src="{{ helper::image_path($languagelist->image) }}" alt=""
                                                class="language-items-img">
                                            <p>{{ $languagelist->name }}</p>
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                @endif
            @endif
            @php
                $currencies = explode('|', helper::appdata($vendordata->id)->currencies);
            @endphp
            @if (@helper::checkaddons('currency_settigns'))
                @if (count($currencies) > 1)
                    <div class="dropdown lag-btn d-flex gap-2 d-lg-none btn-group">
                        <a class="dropdown-toggle open-btn btn-group bg-transparent p-0 border-0 m-0" type="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-regular fa-dollar-sign fs-5"></i>
                        </a>
                        <ul
                            class="dropdown-menu border-0 p-0 bg-body-secondary shadow {{ session()->get('direction') == 2 ? 'min-dropdown-rtl' : 'min-dropdown-ltr' }}">
                            @foreach (helper::available_currency($vendordata->id) as $currencylist)
                                @if (in_array($currencylist->code, explode('|', helper::appdata($vendordata->id)->currencies)))
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center gap-2 p-2"
                                            href="{{ URL::to('/currency/change?currency=' . $currencylist['code']) }}">
                                            <p>{{ $currencylist['currency'] }}</p>
                                            <p>{{ $currencylist['name'] }}</p>
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                @endif
            @endif
            <div class="dropdown lag-btn btn-group d-lg-none">
                <a href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"
                    class="dropdown-toggle open-btn btn-group bg-transparent p-0 border-0 m-0">
                    <i class="fa-regular fa-circle-half-stroke fs-5"></i>
                </a>
                <ul
                    class="dropdown-menu p-0 bg-body-secondary border-0 shadow mt-2 {{ session()->get('direction') == 2 ? 'min-dropdown-rtl' : 'min-dropdown-ltr' }}">
                    <li>
                        <a class="dropdown-item d-flex cursor-pointer align-items-center p-2 gap-2"
                            onclick="setLightMode()">
                            <i class="fa-light fa-lightbulb"></i>
                            <span class="fs-7">Light</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item d-flex cursor-pointer align-items-center p-2 gap-2"
                            onclick="setDarkMode()">
                            <i class="fa-solid fa-moon"></i>
                            <span class="fs-7">Dark</span>
                        </a>
                    </li>
                </ul>
            </div>
            <!--------- new tablet language button --------->
        </div>
        <div class="collapse navbar-collapse" id="Menu">
            <ul
                class="navbar-nav mb-2 mb-lg-0 gap-xl-3 gap-1 text-center {{ session()->get('direction') == 2 ? 'mx-auto' : 'mx-auto ' }}">
                <li class="nav-item">
                    <a class="nav-link navbar-text {{ request()->is($vendordata->slug) ? 'active' : '' }}"
                        aria-current="page" href="{{ URL::to($vendordata->slug) }}">{{ trans('labels.home') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link navbar-text {{ request()->is($vendordata->slug . '/categories*') ? 'active' : '' }}"
                        href="{{ URL::to($vendordata->slug . '/categories') }}">{{ trans('labels.category') }}</a>
                </li>
                @if (helper::appdata($vendordata->id)->service_on_off == 1)
                    <li class="nav-item">
                        <a class="nav-link navbar-text {{ request()->is($vendordata->slug . '/service*') ? 'active' : '' }}"
                            href="{{ URL::to($vendordata->slug . '/services') }}">{{ trans('labels.services') }}</a>
                    </li>
                @endif
                @if (@helper::checkaddons('product_shop'))
                    @if (helper::appdata($vendordata->id)->shop_on_off == 1)
                        <li class="nav-item dropdown">
                            <a class="nav-link navbar-text {{ request()->is($vendordata->slug . '/product*') ? 'active' : '' }}"
                                href="{{ URL::to($vendordata->slug . '/product') }}">
                                {{ trans('labels.shop') }}
                            </a>
                        </li>
                    @endif
                @endif
                @if (@helper::checkaddons('subscription'))
                    @if (@helper::checkaddons('blog'))
                        @php
                            $checkplan = App\Models\Transaction::where('vendor_id',$vdata)
                                ->orderByDesc('id')
                                ->first();
                            $user = App\Models\User::where('id',$vdata)->first();
                            if (@$user->allow_without_subscription == 1) {
                                $blogs = 1;
                            } else {
                                $blogs = @$checkplan->blogs;
                            }
                        @endphp
                        @if ($blogs == 1)
                            <li class="nav-item">
                                <a class="nav-link navbar-text {{ request()->is($vendordata->slug . '/allblog*') ? 'active' : '' }}"
                                    href="{{ URL::to($vendordata->slug . '/allblogs') }}">{{ trans('labels.blog') }}</a>
                            </li>
                        @endif
                    @endif
                @else
                    @if (@helper::checkaddons('blog'))
                        <li class="nav-item">
                            <a class="nav-link navbar-text {{ request()->is($vendordata->slug . '/allblog*') ? 'active' : '' }}"
                                href="{{ URL::to($vendordata->slug . '/allblogs') }}">{{ trans('labels.blog') }}</a>
                        </li>
                    @endif
                @endif
                <li class="nav-item">
                    <a class="nav-link navbar-text {{ request()->is($vendordata->slug . '/gallery') ? 'active' : '' }}"
                        href="{{ URL::to($vendordata->slug . '/gallery') }}">{{ trans('labels.gallery') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link navbar-text {{ request()->is($vendordata->slug . '/contact') ? 'active' : '' }}"
                        href="{{ URL::to($vendordata->slug . '/contact') }}">{{ trans('labels.help_contact') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link navbar-text {{ request()->is($vendordata->slug . '/faq') ? 'active' : '' }}"
                        href="{{ URL::to($vendordata->slug . '/faq') }}">{{ trans('labels.faqs') }}</a>
                </li>
            </ul>
            <!-- dekstop-language-dropdown-button-start-->

            <!--------- new dekstop language button --------->
            @php
                $languages = explode('|', helper::appdata($vendordata->id)->languages);
            @endphp
            <div class="d-flex gap-1">
                <!--------- new language button --------->
                @if (@helper::checkaddons('language'))
                    @if (count($languages) > 1)
                        <div class="btn-group lag-btn">
                            <a class="nav-link d-flex align-items-center" href="#" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="{{ helper::image_path(session()->get('flag')) }}" alt=""
                                    class="language-dropdown-image">
                            </a>
                            <ul
                                class="dropdown-menu border-0 p-0 bg-body-secondary shadow  {{ session()->get('direction') == 2 ? 'min-dropdown-rtl' : 'min-dropdown-ltr' }}">
                                @foreach (helper::available_language($vendordata->id) as $languagelist)
                                    @if (in_array($languagelist->code, explode('|', helper::appdata($vendordata->id)->languages)))
                                        <li>
                                            <a class="dropdown-item d-flex align-items-center gap-2 p-2"
                                                href="{{ URL::to('/lang/change?lang=' . $languagelist->code) }}">
                                                <img src="{{ helper::image_path($languagelist->image) }}"
                                                    alt="" class="language-items-img">
                                                <p>{{ $languagelist->name }}</p>
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    @endif
                @endif
                @if (@helper::checkaddons('currency_settigns'))
                    @if (count($currencies) > 1)
                        <div class="btn-group lag-btn">
                            <a class="nav-link d-flex align-items-center" href="#" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="fs-5">
                                    {{ session()->get('currency') }}
                                </span>

                            </a>
                            <ul
                                class="dropdown-menu border-0 p-0 bg-body-secondary shadow  {{ session()->get('direction') == 2 ? 'min-dropdown-rtl' : 'min-dropdown-ltr' }}">
                                @foreach (helper::available_currency() as $currencylist)
                                    @if (in_array($currencylist->code, explode('|', helper::appdata($vendordata->id)->currencies)))
                                        <li>
                                            <a class="dropdown-item d-flex align-items-center gap-2 p-2"
                                                href="{{ URL::to('/currency/change?currency=' . $currencylist['code']) }}">
                                                <p>{{ $currencylist['currency'] }}</p>
                                                <p>{{ $currencylist['name'] }}</p>
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    @endif
                @endif

                <!-- dekstop-language-dropdown-button--end-->
                @if (@helper::checkaddons('product_shop'))
                    <a href="{{ URL::to($vendordata->slug . '/cartproduct') }}"
                        class="btn-group rounded-3 p-1 position-relative" type="button">
                        <i class="fa-solid fa-bag-shopping"></i>
                        <span
                            class="cart-badge cart-count">{{ helper::getcartcount(@$vendordata->id, session()->getId(), Auth::user() && Auth::user()->type == 3 ? Auth::user()->id : '') }}</span>
                    </a>
                @endif
                <div class="d-flex gap-2">
                    @if (@Auth::user()->type == 3)
                        <!-- new after login btn -->
                        <a href="{{ URL::to($vendordata->slug . '/profile') }}"
                            class="btn-group rounded-3 p-1 overflow-hidden" type="button">
                            <img class="avatar-img object-fit-cover rounded-circle"
                                src="{{ helper::image_path(Auth::user()->image) }}" alt="">
                        </a>
                        <!-- new after login btn -->
                    @else
                        @if (@helper::checkaddons('customer_login'))
                            @if (helper::appdata($vendordata->id)->checkout_login_required == 1)
                                <a href="{{ URL::to($vendordata->slug . '/login') }}" class="btn-group rounded-3"><i
                                        class="fa-solid fa-user"></i></a>
                            @endif
                        @endif
                    @endif
                </div>
                <div class="dropdown btn-group lag-btn">
                    <a role="button" data-bs-toggle="dropdown" aria-expanded="false"
                        class="dropdown-toggle open-btn btn-group bg-transparent p-0 border-0 m-0 cursor-pointer">
                        <i class="fa-regular fa-circle-half-stroke fs-5"></i>
                    </a>
                    <ul
                        class="dropdown-menu p-0 bg-body-secondary border-0 shadow mt-2 {{ session()->get('direction') == 2 ? 'min-dropdown-rtl' : 'min-dropdown-ltr' }}">
                        <li>
                            <a class="dropdown-item d-flex cursor-pointer align-items-center p-2 gap-2"
                                onclick="setLightMode()">
                                <i class="fa-light fa-lightbulb"></i>
                                <span class="fs-7">Light</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex cursor-pointer align-items-center p-2 gap-2"
                                onclick="setDarkMode()">
                                <i class="fa-solid fa-moon"></i>
                                <span class="fs-7">Dark</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>


{{-- mobile menu footer --}}
<div class="mobile-menu-footer">
    <ul class="p-0 py-1 m-0">
        <li class="{{ request()->is($vendordata->slug) ? 'mobile-active' : '' }}">
            <a href="{{ URL::to($vendordata->slug) }}">
                <i class="fa-regular fa-house"></i>
                <span>{{ trans('labels.home') }}</span>
            </a>
        </li>
        <li class="{{ request()->is($vendordata->slug . '/services*') ? 'mobile-active' : '' }}">
            <a href="{{ URL::to($vendordata->slug . '/services') }}">
                <i class="fa-regular fa-gear"></i>
                <span>{{ trans('labels.services') }}</span>
            </a>
        </li>
        @if (@helper::checkaddons('product_shop'))
            <li class="{{ request()->is($vendordata->slug . '/cartproduct*') ? 'mobile-active' : '' }}">
                <a href="{{ URL::to($vendordata->slug . '/cartproduct') }}">
                    <div class="position-relative">
                        <i class="fa-solid fa-bag-shopping"></i>
                        <span
                            class="qut_counter cart-count">{{ helper::getcartcount(@$vendordata->id, session()->getId(), Auth::user() && Auth::user()->type == 3 ? Auth::user()->id : '') }}</span>
                    </div>
                    <span>{{ trans('labels.cart') }}</span>
                </a>
            </li>
        @endif
        <li class="{{ request()->is($vendordata->slug . '/categories*') ? 'mobile-active' : '' }}">
            <a href="{{ URL::to($vendordata->slug . '/categories') }}">
                <i class="fa-regular fa-box-archive"></i>
                <span>{{ trans('labels.category') }}</span>
            </a>
        </li>
        <li class="{{ request()->is($vendordata->slug . '/profile*') ? 'mobile-active' : '' }}">
            @if (@Auth::user()->type == 3)
                <a href="{{ URL::to($vendordata->slug . '/profile') }}">
                    <i class="fa-regular fa-user"></i>
                    <span>{{ trans('labels.account') }}</span>
                </a>
            @else
                @if (@helper::checkaddons('customer_login'))
                    @if (helper::appdata($vendordata->id)->checkout_login_required == 1)
                        <a href="{{ URL::to($vendordata->slug . '/login') }}">
                            <i class="fa-regular fa-user"></i>
                            <span>{{ trans('labels.account') }}</span>
                        </a>
                    @endif
                @endif
            @endif
        </li>
    </ul>
</div>
