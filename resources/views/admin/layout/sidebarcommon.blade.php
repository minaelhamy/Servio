@php
    if (Auth::user()->type == 4) {
        $role_id = Auth::user()->role_id;
        $vendor_id = Auth::user()->vendor_id;
    } else {
        $role_id = '';
        $vendor_id = Auth::user()->id;
    }
    $user = App\Models\User::where('id', $vendor_id)->first();
@endphp

@if (Auth::user()->role_type == 1)
    <ul class="navbar-nav mb-4 {{ session()->get('direction') == 2 ? 'left-padding-rtl' : 'right-padding-ltr' }}">
        <li class="nav-item fs-7 {{ helper::check_menu($role_id, 'role_dashboard') == 1 ? 'd-block' : 'd-none' }}">
            <a class="nav-link d-flex rounded {{ request()->is('admin/dashboard') ? 'active' : '' }}" aria-current="page"
                href="{{ URL::to('/admin/dashboard') }}">
                <i class="fa-solid fa-house-user"></i>
                <span>{{ trans('labels.dashboards') }}</span>
            </a>
        </li>

        <li
            class="nav-item mt-3 {{ helper::check_menu($role_id, 'role_bookings') == 1 || helper::check_menu($role_id, 'role_reports') == 1 ? 'd-block' : 'd-none' }}">
            <h6 class="text-muted mb-2 fs-7 text-capitalize ">{{ trans('labels.booking_management') }}</h6>
        </li>
        <li class="nav-item mb-2 fs-7 {{ helper::check_menu($role_id, 'role_bookings') == 1 ? 'd-block' : 'd-none' }}">
            <a class="nav-link  d-flex rounded {{ request()->is('admin/bookings*') || request()->is('admin/invoice*') ? 'active' : '' }}"
                aria-current="page" href="{{ URL::to('/admin/bookings') }}">
                <i class="fa-solid fa-list-check"></i>
                <span>{{ trans('labels.bookings') }}</span>
            </a>
        </li>
        <li class="nav-item mb-2 fs-7 {{ helper::check_menu($role_id, 'role_reports') == 1 ? 'd-block' : 'd-none' }}">
            <a class="nav-link  d-flex rounded {{ request()->is('admin/reports') ? 'active' : '' }} "
                aria-current="page" href="{{ URL::to('/admin/reports') }}">
                <i class="fa-solid fa-chart-mixed"></i>
                <span>{{ trans('labels.reports') }}</span>
            </a>
        </li>
    </ul>
