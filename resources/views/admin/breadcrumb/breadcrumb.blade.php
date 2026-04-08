<div
    class="d-flex justify-content-between align-items-center flex-wrap {{ str_contains(request()->url(), 'add') || str_contains(request()->url(), 'edit') ? 'mb-3' : '' }} ">
    @if (str_contains(request()->url(), 'add'))
        <h5 class="text-capitalize fs-4 fw-600 color-changer">{{ trans('labels.add_new') }}</h5>
    @endif
    @if (str_contains(request()->url(), 'edit'))
        <h5 class="text-capitalize fs-4 fw-600 color-changer">{{ trans('labels.edit') }}</h5>
    @endif
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb m-0">
            @if (request()->is('admin/users'))
                <li class="breadcrumb-item">
                    <h5 class="text-capitalize fs-4 fw-600 color-changer">{{ trans('labels.vendors') }}</h5>
                </li>
            @elseif (request()->is('admin/users/add') || str_contains(request()->url(), 'admin/users/edit'))
                <li class="breadcrumb-item">
                    <a href="{{ URL::to('/admin/users') }}" class="color-changer">
                        {{ trans('labels.vendors') }}
                    </a>
                </li>
            @endif
            @if (request()->is('admin/plan'))
                <li class="breadcrumb-item">
                    <h5 class="text-capitalize fw-600 fs-4 color-changer">{{ trans('labels.pricing_plan') }}</h5>
                </li>
            @elseif(request()->is('admin/plan/add') || str_contains(request()->url(), 'admin/plan/edit'))
                <li class="breadcrumb-item">
                    <a href="{{ URL::to('/admin/plan') }}" class="color-changer">{{ trans('labels.pricing_plan') }} </a>
                </li>
            @endif
            @if (request()->is('admin/payment'))
                <li class="breadcrumb-item">
                    <h5 class="text-capitalize fw-600 fs-4 color-changer">{{ trans('labels.payment') }}</h5>
                </li>
            @endif
            @if (request()->is('admin/transaction'))
                <li class="breadcrumb-item">
                    <h5 class="text-capitalize fw-600 fs-4 color-changer">{{ trans('labels.transactions') }}<h5>
                </li>
            @endif
            @if (request()->is('admin/payout'))
                <li class="breadcrumb-item">
                    <h5 class="text-capitalize fw-600 fs-4 color-changer">{{ trans('labels.payout') }}<h5>
                </li>
            @endif
            @if (request()->is('admin/settings'))
                <li class="breadcrumb-item">
                    <h5 class="text-capitalize fw-600 fs-4 color-changer">{{ trans('labels.setting') }}</h5>
                </li>
            @endif
            @if (request()->is('admin/basic_settings'))
                <li class="breadcrumb-item">
                    <h5 class="text-capitalize fw-600 fs-4 color-changer">{{ trans('labels.basic_settings') }}</h5>
                </li>
            @endif
            @if (request()->is('admin/whatsapp_settings'))
                <li class="breadcrumb-item">
                    <h5 class="text-capitalize fw-600 fs-4 color-changer">{{ trans('labels.whatsapp_settings') }}</h5>
                </li>
            @endif
            @if (request()->is('admin/telegram_settings'))
                <li class="breadcrumb-item">
                    <h5 class="text-capitalize fw-600 fs-4 color-changer">{{ trans('labels.telegram_settings') }}</h5>
                </li>
            @endif
            @if (request()->is('admin/pos'))
                <li class="breadcrumb-item">
                    <h5 class="text-capitalize fw-600 fs-4 color-changer">{{ trans('labels.pos') }}</h5>
                </li>
            @endif
            @if (request()->is('admin/categories'))
                <li class="breadcrumb-item">
                    <h5 class="text-capitalize fw-600 fs-4 color-changer">{{ trans('labels.categories') }}</h5>
                </li>
            @elseif(request()->is('admin/categories/add') || str_contains(request()->url(), 'admin/categories/edit'))
                <li class="breadcrumb-item">
                    <a href="{{ URL::to('/admin/categories') }}"
                        class="color-changer">{{ trans('labels.categories') }}</a>
                </li>
            @endif
            @if (request()->is('admin/product-category'))
                <li class="breadcrumb-item">
                    <h5 class="text-capitalize fw-600 fs-4 color-changer">{{ trans('labels.categories') }}</h5>
                </li>
            @elseif(request()->is('admin/product-category/add') || str_contains(request()->url(), 'admin/product-category/edit'))
                <li class="breadcrumb-item">
                    <a href="{{ URL::to('/admin/product-category') }}"
                        class="color-changer">{{ trans('labels.categories') }}</a>
                </li>
            @endif
            @if (request()->is('admin/services'))
                <li class="breadcrumb-item">
                    <h5 class="text-capitalize fw-600 fs-4 color-changer">{{ trans('labels.services') }}</h5>
                </li>
            @elseif(request()->is('admin/services/add') || str_contains(request()->url(), 'admin/services/edit'))
                <li class="breadcrumb-item">
                    <a href="{{ URL::to('/admin/services') }}"
                        class="color-changer">{{ trans('labels.services') }}</a>
                </li>
            @endif
            @if (request()->is('admin/products'))
                <li class="breadcrumb-item">
                    <h5 class="text-capitalize fw-600 fs-4 color-changer">{{ trans('labels.product_s') }}</h5>
                </li>
            @elseif(request()->is('admin/products/add') || str_contains(request()->url(), 'admin/products/edit'))
                <li class="breadcrumb-item">
                    <a href="{{ URL::to('/admin/products') }}"
                        class="color-changer">{{ trans('labels.product_s') }}</a>
                </li>
            @endif
            
            @if (request()->is('admin/workinghours*'))
                <li class="breadcrumb-item">
                    <h5 class="text-capitalize fw-600 fs-4 color-changer">{{ trans('labels.workinghours') }}</h5>
                </li>
            @endif
            @if (request()->is('admin/theme_settings*'))
                <li class="breadcrumb-item">
                    <h5 class="text-capitalize fw-600 fs-4 color-changer">{{ trans('labels.theme_settings') }}</h5>
                </li>
            @endif
            @if (request()->is('admin/mobile_section'))
                <li class="breadcrumb-item">
                    <h5 class="text-capitalize fw-600 fs-4 color-changer">{{ trans('labels.mobile_section') }}</h5>
                </li>
            @endif
            @if (request()->is('admin/faqs'))
                <li class="breadcrumb-item">
                    <h5 class="text-capitalize fw-600 fs-4 color-changer">{{ trans('labels.faqs') }}</h5>
                </li>
            @elseif(request()->is('admin/faqs/add') || str_contains(request()->url(), 'admin/faqs/edit'))
                <li class="breadcrumb-item">
                    <a href="{{ URL::to('/admin/faqs') }}" class="color-changer">{{ trans('labels.faqs') }}</a>
                </li>
            @endif
            @if (request()->is('admin/features'))
                <li class="breadcrumb-item">
                    <h5 class="text-capitalize fw-600 fs-4 color-changer">{{ trans('labels.features') }}</h5>
                </li>
            @elseif(request()->is('admin/features/add') || str_contains(request()->url(), 'admin/features/edit'))
                <li class="breadcrumb-item">
                    <a href="{{ URL::to('/admin/features') }}"
                        class="color-changer">{{ trans('labels.features') }}</a>
                </li>
            @endif
            @if (request()->is('admin/roles'))
                <li class="breadcrumb-item">
                    <h5 class="text-capitalize fw-600 fs-4 color-changer">{{ trans('labels.roles') }}</h5>
                </li>
            @elseif(request()->is('admin/roles/add') || str_contains(request()->url(), 'admin/roles/edit'))
                <li class="breadcrumb-item">
                    <a href="{{ URL::to('/admin/roles') }}" class="color-changer">{{ trans('labels.roles') }}</a>
                </li>
            @endif
            @if (request()->is('admin/employees'))
                <li class="breadcrumb-item">
                    <h5 class="text-capitalize fw-600 fs-4 color-changer">{{ trans('labels.employees') }}</h5>
                </li>
            @elseif(request()->is('admin/employees/add') || str_contains(request()->url(), 'admin/employees/edit'))
                <li class="breadcrumb-item">
                    <a href="{{ URL::to('/admin/employees') }}"
                        class="color-changer">{{ trans('labels.employees') }}</a>
                </li>
            @endif
            @if (request()->is('admin/custom_status'))
                <li class="breadcrumb-item">
                    <h5 class="text-capitalize fw-600 fs-4 color-changer">{{ trans('labels.custom_status') }}</h5>
                </li>
            @elseif(request()->is('admin/custom_status/add') || str_contains(request()->url(), 'admin/custom_status/edit'))
                <li class="breadcrumb-item">
                    <a href="{{ URL::to('/admin/custom_status') }}"
                        class="color-changer">{{ trans('labels.custom_status') }}</a>
                </li>
            @endif
            @if (request()->is('admin/tax'))
                <li class="breadcrumb-item">
                    <h5 class="text-capitalize fw-600 fs-4 color-changer">{{ trans('labels.tax') }}</h5>
                </li>
            @elseif(request()->is('admin/tax/add') || str_contains(request()->url(), 'admin/tax/edit'))
                <li class="breadcrumb-item">
                    <a href="{{ URL::to('/admin/tax') }}" class="color-changer">{{ trans('labels.tax') }}</a>
                </li>
            @endif
            @if (request()->is('admin/promotionalbanners'))
                <li class="breadcrumb-item">
                    <h5 class="text-capitalize fw-600 fs-4 color-changer">{{ trans('labels.promotional_banners') }}
                    </h5>
                </li>
            @elseif(request()->is('admin/promotionalbanners/add') || str_contains(request()->url(), 'admin/promotionalbanners/edit'))
                <li class="breadcrumb-item">
                    <a href="{{ URL::to('/admin/promotionalbanners') }}"
                        class="color-changer">{{ trans('labels.promotional_banners') }}</a>
                </li>
            @endif
            @if (request()->is('admin/testimonials'))
                <li class="breadcrumb-item">
                    <h5 class="text-capitalize fw-600 fs-4 color-changer">{{ trans('labels.testimonials') }}</h5>
                </li>
            @elseif(request()->is('admin/testimonials/add') || str_contains(request()->url(), 'admin/testimonials/edit'))
                <li class="breadcrumb-item">
                    <a href="{{ URL::to('/admin/testimonials') }}"
                        class="color-changer">{{ trans('labels.testimonials') }}</a>
                </li>
            @endif
            @if (request()->is('admin/cities'))
                <li class="breadcrumb-item">
                    <h5 class="text-capitalize fw-600 fs-4 color-changer">{{ trans('labels.cities') }}</h5>
                </li>
            @elseif(request()->is('admin/cities/add') || str_contains(request()->url(), 'admin/cities/edit'))
                <li class="breadcrumb-item">
                    <a href="{{ URL::to('/admin/cities') }}" class="color-changer">{{ trans('labels.cities') }}</a>
                </li>
            @endif
            @if (request()->is('admin/countries'))
                <li class="breadcrumb-item">
                    <h5 class="text-capitalize fw-600 fs-4 color-changer">{{ trans('labels.countries') }}</h5>
                </li>
            @elseif(request()->is('admin/countries/add') || str_contains(request()->url(), 'admin/countries/edit'))
                <li class="breadcrumb-item">
                    <a href="{{ URL::to('/admin/countries') }}"
                        class="color-changer">{{ trans('labels.countries') }}</a>
                </li>
            @endif
            @if (request()->is('admin/promocode'))
                <li class="breadcrumb-item">
                    <h5 class="text-capitalize fw-600 fs-4 color-changer">{{ trans('labels.coupons') }}</h5>
                </li>
            @elseif(request()->is('admin/promocode/add') || str_contains(request()->url(), 'admin/promocode/edit'))
                <li class="breadcrumb-item">
                    <a href="{{ URL::to('/admin/promocode') }}"
                        class="color-changer">{{ trans('labels.coupons') }}</a>
                </li>
            @endif
            @php
                $url = '';
            @endphp
            @if (request()->is('admin/bannersection-1') ||
                    request()->is('admin/bannersection-2') ||
                    request()->is('admin/bannersection-3'))
                <li class="breadcrumb-item">
                    <h5 class="text-capitalize fw-600 fs-4 color-changer">{{ @$title }}</h5>
                </li>
            @elseif(
                (str_contains(request()->url(), 'add') || str_contains(request()->url(), 'edit')) &&
                    str_contains(request()->url(), 'bannersection'))
                <li class="breadcrumb-item"><a href="{{ $table_url }}"
                        class="color-changer">{{ @$title }}</a></li>
            @endif
            @if (request()->is('admin/blogs'))
                <li class="breadcrumb-item">
                    <h5 class="text-capitalize fw-600 fs-4 color-changer">{{ trans('labels.blogs') }}</h5>
                </li>
            @elseif(request()->is('admin/blogs/add') || str_contains(request()->url(), 'admin/blogs/edit'))
                <li class="breadcrumb-item">
                    <a href="{{ URL::to('/admin/blogs') }}" class="color-changer">{{ trans('labels.blogs') }}</a>
                </li>
            @endif
            @if (request()->is('admin/gallery'))
                <li class="breadcrumb-item">
                    <h5 class="text-capitalize fw-600 fs-4 color-changer">{{ trans('labels.gallery') }}</h5>
                </li>
            @elseif(request()->is('admin/gallery/add') || str_contains(request()->url(), 'admin/gallery/edit'))
                <li class="breadcrumb-item">
                    <a href="{{ URL::to('/admin/gallery') }}"
                        class="color-changer">{{ trans('labels.gallery') }}</a>
                </li>
            @endif
            @if (request()->is('admin/choose_us'))
                <li class="breadcrumb-item">
                    <h5 class="text-capitalize fw-600 fs-4 color-changer">{{ trans('labels.choose_us') }}</h5>
                </li>
            @elseif(request()->is('admin/choose_us/add') || str_contains(request()->url(), 'admin/choose_us/edit'))
                <li class="breadcrumb-item">
                    <a href="{{ URL::to('/admin/choose_us') }}"
                        class="color-changer">{{ trans('labels.choose_us') }}</a>
                </li>
            @endif
            @if (request()->is('admin/subscription_settings'))
                <li class="breadcrumb-item">
                    <h5 class="text-capitalize fw-600 fs-4 color-changer">{{ trans('labels.subscription_settings') }}
                    </h5>
                </li>
            @endif
            @if (request()->is('admin/bookings'))
                <li class="breadcrumb-item">
                    <a href="{{ URL::to('/admin/bookings') }}">
                        <h5 class="text-capitalize fw-600 fs-4 color-changer">{{ trans('labels.bookings') }}</h5>
                    </a>
                </li>
            @endif
            @if (request()->is('admin/orders'))
                <li class="breadcrumb-item">
                    <a href="{{ URL::to('/admin/orders') }}">
                        <h5 class="text-capitalize fw-600 fs-4 color-changer">{{ trans('labels.order_s') }}</h5>
                    </a>
                </li>
            @endif
           
            @if (request()->is('admin/currency-settings'))
                <li class="breadcrumb-item">
                    <h5 class="text-capitalize fw-600 fs-4 color-changer">{{ trans('labels.currency-settings') }}</h5>
                </li>
            @elseif(request()->is('admin/currency-settings/add') ||
                    str_contains(request()->url(), 'admin/currency-settings/currency/edit'))
                <li class="breadcrumb-item">
                    <a href="{{ URL::to('/admin/currency-settings') }}"
                        class="color-changer">{{ trans('labels.currency-settings') }}</a>
                </li>
            @endif
            @if (request()->is('admin/currencys'))
                <li class="breadcrumb-item">
                    <h5 class="text-capitalize fw-600 fs-4 color-changer">{{ trans('labels.currency') }}</h5>
                </li>
            @elseif(request()->is('admin/currencys/currency_add') ||
                    str_contains(request()->url(), 'admin/currencys/currency_edit'))
                <li class="breadcrumb-item">
                    <a href="{{ URL::to('/admin/currency_add') }}"
                        class="color-changer">{{ trans('labels.currency') }}</a>
                </li>
            @endif
            @if (request()->is('admin/reports*'))
                <li class="breadcrumb-item">
                    <h5 class="text-capitalize fw-600 fs-4 color-changer">{{ trans('labels.reports') }}</h5>
                </li>
            @endif
            @if (request()->is('admin/orderreports*'))
                <li class="breadcrumb-item">
                    <h5 class="text-capitalize fw-600 fs-4 color-changer">{{ trans('labels.reports') }}</h5>
                </li>
            @endif
            @if (request()->is('admin/privacypolicy'))
                <li class="breadcrumb-item">
                    <h5 class="text-capitalize fw-600 fs-4 color-changer">{{ trans('labels.privacy_policy') }}</h5>
                </li>
            @endif
            @if (request()->is('admin/termscondition'))
                <li class="breadcrumb-item">
                    <h5 class="text-capitalize fw-600 fs-4 color-changer">{{ trans('labels.terms_condition') }}</h5>
                </li>
            @endif
            @if (request()->is('admin/aboutus'))
                <li class="breadcrumb-item">
                    <h5 class="text-capitalize fw-600 fs-4 color-changer">{{ trans('labels.about_us') }}</h5>
                </li>
            @endif
            @if (request()->is('admin/custom_domain'))
                <li class="breadcrumb-item">
                    <h5 class="text-capitalize fw-600 fs-4 color-changer">{{ trans('labels.custom_domain') }}</h5>
                </li>
            @elseif(request()->is('admin/custom_domain/add') || str_contains(request()->url(), 'admin/custom_domain/edit'))
                <li class="breadcrumb-item">
                    <a href="{{ URL::to('/admin/custom_domain') }}"
                        class="color-changer">{{ trans('labels.custom_domain') }}</a>
                </li>
            @endif
            @if (request()->is('admin/store_categories'))
                <li class="breadcrumb-item">
                    <h5 class="text-capitalize fw-600 fs-4 color-changer">{{ trans('labels.store_categories') }}</h5>
                </li>
            @elseif(request()->is('admin/store_categories/add') || str_contains(request()->url(), 'admin/store_categories/edit'))
                <li class="breadcrumb-item">
                    <a href="{{ URL::to('/admin/store_categories') }}"
                        class="color-changer">{{ trans('labels.store_categories') }}</a>
                </li>
            @endif
            @if (request()->is('admin/shipping'))
                <li class="breadcrumb-item">
                    <h5 class="text-capitalize fw-600 fs-4 color-changer">{{ trans('labels.shipping_management') }}
                    </h5>
                </li>
            @elseif(request()->is('admin/shipping/add') || str_contains(request()->url(), 'admin/shipping/edit'))
                <li class="breadcrumb-item">
                    <a href="{{ URL::to('/admin/shipping') }}"
                        class="color-changer">{{ trans('labels.shipping_management') }}</a>
                </li>
            @endif
            @if (request()->is('admin/how_it_works'))
                <li class="breadcrumb-item">
                    <h5 class="text-capitalize fw-600 fs-4 color-changer">{{ trans('labels.how_it_works') }}</h5>
                </li>
            @elseif(request()->is('admin/how_it_works/add') || str_contains(request()->url(), 'admin/how_it_works/edit'))
                <li class="breadcrumb-item">
                    <a href="{{ URL::to('/admin/how_it_works') }}"
                        class="color-changer">{{ trans('labels.how_it_works') }}</a>
                </li>
            @endif
            @if (request()->is('admin/themes'))
                <li class="breadcrumb-item">
                    <h5 class="text-capitalize fw-600 fs-4 color-changer">{{ trans('labels.theme_images') }}</h5>
                </li>
            @elseif(request()->is('admin/themes/add') || str_contains(request()->url(), 'admin/themes/edit'))
                <li class="breadcrumb-item">
                    <a href="{{ URL::to('/admin/themes') }}"
                        class="color-changer">{{ trans('labels.theme_images') }}</a>
                </li>
            @endif
            @if (request()->is('admin/customers'))
                <li class="breadcrumb-item">
                    <h5 class="text-capitalize fw-600 fs-4 color-changer">{{ trans('labels.customers') }}</h5>
                </li>
            @elseif(request()->is('admin/customers/add') || str_contains(request()->url(), 'admin/customers/edit'))
                <li class="breadcrumb-item">
                    <a href="{{ URL::to('/admin/customers') }}"
                        class="color-changer">{{ trans('labels.customers') }}</a>
                </li>
            @endif
            @if (request()->is('admin/apps'))
                <li class="breadcrumb-item">
                    <h5 class="text-capitalize fw-600 fs-4 color-changer">{{ trans('labels.addons_manager') }}</h5>
                </li>
            @elseif (request()->is('admin/apps/add'))
                <li class="breadcrumb-item">
                    <a href="{{ URL::to('/admin/apps') }}"
                        class="color-changer">{{ trans('labels.addons_manager') }}</a>
                </li>
            @endif
            @if (request()->is('admin/calendar/add'))
                <li class="breadcrumb-item">
                    <a href="{{ URL::to('/admin/calendar') }}"
                        class="color-changer">{{ trans('labels.calendar') }}</a>
                </li>
            @endif
            @if (str_contains(request()->url(), 'add'))
                <li
                    class="breadcrumb-item active color-changer {{ session()->get('direction') == 2 ? 'breadcrumb-rtl' : '' }}">
                    {{ trans('labels.add') }}</li>
            @endif
            @if (str_contains(request()->url(), 'edit'))
                <li
                    class="breadcrumb-item active color-changer {{ session()->get('direction') == 2 ? 'breadcrumb-rtl' : '' }}">
                    {{ trans('labels.edit') }}</li>
            @endif
            @if (str_contains(request()->url(), 'selectplan'))
                <li class="breadcrumb-item active color-changer">{{ trans('labels.buy_now') }}</li>
            @endif

            @if (str_contains(request()->url(), 'invoice'))
                <h5 class="text-capitalize fw-600 fs-4">
                    <li class="breadcrumb-item active text-dark color-changer">{{ trans('labels.invoice') }}</li>
                </h5>
            @endif

        </ol>
    </nav>

    @if (request()->is('admin/apps'))
        <a href="{{ URL::to('admin/apps/add') }}" class="btn btn-secondary px-sm-4 d-flex">
            <i class="fa-regular fa-plus mx-1"></i>{{ trans('labels.install_update_addons') }}</a>
    @endif
    @if (Auth::user()->type == 2 || (Auth::user()->type == 4 && Auth::user()->vendor_id != 1))
        @if (request()->is('admin/custom_domain'))
            <a href="{{ URL::to('admin/custom_domain/add') }}"
                class="btn btn-secondary px-sm-4 mt-2 mt-sm-0 col-sm-auto col-12 {{ Auth::user()->type == 4 ? (helper::check_access($module, Auth::user()->role_id, Auth::user()->vendor_id, 'add') == 1 ? '' : 'd-none') : '' }}">{{ trans('labels.request_custom_domain') }}</a>
        @endif
    @endif
    @if (request()->is('admin/transaction'))
        <form action="{{ URL::to('/admin/transaction') }} " method="get">
            <div class="row">
                <div class="col-12">
                    <div class="input-group gap-2 ps-0 justify-content-end">
                        @if (Auth::user()->type == 1 || (Auth::user()->type == 4 && Auth::user()->vendor_id == 1))
                            <select class="form-select transaction-select" name="vendor">
                                <option value=""
                                    data-value="{{ URL::to('/admin/transaction?vendor=' . '&startdate=' . request()->get('startdate') . '&enddate=' . request()->get('enddate')) }}"
                                    selected>{{ trans('labels.select') }}</option>
                                @foreach ($vendors as $vendor)
                                    <option value="{{ $vendor->id }}"
                                        data-value="{{ URL::to('/admin/transaction?vendor=' . $vendor->id . '&startdate=' . request()->get('startdate') . '&enddate=' . request()->get('enddate')) }}"
                                        {{ request()->get('vendor') == $vendor->id ? 'selected' : '' }}>
                                        {{ $vendor->name }}</option>
                                @endforeach
                            </select>
                        @endif
                        <div class="input-group-append col-sm-auto col-12">
                            <input type="date" class="form-control rounded p-2" name="startdate"
                                value="{{ request()->get('startdate') }}">
                        </div>
                        <div class="input-group-append col-sm-auto col-12">
                            <input type="date" class="form-control rounded p-2" name="enddate"
                                value="{{ request()->get('enddate') }}">
                        </div>
                        <div class="input-group-append col-sm-auto col-12">
                            <button class="btn btn-primary w-100 rounded"
                                type="submit">{{ trans('labels.fetch') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    @endif
    @if (request()->is('admin/reports') || request()->is('admin/orderreports'))
        @if (request()->is('admin/orderreports'))
            <form action="{{ URL::to('/admin/orderreports') }}">
            @else
                <form action="{{ URL::to('/admin/reports') }}">
        @endif
        <div class="input-group gap-2 col-md-12 ps-0">
            @if (@helper::checkaddons('customer_login'))
                @if ($getcustomerslist->count() > 0)
                    <div
                        class="input-group-append col-auto px-1 {{ Auth::user()->type == 4 ? (helper::check_menu(Auth::user()->role_id, 'role_customers') == 1 ? '' : 'd-none') : '' }}">
                        <select name="customer_id" class="form-select rounded">
                            <option value="">{{ trans('labels.select_customer') }}</option>
                            @foreach ($getcustomerslist as $getcustomer)
                                <option value="{{ $getcustomer->id }}"
                                    {{ $getcustomer->id == @$_GET['customer_id'] ? 'selected' : '' }}>
                                    {{ $getcustomer->name }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif
            @endif
            <div class="input-group-append col-sm-auto col-12">
                <input type="date" class="form-control rounded p-2" name="startdate"
                    value="{{ request()->get('startdate') }}" required="">
            </div>

            <div class="input-group-append col-sm-auto col-12">
                <input type="date" class="form-control rounded p-2" name="enddate"
                    value="{{ request()->get('enddate') }}" required="">
            </div>
            <div class="input-group-append col-sm-auto col-12">
                <button class="btn btn-primary px-sm-4 rounded w-100"
                    type="submit">{{ trans('labels.fetch') }}</button>
            </div>
        </div>
        </form>
    @endif
    @if (str_contains(request()->url(), 'add') ||
            str_contains(request()->url(), 'edit') ||
            request()->is('admin/payment') ||
            request()->is('admin/transaction') ||
            request()->is('admin/payout') ||
            request()->is('admin/settings') ||
            request()->is('admin/whatsapp_settings') ||
            request()->is('admin/telegram_settings') ||
            request()->is('admin/workinghours*') ||
            request()->is('admin/bookings*') ||
            request()->is('admin/orders*') ||
            request()->is('admin/reports*') ||
            request()->is('admin/orderreports*') ||
            request()->is('admin/privacypolicy') ||
            request()->is('admin/termscondition') ||
            request()->is('admin/aboutus') ||
            request()->is('admin/custom_domain') ||
            str_contains(request()->url(), 'invoice') ||
            request()->is('admin/apps') ||
            request()->is('admin/theme_settings') ||
            request()->is('admin/mobile_section') ||
            request()->is('admin/choose_us') ||
            request()->is('admin/shipping') ||
            request()->is('admin/basic_settings') ||
            request()->is('admin/pos') ||
            (request()->is('admin/plan*') &&
                (Auth::user()->type == 2 || (Auth::user()->type == 4 && Auth::user()->vendor_id != 1))))
        <a href="{{ URL::to(request()->url() . '/add') }}" class="btn btn-secondary px-sm-4 d-none">
            <i class="fa-regular fa-plus mx-1"></i>{{ trans('labels.add') }}</a>
    @else
        @if (request()->is('admin/services'))
            <div class="d-flex">
                <div class="d-flex align-items-center" style="gap: 10px;">
                    <!-- Bulk Delete Button -->
                    @if (@helper::checkaddons('bulk_delete'))
                        <button id="bulkDeleteBtn"
                            @if (env('Environment')=='sendbox' ) onclick="myFunction()" @else onclick="deleteSelected('{{ URL::to(request()->url(). '/bulk_delete') }}')" @endif class="btn btn-danger hov btn-sm d-none d-flex" tooltip="{{ trans('labels.delete') }}">
                            <i class="fa-regular fa-trash"></i>
                        </button>
                    @endif
                    <a href="{{ URL::to(request()->url() . '/add') }}"
                        class="btn btn-secondary px-sm-4 d-flex {{ Auth::user()->type == 4 ? (helper::check_access($module, Auth::user()->role_id, Auth::user()->vendor_id, 'add') == 1 ? '' : 'd-none') : '' }}">
                        <i class="fa-regular fa-plus mx-1"></i>{{ trans('labels.add') }}</a>
                </div>
                @if (@helper::checkaddons('service_import'))
                    @if ($service->count() > 0)
                        <a href="{{ URL::to('/admin/services/exportservices') }}"
                            class="btn btn-secondary px-sm-4 d-flex {{ Auth::user()->type == 4 ? (helper::check_access('role_services', Auth::user()->role_id, $vendor_id, 'add') == 1 ? '' : 'd-none') : '' }} mx-2">{{ trans('labels.export') }}</a>
                    @endif
                @endif
            </div>
        @elseif (request()->is('admin/products'))
            <div class="d-flex">
                <div class="d-flex align-items-center" style="gap: 10px;">
                    <!-- Bulk Delete Button -->
                    @if (@helper::checkaddons('bulk_delete'))
                        <button id="bulkDeleteBtn"
                            @if (env('Environment')=='sendbox' ) onclick="myFunction()" @else onclick="deleteSelected('{{ URL::to(request()->url(). '/bulk_delete') }}')" @endif class="btn btn-danger hov btn-sm d-none d-flex" tooltip="{{ trans('labels.delete') }}">
                            <i class="fa-regular fa-trash"></i>
                        </button>
                    @endif
                    <a href="{{ URL::to(request()->url() . '/add') }}"
                        class="btn btn-secondary px-sm-4 d-flex {{ Auth::user()->type == 4 ? (helper::check_access($module, Auth::user()->role_id, Auth::user()->vendor_id, 'add') == 1 ? '' : 'd-none') : '' }}">
                        <i class="fa-regular fa-plus mx-1"></i>{{ trans('labels.add') }}</a>
                </div>
                @if (@helper::checkaddons('product_import'))
                    @if ($product->count() > 0)
                        <a href="{{ URL::to('/admin/products/exportproducts') }}"
                            class="btn btn-secondary px-sm-4 d-flex {{ Auth::user()->type == 4 ? (helper::check_access('role_products', Auth::user()->role_id, $vendor_id, 'add') == 1 ? '' : 'd-none') : '' }} mx-2">{{ trans('labels.export') }}</a>
                    @endif
                @endif
            </div>
        @elseif (request()->is('admin/customers'))
            @if (Auth::user()->type == 2 || (Auth::user()->type == 4 && Auth::user()->vendor_id != 1))
                 <div class="d-flex align-items-center" style="gap: 10px;">
                    <!-- Bulk Delete Button -->
                    @if (@helper::checkaddons('bulk_delete'))
                        <button id="bulkDeleteBtn"
                            @if (env('Environment')=='sendbox' ) onclick="myFunction()" @else onclick="deleteSelected('{{ URL::to(request()->url(). '/bulk_delete') }}')" @endif class="btn btn-danger hov btn-sm d-none d-flex" tooltip="{{ trans('labels.delete') }}">
                        <i class="fa-regular fa-trash"></i>
                        </button>
                    @endif
                    <a href="{{ URL::to(request()->url() . '/add') }}"
                        class="btn btn-secondary px-sm-4 d-flex {{ Auth::user()->type == 4 ? (helper::check_access($module, Auth::user()->role_id, Auth::user()->vendor_id, 'add') == 1 ? '' : 'd-none') : '' }}">
                        <i class="fa-regular fa-plus mx-1"></i>{{ trans('labels.add') }}</a>
                 </div>
            @endif
        @elseif (request()->is('admin/currency-settings'))
            @if (helper::checkaddons('currency_settigns'))
                @if (Auth::user()->type == 1 || (Auth::user()->type == 4 && Auth::user()->vendor_id == 1))
                    <div class="d-flex align-items-center" style="gap: 10px;">
                        <!-- Bulk Delete Button -->
                        @if (@helper::checkaddons('bulk_delete'))
                            <button id="bulkDeleteBtn"
                                @if (env('Environment')=='sendbox' ) onclick="myFunction()" @else onclick="deleteSelected('{{ URL::to(request()->url(). '/bulk_delete') }}')" @endif class="btn btn-danger hov btn-sm d-none d-flex" tooltip="{{ trans('labels.delete') }}">
                                <i class="fa-regular fa-trash"></i>
                            </button>
                        @endif
                        <a href="{{ URL::to(request()->url() . '/add') }}"
                            class="btn btn-secondary px-sm-4 d-flex {{ Auth::user()->type == 4 ? (helper::check_access($module, Auth::user()->role_id, Auth::user()->vendor_id, 'add') == 1 ? '' : 'd-none') : '' }}">
                            <i class="fa-regular fa-plus mx-1"></i>{{ trans('labels.add') }}</a>
                    </div>
                @endif
            @endif
        @elseif (request()->is('admin/currencys'))
            @if (helper::checkaddons('currency_settigns'))
                @if (Auth::user()->type == 1 || (Auth::user()->type == 4 && Auth::user()->vendor_id == 1))
                    <div class="d-flex align-items-center" style="gap: 10px;">
                        <!-- Bulk Delete Button -->
                        @if (@helper::checkaddons('bulk_delete'))
                            <button id="bulkDeleteBtn"
                                @if (env('Environment')=='sendbox' ) onclick="myFunction()" @else onclick="deleteSelected('{{ URL::to(request()->url(). '/bulk_delete') }}')" @endif class="btn btn-danger hov btn-sm d-none d-flex" tooltip="{{ trans('labels.delete') }}">
                                <i class="fa-regular fa-trash"></i>
                            </button>
                        @endif
                        <a href="{{ URL::to(request()->url() . '/currency_add') }}"
                            class="btn btn-secondary px-sm-4 d-flex {{ Auth::user()->type == 4 ? (helper::check_access($module, Auth::user()->role_id, Auth::user()->vendor_id, 'add') == 1 ? '' : 'd-none') : '' }}">
                            <i class="fa-regular fa-plus mx-1"></i>{{ trans('labels.add') }}</a>
                    </div>
                @endif
            @endif
        @else
         <div class="d-flex align-items-center" style="gap: 10px;">
            <!-- Bulk Delete Button -->
            @if (@helper::checkaddons('bulk_delete'))
                <button id="bulkDeleteBtn"
                    @if (env('Environment')=='sendbox' ) onclick="myFunction()" @else onclick="deleteSelected('{{ URL::to(request()->url(). '/bulk_delete') }}')" @endif class="btn btn-danger hov btn-sm d-none d-flex" tooltip="{{ trans('labels.delete') }}">
                    <i class="fa-regular fa-trash"></i>
                </button>
            @endif

            <a href="{{ URL::to(request()->url() . '/add') }}"
                class="btn btn-secondary px-sm-4 d-flex {{ Auth::user()->type == 4 ? (helper::check_access($module, Auth::user()->role_id, Auth::user()->vendor_id, 'add') == 1 ? '' : 'd-none') : '' }}">
                <i class="fa-regular fa-plus mx-1"></i>{{ trans('labels.add') }}</a>
         </div>
        @endif
    @endif
</div>