@else
    <ul class="navbar-nav mb-4 {{ session()->get('direction') == 2 ? 'left-padding-rtl' : 'right-padding-ltr' }}">
        <li
            class="nav-item mb-2 fs-7 {{ helper::check_menu($role_id, 'role_dashboard') == 1 ? 'd-block' : 'd-none' }}">
            <a class="nav-link d-flex rounded {{ request()->is('admin/dashboard') ? 'active' : '' }}"
                aria-current="page" href="{{ URL::to('/admin/dashboard') }}">
                <i class="fa-solid fa-house-user"></i>
                <span>{{ trans('labels.dashboards') }}</span>
            </a>
        </li>
        @if (Auth::user()->type == 1 || (Auth::user()->type == 4 && Auth::user()->vendor_id == 1))
            <li
                class="nav-item mb-2 fs-7 {{ helper::check_menu($role_id, 'role_addons_manager') == 1 ? 'd-block' : 'd-none' }}">
                <a class="nav-link d-flex rounded {{ request()->is('admin/apps*') ? 'active' : '' }}"
                    aria-current="page" href="{{ URL::to('/admin/apps') }}">
                    <i class="fa-solid fa-rocket"></i>
                    <p class="w-100 d-flex justify-content-between align-items-center">
                        <span>{{ trans('labels.addons_manager') }}</span>
                        <span class="rainbowText float-right">Premium</span>
                    </p>
                </a>
            </li>
        @endif
        @if (@helper::checkaddons('customer_login'))
            <li
                class="nav-item mt-3 {{ helper::check_menu($role_id, 'role_vendors') == 1 || helper::check_menu($role_id, 'role_customers') == 1 ? 'd-block' : 'd-none' }}">
                <h6 class="text-muted mb-2 fs-7 text-capitalize ">{{ trans('labels.user_management') }}</h6>
            </li>
        @endif
        @if (Auth::user()->type == 1 || (Auth::user()->type == 4 && Auth::user()->vendor_id == 1))
            <li
                class="nav-item mb-2 fs-7 {{ helper::check_menu($role_id, 'role_vendors') == 1 ? 'd-block' : 'd-none' }}">
                <a class="nav-link  d-flex rounded {{ request()->is('admin/users*') ? 'active' : '' }}"
                    aria-current="page" href="{{ URL::to('/admin/users') }}">
                    <i class="fa-solid fa-user-plus"></i>
                    <span>{{ trans('labels.vendors') }}</span>
                </a>
            </li>
        @endif
        @if (@helper::checkaddons('customer_login'))
            <li
                class="nav-item mb-2 fs-7 {{ helper::check_menu($role_id, 'role_customers') == 1 ? 'd-block' : 'd-none' }}">
                <a class="nav-link rounded d-flex {{ request()->is('admin/customers*') ? 'active' : '' }}"
                    aria-current="page" href="{{ URL::to('admin/customers') }}">
                    <i class="fa-solid fa-users"></i>
                    <p class="w-100 d-flex justify-content-between align-items-center">
                        <span>{{ trans('labels.customers') }}</span>
                        @if (env('Environment') == 'sendbox')
                            <span class="badge badge bg-danger float-right">{{ trans('labels.addon') }}</span>
                        @endif
                    </p>
                </a>
            </li>
        @endif
        @if (Auth::user()->type == 2 || (Auth::user()->type == 4 && Auth::user()->vendor_id != 1))
            <li
                class="nav-item mt-3 {{ helper::check_menu($role_id, 'role_categories') == 1 || helper::check_menu($role_id, 'role_bulk_import') == 1 || helper::check_menu($role_id, 'role_services') == 1 || helper::check_menu($role_id, 'role_bookings') == 1 || helper::check_menu($role_id, 'role_reports') == 1 ? 'd-block' : 'd-none' }}">
                <h6 class="text-muted mb-2 fs-7 text-capitalize ">{{ trans('labels.service_management') }}</h6>
            </li>
            <li
                class="nav-item mb-2 fs-7 dropdown multimenu {{ helper::check_menu($role_id, 'role_services') == 1 ? 'd-block' : 'd-none' }}">
                <a class="nav-link collapsed rounded d-flex align-items-center justify-content-between dropdown-toggle mb-1"
                    href="#service-menu" data-bs-toggle="collapse" role="button" aria-expanded="false"
                    aria-controls="service-menu">
                    <span class="d-flex"><i class="fa-solid fa-file-lines"></i>
                        <span class="multimenu-title">{{ trans('labels.services') }}</span>
                    </span>
                </a>
                <ul class="collapse" id="service-menu">
                    <li
                        class="nav-item ps-4 mb-1 {{ helper::check_menu($role_id, 'role_categories') == 1 ? 'd-block' : 'd-none' }}">
                        <a class="nav-link rounded d-flex {{ request()->is('admin/categories*') ? 'active' : '' }}"
                            aria-current="page" href="{{ URL::to('/admin/categories') }}">
                            <span class="d-flex align-items-center multimenu-menu-indicator">
                                <i class="fa-solid fa-circle-small"></i>{{ trans('labels.categories') }}
                            </span>
                        </a>
                    </li>
                    <li
                        class="nav-item ps-4 mb-1 {{ helper::check_menu($role_id, 'role_services') == 1 ? 'd-block' : 'd-none' }}">
                        <a class="nav-link rounded d-flex {{ request()->is('admin/services*') ? 'active' : '' }}"
                            aria-current="page" href="{{ URL::to('/admin/services') }}">
                            <span class="d-flex align-items-center multimenu-menu-indicator">
                                <i class="fa-solid fa-circle-small"></i>{{ trans('labels.services') }}
                            </span>
                        </a>
                    </li>
                    @if (@helper::checkaddons('question_answer'))
                        <li
                            class="nav-item ps-4 mb-1 {{ helper::check_menu($role_id, 'role_service_question_answer') == 1 ? 'd-block' : 'd-none' }}">
                            <a class="nav-link rounded {{ request()->is('admin/service_question_answer*') ? 'active' : '' }}"
                                aria-current="page" href="{{ URL::to('/admin/service_question_answer') }}">
                                <span class="d-flex align-items-center multimenu-menu-indicator">
                                    <i
                                        class="fa-solid fa-circle-small"></i>{{ trans('labels.service_question_answer') }}
                                </span>
                            </a>
                        </li>
                    @endif

                    @if (@helper::checkaddons('service_import'))
                        <li
                            class="nav-item ps-4 mb-1 {{ helper::check_menu($role_id, 'role_bulk_import') == 1 ? 'd-block' : 'd-none' }}">
                            <a class="nav-link rounded {{ request()->is('admin/import*') || request()->is('admin/media*') ? 'active' : '' }}"
                                aria-current="page" href="{{ URL::to('/admin/import') }}">
                                <span class="d-flex align-items-center multimenu-menu-indicator">
                                    <i class="fa-solid fa-circle-small"></i>{{ trans('labels.product_upload') }}
                                </span>
                            </a>
                        </li>
                    @endif
                </ul>
            </li>
            <li
                class="nav-item mb-2 fs-7 {{ helper::check_menu($role_id, 'role_bookings') == 1 ? 'd-block' : 'd-none' }}">
                <a class="nav-link  d-flex rounded {{ request()->is('admin/bookings*') || request()->is('admin/invoice*') ? 'active' : '' }}"
                    aria-current="page" href="{{ URL::to('/admin/bookings') }}">
                    <i class="fa-solid fa-list-check"></i>
                    <span>{{ trans('labels.bookings') }}</span>
                </a>
            </li>
            <li
                class="nav-item mb-2 fs-7 {{ helper::check_menu($role_id, 'role_reports') == 1 ? 'd-block' : 'd-none' }}">
                <a class="nav-link  d-flex rounded {{ request()->is('admin/reports') ? 'active' : '' }} "
                    aria-current="page" href="{{ URL::to('/admin/reports') }}">
                    <i class="fa-solid fa-chart-mixed"></i>
                    <span>{{ trans('labels.reports') }}</span>
                </a>
            </li>

            @if (@helper::checkaddons('product_shop'))
                <li
                    class="nav-item mt-3 {{ helper::check_menu($role_id, 'role_orders') == 1 || helper::check_menu($role_id, 'role_order_reports') == 1 || helper::check_menu($role_id, 'role_products_categories') == 1 || helper::check_menu($role_id, 'role_products') == 1 || helper::check_menu($role_id, 'role_products_bulk_import') == 1 || helper::check_menu($role_id, 'role_shipping_management') == 1 ? 'd-block' : 'd-none' }}">
                    <h6 class="text-muted mb-2 fs-7 text-capitalize">{{ trans('labels.product_management') }}</h6>
                </li>
                <li
                    class="nav-item mb-2 fs-7 dropdown multimenu {{ helper::check_menu($role_id, 'role_products') == 1 ? 'd-block' : 'd-none' }}">
                    <a class="nav-link collapsed rounded d-flex align-items-center justify-content-between dropdown-toggle mb-1"
                        href="#products-menu" data-bs-toggle="collapse" role="button" aria-expanded="false"
                        aria-controls="products-menu">
                        <span class="d-flex">
                            <i class="fa-solid fa-file-lines"></i>
                            <span class="multimenu-title">{{ trans('labels.product_s') }}</span>
                        </span>
                        @if (env('Environment') == 'sendbox')
                            <span class="badge badge bg-danger float-right">{{ trans('labels.addon') }}</span>
                        @endif
                    </a>
                    <ul class="collapse" id="products-menu">
                        {{-- <li
                            class="nav-item ps-4 mb-1 {{ helper::check_menu($role_id, 'role_pos') == 1 ? 'd-block' : 'd-none' }}">
                            <a class="nav-link rounded d-flex {{ request()->is('admin/pos*') ? 'active' : '' }}"
                                aria-current="page" href="{{ URL::to('/admin/pos') }}">
                                <span class="d-flex align-items-center multimenu-menu-indicator w-100">
                                    <i class="fa-solid fa-circle-small"></i>{{ trans('labels.pos') }}
                                </span>
                            </a>
                        </li> --}}
                        <li
                            class="nav-item ps-4 mb-1 {{ helper::check_menu($role_id, 'role_products_categories') == 1 ? 'd-block' : 'd-none' }}">
                            <a class="nav-link rounded d-flex {{ request()->is('admin/product-category*') ? 'active' : '' }}"
                                aria-current="page" href="{{ URL::to('/admin/product-category') }}">
                                <span class="d-flex align-items-center multimenu-menu-indicator">
                                    <i class="fa-solid fa-circle-small"></i>{{ trans('labels.categories') }}
                                </span>
                            </a>
                        </li>
                        <li
                            class="nav-item ps-4 mb-1 {{ helper::check_menu($role_id, 'role_products') == 1 ? 'd-block' : 'd-none' }}">
                            <a class="nav-link rounded d-flex {{ request()->is('admin/products*') ? 'active' : '' }}"
                                aria-current="page" href="{{ URL::to('/admin/products') }}">
                                <span class="d-flex align-items-center multimenu-menu-indicator">
                                    <i class="fa-solid fa-circle-small"></i>{{ trans('labels.product_s') }}
                                </span>
                            </a>
                        </li>
                        @if (@helper::checkaddons('product_import'))
                            <li
                                class="nav-item ps-4 mb-1 {{ helper::check_menu($role_id, 'role_products_bulk_import') == 1 ? 'd-block' : 'd-none' }}">
                                <a class="nav-link rounded {{ request()->is('admin/productimport*') || request()->is('admin/productmedia*') ? 'active' : '' }}"
                                    aria-current="page" href="{{ URL::to('/admin/productimport') }}">
                                    <span class="d-flex align-items-center multimenu-menu-indicator">
                                        <i class="fa-solid fa-circle-small"></i>{{ trans('labels.product_s_upload') }}
                                    </span>
                                </a>
                            </li>
                        @endif
                        <li
                            class="nav-item ps-4 mb-1 {{ helper::check_menu($role_id, 'role_shipping_management') == 1 ? 'd-block' : 'd-none' }}">
                            <a class="nav-link rounded {{ request()->is('admin/shipping*') ? 'active' : '' }}"
                                aria-current="page" href="{{ URL::to('/admin/shipping') }}">
                                <span class="d-flex align-items-center multimenu-menu-indicator">
                                    <i class="fa-solid fa-circle-small"></i>{{ trans('labels.shipping_management') }}
                                </span>
                            </a>
                        </li>
                        @if (@helper::checkaddons('question_answer'))
                            <li
                                class="nav-item ps-4 mb-1 {{ helper::check_menu($role_id, 'role_product_question_answer') == 1 ? 'd-block' : 'd-none' }}">
                                <a class="nav-link rounded {{ request()->is('admin/question_answer*') ? 'active' : '' }}"
                                    aria-current="page" href="{{ URL::to('/admin/question_answer') }}">
                                    <span class="d-flex align-items-center multimenu-menu-indicator">
                                        <i
                                            class="fa-solid fa-circle-small"></i>{{ trans('labels.product_question_answer') }}
                                    </span>
                                </a>
                            </li>
                        @endif

                    </ul>
                </li>
                <li
                    class="nav-item mb-2 fs-7 {{ helper::check_menu($role_id, 'role_orders') == 1 ? 'd-block' : 'd-none' }}">
                    <a class="nav-link  d-flex rounded {{ request()->is('admin/orders*') || request()->is('admin/order/invoice*') ? 'active' : '' }}"
                        aria-current="page" href="{{ URL::to('/admin/orders') }}">
                        <i class="fa-solid fa-list-check"></i>
                        <span>{{ trans('labels.order_s') }}</span>
                    </a>
                </li>
                <li
                    class="nav-item mb-2 fs-7 {{ helper::check_menu($role_id, 'role_order_reports') == 1 ? 'd-block' : 'd-none' }}">
                    <a class="nav-link  d-flex rounded {{ request()->is('admin/orderreports') ? 'active' : '' }} "
                        aria-current="page" href="{{ URL::to('/admin/orderreports') }}">
                        <i class="fa-solid fa-chart-mixed"></i>
                        <span>{{ trans('labels.reports') }}</span>
                    </a>
                </li>
            @endif

            <li
                class="nav-item mt-3 {{ helper::check_menu($role_id, 'role_banners') == 1 || helper::check_menu($role_id, 'role_coupons') == 1 || helper::check_menu($role_id, 'role_top_deals') == 1 ? 'd-block' : 'd-none' }}">
                <h6 class="text-muted mb-2 fs-7 text-capitalize ">{{ trans('labels.promotions') }}</h6>
            </li>
            <li
                class="nav-item mb-2 fs-7 dropdown multimenu {{ helper::check_menu($role_id, 'role_banners') == 1 ? 'd-block' : 'd-none' }}">
                <a class="nav-link collapsed rounded d-flex align-items-center justify-content-between dropdown-toggle mb-1"
                    href="#banners" data-bs-toggle="collapse" role="button" aria-expanded="false"
                    aria-controls="banners">
                    <span class="d-flex">
                        <i class="fa-solid fa-image"></i>
                        <span class="multimenu-title">{{ trans('labels.banners') }}</span>
                    </span>
                </a>
                <ul class="collapse" id="banners">
                    <li class="nav-item ps-4 mb-1">
                        <a class="nav-link rounded {{ request()->is('admin/bannersection-1*') ? 'active' : '' }}"
                            aria-current="page" href="{{ URL::to('/admin/bannersection-1') }}">
                            <span class="d-flex align-items-center multimenu-menu-indicator"><i
                                    class="fa-solid fa-circle-small"></i>{{ trans('labels.section-1') }}</span>
                        </a>
                    </li>
                    <li class="nav-item ps-4 mb-1">
                        <a class="nav-link rounded {{ request()->is('admin/bannersection-2*') ? 'active' : '' }}"
                            aria-current="page" href="{{ URL::to('/admin/bannersection-2') }}">
                            <span class="d-flex align-items-center multimenu-menu-indicator"><i
                                    class="fa-solid fa-circle-small"></i>{{ trans('labels.section-2') }}</span>
                        </a>
                    </li>
                </ul>
            </li>
            @if (@helper::checkaddons('subscription'))
                @if (@helper::checkaddons('coupon'))
                    @php
                        $checkplan = App\Models\Transaction::where('vendor_id', $vendor_id)->orderByDesc('id')->first();

                        if (@$user->allow_without_subscription == 1) {
                            $coupons = 1;
                        } else {
                            $coupons = @$checkplan->coupons;
                        }
                    @endphp
                    @if ($coupons == 1)
                        <li
                            class="nav-item mb-2 fs-7 {{ helper::check_menu($role_id, 'role_coupons') == 1 ? 'd-block' : 'd-none' }}">
                            <a class="nav-link  d-flex rounded {{ request()->is('admin/promocode*') ? 'active' : '' }}"
                                aria-current="page" href="{{ URL::to('/admin/promocode') }}">
                                <i class="fa-solid fa-badge-percent"></i>
                                <p class="w-100 d-flex justify-content-between align-items-center">
                                    <span class="nav-text ">{{ trans('labels.coupons') }}</span>
                                    @if (env('Environment') == 'sendbox')
                                        <span
                                            class="badge badge bg-danger float-right">{{ trans('labels.addon') }}</span>
                                    @endif
                                </p>
                            </a>
                        </li>
                    @endif
                @endif
            @else
                @if (@helper::checkaddons('coupon'))
                    <li
                        class="nav-item mb-2 fs-7 {{ helper::check_menu($role_id, 'role_coupons') == 1 ? 'd-block' : 'd-none' }}">
                        <a class="nav-link  d-flex rounded {{ request()->is('admin/promocode*') ? 'active' : '' }}"
                            aria-current="page" href="{{ URL::to('/admin/promocode') }}">
                            <i class="fa-solid fa-badge-percent"></i>
                            <p class="w-100 d-flex justify-content-between align-items-center">
                                <span class="nav-text ">{{ trans('labels.coupons') }}</span>
                                @if (env('Environment') == 'sendbox')
                                    <span
                                        class="badge badge bg-danger float-right">{{ trans('labels.addon') }}</span>
                                @endif
                            </p>
                        </a>
                    </li>
                @endif
            @endif
            @if (@helper::checkaddons('top_deals'))
                <li
                    class="nav-item mb-2 fs-7 {{ helper::check_menu($role_id, 'role_top_deals') == 1 ? 'd-block' : 'd-none' }}">
                    <a class="nav-link  d-flex rounded {{ request()->is('admin/top_deals*') ? 'active' : '' }}"
                        aria-current="page" href="{{ URL::to('/admin/top_deals') }}">
                        <i class="fa-solid fa-tags"></i>
                        <p class="w-100 d-flex justify-content-between align-items-center">
                            <span class="nav-text ">{{ trans('labels.top_deals') }}</span>
                            @if (env('Environment') == 'sendbox')
                                <span class="badge badge bg-danger float-right">{{ trans('labels.addon') }}</span>
                            @endif
                        </p>
                    </a>
                </li>
            @endif
        @endif
        <li
            class="nav-item mt-3 {{ helper::check_menu($role_id, 'role_tax') == 1 || helper::check_menu($role_id, 'role_pricing_plan') == 1 || helper::check_menu($role_id, 'role_transactions') == 1 || helper::check_menu($role_id, 'role_payment') == 1 || helper::check_menu($role_id, 'role_payout') == 1 || helper::check_menu($role_id, 'role_countries') == 1 || helper::check_menu($role_id, 'role_cities') == 1 || helper::check_menu($role_id, 'role_store_categories') == 1 || helper::check_menu($role_id, 'role_custom_domains') == 1 || helper::check_menu($role_id, 'role_calendar') == 1 || helper::check_menu($role_id, 'role_custom_status') == 1 ? 'd-block' : 'd-none' }}">
            <h6 class="text-muted mb-2 fs-7 text-capitalize ">{{ trans('labels.business_management') }}</h6>
        </li>
        <li class="nav-item mb-2 fs-7 {{ helper::check_menu($role_id, 'role_tax') == 1 ? 'd-block' : 'd-none' }}">
            <a class="nav-link rounded d-flex {{ request()->is('admin/tax*') ? 'active' : '' }}" aria-current="page"
                href="{{ URL::to('/admin/tax') }}">
                <i class="fa-solid fa-box-archive"></i>
                <p class="w-100 d-flex justify-content-between">
                    <span class="nav-text ">{{ trans('labels.tax') }}</span>
                </p>
            </a>
        </li>
        @if (@helper::checkaddons('subscription'))
            @if ($user->allow_without_subscription != 1)
                <li
                    class="nav-item mb-2 fs-7 {{ helper::check_menu($role_id, 'role_pricing_plan') == 1 ? 'd-block' : 'd-none' }}">
                    <a class="nav-link  d-flex rounded {{ request()->is('admin/plan*') ? 'active' : '' }}"
                        aria-current="page" href="{{ URL::to('/admin/plan') }}">
                        <i class="fa-solid fa-medal"></i>
                        <span>{{ trans('labels.pricing_plan') }}</span>
                    </a>
                </li>
            @endif
            <li
                class="nav-item mb-2 fs-7 {{ helper::check_menu($role_id, 'role_transactions') == 1 ? 'd-block' : 'd-none' }}">
                <a class="nav-link d-flex rounded {{ request()->is('admin/transaction') ? 'active' : '' }}"
                    aria-current="page" href="{{ URL::to('/admin/transaction') }}">
                    <i class="fa-solid fa-file-invoice-dollar"></i>
                    <span>{{ trans('labels.transactions') }}</span>
                </a>
            </li>
        @endif
        @if (@helper::checkaddons('subscription'))
            <li
                class="nav-item mb-2 fs-7 {{ helper::check_menu($role_id, 'role_payment') == 1 ? 'd-block' : 'd-none' }}">
                <a class="nav-link  d-flex rounded {{ request()->is('admin/payment') ? 'active' : '' }}"
                    aria-current="page" href="{{ URL::to('/admin/payment') }}">
                    <i class="fa-solid fa-money-check-dollar-pen"></i>
                    <span>{{ trans('labels.payment') }}</span>
                </a>
            </li>
        @else
            @if (Auth::user()->type == 2 || (Auth::user()->type == 4 && Auth::user()->vendor_id != 1))
                <li
                    class="nav-item mb-2 fs-7 {{ helper::check_menu($role_id, 'role_payment') == 1 ? 'd-block' : 'd-none' }}">
                    <a class="nav-link  d-flex rounded {{ request()->is('admin/payment') ? 'active' : '' }}"
                        aria-current="page" href="{{ URL::to('/admin/payment') }}">
                        <i class="fa-solid fa-money-check-dollar-pen"></i>
                        <span>{{ trans('labels.payment') }}</span>
                    </a>
                </li>
            @endif
        @endif

        @if (@helper::checkaddons('commission_module'))
            @if (helper::getslug($vendor_id)->commission_on_off == 1)
                <li
                    class="nav-item mb-2 fs-7 {{ helper::check_menu($role_id, 'role_payout') == 1 ? 'd-block' : 'd-none' }}">
                    <a class="nav-link rounded d-flex {{ request()->is('admin/payout*') ? 'active' : '' }}"
                        aria-current="page" href="{{ URL::to('/admin/payout') }}">
                        <i class="fa-solid fa-handshake"></i>
                        <p class="w-100 d-flex justify-content-between align-items-center">
                            <span class="nav-text ">{{ trans('labels.payout') }}</span>
                            @if (env('Environment') == 'sendbox')
                                <span class="badge badge bg-danger float-right">{{ trans('labels.addon') }}</span>
                            @endif
                        </p>
                    </a>
                </li>
            @endif
        @endif
        @if (Auth::user()->type == 1 || (Auth::user()->type == 4 && Auth::user()->vendor_id == 1))
            <li
                class="nav-item mb-2 fs-7 dropdown multimenu {{ helper::check_menu($role_id, 'role_countries') == 1 || helper::check_menu($role_id, 'role_cities') == 1 ? 'd-block' : 'd-none' }}">
                <a class="nav-link collapsed rounded d-flex align-items-center justify-content-between dropdown-toggle mb-1"
                    href="#location" data-bs-toggle="collapse" role="button" aria-expanded="false"
                    aria-controls="location">
                    <span class="d-flex"><i class="fa-sharp fa-solid fa-location-dot"></i><span
                            class="multimenu-title">{{ trans('labels.location') }}</span></span>
                </a>
                <ul class="collapse" id="location">
                    <li
                        class="nav-item ps-4 mb-1 {{ helper::check_menu($role_id, 'role_countries') == 1 ? 'd-block' : 'd-none' }}">
                        <a class="nav-link rounded {{ request()->is('admin/countries') ? 'active' : '' }}"
                            aria-current="page" href="{{ URL::to('/admin/countries') }}">
                            <span class="d-flex align-items-center multimenu-menu-indicator"><i
                                    class="fa-solid fa-circle-small"></i>{{ trans('labels.countries') }}</span>
                        </a>
                    </li>
                    <li
                        class="nav-item ps-4 mb-1 {{ helper::check_menu($role_id, 'role_cities') == 1 ? 'd-block' : 'd-none' }}">
                        <a class="nav-link rounded {{ request()->is('admin/cities') ? 'active' : '' }}"
                            aria-current="page" href="{{ URL::to('/admin/cities') }}">
                            <span class="d-flex align-items-center multimenu-menu-indicator"><i
                                    class="fa-solid fa-circle-small"></i>{{ trans('labels.cities') }}</span>
                        </a>
                    </li>
                </ul>
            </li>
            @if (@helper::checkaddons('custom_domain'))
                <li
                    class="nav-item mb-2 fs-7 {{ helper::check_menu($role_id, 'role_custom_domains') == 1 ? 'd-block' : 'd-none' }}">
                    <a class="nav-link d-flex rounded {{ request()->is('admin/custom_domain*') ? 'active' : '' }}"
                        aria-current="page" href="{{ URL::to('/admin/custom_domain') }}">
                        <i class="fa-solid fa-link"></i>
                        <p class="w-100 d-flex justify-content-between align-items-center">
                            <span>{{ trans('labels.custom_domains') }}</span>
                            @if (env('Environment') == 'sendbox')
                                <span class="badge badge bg-danger float-right">{{ trans('labels.addon') }}</span>
                            @endif
                        </p>
                    </a>
                </li>
            @endif
            <li
                class="nav-item mb-2 fs-7 {{ helper::check_menu($role_id, 'role_store_categories') == 1 ? 'd-block' : 'd-none' }}">
                <a class="nav-link rounded d-flex {{ request()->is('admin/store_categories*') ? 'active' : '' }}"
                    href="{{ URL::to('/admin/store_categories') }}" aria-expanded="false">
                    <i class="fa-solid fa-table-list"></i> <span
                        class="nav-text ">{{ trans('labels.store_categories') }}</span>
                </a>
            </li>
        @endif
        @if (Auth::user()->type == 2 || (Auth::user()->type == 4 && Auth::user()->vendor_id != 1))
            @if (@helper::checkaddons('subscription'))
                @if (@helper::checkaddons('vendor_calendar'))
                    @php
                        $checkplan = App\Models\Transaction::where('vendor_id', $vendor_id)->orderByDesc('id')->first();

                        if (@$user->allow_without_subscription == 1) {
                            $vendor_calendar = 1;
                        } else {
                            $vendor_calendar = @$checkplan->vendor_calendar;
                        }

                    @endphp
                    @if ($vendor_calendar == 1)
                        <li
                            class="nav-item mb-2 fs-7 {{ helper::check_menu($role_id, 'role_calendar') == 1 ? 'd-block' : 'd-none' }}">
                            <a class="nav-link rounded d-flex {{ request()->is('admin/calendar*') ? 'active' : '' }}"
                                aria-current="page" href="{{ URL::to('/admin/calendar') }}">
                                <i class="fa-solid fa-calendar-days"></i>
                                <p class="w-100 d-flex justify-content-between align-items-center">
                                    <span class="nav-text ">{{ trans('labels.calendar') }}</span>
                                    @if (env('Environment') == 'sendbox')
                                        <span
                                            class="badge badge bg-danger float-right">{{ trans('labels.addon') }}</span>
                                    @endif
                                </p>
                            </a>
                        </li>
                    @endif
                @endif
            @else
                @if (@helper::checkaddons('vendor_calendar'))
                    <li
                        class="nav-item mb-2 fs-7 {{ helper::check_menu($role_id, 'role_calendar') == 1 ? 'd-block' : 'd-none' }}">
                        <a class="nav-link rounded d-flex {{ request()->is('admin/calendar*') ? 'active' : '' }}"
                            aria-current="page" href="{{ URL::to('/admin/calendar') }}">
                            <i class="fa-solid fa-calendar-days"></i>
                            <p class="w-100 d-flex justify-content-between align-items-center">
                                <span class="nav-text ">{{ trans('labels.calendar') }}</span>
                                @if (env('Environment') == 'sendbox')
                                    <span
                                        class="badge badge bg-danger float-right">{{ trans('labels.addon') }}</span>
                                @endif
                            </p>
                        </a>
                    </li>
                @endif
            @endif
            @if (@helper::checkaddons('custom_status'))
                <li
                    class="nav-item mb-2 fs-7 {{ helper::check_menu($role_id, 'role_custom_status') == 1 ? 'd-block' : 'd-none' }}">
                    <a class="nav-link rounded d-flex {{ request()->is('admin/custom_status*') ? 'active' : '' }}"
                        aria-current="page" href="{{ URL::to('admin/custom_status') }}">
                        <i class="fa-regular fa-clipboard-list-check"></i>
                        <p class="w-100 d-flex justify-content-between align-items-center">
                            <span class="nav-text ">{{ trans('labels.custom_status') }}</span>
                            @if (env('Environment') == 'sendbox')
                                <span class="badge badge bg-danger float-right">{{ trans('labels.addon') }}</span>
                            @endif
                        </p>
                    </a>
                </li>
            @endif

            @if (@helper::checkaddons('subscription'))
                @if (@helper::checkaddons('custom_domain'))
                    @php
                        $checkplan = App\Models\Transaction::where('vendor_id', $vendor_id)->orderByDesc('id')->first();

                        if (@$user->allow_without_subscription == 1) {
                            $custom_domain = 1;
                        } else {
                            $custom_domain = @$checkplan->custom_domain;
                        }

                    @endphp
                    @if (@$custom_domain == 1)
                        <li
                            class="nav-item mb-2 fs-7 {{ helper::check_menu($role_id, 'role_custom_domains') == 1 ? 'd-block' : 'd-none' }}">
                            <a class="nav-link d-flex rounded {{ request()->is('admin/custom_domain*') ? 'active' : '' }}"
                                aria-current="page" href="{{ URL::to('/admin/custom_domain') }}">
                                <i class="fa-solid fa-link"></i>
                                <p class="w-100 d-flex justify-content-between align-items-center">
                                    <span>{{ trans('labels.custom_domains') }}</span>
                                    @if (env('Environment') == 'sendbox')
                                        <span
                                            class="badge badge bg-danger float-right">{{ trans('labels.addon') }}</span>
                                    @endif
                                </p>
                            </a>
                        </li>
                    @endif
                @endif
            @else
                @if (@helper::checkaddons('custom_domain'))
                    <li
                        class="nav-item mb-2 fs-7 {{ helper::check_menu($role_id, 'role_custom_domains') == 1 ? 'd-block' : 'd-none' }}">
                        <a class="nav-link d-flex rounded {{ request()->is('admin/custom_domain*') ? 'active' : '' }}"
                            aria-current="page" href="{{ URL::to('/admin/custom_domain') }}">
                            <i class="fa-solid fa-link"></i>
                            <p class="w-100 d-flex justify-content-between align-items-center">
                                <span>{{ trans('labels.custom_domains') }}</span>
                                @if (env('Environment') == 'sendbox')
                                    <span
                                        class="badge badge bg-danger float-right">{{ trans('labels.addon') }}</span>
                                @endif
                            </p>
                        </a>
                    </li>
                @endif
            @endif
        @endif
        @if (Auth::user()->type == 2 || (Auth::user()->type == 4 && Auth::user()->vendor_id != 1))
            <li
                class="nav-item mt-3 {{ helper::check_menu($role_id, 'role_theme_settings') == 1 || helper::check_menu($role_id, 'role_choose_us') == 1 || helper::check_menu($role_id, 'role_mobile_section') == 1 || helper::check_menu($role_id, 'role_blogs') == 1 || helper::check_menu($role_id, 'role_faqs') == 1 || helper::check_menu($role_id, 'role_testimonials') == 1 || helper::check_menu($role_id, 'role_gallery') == 1 || helper::check_menu($role_id, 'role_cms_pages') == 1 ? 'd-block' : 'd-none' }}">
                <h6 class="text-muted mb-2 fs-7 text-capitalize ">{{ trans('labels.website_settings') }}</h6>
            </li>
            <li
                class="nav-item mb-2 fs-7 {{ helper::check_menu($role_id, 'role_basic_settings') == 1 ? 'd-block' : 'd-none' }}">
                <a class="nav-link rounded d-flex {{ request()->is('admin/basic_settings*') ? 'active' : '' }}"
                    aria-current="page" href="{{ URL::to('admin/basic_settings') }}">
                    <i class="fa-solid fa-list"></i><span class="">{{ trans('labels.basic_settings') }}</span>
                </a>
            </li>
            <li
                class="nav-item mb-2 fs-7 {{ helper::check_menu($role_id, 'role_choose_us') == 1 ? 'd-block' : 'd-none' }}">
                <a class="nav-link  d-flex rounded {{ request()->is('admin/choose_us*') ? 'active' : '' }}"
                    aria-current="page" href="{{ URL::to('/admin/choose_us') }}">
                    <i class="fa-solid fa-tag"></i>
                    <span>{{ trans('labels.choose_us') }}</span>
                </a>
            </li>
            @if (@helper::checkaddons('subscription'))
                @if (@helper::checkaddons('blog'))
                    @php
                        $checkplan = App\Models\Transaction::where('vendor_id', $vendor_id)->orderByDesc('id')->first();

                        if (@$user->allow_without_subscription == 1) {
                            $blogs = 1;
                        } else {
                            $blogs = @$checkplan->blogs;
                        }

                    @endphp
                    @if ($blogs == 1)
                        <li
                            class="nav-item mb-2 fs-7 {{ helper::check_menu($role_id, 'role_blogs') == 1 ? 'd-block' : 'd-none' }}">
                            <a class="nav-link d-flex rounded {{ request()->is('admin/blogs*') ? 'active' : '' }}"
                                aria-current="page" href="{{ URL::to('/admin/blogs') }}">
                                <i class="fa-solid fa-blog"></i>
                                <p class="w-100 d-flex justify-content-between align-items-center">
                                    <span class="nav-text ">{{ trans('labels.blogs') }}</span>
                                    @if (env('Environment') == 'sendbox')
                                        <span
                                            class="badge badge bg-danger float-right">{{ trans('labels.addon') }}</span>
                                    @endif
                                </p>
                            </a>
                        </li>
                    @endif

                @endif
            @else
                @if (@helper::checkaddons('blog'))
                    <li
                        class="nav-item mb-2 fs-7 {{ helper::check_menu($role_id, 'role_blogs') == 1 ? 'd-block' : 'd-none' }}">
                        <a class="nav-link d-flex rounded {{ request()->is('admin/blogs*') ? 'active' : '' }}"
                            aria-current="page" href="{{ URL::to('/admin/blogs') }}">
                            <i class="fa-solid fa-blog"></i>
                            <p class="w-100 d-flex justify-content-between align-items-center">
                                <span class="nav-text ">{{ trans('labels.blogs') }}</span>
                                @if (env('Environment') == 'sendbox')
                                    <span
                                        class="badge badge bg-danger float-right">{{ trans('labels.addon') }}</span>
                                @endif
                            </p>
                        </a>
                    </li>
                @endif
            @endif

            <li
                class="nav-item mb-2 fs-7 {{ helper::check_menu($role_id, 'role_faqs') == 1 ? 'd-block' : 'd-none' }}">
                <a class="nav-link d-flex rounded {{ request()->is('admin/faqs*') ? 'active' : '' }}"
                    aria-current="page" href="{{ URL::to('/admin/faqs') }}">
                    <i class="fa-solid fa-question"></i>
                    <span>{{ trans('labels.faqs') }}</span>
                </a>
            </li>
            @if (@helper::checkaddons('store_reviews'))
                <li
                    class="nav-item mb-2 fs-7 {{ helper::check_menu($role_id, 'role_testimonials') == 1 ? 'd-block' : 'd-none' }}">
                    <a class="nav-link d-flex rounded {{ request()->is('admin/testimonials*') ? 'active' : '' }}"
                        aria-current="page" href="{{ URL::to('/admin/testimonials') }}">
                        <i class="fa-solid fa-comment-dots"></i>
                        <p class="w-100 d-flex justify-content-between align-items-center">
                            <span class="nav-text ">{{ trans('labels.testimonials') }}</span>
                            @if (env('Environment') == 'sendbox')
                                <span class="badge badge bg-danger float-right">{{ trans('labels.addon') }}</span>
                            @endif
                        </p>
                    </a>
                </li>
            @endif
            <li
                class="nav-item mb-2 fs-7 {{ helper::check_menu($role_id, 'role_gallery') == 1 ? 'd-block' : 'd-none' }}">
                <a class="nav-link rounded d-flex {{ request()->is('admin/gallery*') ? 'active' : '' }}"
                    aria-current="page" href="{{ URL::to('admin/gallery') }}">
                    <i class="fa-solid fa-images"></i> <span class="">{{ trans('labels.gallery') }}</span>
                </a>
            </li>
            <li
                class="nav-item mb-2 fs-7 dropdown multimenu {{ helper::check_menu($role_id, 'role_cms_pages') == 1 ? 'd-block' : 'd-none' }}">
                <a class="nav-link collapsed rounded d-flex align-items-center justify-content-between dropdown-toggle mb-1"
                    href="#pages" data-bs-toggle="collapse" role="button" aria-expanded="false"
                    aria-controls="pages">
                    <span class="d-flex"><i class="fa-solid fa-file-lines"></i><span
                            class="multimenu-title">{{ trans('labels.cms_pages') }}</span></span>
                </a>
                <ul class="collapse" id="pages">
                    <li class="nav-item ps-4 mb-1">
                        <a class="nav-link rounded {{ request()->is('admin/privacypolicy') ? 'active' : '' }}"
                            aria-current="page" href="{{ URL::to('/admin/privacypolicy') }}">
                            <span class="d-flex align-items-center multimenu-menu-indicator"><i
                                    class="fa-solid fa-circle-small"></i>{{ trans('labels.privacy_policy') }}</span>
                        </a>
                    </li>
                    <li class="nav-item ps-4 mb-1">
                        <a class="nav-link rounded {{ request()->is('admin/termscondition') ? 'active' : '' }}"
                            aria-current="page" href="{{ URL::to('/admin/termscondition') }}">
                            <span class="d-flex align-items-center multimenu-menu-indicator"><i
                                    class="fa-solid fa-circle-small"></i>{{ trans('labels.terms_condition') }}</span>
                        </a>
                    </li>
                    <li class="nav-item ps-4 mb-1">
                        <a class="nav-link rounded {{ request()->is('admin/aboutus*') ? 'active' : '' }}"
                            aria-current="page" href="{{ URL::to('/admin/aboutus') }}">
                            <span class="d-flex align-items-center multimenu-menu-indicator"><i
                                    class="fa-solid fa-circle-small"></i>{{ trans('labels.about_us') }}</span>
                        </a>
                    </li>
                    <li class="nav-item ps-4 mb-1">
                        <a class="nav-link rounded {{ request()->is('admin/refund_policy') ? 'active' : '' }}"
                            aria-current="page" href="{{ URL::to('/admin/refund_policy') }}">
                            <span class="d-flex align-items-center multimenu-menu-indicator"><i
                                    class="fa-solid fa-circle-small"></i>{{ trans('labels.refund_policy') }}</span>
                        </a>
                    </li>

                </ul>
            </li>

            {{-- role management --}}

            @if (@helper::checkaddons('subscription'))
                @if (@helper::checkaddons('employee'))
                    @php
                        $checkplan = App\Models\Transaction::where('vendor_id', $vendor_id)->orderByDesc('id')->first();

                        if (@$user->allow_without_subscription == 1) {
                            $employee = 1;
                        } else {
                            $employee = @$checkplan->employee;
                        }
                    @endphp
                    @if ($employee == 1)
                        <li
                            class="nav-item mt-3 {{ helper::check_menu($role_id, 'role_employees') == 1 || helper::check_menu($role_id, 'role_roles') == 1 ? 'd-block' : 'd-none' }}">
                            <h6 class="text-muted mb-2 fs-7 text-capitalize ">
                                {{ trans('labels.employee_management') }}
                            </h6>
                        </li>
                        <li
                            class="nav-item mb-2 fs-7 {{ helper::check_menu($role_id, 'role_roles') == 1 ? 'd-block' : 'd-none' }}">
                            <a class="nav-link  d-flex rounded {{ request()->is('admin/roles*') ? 'active' : '' }}"
                                aria-current="page" href="{{ URL::to('/admin/roles') }}">
                                <i class="fa-solid fa-user-secret"></i>
                                <p class="w-100 d-flex justify-content-between align-items-center">
                                    <span class="nav-text ">{{ trans('labels.roles') }}</span>
                                    @if (env('Environment') == 'sendbox')
                                        <span
                                            class="badge badge bg-danger float-right">{{ trans('labels.addon') }}</span>
                                    @endif
                                </p>
                            </a>
                        </li>
                        <li
                            class="nav-item mb-2 fs-7 {{ helper::check_menu($role_id, 'role_employees') == 1 ? 'd-block' : 'd-none' }}">
                            <a class="nav-link  d-flex rounded {{ request()->is('admin/employees*') ? 'active' : '' }}"
                                aria-current="page" href="{{ URL::to('/admin/employees') }}">
                                <i class="fa fa-users"></i>
                                <p class="w-100 d-flex justify-content-between align-items-center">
                                    <span class="nav-text ">{{ trans('labels.employees') }}</span>
                                    @if (env('Environment') == 'sendbox')
                                        <span
                                            class="badge badge bg-danger float-right">{{ trans('labels.addon') }}</span>
                                    @endif
                                </p>
                            </a>
                        </li>
                    @endif

                @endif
            @else
                @if (@helper::checkaddons('employee'))
                    <li
                        class="nav-item mt-3 {{ helper::check_menu($role_id, 'role_employees') == 1 || helper::check_menu($role_id, 'role_roles') == 1 ? 'd-block' : 'd-none' }}">
                        <h6 class="text-muted mb-2 fs-7 text-capitalize ">{{ trans('labels.employee_management') }}
                        </h6>
                    </li>
                    <li
                        class="nav-item mb-2 fs-7 {{ helper::check_menu($role_id, 'role_roles') == 1 ? 'd-block' : 'd-none' }}">
                        <a class="nav-link  d-flex rounded {{ request()->is('admin/roles*') ? 'active' : '' }}"
                            aria-current="page" href="{{ URL::to('/admin/roles') }}">
                            <i class="fa-solid fa-user-secret"></i>
                            <p class="w-100 d-flex justify-content-between align-items-center">
                                <span class="nav-text ">{{ trans('labels.roles') }}</span>
                                @if (env('Environment') == 'sendbox')
                                    <span
                                        class="badge badge bg-danger float-right">{{ trans('labels.addon') }}</span>
                                @endif
                            </p>
                        </a>
                    </li>
                    <li
                        class="nav-item mb-2 fs-7 {{ helper::check_menu($role_id, 'role_employees') == 1 ? 'd-block' : 'd-none' }}">
                        <a class="nav-link  d-flex rounded {{ request()->is('admin/employees*') ? 'active' : '' }}"
                            aria-current="page" href="{{ URL::to('/admin/employees') }}">
                            <i class="fa fa-users"></i>
                            <p class="w-100 d-flex justify-content-between align-items-center">
                                <span class="nav-text ">{{ trans('labels.employees') }}</span>
                                @if (env('Environment') == 'sendbox')
                                    <span
                                        class="badge badge bg-danger float-right">{{ trans('labels.addon') }}</span>
                                @endif
                            </p>
                        </a>
                    </li>
                @endif
            @endif
        @endif

        @if (Auth::user()->type == 1 || (Auth::user()->type == 4 && Auth::user()->vendor_id == 1))
            {{-- landing Page --}}
            <li
                class="nav-item mt-3 {{ helper::check_menu($role_id, 'role_basic_settings') == 1 || helper::check_menu($role_id, 'role_how_it_works') == 1 || helper::check_menu($role_id, 'role_theme_images') == 1 || helper::check_menu($role_id, 'role_features') == 1 || helper::check_menu($role_id, 'role_promotional_banners') == 1 || helper::check_menu($role_id, 'role_blogs') == 1 || helper::check_menu($role_id, 'role_faqs') == 1 || helper::check_menu($role_id, 'role_testimonials') == 1 || helper::check_menu($role_id, 'role_cms_pages') == 1 || helper::check_menu($role_id, 'role_coupons') == 1 ? 'd-block' : 'd-none' }}">
                <h6 class="text-muted mb-2 fs-7 text-capitalize ">{{ trans('labels.landing_page') }}</h6>
            </li>
            <li
                class="nav-item mb-2 fs-7 {{ helper::check_menu($role_id, 'role_basic_settings') == 1 ? 'd-block' : 'd-none' }}">
                <a class="nav-link d-flex rounded {{ request()->is('admin/basic_settings*') ? 'active' : '' }}"
                    aria-current="page" href="{{ URL::to('/admin/basic_settings') }}">
                    <i class="fa-solid fa-list"></i>
                    <span>{{ trans('labels.basic_settings') }}</span>
                </a>
            </li>
            <li
                class="nav-item mb-2 fs-7 {{ helper::check_menu($role_id, 'role_how_it_works') == 1 ? 'd-block' : 'd-none' }}">
                <a class="nav-link d-flex rounded {{ request()->is('admin/how_it_works*') ? 'active' : '' }}"
                    aria-current="page" href="{{ URL::to('/admin/how_it_works') }}">
                    <i class="fa-regular fa-hourglass"></i>
                    <span>{{ trans('labels.how_it_works') }}</span>
                </a>
            </li>
            <li
                class="nav-item mb-2 fs-7 {{ helper::check_menu($role_id, 'role_theme_images') == 1 ? 'd-block' : 'd-none' }}">
                <a class="nav-link d-flex rounded {{ request()->is('admin/themes*') ? 'active' : '' }}"
                    aria-current="page" href="{{ URL::to('/admin/themes') }}">
                    <i class="fa-solid fa-palette"></i>
                    <span>{{ trans('labels.theme_images') }}</span>
                </a>
            </li>
            <li
                class="nav-item mb-2 fs-7 {{ helper::check_menu($role_id, 'role_features') == 1 ? 'd-block' : 'd-none' }}">
                <a class="nav-link d-flex rounded {{ request()->is('admin/features*') ? 'active' : '' }}"
                    aria-current="page" href="{{ URL::to('/admin/features') }}">
                    <i class="fa-solid fa-sliders"></i>
                    <span>{{ trans('labels.features') }}</span>
                </a>
            </li>
            <li
                class="nav-item mb-2 fs-7 {{ helper::check_menu($role_id, 'role_promotional_banners') == 1 ? 'd-block' : 'd-none' }}">
                <a class="nav-link d-flex rounded {{ request()->is('admin/promotionalbanners*') ? 'active' : '' }}"
                    aria-current="page" href="{{ URL::to('/admin/promotionalbanners') }}">
                    <i class="fa-solid fa-bullhorn"></i>
                    <span>{{ trans('labels.promotional_banners') }}</span>
                </a>
            </li>

            @if (@helper::checkaddons('blog'))
                <li
                    class="nav-item mb-2 fs-7 {{ helper::check_menu($role_id, 'role_blogs') == 1 ? 'd-block' : 'd-none' }}">
                    <a class="nav-link d-flex rounded {{ request()->is('admin/blogs*') ? 'active' : '' }}"
                        aria-current="page" href="{{ URL::to('/admin/blogs') }}">
                        <i class="fa-solid fa-blog"></i>
                        <p class="w-100 d-flex justify-content-between align-items-center">
                            <span class="nav-text ">{{ trans('labels.blogs') }}</span>
                            @if (env('Environment') == 'sendbox')
                                <span class="badge badge bg-danger float-right">{{ trans('labels.addon') }}</span>
                            @endif
                        </p>
                    </a>
                </li>
            @endif
            <li
                class="nav-item mb-2 fs-7 {{ helper::check_menu($role_id, 'role_faqs') == 1 ? 'd-block' : 'd-none' }}">
                <a class="nav-link d-flex rounded {{ request()->is('admin/faqs*') ? 'active' : '' }}"
                    aria-current="page" href="{{ URL::to('/admin/faqs') }}">
                    <i class="fa-solid fa-question"></i>
                    <span>{{ trans('labels.faqs') }}</span>
                </a>
            </li>
            @if (@helper::checkaddons('store_reviews'))
                <li
                    class="nav-item mb-2 fs-7 {{ helper::check_menu($role_id, 'role_testimonials') == 1 ? 'd-block' : 'd-none' }}">
                    <a class="nav-link d-flex rounded {{ request()->is('admin/testimonials*') ? 'active' : '' }}"
                        aria-current="page" href="{{ URL::to('/admin/testimonials') }}">
                        <i class="fa-solid fa-comment-dots"></i>
                        <p class="w-100 d-flex justify-content-between align-items-center">
                            <span class="nav-text ">{{ trans('labels.testimonials') }}</span>
                            @if (env('Environment') == 'sendbox')
                                <span class="badge badge bg-danger float-right">{{ trans('labels.addon') }}</span>
                            @endif
                        </p>
                    </a>
                </li>
            @endif

            <li
                class="nav-item mb-2 fs-7 dropdown multimenu {{ helper::check_menu($role_id, 'role_cms_pages') == 1 ? 'd-block' : 'd-none' }}">
                <a class="nav-link collapsed rounded d-flex align-items-center justify-content-between dropdown-toggle mb-1"
                    href="#pages" data-bs-toggle="collapse" role="button" aria-expanded="false"
                    aria-controls="pages">
                    <span class="d-flex"><i class="fa-solid fa-file-lines"></i></i><span
                            class="multimenu-title">{{ trans('labels.cms_pages') }}</span></span>
                </a>
                <ul class="collapse" id="pages">
                    <li class="nav-item ps-4 mb-1">
                        <a class="nav-link rounded {{ request()->is('admin/privacypolicy') ? 'active' : '' }}"
                            aria-current="page" href="{{ URL::to('/admin/privacypolicy') }}">
                            <span class="d-flex align-items-center multimenu-menu-indicator"><i
                                    class="fa-solid fa-circle-small"></i>{{ trans('labels.privacy_policy') }}</span>
                        </a>
                    </li>
                    <li class="nav-item ps-4 mb-1">
                        <a class="nav-link rounded {{ request()->is('admin/termscondition') ? 'active' : '' }}"
                            aria-current="page" href="{{ URL::to('/admin/termscondition') }}">
                            <span class="d-flex align-items-center multimenu-menu-indicator"><i
                                    class="fa-solid fa-circle-small"></i>{{ trans('labels.terms_condition') }}</span>
                        </a>
                    </li>
                    <li class="nav-item ps-4 mb-1">
                        <a class="nav-link rounded {{ request()->is('admin/aboutus*') ? 'active' : '' }}"
                            aria-current="page" href="{{ URL::to('/admin/aboutus') }}">
                            <span class="d-flex align-items-center multimenu-menu-indicator"><i
                                    class="fa-solid fa-circle-small"></i>{{ trans('labels.about_us') }}</span>
                        </a>
                    </li>
                    <li class="nav-item ps-4 mb-1">
                        <a class="nav-link rounded {{ request()->is('admin/refund_policy') ? 'active' : '' }}"
                            aria-current="page" href="{{ URL::to('/admin/refund_policy') }}">
                            <span class="d-flex align-items-center multimenu-menu-indicator"><i
                                    class="fa-solid fa-circle-small"></i>{{ trans('labels.refund_policy') }}</span>
                        </a>
                    </li>
                </ul>
            </li>

            @if (@helper::checkaddons('coupon'))
                <li
                    class="nav-item mb-2 fs-7 {{ helper::check_menu($role_id, 'role_coupons') == 1 ? 'd-block' : 'd-none' }}">
                    <a class="nav-link  d-flex rounded {{ request()->is('admin/promocode*') ? 'active' : '' }}"
                        aria-current="page" href="{{ URL::to('/admin/promocode') }}">
                        <i class="fa-solid fa-badge-percent"></i>
                        <p class="w-100 d-flex justify-content-between align-items-center">
                            <span class="nav-text ">{{ trans('labels.coupons') }}</span>
                            @if (env('Environment') == 'sendbox')
                                <span class="badge badge bg-danger float-right">{{ trans('labels.addon') }}</span>
                            @endif
                        </p>
                    </a>
                </li>
            @endif
            @if (@helper::checkaddons('employee'))
                <li
                    class="nav-item mt-3 {{ helper::check_menu($role_id, 'role_employees') == 1 || helper::check_menu($role_id, 'role_roles') == 1 ? 'd-block' : 'd-none' }}">
                    <h6 class="text-muted mb-2 fs-7 text-capitalize ">{{ trans('labels.employee_management') }}
                    </h6>
                </li>
                <li
                    class="nav-item mb-2 fs-7 {{ helper::check_menu($role_id, 'role_roles') == 1 ? 'd-block' : 'd-none' }}">
                    <a class="nav-link  d-flex rounded {{ request()->is('admin/roles*') ? 'active' : '' }}"
                        aria-current="page" href="{{ URL::to('/admin/roles') }}">
                        <i class="fa-solid fa-user-secret"></i>
                        <p class="w-100 d-flex justify-content-between align-items-center">
                            <span class="nav-text ">{{ trans('labels.roles') }}</span>
                            @if (env('Environment') == 'sendbox')
                                <span class="badge badge bg-danger float-right">{{ trans('labels.addon') }}</span>
                            @endif
                        </p>
                    </a>
                </li>
                <li
                    class="nav-item mb-2 fs-7 {{ helper::check_menu($role_id, 'role_employees') == 1 ? 'd-block' : 'd-none' }}">
                    <a class="nav-link  d-flex rounded {{ request()->is('admin/employees*') ? 'active' : '' }}"
                        aria-current="page" href="{{ URL::to('/admin/employees') }}">
                        <i class="fa-solid fa-users-gear"></i>
                        <p class="w-100 d-flex justify-content-between align-items-center">
                            <span class="nav-text ">{{ trans('labels.employees') }}</span>
                            @if (env('Environment') == 'sendbox')
                                <span class="badge badge bg-danger float-right">{{ trans('labels.addon') }}</span>
                            @endif
                        </p>
                    </a>
                </li>
            @endif
        @endif

        {{-- other --}}
        <li
            class="nav-item mt-3 {{ helper::check_menu($role_id, 'role_subscribers') == 1 || helper::check_menu($role_id, 'role_inquiries') == 1 || helper::check_menu($role_id, 'role_share') == 1 || helper::check_menu($role_id, 'role_setting') == 1 || helper::check_menu($role_id, 'role_language_settings') == 1 ? 'd-block' : 'd-none' }}">
            <h6 class="text-muted mb-2 fs-7 text-capitalize ">{{ trans('labels.other') }}</h6>
        </li>
        <li
            class="nav-item mb-2 fs-7 {{ helper::check_menu($role_id, 'role_subscribers') == 1 ? 'd-block' : 'd-none' }}">
            <a class="nav-link rounded d-flex {{ request()->is('admin/subscribers*') ? 'active' : '' }}"
                aria-current="page" href="{{ URL::to('admin/subscribers') }}">
                <i class="fa-solid fa-envelope"></i> <span class="">{{ trans('labels.subscribers') }}</span>
            </a>
        </li>
        <li
            class="nav-item mb-2 fs-7 {{ helper::check_menu($role_id, 'role_inquiries') == 1 ? 'd-block' : 'd-none' }}">
            <a class="nav-link  d-flex rounded {{ request()->is('admin/contacts') ? 'active' : '' }} "
                aria-current="page" href="{{ URL::to('/admin/contacts') }}">
                <i class="fa-solid fa-solid fa-address-book"></i>
                <span>{{ trans('labels.inquiries') }}</span>
            </a>
        </li>
        @if (Auth::user()->type == 2 || (Auth::user()->type == 4 && Auth::user()->vendor_id != 1))

            <li
                class="nav-item mb-2 fs-7 {{ helper::check_menu($role_id, 'role_share') == 1 ? 'd-block' : 'd-none' }}">
                <a class="nav-link rounded d-flex {{ request()->is('admin/share*') ? 'active' : '' }}"
                    aria-current="page" href="{{ URL::to('admin/share') }}">
                    <i class="fa-solid fa-share-from-square"></i> <span
                        class="">{{ trans('labels.share') }}</span>
                </a>
            </li>
            @if (@helper::checkaddons('subscription'))
                @if (@helper::checkaddons('whatsapp_message'))
                    @php
                        $checkplan = App\Models\Transaction::where('vendor_id', $vendor_id)->orderByDesc('id')->first();

                        if (@$user->allow_without_subscription == 1) {
                            $whatsapp_message = 1;
                        } else {
                            $whatsapp_message = @$checkplan->whatsapp_message;
                        }
                    @endphp
                    @if ($whatsapp_message == 1)
                        <li
                            class="nav-item mb-2 fs-7 {{ helper::check_menu($role_id, 'role_whatsapp_settings') == 1 ? 'd-block' : 'd-none' }}">
                            <a class="nav-link rounded d-flex {{ request()->is('admin/whatsapp_settings*') ? 'active' : '' }}"
                                aria-current="page" href="{{ URL::to('admin/whatsapp_settings') }}">
                                <i class="fa-brands fa-whatsapp fs-5"></i>
                                <p class="w-100 d-flex justify-content-between align-items-center">
                                    <span class="">{{ trans('labels.whatsapp_settings') }}</span>
                                    @if (env('Environment') == 'sendbox')
                                        <span
                                            class="badge badge bg-danger float-right">{{ trans('labels.addon') }}</span>
                                    @endif
                                </p>
                            </a>
                        </li>
                    @endif
                @endif
            @else
                @if (@helper::checkaddons('whatsapp_message'))
                    <li
                        class="nav-item mb-2 fs-7 {{ helper::check_menu($role_id, 'role_whatsapp_settings') == 1 ? 'd-block' : 'd-none' }}">
                        <a class="nav-link rounded d-flex {{ request()->is('admin/whatsapp_settings*') ? 'active' : '' }}"
                            aria-current="page" href="{{ URL::to('admin/whatsapp_settings') }}">
                            <i class="fa-brands fa-whatsapp fs-5"></i>
                            <p class="w-100 d-flex justify-content-between align-items-center">
                                <span class="">{{ trans('labels.whatsapp_settings') }}</span>
                                @if (env('Environment') == 'sendbox')
                                    <span
                                        class="badge badge bg-danger float-right">{{ trans('labels.addon') }}</span>
                                @endif
                            </p>
                        </a>
                    </li>
                @endif
            @endif
            @if (@helper::checkaddons('subscription'))
                @if (@helper::checkaddons('telegram_message'))
                    @php
                        $checkplan = App\Models\Transaction::where('vendor_id', $vendor_id)->orderByDesc('id')->first();

                        if (@$user->allow_without_subscription == 1) {
                            $telegram_message = 1;
                        } else {
                            $telegram_message = @$checkplan->telegram_message;
                        }
                    @endphp
                    @if ($telegram_message == 1)
                        <li
                            class="nav-item mb-2 fs-7 {{ helper::check_menu($role_id, 'role_telegram_settings') == 1 ? 'd-block' : 'd-none' }}">
                            <a class="nav-link rounded d-flex {{ request()->is('admin/telegram_settings*') ? 'active' : '' }}"
                                aria-current="page" href="{{ URL::to('admin/telegram_settings') }}">
                                <i class="fa-brands fa-telegram fs-5"></i>
                                <p class="w-100 d-flex justify-content-between align-items-center">
                                    <span class="">{{ trans('labels.telegram_settings') }}</span>
                                    @if (env('Environment') == 'sendbox')
                                        <span
                                            class="badge badge bg-danger float-right">{{ trans('labels.addon') }}</span>
                                    @endif
                                </p>
                            </a>
                        </li>
                    @endif
                @endif
            @else
                @if (@helper::checkaddons('telegram_message'))
                    <li
                        class="nav-item mb-2 fs-7 {{ helper::check_menu($role_id, 'role_telegram_settings') == 1 ? 'd-block' : 'd-none' }}">
                        <a class="nav-link rounded d-flex {{ request()->is('admin/telegram_settings*') ? 'active' : '' }}"
                            aria-current="page" href="{{ URL::to('admin/telegram_settings') }}">
                            <i class="fa-brands fa-telegram fs-5"></i>
                            <p class="w-100 d-flex justify-content-between align-items-center">
                                <span class="">{{ trans('labels.telegram_settings') }}</span>
                                @if (env('Environment') == 'sendbox')
                                    <span
                                        class="badge badge bg-danger float-right">{{ trans('labels.addon') }}</span>
                                @endif
                            </p>
                        </a>
                    </li>
                @endif
            @endif
            @if (@helper::checkaddons('language'))
                @if (helper::listoflanguage()->count() > 1)
                    <li
                        class="nav-item mb-2 fs-7 {{ helper::check_menu($role_id, 'role_language_settings') == 1 ? 'd-block' : 'd-none' }}">
                        <a class="nav-link rounded d-flex {{ request()->is('admin/language-settings*') ? 'active' : '' }}"
                            aria-current="page" href="{{ URL::to('/admin/language-settings') }}">
                            <i class="fa-solid fa-language"></i>
                            <p class="w-100 d-flex justify-content-between">
                                <span class="nav-text ">{{ trans('labels.language-settings') }}</span>
                            </p>
                        </a>
                    </li>
                @endif
            @endif

            @if (@helper::checkaddons('currency_settigns'))
                @if (helper::available_currency()->count() > 1)
                    <li
                        class="nav-item mb-2 fs-7 {{ helper::check_menu($role_id, 'role_currency_settings') == 1 ? 'd-block' : 'd-none' }}">
                        <a class="nav-link rounded d-flex {{ request()->is('admin/currency-settings*') ? 'active' : '' }}"
                            aria-current="page" href="{{ URL::to('/admin/currency-settings') }}">
                            <i class="fa-solid fa-dollar-sign"></i>
                            <p class="w-100 d-flex justify-content-between">
                                <span class="nav-text ">{{ trans('labels.currency-settings') }}</span>
                            </p>
                        </a>
                    </li>
                @endif
            @endif
        @endif
        @if (Auth::user()->type == 1 || (Auth::user()->type == 4 && Auth::user()->vendor_id == 1))
            @if (@helper::checkaddons('language'))
                <li
                    class="nav-item mb-2 fs-7 {{ helper::check_menu($role_id, 'role_language_settings') == 1 ? 'd-block' : 'd-none' }}">
                    <a class="nav-link rounded d-flex {{ request()->is('admin/language-settings*') ? 'active' : '' }}"
                        aria-current="page" href="{{ URL::to('/admin/language-settings') }}">
                        <i class="fa-solid fa-language"></i>
                        <p class="w-100 d-flex justify-content-between">
                            <span class="nav-text ">{{ trans('labels.language-settings') }}</span>
                        </p>
                    </a>
                </li>
            @endif
            <li
                class="nav-item mb-2 fs-7 dropdown multimenu {{ helper::check_menu($role_id, 'role_currency_settings') == 1 ? 'd-block' : 'd-none' }}">
                <a class="nav-link collapsed rounded d-flex align-items-center justify-content-between dropdown-toggle mb-1"
                    href="#currency_setting" data-bs-toggle="collapse" role="button" aria-expanded="false"
                    aria-controls="currency_setting">
                    <span class="d-flex"><i class="fa-solid  fa-dollar-sign"></i><span
                            class="multimenu-title">{{ trans('labels.currency-settings') }}</span></span>
                </a>
                <ul class="collapse" id="currency_setting">
                    @if (@helper::checkaddons('currency_settigns'))
                        <li class="nav-item ps-4 mb-1">
                            <a class="nav-link rounded {{ request()->is('admin/currencys*') ? 'active' : '' }}"
                                aria-current="page" href="{{ URL::to('/admin/currencys') }}">
                                <span class="d-flex align-items-center multimenu-menu-indicator"><i
                                        class="fa-solid fa-circle-small"></i>{{ trans('labels.currency') }}</span>
                            </a>
                        </li>
                    @endif
                    <li class="nav-item ps-4 mb-1">
                        <a class="nav-link rounded {{ request()->is('admin/currency-settings*') ? 'active' : '' }}"
                            aria-current="page" href="{{ URL::to('/admin/currency-settings') }}">
                            <span class="d-flex align-items-center multimenu-menu-indicator"><i
                                    class="fa-solid fa-circle-small"></i>{{ trans('labels.currency-settings') }}</span>
                        </a>
                    </li>

                </ul>
            </li>
        @endif
        <li
            class="nav-item mb-2 fs-7 {{ helper::check_menu($role_id, 'role_general_settings') == 1 ? 'd-block' : 'd-none' }}">
            <a class="nav-link d-flex rounded {{ request()->is('admin/settings') ? 'active' : '' }}"
                aria-current="page" href="{{ URL::to('/admin/settings') }}">
                <i class="fa-solid fa-gear"></i>
                <span>{{ trans('labels.setting') }}</span>
            </a>
        </li>
    </ul>
@endif
