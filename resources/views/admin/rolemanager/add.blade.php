@extends('admin.layout.default')
@section('content')
    @php
        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        $user = App\Models\User::where('id', $vendor_id)->first();
    @endphp
    @include('admin.breadcrumb.breadcrumb')
    <div class="row">
        <div class="col-12">
            <div class="card border-0 my-3 box-shadow">
                <div class="card-body">
                    <form action="{{ URL::to('admin/roles/save') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="col-form-label" for="">{{ trans('labels.role') }}
                                        <span class="text-danger">*</span> </label>
                                    <input type="text" class="form-control" name="name"
                                        placeholder="{{ trans('labels.role') }}" required>
                                </div>
                            </div>
                        </div>
                        <h5 class="mb-3 fw-bold color-changer">{{ trans('labels.system_modules') }} <span
                                class="text-danger">*</span>
                        </h5>
                        <div class="row bg-light rolmangement_dark">
                            <div class="col-4 cursor-pointer d-block my-3">
                                <input class="form-check-input" type="checkbox" value="" name="checkall"
                                    id="checkall">
                                <label class="form-check-label fs-13 fw-bolder" for="checkall">
                                    {{ trans('labels.modules') }}
                                </label>
                            </div>
                            <div class="col-8 d-block my-3">
                                <label class="form-check-label fs-13 fw-bolder">
                                    {{ trans('labels.permissions') }}
                                </label>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-4 " id="checkboxes">
                                <div class="cursor-pointer d-block mb-3">
                                    <input class="form-check-input" type="checkbox" value="" name="Dashboard"
                                        id="role_dashboard">
                                    <label class="cursor-pointer color-changer fs-13" for="role_dashboard">
                                        {{ trans('labels.dashboards') }}
                                    </label>
                                </div>
                                @if (Auth::user()->type == 1 || (Auth::user()->type == 4 && Auth::user()->vendor_id == 1))
                                    <div class="cursor-pointer d-block mb-3">
                                        <input class="form-check-input" type="checkbox" value="" name="Addon manager"
                                            id="role_addons_manager">
                                        <label class="cursor-pointer color-changer fs-13" for="role_addons_manager">
                                            {{ trans('labels.addons_manager') }}
                                        </label>
                                    </div>
                                    <div class="cursor-pointer d-block mb-3">
                                        <input class="form-check-input" type="checkbox" value="" name="Vendors"
                                            id="role_vendors">
                                        <label class="cursor-pointer color-changer fs-13" for="role_vendors">
                                            {{ trans('labels.vendors') }}
                                        </label>
                                    </div>
                                @endif
                                @if (@helper::checkaddons('customer_login'))
                                    <div class="cursor-pointer d-block mb-3">
                                        <input class="form-check-input" type="checkbox" value="" name="customers"
                                            id="role_customers">
                                        <label class="cursor-pointer color-changer fs-13" for="role_customers">
                                            {{ trans('labels.customers') }}
                                        </label>
                                    </div>
                                @endif
                                @if (Auth::user()->type == 2 || (Auth::user()->type == 4 && Auth::user()->vendor_id != 1))
                                    <div class="cursor-pointer d-block mb-3">
                                        <input class="form-check-input" type="checkbox" value="" name="categories"
                                            id="role_categories">
                                        <label class="cursor-pointer color-changer fs-13" for="role_categories">
                                            {{ trans('labels.categories') }}
                                        </label>
                                    </div>
                                    <div class="cursor-pointer d-block mb-3">
                                        <input class="form-check-input" type="checkbox" value="" name="services"
                                            id="role_services">
                                        <label class="cursor-pointer color-changer fs-13" for="role_services">
                                            {{ trans('labels.services') }}
                                        </label>
                                    </div>
                                    @if (@helper::checkaddons('service_import'))
                                        <div class="cursor-pointer d-block mb-3">
                                            <input class="form-check-input" type="checkbox" value=""
                                                name="bulk_import" id="role_bulk_import">
                                            <label class="cursor-pointer color-changer fs-13" for="role_bulk_import">
                                                {{ trans('labels.product_upload') }}
                                            </label>
                                        </div>
                                    @endif
                                    @if (@helper::checkaddons('question_answer'))
                                        <div class="cursor-pointer d-block mb-3">
                                            <input class="form-check-input" type="checkbox" value=""
                                                name="service_question_answer" id="role_service_question_answer">
                                            <label class="cursor-pointer color-changer fs-13" for="role_service_question_answer">
                                                {{ trans('labels.service_question_answer') }}
                                            </label>
                                        </div>
                                    @endif
                                    <div class="cursor-pointer d-block mb-3">
                                        <input class="form-check-input" type="checkbox" value="" name="Bookings"
                                            id="role_bookings">
                                        <label class="cursor-pointer color-changer fs-13" for="role_bookings">
                                            {{ trans('labels.bookings') }}
                                        </label>
                                    </div>
                                    <div class="cursor-pointer d-block mb-3">
                                        <input class="form-check-input" type="checkbox" value="" name="Reports"
                                            id="role_reports">
                                        <label class="cursor-pointer color-changer fs-13" for="role_reports">
                                            {{ trans('labels.reports') }}
                                        </label>
                                    </div>
                                    @if (@helper::checkaddons('product_shop'))
                                        <div class="cursor-pointer d-block mb-3">
                                            <input class="form-check-input" type="checkbox" value=""
                                                name="products_categories" id="role_products_categories">
                                            <label class="cursor-pointer color-changer fs-13"
                                                for="role_products_categories">
                                                {{ trans('labels.products_categories') }}
                                            </label>
                                        </div>
                                        <div class="cursor-pointer d-block mb-3">
                                            <input class="form-check-input" type="checkbox" value=""
                                                name="products" id="role_products">
                                            <label class="cursor-pointer color-changer fs-13" for="role_products">
                                                {{ trans('labels.product_s') }}
                                            </label>
                                        </div>
                                        @if (@helper::checkaddons('product_import'))
                                            <div class="cursor-pointer d-block mb-3">
                                                <input class="form-check-input" type="checkbox" value=""
                                                    name="products_bulk_import" id="role_products_bulk_import">
                                                <label class="cursor-pointer color-changer fs-13"
                                                    for="role_products_bulk_import">
                                                    {{ trans('labels.product_s_upload') }}
                                                </label>
                                            </div>
                                        @endif
                                        <div class="cursor-pointer d-block mb-3">
                                            <input class="form-check-input" type="checkbox" value=""
                                                name="shipping_management" id="role_shipping_management">
                                            <label class="cursor-pointer color-changer fs-13"
                                                for="role_shipping_management">
                                                {{ trans('labels.shipping_management') }}
                                            </label>
                                        </div>
                                        @if (@helper::checkaddons('question_answer'))
                                            <div class="cursor-pointer d-block mb-3">
                                                <input class="form-check-input" type="checkbox" value=""
                                                    name="product_question_answer" id="role_product_question_answer">
                                                <label class="cursor-pointer color-changer fs-13"
                                                    for="role_product_question_answer">
                                                    {{ trans('labels.product_question_answer') }}
                                                </label>
                                            </div>
                                        @endif
                                        <div class="cursor-pointer d-block mb-3">
                                            <input class="form-check-input" type="checkbox" value=""
                                                name="orders" id="role_orders">
                                            <label class="cursor-pointer color-changer fs-13" for="role_orders">
                                                {{ trans('labels.order_s') }}
                                            </label>
                                        </div>
                                        <div class="cursor-pointer d-block mb-3">
                                            <input class="form-check-input" type="checkbox" value=""
                                                name="order_reports" id="role_order_reports">
                                            <label class="cursor-pointer color-changer fs-13" for="role_order_reports">
                                                {{ trans('labels.order_reports') }}
                                            </label>
                                        </div>
                                    @endif
                                    <div class="cursor-pointer d-block mb-3">
                                        <input class="form-check-input" type="checkbox" value="" name="banners"
                                            id="role_banners">
                                        <label class="cursor-pointer color-changer fs-13" for="role_banners">
                                            {{ trans('labels.banners') }}
                                        </label>
                                    </div>
                                    @if (@helper::checkaddons('subscription'))
                                        @if (@helper::checkaddons('coupon'))
                                            @php
                                                $checkplan = App\Models\Transaction::where('vendor_id', $vendor_id)
                                                    ->orderByDesc('id')
                                                    ->first();
                                                if (@$user->allow_without_subscription == 1) {
                                                    $coupons = 1;
                                                } else {
                                                    $coupons = @$checkplan->coupons;
                                                }
                                            @endphp
                                            @if ($coupons == 1)
                                                <div class="cursor-pointer d-block mb-3">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        name="coupons" id="role_coupons">
                                                    <label class="cursor-pointer color-changer fs-13" for="role_coupons">
                                                        {{ trans('labels.coupons') }}
                                                    </label>
                                                </div>
                                            @endif
                                        @endif
                                    @else
                                        @if (@helper::checkaddons('coupon'))
                                            <div class="cursor-pointer d-block mb-3">
                                                <input class="form-check-input" type="checkbox" value=""
                                                    name="coupons" id="role_coupons">
                                                <label class="cursor-pointer color-changer fs-13" for="role_coupons">
                                                    {{ trans('labels.coupons') }}
                                                </label>
                                            </div>
                                        @endif
                                    @endif
                                    @if (@helper::checkaddons('top_deals'))
                                        <div class="cursor-pointer d-block mb-3">
                                            <input class="form-check-input" type="checkbox" value=""
                                                name="top_deals" id="role_top_deals">
                                            <label class="cursor-pointer color-changer fs-13" for="role_top_deals">
                                                {{ trans('labels.top_deals') }}
                                            </label>
                                        </div>
                                    @endif
                                @endif
                                <div class="cursor-pointer d-block mb-3">
                                    <input class="form-check-input" type="checkbox" value="" name="tax"
                                        id="role_tax">
                                    <label class="cursor-pointer color-changer fs-13" for="role_tax">
                                        {{ trans('labels.tax') }}
                                    </label>
                                </div>
                                @if (@helper::checkaddons('subscription'))
                                    @if ($user->allow_without_subscription != 1)
                                        <div class="cursor-pointer d-block mb-3">
                                            <input class="form-check-input" type="checkbox" value=""
                                                name="pricing_plan" id="role_pricing_plan">
                                            <label class="cursor-pointer color-changer fs-13" for="role_pricing_plan">
                                                {{ trans('labels.pricing_plan') }}
                                            </label>
                                        </div>
                                    @endif
                                    <div class="cursor-pointer d-block mb-3">
                                        <input class="form-check-input" type="checkbox" value=""
                                            name="transaction" id="role_transactions">
                                        <label class="cursor-pointer color-changer fs-13" for="role_transactions">
                                            {{ trans('labels.transaction') }}
                                        </label>
                                    </div>
                                @endif
                                <div class="cursor-pointer d-block mb-3">
                                    <input class="form-check-input" type="checkbox" value="" name="payment"
                                        id="role_payment">
                                    <label class="cursor-pointer color-changer fs-13" for="role_payment">
                                        {{ trans('labels.payment') }}
                                    </label>
                                </div>
                                @if (@helper::checkaddons('commission_module'))
                                    <div class="cursor-pointer d-block mb-3">
                                        <input class="form-check-input" type="checkbox" value="" name="payout"
                                            id="role_payout">
                                        <label class="cursor-pointer color-changer fs-13" for="role_payout">
                                            {{ trans('labels.payout') }}
                                        </label>
                                    </div>
                                @endif
                                @if (Auth::user()->type == 2 || (Auth::user()->type == 4 && Auth::user()->vendor_id != 1))
                                    @if (@helper::checkaddons('subscription'))
                                        @if (@helper::checkaddons('vendor_calendar'))
                                            @php
                                                $checkplan = App\Models\Transaction::where('vendor_id', $vendor_id)
                                                    ->orderByDesc('id')
                                                    ->first();
                                                if (@$user->allow_without_subscription == 1) {
                                                    $vendor_calendar = 1;
                                                } else {
                                                    $vendor_calendar = @$checkplan->vendor_calendar;
                                                }
                                            @endphp
                                            @if (@$vendor_calendar == 1)
                                                <div class="cursor-pointer d-block mb-3">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        name="calendar" id="role_calendar">
                                                    <label class="cursor-pointer color-changer fs-13" for="role_calendar">
                                                        {{ trans('labels.calendar') }}
                                                    </label>
                                                </div>
                                            @endif
                                        @endif
                                    @else
                                        @if (@helper::checkaddons('vendor_calendar'))
                                            <div class="cursor-pointer d-block mb-3">
                                                <input class="form-check-input" type="checkbox" value=""
                                                    name="calendar" id="role_calendar">
                                                <label class="cursor-pointer color-changer fs-13" for="role_calendar">
                                                    {{ trans('labels.calendar') }}
                                                </label>
                                            </div>
                                        @endif
                                    @endif
                                    @if (@helper::checkaddons('custom_status'))
                                        <div class="cursor-pointer d-block mb-3">
                                            <input class="form-check-input" type="checkbox" value=""
                                                name="custom_status" id="role_custom_status">
                                            <label class="cursor-pointer color-changer fs-13" for="role_custom_status">
                                                {{ trans('labels.custom_status') }}
                                            </label>
                                        </div>
                                    @endif
                                    @if (@helper::checkaddons('subscription'))
                                        @if (@helper::checkaddons('custom_domain'))
                                            @php
                                                $checkplan = App\Models\Transaction::where('vendor_id', $vendor_id)
                                                    ->orderByDesc('id')
                                                    ->first();
                                                if (@$user->allow_without_subscription == 1) {
                                                    $custom_domain = 1;
                                                } else {
                                                    $custom_domain = @$checkplan->custom_domain;
                                                }
                                            @endphp
                                            @if (@$custom_domain == 1)
                                                <div class="cursor-pointer d-block mb-3">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        name="custom_domains" id="role_custom_domains">
                                                    <label class="cursor-pointer color-changer fs-13"
                                                        for="role_custom_domains">
                                                        {{ trans('labels.custom_domains') }}
                                                    </label>
                                                </div>
                                            @endif
                                        @endif
                                    @else
                                        @if (@helper::checkaddons('custom_domain'))
                                            <div class="cursor-pointer d-block mb-3">
                                                <input class="form-check-input" type="checkbox" value=""
                                                    name="custom_domains" id="role_custom_domains">
                                                <label class="cursor-pointer color-changer fs-13"
                                                    for="role_custom_domains">
                                                    {{ trans('labels.custom_domains') }}
                                                </label>
                                            </div>
                                        @endif
                                    @endif
                                @endif
                                @if (Auth::user()->type == 1 || (Auth::user()->type == 4 && Auth::user()->vendor_id == 1))
                                    <div class="cursor-pointer d-block mb-3">
                                        <input class="form-check-input" type="checkbox" value="" name="countries"
                                            id="role_countries">
                                        <label class="cursor-pointer color-changer fs-13" for="role_countries">
                                            {{ trans('labels.countries') }}
                                        </label>
                                    </div>
                                    <div class="cursor-pointer d-block mb-3">
                                        <input class="form-check-input" type="checkbox" value="" name="cities"
                                            id="role_cities">
                                        <label class="cursor-pointer color-changer fs-13" for="role_cities">
                                            {{ trans('labels.cities') }}
                                        </label>
                                    </div>
                                    @if (@helper::checkaddons('custom_domain'))
                                        <div class="cursor-pointer d-block mb-3">
                                            <input class="form-check-input" type="checkbox" value=""
                                                name="custom_domains" id="role_custom_domains">
                                            <label class="cursor-pointer color-changer fs-13" for="role_custom_domains">
                                                {{ trans('labels.custom_domains') }}
                                            </label>
                                        </div>
                                    @endif
                                    <div class="cursor-pointer d-block mb-3">
                                        <input class="form-check-input" type="checkbox" value=""
                                            name="store_categories" id="role_store_categories">
                                        <label class="cursor-pointer color-changer fs-13" for="role_store_categories">
                                            {{ trans('labels.store_categories') }}
                                        </label>
                                    </div>
                                @endif
                                <div class="cursor-pointer d-block mb-3">
                                    <input class="form-check-input" type="checkbox" value="" name="basic_settings"
                                        id="role_basic_settings">
                                    <label class="cursor-pointer color-changer fs-13" for="role_basic_settings">
                                        {{ trans('labels.basic_settings') }}
                                    </label>
                                </div>
                                @if (Auth::user()->type == 1 || (Auth::user()->type == 4 && Auth::user()->vendor_id == 1))
                                    <div class="cursor-pointer d-block mb-3">
                                        <input class="form-check-input" type="checkbox" value=""
                                            name="how_it_works" id="role_how_it_works">
                                        <label class="cursor-pointer color-changer fs-13" for="role_how_it_works">
                                            {{ trans('labels.how_it_works') }}
                                        </label>
                                    </div>
                                    <div class="cursor-pointer d-block mb-3">
                                        <input class="form-check-input" type="checkbox" value=""
                                            name="theme_images" id="role_theme_images">
                                        <label class="cursor-pointer color-changer fs-13" for="role_theme_images">
                                            {{ trans('labels.theme_images') }}
                                        </label>
                                    </div>
                                    <div class="cursor-pointer d-block mb-3">
                                        <input class="form-check-input" type="checkbox" value="" name="features"
                                            id="role_features">
                                        <label class="cursor-pointer color-changer fs-13" for="role_features">
                                            {{ trans('labels.features') }}
                                        </label>
                                    </div>
                                    <div class="cursor-pointer d-block mb-3">
                                        <input class="form-check-input" type="checkbox" value=""
                                            name="promotional_banners" id="role_promotional_banners">
                                        <label class="cursor-pointer color-changer fs-13" for="role_promotional_banners">
                                            {{ trans('labels.promotional_banners') }}
                                        </label>
                                    </div>
                                    @if (@helper::checkaddons('blog'))
                                        <div class="cursor-pointer d-block mb-3">
                                            <input class="form-check-input" type="checkbox" value=""
                                                name="blogs" id="role_blogs">
                                            <label class="cursor-pointer color-changer fs-13" for="role_blogs">
                                                {{ trans('labels.blogs') }}
                                            </label>
                                        </div>
                                    @endif
                                @endif
                                @if (Auth::user()->type == 2 || (Auth::user()->type == 4 && Auth::user()->vendor_id != 1))
                                    <div class="cursor-pointer d-block mb-3">
                                        <input class="form-check-input" type="checkbox" value="" name="choose_us"
                                            id="role_choose_us">
                                        <label class="cursor-pointer color-changer fs-13" for="role_choose_us">
                                            {{ trans('labels.choose_us') }}
                                        </label>
                                    </div>
                                    @if (@helper::checkaddons('subscription'))
                                        @if (@helper::checkaddons('blog'))
                                            @php
                                                $checkplan = App\Models\Transaction::where('vendor_id', $vendor_id)
                                                    ->orderByDesc('id')
                                                    ->first();
                                                if (@$user->allow_without_subscription == 1) {
                                                    $blogs = 1;
                                                } else {
                                                    $blogs = @$checkplan->blogs;
                                                }
                                            @endphp
                                            @if ($blogs == 1)
                                                <div class="cursor-pointer d-block mb-3">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        name="blogs" id="role_blogs">
                                                    <label class="cursor-pointer color-changer fs-13" for="role_blogs">
                                                        {{ trans('labels.blogs') }}
                                                    </label>
                                                </div>
                                            @endif
                                        @endif
                                    @else
                                        @if (@helper::checkaddons('blog'))
                                            <div class="cursor-pointer d-block mb-3">
                                                <input class="form-check-input" type="checkbox" value=""
                                                    name="blogs" id="role_blogs">
                                                <label class="cursor-pointer color-changer fs-13" for="role_blogs">
                                                    {{ trans('labels.blogs') }}
                                                </label>
                                            </div>
                                        @endif
                                    @endif
                                @endif
                                <div class="cursor-pointer d-block mb-3">
                                    <input class="form-check-input" type="checkbox" value="" name="faqs"
                                        id="role_faqs">
                                    <label class="cursor-pointer color-changer fs-13" for="role_faqs">
                                        {{ trans('labels.faqs') }}
                                    </label>
                                </div>
                                <div class="cursor-pointer d-block mb-3">
                                    <input class="form-check-input" type="checkbox" value="" name="testimonials"
                                        id="role_testimonials">
                                    <label class="cursor-pointer color-changer fs-13" for="role_testimonials">
                                        {{ trans('labels.testimonials') }}
                                    </label>
                                </div>
                                @if (Auth::user()->type == 2 || (Auth::user()->type == 4 && Auth::user()->vendor_id != 1))
                                    <div class="cursor-pointer d-block mb-3">
                                        <input class="form-check-input" type="checkbox" value="" name="gallery"
                                            id="role_gallery">
                                        <label class="cursor-pointer color-changer fs-13" for="role_gallery">
                                            {{ trans('labels.gallery') }}
                                        </label>
                                    </div>
                                @endif
                                <div class="cursor-pointer d-block mb-3">
                                    <input class="form-check-input" type="checkbox" value="" name="cms_pages"
                                        id="role_cms_pages">
                                    <label class="cursor-pointer color-changer fs-13" for="role_cms_pages">
                                        {{ trans('labels.cms_pages') }}
                                    </label>
                                </div>
                                @if (Auth::user()->type == 1 || (Auth::user()->type == 4 && Auth::user()->vendor_id == 1))
                                    @if (@helper::checkaddons('coupon'))
                                        <div class="cursor-pointer d-block mb-3">
                                            <input class="form-check-input" type="checkbox" value=""
                                                name="coupons" id="role_coupons">
                                            <label class="cursor-pointer color-changer fs-13" for="role_coupons">
                                                {{ trans('labels.coupons') }}
                                            </label>
                                        </div>
                                    @endif
                                    @if (@helper::checkaddons('employee'))
                                        <div class="cursor-pointer d-block mb-3">
                                            <input class="form-check-input" type="checkbox" value=""
                                                name="roles" id="role_roles">
                                            <label class="cursor-pointer color-changer fs-13" for="role_roles">
                                                {{ trans('labels.roles') }}
                                            </label>
                                        </div>
                                        <div class="cursor-pointer d-block mb-3">
                                            <input class="form-check-input" type="checkbox" value=""
                                                name="employees" id="role_employees">
                                            <label class="cursor-pointer color-changer fs-13" for="role_employees">
                                                {{ trans('labels.employees') }}
                                            </label>
                                        </div>
                                    @endif
                                @endif
                                @if (Auth::user()->type == 2 || (Auth::user()->type == 4 && Auth::user()->vendor_id != 1))
                                    @if (@helper::checkaddons('subscription'))
                                        @if (@helper::checkaddons('employee'))
                                            @php
                                                $checkplan = App\Models\Transaction::where('vendor_id', $vendor_id)
                                                    ->orderByDesc('id')
                                                    ->first();
                                                if (@$user->allow_without_subscription == 1) {
                                                    $employee = 1;
                                                } else {
                                                    $employee = @$checkplan->employee;
                                                }
                                            @endphp
                                            @if ($employee == 1)
                                                <div class="cursor-pointer d-block mb-3">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        name="roles" id="role_roles">
                                                    <label class="cursor-pointer color-changer fs-13" for="role_roles">
                                                        {{ trans('labels.roles') }}
                                                    </label>
                                                </div>
                                                <div class="cursor-pointer d-block mb-3">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        name="employees" id="role_employees">
                                                    <label class="cursor-pointer color-changer fs-13"
                                                        for="role_employees">
                                                        {{ trans('labels.employees') }}
                                                    </label>
                                                </div>
                                            @endif
                                        @endif
                                    @else
                                        @if (@helper::checkaddons('employee'))
                                            <div class="cursor-pointer d-block mb-3">
                                                <input class="form-check-input" type="checkbox" value=""
                                                    name="roles" id="role_roles">
                                                <label class="cursor-pointer color-changer fs-13" for="role_roles">
                                                    {{ trans('labels.roles') }}
                                                </label>
                                            </div>
                                            <div class="cursor-pointer d-block mb-3">
                                                <input class="form-check-input" type="checkbox" value=""
                                                    name="employees" id="role_employees">
                                                <label class="cursor-pointer color-changer fs-13" for="role_employees">
                                                    {{ trans('labels.employees') }}
                                                </label>
                                            </div>
                                        @endif
                                    @endif
                                @endif
                                <div class="cursor-pointer d-block mb-3">
                                    <input class="form-check-input" type="checkbox" value="" name="subscribers"
                                        id="role_subscribers">
                                    <label class="cursor-pointer color-changer fs-13" for="role_subscribers">
                                        {{ trans('labels.subscribers') }}
                                    </label>
                                </div>
                                <div class="cursor-pointer d-block mb-3">
                                    <input class="form-check-input" type="checkbox" value="" name="inquiries"
                                        id="role_inquiries">
                                    <label class="cursor-pointer color-changer fs-13" for="role_inquiries">
                                        {{ trans('labels.inquiries') }}
                                    </label>
                                </div>
                                @if (Auth::user()->type == 2 || (Auth::user()->type == 4 && Auth::user()->vendor_id != 1))
                                    <div class="cursor-pointer d-block mb-3">
                                        <input class="form-check-input" type="checkbox" value="" name="share"
                                            id="role_share">
                                        <label class="cursor-pointer color-changer fs-13" for="role_share">
                                            {{ trans('labels.share') }}
                                        </label>
                                    </div>
                                    @if (@helper::checkaddons('subscription'))
                                        @if (@helper::checkaddons('whatsapp_message'))
                                            @php
                                                $checkplan = App\Models\Transaction::where('vendor_id', $vendor_id)
                                                    ->orderByDesc('id')
                                                    ->first();

                                                if (@$user->allow_without_subscription == 1) {
                                                    $whatsapp_message = 1;
                                                } else {
                                                    $whatsapp_message = @$checkplan->whatsapp_message;
                                                }
                                            @endphp
                                            @if ($whatsapp_message == 1)
                                                <div class="cursor-pointer d-block mb-3">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        name="whatsapp_settings" id="role_whatsapp_settings">
                                                    <label class="cursor-pointer color-changer fs-13"
                                                        for="role_whatsapp_settings">
                                                        {{ trans('labels.whatsapp_settings') }}
                                                    </label>
                                                </div>
                                            @endif
                                        @endif
                                    @else
                                        @if (@helper::checkaddons('whatsapp_message'))
                                            <div class="cursor-pointer d-block mb-3">
                                                <input class="form-check-input" type="checkbox" value=""
                                                    name="whatsapp_settings" id="role_whatsapp_settings">
                                                <label class="cursor-pointer color-changer fs-13"
                                                    for="role_whatsapp_settings">
                                                    {{ trans('labels.whatsapp_settings') }}
                                                </label>
                                            </div>
                                        @endif
                                    @endif
                                    @if (@helper::checkaddons('subscription'))
                                        @if (@helper::checkaddons('telegram_message'))
                                            @php
                                                $checkplan = App\Models\Transaction::where('vendor_id', $vendor_id)
                                                    ->orderByDesc('id')
                                                    ->first();

                                                if (@$user->allow_without_subscription == 1) {
                                                    $telegram_message = 1;
                                                } else {
                                                    $telegram_message = @$checkplan->telegram_message;
                                                }
                                            @endphp
                                            @if ($telegram_message == 1)
                                                <div class="cursor-pointer d-block mb-3">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        name="telegram_settings" id="role_telegram_settings">
                                                    <label class="cursor-pointer color-changer fs-13"
                                                        for="role_telegram_settings">
                                                        {{ trans('labels.telegram_settings') }}
                                                    </label>
                                                </div>
                                            @endif
                                        @endif
                                    @else
                                        @if (@helper::checkaddons('telegram_message'))
                                            <div class="cursor-pointer d-block mb-3">
                                                <input class="form-check-input" type="checkbox" value=""
                                                    name="telegram_settings" id="role_telegram_settings">
                                                <label class="cursor-pointer color-changer fs-13"
                                                    for="role_telegram_settings">
                                                    {{ trans('labels.telegram_settings') }}
                                                </label>
                                            </div>
                                        @endif
                                    @endif
                                @endif
                                <div class="cursor-pointer d-block mb-3">
                                    <input class="form-check-input" type="checkbox" value=""
                                        name="language_settings" id="role_language_settings">
                                    <label class="cursor-pointer color-changer fs-13" for="role_language_settings">
                                        {{ trans('labels.language-settings') }}
                                    </label>
                                </div>
                                <div class="cursor-pointer d-block mb-3">
                                    <input class="form-check-input" type="checkbox" value=""
                                        name="language_settings" id="role_currency_settings">
                                    <label class="cursor-pointer color-changer fs-13" for="role_currency_settings">
                                        {{ trans('labels.currency-settings') }}
                                    </label>
                                </div>
                                <div class="cursor-pointer d-block mb-3">
                                    <input class="form-check-input" type="checkbox" value=""
                                        name="general_settings" id="role_general_settings">
                                    <label class="cursor-pointer color-changer fs-13" for="role_general_settings">
                                        {{ trans('labels.general_settings') }}
                                    </label>
                                </div>
                            </div>
                            <div class="col-8" id="permissioncheckbox">
                                <div class="d-block mb-3">
                                    <div class="row g-2">
                                        <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                            <input class="form-check-input" type="checkbox" value="role_dashboard"
                                                name="modules[role_dashboard]" id="manage[role_dashboard]">
                                            <label class="form-check-label fs-13" for="manage[role_dashboard]">
                                                {{ trans('labels.view') }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                @if (Auth::user()->type == 1 || (Auth::user()->type == 4 && Auth::user()->vendor_id == 1))
                                    <div class="d-block mb-3">
                                        <div class="row g-2">
                                            <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                <input class="form-check-input" type="checkbox"
                                                    value="role_addons_manager" name="modules[role_addons_manager]"
                                                    id="manage[role_addons_manager]">
                                                <label class="form-check-label fs-13" for="manage[role_addons_manager]">
                                                    {{ trans('labels.view') }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-block mb-3">
                                        <div class="row g-2">
                                            <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                <input class="form-check-input" type="checkbox" value="role_vendors"
                                                    name="modules[role_vendors]" id="manage[role_vendors]">
                                                <label class="form-check-label fs-13" for="manage[role_vendors]">
                                                    {{ trans('labels.view') }}
                                                </label>
                                            </div>
                                            <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                <input class="form-check-input" type="checkbox" value="role_vendors"
                                                    name="add[role_vendors]" id="add[role_vendors]">
                                                <label class="form-check-label fs-13" for="add[role_vendors]">
                                                    {{ trans('labels.add') }}
                                                </label>
                                            </div>
                                            <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                <input class="form-check-input" type="checkbox" value="role_vendors"
                                                    name="edit[role_vendors]" id="edit[role_vendors]">
                                                <label class="form-check-label fs-13" for="edit[role_vendors]">
                                                    {{ trans('labels.edit') }}
                                                </label>
                                            </div>
                                            <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                <input class="form-check-input" type="checkbox" value="role_vendors"
                                                    name="delete[role_vendors]" id="delete[role_vendors]">
                                                <label class="form-check-label fs-13" for="delete[role_vendors]">
                                                    {{ trans('labels.delete') }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @if (@helper::checkaddons('customer_login'))
                                    <div class="d-block mb-3">
                                        <div class="row g-2">
                                            <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                <input class="form-check-input" type="checkbox" value="role_customers"
                                                    name="modules[role_customers]" id="manage[role_customers]">
                                                <label class="form-check-label fs-13" for="manage[role_customers]">
                                                    {{ trans('labels.view') }}
                                                </label>
                                            </div>
                                            @if (Auth::user()->type == 2 || (Auth::user()->type == 4 && Auth::user()->vendor_id != 1))
                                                <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                    <input class="form-check-input" type="checkbox"
                                                        value="role_customers" name="add[role_customers]"
                                                        id="add[role_customers]">
                                                    <label class="form-check-label fs-13" for="add[role_customers]">
                                                        {{ trans('labels.add') }}
                                                    </label>
                                                </div>
                                                <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                    <input class="form-check-input" type="checkbox"
                                                        value="role_customers" name="edit[role_customers]"
                                                        id="edit[role_customers]">
                                                    <label class="form-check-label fs-13" for="edit[role_customers]">
                                                        {{ trans('labels.edit') }}
                                                    </label>
                                                </div>
                                                <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                    <input class="form-check-input" type="checkbox"
                                                        value="role_customers" name="delete[role_customers]"
                                                        id="delete[role_customers]">
                                                    <label class="form-check-label fs-13" for="delete[role_customers]">
                                                        {{ trans('labels.delete') }}
                                                    </label>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                                @if (Auth::user()->type == 2 || (Auth::user()->type == 4 && Auth::user()->vendor_id != 1))
                                    <div class="d-block mb-3">
                                        <div class="row g-2">
                                            <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                <input class="form-check-input" type="checkbox" value="role_categories"
                                                    name="modules[role_categories]" id="manage[role_categories]">
                                                <label class="form-check-label fs-13" for="manage[role_categories]">
                                                    {{ trans('labels.view') }}
                                                </label>
                                            </div>
                                            <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                <input class="form-check-input" type="checkbox" value="role_categories"
                                                    name="add[role_categories]" id="add[role_categories]">
                                                <label class="form-check-label fs-13" for="add[role_categories]">
                                                    {{ trans('labels.add') }}
                                                </label>
                                            </div>
                                            <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                <input class="form-check-input" type="checkbox" value="role_categories"
                                                    name="edit[role_categories]" id="edit[role_categories]">
                                                <label class="form-check-label fs-13" for="edit[role_categories]">
                                                    {{ trans('labels.edit') }}
                                                </label>
                                            </div>
                                            <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                <input class="form-check-input" type="checkbox" value="role_categories"
                                                    name="delete[role_categories]" id="delete[role_categories]">
                                                <label class="form-check-label fs-13" for="delete[role_categories]">
                                                    {{ trans('labels.delete') }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-block mb-3">
                                        <div class="row g-2">
                                            <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                <input class="form-check-input" type="checkbox" value="role_services"
                                                    name="modules[role_services]" id="manage[role_services]">
                                                <label class="form-check-label fs-13" for="manage[role_services]">
                                                    {{ trans('labels.view') }}
                                                </label>
                                            </div>
                                            <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                <input class="form-check-input" type="checkbox" value="role_services"
                                                    name="add[role_services]" id="add[role_services]">
                                                <label class="form-check-label fs-13" for="add[role_services]">
                                                    {{ trans('labels.add') }}
                                                </label>
                                            </div>
                                            <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                <input class="form-check-input" type="checkbox" value="role_services"
                                                    name="edit[role_services]" id="edit[role_services]">
                                                <label class="form-check-label fs-13" for="edit[role_services]">
                                                    {{ trans('labels.edit') }}
                                                </label>
                                            </div>
                                            <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                <input class="form-check-input" type="checkbox" value="role_services"
                                                    name="delete[role_services]" id="delete[role_services]">
                                                <label class="form-check-label fs-13" for="delete[role_services]">
                                                    {{ trans('labels.delete') }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    @if (@helper::checkaddons('service_import'))
                                        <div class="d-block mb-3">
                                            <div class="row g-2">
                                                <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                    <input class="form-check-input" type="checkbox"
                                                        value="role_bulk_import" name="modules[role_bulk_import]"
                                                        id="manage[role_bulk_import]">
                                                    <label class="form-check-label fs-13" for="manage[role_bulk_import]">
                                                        {{ trans('labels.view') }}
                                                    </label>
                                                </div>
                                                <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                    <input class="form-check-input" type="checkbox"
                                                        value="role_bulk_import" name="add[role_bulk_import]"
                                                        id="add[role_bulk_import]">
                                                    <label class="form-check-label fs-13" for="add[role_bulk_import]">
                                                        {{ trans('labels.add') }}
                                                    </label>
                                                </div>
                                                <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                    <input class="form-check-input" type="checkbox"
                                                        value="role_bulk_import" name="delete[role_bulk_import]"
                                                        id="delete[role_bulk_import]">
                                                    <label class="form-check-label fs-13" for="delete[role_bulk_import]">
                                                        {{ trans('labels.delete') }}
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                     @if (@helper::checkaddons('question_answer'))
                                            <div class="d-block mb-3">
                                                <div class="row g-2">
                                                    <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                        <input class="form-check-input" type="checkbox"
                                                            value="role_service_question_answer"
                                                            name="modules[role_service_question_answer]"
                                                            id="manage[role_service_question_answer]">
                                                        <label class="form-check-label fs-13"
                                                            for="manage[role_service_question_answer]">
                                                            {{ trans('labels.view') }}
                                                        </label>
                                                    </div>
                                                    
                                                    <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                        <input class="form-check-input" type="checkbox"
                                                            value="role_service_question_answer"
                                                            name="edit[role_service_question_answer]"
                                                            id="edit[role_service_question_answer]">
                                                        <label class="form-check-label fs-13"
                                                            for="edit[role_service_question_answer]">
                                                            {{ trans('labels.edit') }}
                                                        </label>
                                                    </div>
                                                    <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                        <input class="form-check-input" type="checkbox"
                                                            value="role_service_question_answer"
                                                            name="delete[role_service_question_answer]"
                                                            id="delete[role_service_question_answer]">
                                                        <label class="form-check-label fs-13"
                                                            for="delete[role_service_question_answer]">
                                                            {{ trans('labels.delete') }}
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif

                                    <div class="d-block mb-3">
                                        <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                            <input class="form-check-input" type="checkbox" value="role_bookings"
                                                name="modules[role_bookings]" id="manage[role_bookings]">
                                            <label class="form-check-label fs-13" for="manage[role_bookings]">
                                                {{ trans('labels.view') }}
                                            </label>
                                        </div>
                                    </div>
                                    <div class="d-block mb-3">
                                        <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                            <input class="form-check-input" type="checkbox" value="role_reports"
                                                name="modules[role_reports]" id="manage[role_reports]">
                                            <label class="form-check-label fs-13" for="manage[role_reports]">
                                                {{ trans('labels.view') }}
                                            </label>
                                        </div>
                                    </div>
                                    @if (@helper::checkaddons('product_shop'))
                                        <div class="d-block mb-3">
                                            <div class="row g-2">
                                                <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                    <input class="form-check-input" type="checkbox"
                                                        value="role_products_categories"
                                                        name="modules[role_products_categories]"
                                                        id="manage[role_products_categories]">
                                                    <label class="form-check-label fs-13"
                                                        for="manage[role_products_categories]">
                                                        {{ trans('labels.view') }}
                                                    </label>
                                                </div>
                                                <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                    <input class="form-check-input" type="checkbox"
                                                        value="role_products_categories"
                                                        name="add[role_products_categories]"
                                                        id="add[role_products_categories]">
                                                    <label class="form-check-label fs-13"
                                                        for="add[role_products_categories]">
                                                        {{ trans('labels.add') }}
                                                    </label>
                                                </div>
                                                <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                    <input class="form-check-input" type="checkbox"
                                                        value="role_products_categories"
                                                        name="edit[role_products_categories]"
                                                        id="edit[role_products_categories]">
                                                    <label class="form-check-label fs-13"
                                                        for="edit[role_products_categories]">
                                                        {{ trans('labels.edit') }}
                                                    </label>
                                                </div>
                                                <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                    <input class="form-check-input" type="checkbox"
                                                        value="role_products_categories"
                                                        name="delete[role_products_categories]"
                                                        id="delete[role_products_categories]">
                                                    <label class="form-check-label fs-13"
                                                        for="delete[role_products_categories]">
                                                        {{ trans('labels.delete') }}
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-block mb-3">
                                            <div class="row g-2">
                                                <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                    <input class="form-check-input" type="checkbox" value="role_products"
                                                        name="modules[role_products]" id="manage[role_products]">
                                                    <label class="form-check-label fs-13" for="manage[role_products]">
                                                        {{ trans('labels.view') }}
                                                    </label>
                                                </div>
                                                <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                    <input class="form-check-input" type="checkbox" value="role_products"
                                                        name="add[role_products]" id="add[role_products]">
                                                    <label class="form-check-label fs-13" for="add[role_products]">
                                                        {{ trans('labels.add') }}
                                                    </label>
                                                </div>
                                                <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                    <input class="form-check-input" type="checkbox" value="role_products"
                                                        name="edit[role_products]" id="edit[role_products]">
                                                    <label class="form-check-label fs-13" for="edit[role_products]">
                                                        {{ trans('labels.edit') }}
                                                    </label>
                                                </div>
                                                <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                    <input class="form-check-input" type="checkbox" value="role_products"
                                                        name="delete[role_products]" id="delete[role_products]">
                                                    <label class="form-check-label fs-13" for="delete[role_products]">
                                                        {{ trans('labels.delete') }}
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        @if (@helper::checkaddons('product_import'))
                                            <div class="d-block mb-3">
                                                <div class="row g-2">
                                                    <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                        <input class="form-check-input" type="checkbox"
                                                            value="role_products_bulk_import"
                                                            name="modules[role_products_bulk_import]"
                                                            id="manage[role_products_bulk_import]">
                                                        <label class="form-check-label fs-13"
                                                            for="manage[role_products_bulk_import]">
                                                            {{ trans('labels.view') }}
                                                        </label>
                                                    </div>
                                                    <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                        <input class="form-check-input" type="checkbox"
                                                            value="role_products_bulk_import"
                                                            name="add[role_products_bulk_import]"
                                                            id="add[role_products_bulk_import]">
                                                        <label class="form-check-label fs-13"
                                                            for="add[role_products_bulk_import]">
                                                            {{ trans('labels.add') }}
                                                        </label>
                                                    </div>
                                                    <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                        <input class="form-check-input" type="checkbox"
                                                            value="role_products_bulk_import"
                                                            name="delete[role_products_bulk_import]"
                                                            id="delete[role_products_bulk_import]">
                                                        <label class="form-check-label fs-13"
                                                            for="delete[role_products_bulk_import]">
                                                            {{ trans('labels.delete') }}
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                        <div class="d-block mb-3">
                                            <div class="row g-2">
                                                <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                    <input class="form-check-input" type="checkbox"
                                                        value="role_shipping_management"
                                                        name="modules[role_shipping_management]"
                                                        id="manage[role_shipping_management]">
                                                    <label class="form-check-label fs-13"
                                                        for="manage[role_shipping_management]">
                                                        {{ trans('labels.view') }}
                                                    </label>
                                                </div>
                                                <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                    <input class="form-check-input" type="checkbox"
                                                        value="role_shipping_management"
                                                        name="add[role_shipping_management]"
                                                        id="add[role_shipping_management]">
                                                    <label class="form-check-label fs-13"
                                                        for="add[role_shipping_management]">
                                                        {{ trans('labels.add') }}
                                                    </label>
                                                </div>
                                                @if (@helper::checkaddons('shipping_area'))
                                                    @if (helper::appdata($vendor_id)->shipping_area == 1)
                                                        <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                            <input class="form-check-input" type="checkbox"
                                                                value="role_shipping_management"
                                                                name="edit[role_shipping_management]"
                                                                id="edit[role_shipping_management]">
                                                            <label class="form-check-label fs-13"
                                                                for="edit[role_shipping_management]">
                                                                {{ trans('labels.edit') }}
                                                            </label>
                                                        </div>
                                                        <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                            <input class="form-check-input" type="checkbox"
                                                                value="role_shipping_management"
                                                                name="delete[role_shipping_management]"
                                                                id="delete[role_shipping_management]">
                                                            <label class="form-check-label fs-13"
                                                                for="delete[role_shipping_management]">
                                                                {{ trans('labels.delete') }}
                                                            </label>
                                                        </div>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>


                                        @if (@helper::checkaddons('question_answer'))
                                            <div class="d-block mb-3">
                                                <div class="row g-2">
                                                    <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                        <input class="form-check-input" type="checkbox"
                                                            value="role_product_question_answer"
                                                            name="modules[role_product_question_answer]"
                                                            id="manage[role_product_question_answer]">
                                                        <label class="form-check-label fs-13"
                                                            for="manage[role_product_question_answer]">
                                                            {{ trans('labels.view') }}
                                                        </label>
                                                    </div>
                                                    
                                                    <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                        <input class="form-check-input" type="checkbox"
                                                            value="role_product_question_answer"
                                                            name="edit[role_product_question_answer]"
                                                            id="edit[role_product_question_answer]">
                                                        <label class="form-check-label fs-13"
                                                            for="edit[role_product_question_answer]">
                                                            {{ trans('labels.edit') }}
                                                        </label>
                                                    </div>
                                                    <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                        <input class="form-check-input" type="checkbox"
                                                            value="role_product_question_answer"
                                                            name="delete[role_product_question_answer]"
                                                            id="delete[role_product_question_answer]">
                                                        <label class="form-check-label fs-13"
                                                            for="delete[role_product_question_answer]">
                                                            {{ trans('labels.delete') }}
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif


                                        <div class="d-block mb-3">
                                            <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                <input class="form-check-input" type="checkbox" value="role_orders"
                                                    name="modules[role_orders]" id="manage[role_orders]">
                                                <label class="form-check-label fs-13" for="manage[role_orders]">
                                                    {{ trans('labels.view') }}
                                                </label>
                                            </div>
                                        </div>
                                        <div class="d-block mb-3">
                                            <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                <input class="form-check-input" type="checkbox"
                                                    value="role_order_reports" name="modules[role_order_reports]"
                                                    id="manage[role_order_reports]">
                                                <label class="form-check-label fs-13" for="manage[role_order_reports]">
                                                    {{ trans('labels.view') }}
                                                </label>
                                            </div>
                                        </div>
                                    @endif
                                @endif
                                @if (Auth::user()->type == 2 || (Auth::user()->type == 4 && Auth::user()->vendor_id != 1))
                                    <div class="d-block mb-3">
                                        <div class="row g-2">
                                            <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                <input class="form-check-input" type="checkbox" value="role_banners"
                                                    name="modules[role_banners]" id="manage[role_banners]">
                                                <label class="form-check-label fs-13" for="manage[role_banners]">
                                                    {{ trans('labels.view') }}
                                                </label>
                                            </div>
                                            <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                <input class="form-check-input" type="checkbox" value="role_banners"
                                                    name="add[role_banners]" id="add[role_banners]">
                                                <label class="form-check-label fs-13" for="add[role_banners]">
                                                    {{ trans('labels.add') }}
                                                </label>
                                            </div>
                                            <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                <input class="form-check-input" type="checkbox" value="role_banners"
                                                    name="edit[role_banners]" id="edit[role_banners]">
                                                <label class="form-check-label fs-13" for="edit[role_banners]">
                                                    {{ trans('labels.edit') }}
                                                </label>
                                            </div>
                                            <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                <input class="form-check-input" type="checkbox" value="role_banners"
                                                    name="delete[role_banners]" id="delete[role_banners]">
                                                <label class="form-check-label fs-13" for="delete[role_banners]">
                                                    {{ trans('labels.delete') }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    @if (@helper::checkaddons('subscription'))
                                        @if (@helper::checkaddons('coupon'))
                                            <?php
                                            $checkplan = App\Models\Transaction::where('vendor_id', $vendor_id)->orderByDesc('id')->first();
                                            if (@$user->allow_without_subscription == 1) {
                                                $coupons = 1;
                                            } else {
                                                $coupons = @$checkplan->coupons;
                                            }
                                            ?>
                                            @if ($coupons == 1)
                                                <div class="d-block mb-3">
                                                    <div class="row g-2">
                                                        <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                            <input class="form-check-input" type="checkbox"
                                                                value="role_coupons" name="modules[role_coupons]"
                                                                id="manage[role_coupons]">
                                                            <label class="form-check-label fs-13"
                                                                for="manage[role_coupons]">
                                                                {{ trans('labels.view') }}
                                                            </label>
                                                        </div>
                                                        <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                            <input class="form-check-input" type="checkbox"
                                                                value="role_coupons" name="add[role_coupons]"
                                                                id="add[role_coupons]">
                                                            <label class="form-check-label fs-13" for="add[role_coupons]">
                                                                {{ trans('labels.add') }}
                                                            </label>
                                                        </div>
                                                        <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                            <input class="form-check-input" type="checkbox"
                                                                value="role_coupons" name="edit[role_coupons]"
                                                                id="edit[role_coupons]">
                                                            <label class="form-check-label fs-13"
                                                                for="edit[role_coupons]">
                                                                {{ trans('labels.edit') }}
                                                            </label>
                                                        </div>
                                                        <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                            <input class="form-check-input" type="checkbox"
                                                                value="role_coupons" name="delete[role_coupons]"
                                                                id="delete[role_coupons]">
                                                            <label class="form-check-label fs-13"
                                                                for="delete[role_coupons]">
                                                                {{ trans('labels.delete') }}
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endif
                                    @else
                                        @if (@helper::checkaddons('coupon'))
                                            <div class="d-block mb-3">
                                                <div class="row g-2">
                                                    <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                        <input class="form-check-input" type="checkbox"
                                                            value="role_coupons" name="modules[role_coupons]"
                                                            id="manage[role_coupons]">
                                                        <label class="form-check-label fs-13" for="manage[role_coupons]">
                                                            {{ trans('labels.view') }}
                                                        </label>
                                                    </div>
                                                    <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                        <input class="form-check-input" type="checkbox"
                                                            value="role_coupons" name="add[role_coupons]"
                                                            id="add[role_coupons]">
                                                        <label class="form-check-label fs-13" for="add[role_coupons]">
                                                            {{ trans('labels.add') }}
                                                        </label>
                                                    </div>
                                                    <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                        <input class="form-check-input" type="checkbox"
                                                            value="role_coupons" name="edit[role_coupons]"
                                                            id="edit[role_coupons]">
                                                        <label class="form-check-label fs-13" for="edit[role_coupons]">
                                                            {{ trans('labels.edit') }}
                                                        </label>
                                                    </div>
                                                    <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                        <input class="form-check-input" type="checkbox"
                                                            value="role_coupons" name="delete[role_coupons]"
                                                            id="delete[role_coupons]">
                                                        <label class="form-check-label fs-13"
                                                            for="delete[role_coupons]">
                                                            {{ trans('labels.delete') }}
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endif
                                    @if (@helper::checkaddons('top_deals'))
                                        <div class="d-block mb-3">
                                            <div class="row g-2">
                                                <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                    <input class="form-check-input" type="checkbox"
                                                        value="role_top_deals" name="modules[role_top_deals]"
                                                        id="manage[role_top_deals]">
                                                    <label class="form-check-label fs-13" for="manage[role_top_deals]">
                                                        {{ trans('labels.view') }}
                                                    </label>
                                                </div>
                                                <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                    <input class="form-check-input" type="checkbox"
                                                        value="role_top_deals" name="edit[role_top_deals]"
                                                        id="edit[role_top_deals]">
                                                    <label class="form-check-label fs-13" for="edit[role_top_deals]">
                                                        {{ trans('labels.edit') }}
                                                    </label>
                                                </div>
                                                <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                    <input class="form-check-input" type="checkbox"
                                                        value="role_top_deals" name="delete[role_top_deals]"
                                                        id="delete[role_top_deals]">
                                                    <label class="form-check-label fs-13" for="delete[role_top_deals]">
                                                        {{ trans('labels.delete') }}
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endif
                                <div class="d-block mb-3">
                                    <div class="row g-2">
                                        <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                            <input class="form-check-input" type="checkbox" value="role_tax"
                                                name="modules[role_tax]" id="manage[role_tax]">
                                            <label class="form-check-label fs-13" for="manage[role_tax]">
                                                {{ trans('labels.view') }}
                                            </label>
                                        </div>
                                        <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                            <input class="form-check-input" type="checkbox" value="role_tax"
                                                name="add[role_tax]" id="add[role_tax]">
                                            <label class="form-check-label fs-13" for="add[role_tax]">
                                                {{ trans('labels.add') }}
                                            </label>
                                        </div>
                                        <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                            <input class="form-check-input" type="checkbox" value="role_tax"
                                                name="edit[role_tax]" id="edit[role_tax]">
                                            <label class="form-check-label fs-13" for="edit[role_tax]">
                                                {{ trans('labels.edit') }}
                                            </label>
                                        </div>
                                        <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                            <input class="form-check-input" type="checkbox" value="role_tax"
                                                name="delete[role_tax]" id="delete[role_tax]">
                                            <label class="form-check-label fs-13" for="delete[role_tax]">
                                                {{ trans('labels.delete') }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                @if (@helper::checkaddons('subscription'))
                                    @if (@$user->allow_without_subscription != 1)
                                        <div class="d-block mb-3">
                                            <div class="row g-2">
                                                <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                    <input class="form-check-input" type="checkbox"
                                                        value="role_pricing_plan" name="modules[role_pricing_plan]"
                                                        id="manage[role_pricing_plan]">
                                                    <label class="form-check-label fs-13"
                                                        for="manage[role_pricing_plan]">
                                                        {{ trans('labels.view') }}
                                                    </label>
                                                </div>
                                                @if (Auth::user()->type == 1 || (Auth::user()->type == 4 && Auth::user()->vendor_id == 1))
                                                    <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                        <input class="form-check-input" type="checkbox"
                                                            value="role_pricing_plan" name="add[role_pricing_plan]"
                                                            id="add[role_pricing_plan]">
                                                        <label class="form-check-label fs-13"
                                                            for="add[role_pricing_plan]">
                                                            {{ trans('labels.add') }}
                                                        </label>
                                                    </div>
                                                    <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                        <input class="form-check-input" type="checkbox"
                                                            value="role_pricing_plan" name="edit[role_pricing_plan]"
                                                            id="edit[role_pricing_plan]">
                                                        <label class="form-check-label fs-13"
                                                            for="edit[role_pricing_plan]">
                                                            {{ trans('labels.edit') }}
                                                        </label>
                                                    </div>
                                                    <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                        <input class="form-check-input" type="checkbox"
                                                            value="role_pricing_plan" name="delete[role_pricing_plan]"
                                                            id="delete[role_pricing_plan]">
                                                        <label class="form-check-label fs-13"
                                                            for="delete[role_pricing_plan]">
                                                            {{ trans('labels.delete') }}
                                                        </label>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endif
                                    <div class="d-block mb-3">
                                        <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                            <input class="form-check-input" type="checkbox" value="role_transactions"
                                                name="modules[role_transactions]" id="manage[role_transactions]">
                                            <label class="form-check-label fs-13" for="manage[role_transactions]">
                                                {{ trans('labels.view') }}
                                            </label>
                                        </div>
                                    </div>
                                @endif
                                <div class="d-block mb-3">
                                    <div class="row g-2">
                                        <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                            <input class="form-check-input" type="checkbox" value="role_payment"
                                                name="modules[role_payment]" id="manage[role_payment]">
                                            <label class="form-check-label fs-13" for="manage[role_payment]">
                                                {{ trans('labels.view') }}
                                            </label>
                                        </div>
                                        <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                            <input class="form-check-input" type="checkbox" value="role_payment"
                                                name="edit[role_payment]" id="edit[role_payment]">
                                            <label class="form-check-label fs-13" for="edit[role_payment]">
                                                {{ trans('labels.edit') }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                @if (@helper::checkaddons('commission_module'))
                                    <div class="d-block mb-3">
                                        <div class="row g-2">
                                            <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                <input class="form-check-input" type="checkbox" value="role_payout"
                                                    name="modules[role_payout]" id="manage[role_payout]">
                                                <label class="form-check-label fs-13" for="manage[role_payout]">
                                                    {{ trans('labels.view') }}
                                                </label>
                                            </div>
                                            <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                <input class="form-check-input" type="checkbox" value="role_payout"
                                                    name="edit[role_payout]" id="edit[role_payout]">
                                                <label class="form-check-label fs-13" for="edit[role_payout]">
                                                    {{ trans('labels.edit') }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @if (Auth::user()->type == 2 || (Auth::user()->type == 4 && Auth::user()->vendor_id != 1))
                                    @if (@helper::checkaddons('subscription'))
                                        @if (@helper::checkaddons('vendor_calendar'))
                                            @php
                                                $checkplan = App\Models\Transaction::where('vendor_id', $vendor_id)
                                                    ->orderByDesc('id')
                                                    ->first();
                                                if (@$user->allow_without_subscription == 1) {
                                                    $vendor_calendar = 1;
                                                } else {
                                                    $vendor_calendar = @$checkplan->vendor_calendar;
                                                }
                                            @endphp
                                            @if ($vendor_calendar == 1)
                                                <div class="d-block mb-3">
                                                    <div class="row g-2">
                                                        <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                            <input class="form-check-input" type="checkbox"
                                                                value="role_calendar" name="modules[role_calendar]"
                                                                id="manage[role_calendar]">
                                                            <label class="form-check-label fs-13"
                                                                for="manage[role_calendar]">
                                                                {{ trans('labels.view') }}
                                                            </label>
                                                        </div>
                                                        <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                            <input class="form-check-input" type="checkbox"
                                                                value="role_calendar" name="add[role_calendar]"
                                                                id="add[role_calendar]">
                                                            <label class="form-check-label fs-13"
                                                                for="add[role_calendar]">
                                                                {{ trans('labels.add') }}
                                                            </label>
                                                        </div>
                                                        <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                            <input class="form-check-input" type="checkbox"
                                                                value="role_calendar" name="edit[role_calendar]"
                                                                id="edit[role_calendar]">
                                                            <label class="form-check-label fs-13"
                                                                for="edit[role_calendar]">
                                                                {{ trans('labels.edit') }}
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endif
                                    @else
                                        @if (@helper::checkaddons('vendor_calendar'))
                                            <div class="d-block mb-3">
                                                <div class="row g-2">
                                                    <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                        <input class="form-check-input" type="checkbox"
                                                            value="role_calendar" name="modules[role_calendar]"
                                                            id="manage[role_calendar]">
                                                        <label class="form-check-label fs-13"
                                                            for="manage[role_calendar]">
                                                            {{ trans('labels.view') }}
                                                        </label>
                                                    </div>
                                                    <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                        <input class="form-check-input" type="checkbox"
                                                            value="role_calendar" name="add[role_calendar]"
                                                            id="add[role_calendar]">
                                                        <label class="form-check-label fs-13" for="add[role_calendar]">
                                                            {{ trans('labels.add') }}
                                                        </label>
                                                    </div>
                                                    <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                        <input class="form-check-input" type="checkbox"
                                                            value="role_calendar" name="edit[role_calendar]"
                                                            id="edit[role_calendar]">
                                                        <label class="form-check-label fs-13" for="edit[role_calendar]">
                                                            {{ trans('labels.edit') }}
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endif
                                    @if (@helper::checkaddons('custom_status'))
                                        <div class="d-block mb-3">
                                            <div class="row g-2">
                                                <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                    <input class="form-check-input" type="checkbox"
                                                        value="role_custom_status" name="modules[role_custom_status]"
                                                        id="manage[role_custom_status]">
                                                    <label class="form-check-label fs-13"
                                                        for="manage[role_custom_status]">
                                                        {{ trans('labels.view') }}
                                                    </label>
                                                </div>
                                                <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                    <input class="form-check-input" type="checkbox"
                                                        value="role_custom_status" name="add[role_custom_status]"
                                                        id="add[role_custom_status]">
                                                    <label class="form-check-label fs-13" for="add[role_custom_status]">
                                                        {{ trans('labels.add') }}
                                                    </label>
                                                </div>
                                                <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                    <input class="form-check-input" type="checkbox"
                                                        value="role_custom_status" name="edit[role_custom_status]"
                                                        id="edit[role_custom_status]">
                                                    <label class="form-check-label fs-13"
                                                        for="edit[role_custom_status]">
                                                        {{ trans('labels.edit') }}
                                                    </label>
                                                </div>
                                                <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                    <input class="form-check-input" type="checkbox"
                                                        value="role_custom_status" name="delete[role_custom_status]"
                                                        id="delete[role_custom_status]">
                                                    <label class="form-check-label fs-13"
                                                        for="delete[role_custom_status]">
                                                        {{ trans('labels.delete') }}
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    @if (@helper::checkaddons('subscription'))
                                        @if (@helper::checkaddons('custom_domain'))
                                            @php
                                                $checkplan = App\Models\Transaction::where('vendor_id', $vendor_id)
                                                    ->orderByDesc('id')
                                                    ->first();
                                                if (@$user->allow_without_subscription == 1) {
                                                    $custom_domain = 1;
                                                } else {
                                                    $custom_domain = @$checkplan->custom_domain;
                                                }
                                            @endphp
                                            @if ($custom_domain == 1)
                                                <div class="d-block mb-3">
                                                    <div class="row g-2">
                                                        <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                            <input class="form-check-input" type="checkbox"
                                                                value="role_custom_domains"
                                                                name="modules[role_custom_domains]"
                                                                id="manage[role_custom_domains]">
                                                            <label class="form-check-label fs-13"
                                                                for="manage[role_custom_domains]">
                                                                {{ trans('labels.view') }}
                                                            </label>
                                                        </div>
                                                        <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                            <input class="form-check-input" type="checkbox"
                                                                value="role_custom_domains"
                                                                name="add[role_custom_domains]"
                                                                id="add[role_custom_domains]">
                                                            <label class="form-check-label fs-13"
                                                                for="add[role_custom_domains]">
                                                                {{ trans('labels.add') }}
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endif
                                    @else
                                        @if (@helper::checkaddons('custom_domain'))
                                            <div class="d-block mb-3">
                                                <div class="row g-2">
                                                    <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                        <input class="form-check-input" type="checkbox"
                                                            value="role_custom_domains"
                                                            name="modules[role_custom_domains]"
                                                            id="manage[role_custom_domains]">
                                                        <label class="form-check-label fs-13"
                                                            for="manage[role_custom_domains]">
                                                            {{ trans('labels.view') }}
                                                        </label>
                                                    </div>
                                                    <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                        <input class="form-check-input" type="checkbox"
                                                            value="role_custom_domains" name="add[role_custom_domains]"
                                                            id="add[role_custom_domains]">
                                                        <label class="form-check-label fs-13"
                                                            for="add[role_custom_domains]">
                                                            {{ trans('labels.add') }}
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endif
                                @endif
                                @if (Auth::user()->type == 1 || (Auth::user()->type == 4 && Auth::user()->vendor_id == 1))
                                    <div class="d-block mb-3">
                                        <div class="row g-2">
                                            <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                <input class="form-check-input" type="checkbox" value="role_countries"
                                                    name="modules[role_countries]" id="manage[role_countries]">
                                                <label class="form-check-label fs-13" for="manage[role_countries]">
                                                    {{ trans('labels.view') }}
                                                </label>
                                            </div>
                                            <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                <input class="form-check-input" type="checkbox" value="role_countries"
                                                    name="add[role_countries]" id="add[role_countries]">
                                                <label class="form-check-label fs-13" for="add[role_countries]">
                                                    {{ trans('labels.add') }}
                                                </label>
                                            </div>
                                            <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                <input class="form-check-input" type="checkbox" value="role_countries"
                                                    name="edit[role_countries]" id="edit[role_countries]">
                                                <label class="form-check-label fs-13" for="edit[role_countries]">
                                                    {{ trans('labels.edit') }}
                                                </label>
                                            </div>
                                            <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                <input class="form-check-input" type="checkbox" value="role_countries"
                                                    name="delete[role_countries]" id="delete[role_countries]">
                                                <label class="form-check-label fs-13" for="delete[role_countries]">
                                                    {{ trans('labels.delete') }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-block mb-3">
                                        <div class="row g-2">
                                            <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                <input class="form-check-input" type="checkbox" value="role_cities"
                                                    name="modules[role_cities]" id="manage[role_cities]">
                                                <label class="form-check-label fs-13" for="manage[role_cities]">
                                                    {{ trans('labels.view') }}
                                                </label>
                                            </div>
                                            <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                <input class="form-check-input" type="checkbox" value="role_cities"
                                                    name="add[role_cities]" id="add[role_cities]">
                                                <label class="form-check-label fs-13" for="add[role_cities]">
                                                    {{ trans('labels.add') }}
                                                </label>
                                            </div>
                                            <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                <input class="form-check-input" type="checkbox" value="role_cities"
                                                    name="edit[role_cities]" id="edit[role_cities]">
                                                <label class="form-check-label fs-13" for="edit[role_cities]">
                                                    {{ trans('labels.edit') }}
                                                </label>
                                            </div>
                                            <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                <input class="form-check-input" type="checkbox" value="role_cities"
                                                    name="delete[role_cities]" id="delete[role_cities]">
                                                <label class="form-check-label fs-13" for="delete[role_cities]">
                                                    {{ trans('labels.delete') }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    @if (@helper::checkaddons('custom_domain'))
                                        <div class="d-block mb-3">
                                            <div class="row g-2">
                                                <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                    <input class="form-check-input" type="checkbox"
                                                        value="role_custom_domains" name="modules[role_custom_domains]"
                                                        id="manage[role_custom_domains]">
                                                    <label class="form-check-label fs-13"
                                                        for="manage[role_custom_domains]">
                                                        {{ trans('labels.view') }}
                                                    </label>
                                                </div>
                                                <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                    <input class="form-check-input" type="checkbox"
                                                        value="role_custom_domains" name="add[role_custom_domains]"
                                                        id="add[role_custom_domains]">
                                                    <label class="form-check-label fs-13"
                                                        for="add[role_custom_domains]">
                                                        {{ trans('labels.add') }}
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="d-block mb-3">
                                        <div class="row g-2">
                                            <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                <input class="form-check-input" type="checkbox"
                                                    value="role_store_categories" name="modules[role_store_categories]"
                                                    id="manage[role_store_categories]">
                                                <label class="form-check-label fs-13"
                                                    for="manage[role_store_categories]">
                                                    {{ trans('labels.view') }}
                                                </label>
                                            </div>
                                            <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                <input class="form-check-input" type="checkbox"
                                                    value="role_store_categories" name="add[role_store_categories]"
                                                    id="add[role_store_categories]">
                                                <label class="form-check-label fs-13" for="add[role_store_categories]">
                                                    {{ trans('labels.add') }}
                                                </label>
                                            </div>
                                            <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                <input class="form-check-input" type="checkbox"
                                                    value="role_store_categories" name="edit[role_store_categories]"
                                                    id="edit[role_store_categories]">
                                                <label class="form-check-label fs-13" for="edit[role_store_categories]">
                                                    {{ trans('labels.edit') }}
                                                </label>
                                            </div>
                                            <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                <input class="form-check-input" type="checkbox"
                                                    value="role_store_categories" name="delete[role_store_categories]"
                                                    id="delete[role_store_categories]">
                                                <label class="form-check-label fs-13"
                                                    for="delete[role_store_categories]">
                                                    {{ trans('labels.delete') }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div class="d-block mb-3">
                                    <div class="row g-2">
                                        <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                            <input class="form-check-input" type="checkbox"
                                                value="role_basic_settings" name="modules[role_basic_settings]"
                                                id="manage[role_basic_settings]">
                                            <label class="form-check-label fs-13" for="manage[role_basic_settings]">
                                                {{ trans('labels.view') }}
                                            </label>
                                        </div>
                                        <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                            <input class="form-check-input" type="checkbox"
                                                value="role_basic_settings" name="edit[role_basic_settings]"
                                                id="edit[role_basic_settings]">
                                            <label class="form-check-label fs-13" for="edit[role_basic_settings]">
                                                {{ trans('labels.edit') }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                @if (Auth::user()->type == 1 || (Auth::user()->type == 4 && Auth::user()->vendor_id == 1))
                                    <div class="d-block mb-3">
                                        <div class="row g-2">
                                            <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                <input class="form-check-input" type="checkbox"
                                                    value="role_how_it_works" name="modules[role_how_it_works]"
                                                    id="manage[role_how_it_works]">
                                                <label class="form-check-label fs-13" for="manage[role_how_it_works]">
                                                    {{ trans('labels.view') }}
                                                </label>
                                            </div>
                                            <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                <input class="form-check-input" type="checkbox"
                                                    value="role_how_it_works" name="add[role_how_it_works]"
                                                    id="add[role_how_it_works]">
                                                <label class="form-check-label fs-13" for="add[role_how_it_works]">
                                                    {{ trans('labels.add') }}
                                                </label>
                                            </div>
                                            <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                <input class="form-check-input" type="checkbox"
                                                    value="role_how_it_works" name="edit[role_how_it_works]"
                                                    id="edit[role_how_it_works]">
                                                <label class="form-check-label fs-13" for="edit[role_how_it_works]">
                                                    {{ trans('labels.edit') }}
                                                </label>
                                            </div>
                                            <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                <input class="form-check-input" type="checkbox"
                                                    value="role_how_it_works" name="delete[role_how_it_works]"
                                                    id="delete[role_how_it_works]">
                                                <label class="form-check-label fs-13" for="delete[role_how_it_works]">
                                                    {{ trans('labels.delete') }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-block mb-3">
                                        <div class="row g-2">
                                            <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                <input class="form-check-input" type="checkbox"
                                                    value="role_theme_images" name="modules[role_theme_images]"
                                                    id="manage[role_theme_images]">
                                                <label class="form-check-label fs-13" for="manage[role_theme_images]">
                                                    {{ trans('labels.view') }}
                                                </label>
                                            </div>
                                            <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                <input class="form-check-input" type="checkbox"
                                                    value="role_theme_images" name="add[role_theme_images]"
                                                    id="add[role_theme_images]">
                                                <label class="form-check-label fs-13" for="add[role_theme_images]">
                                                    {{ trans('labels.add') }}
                                                </label>
                                            </div>
                                            <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                <input class="form-check-input" type="checkbox"
                                                    value="role_theme_images" name="edit[role_theme_images]"
                                                    id="edit[role_theme_images]">
                                                <label class="form-check-label fs-13" for="edit[role_theme_images]">
                                                    {{ trans('labels.edit') }}
                                                </label>
                                            </div>
                                            <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                <input class="form-check-input" type="checkbox"
                                                    value="role_theme_images" name="delete[role_theme_images]"
                                                    id="delete[role_theme_images]">
                                                <label class="form-check-label fs-13" for="delete[role_theme_images]">
                                                    {{ trans('labels.delete') }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-block mb-3">
                                        <div class="row g-2">
                                            <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                <input class="form-check-input" type="checkbox" value="role_features"
                                                    name="modules[role_features]" id="manage[role_features]">
                                                <label class="form-check-label fs-13" for="manage[role_features]">
                                                    {{ trans('labels.view') }}
                                                </label>
                                            </div>
                                            <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                <input class="form-check-input" type="checkbox" value="role_features"
                                                    name="add[role_features]" id="add[role_features]">
                                                <label class="form-check-label fs-13" for="add[role_features]">
                                                    {{ trans('labels.add') }}
                                                </label>
                                            </div>
                                            <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                <input class="form-check-input" type="checkbox" value="role_features"
                                                    name="edit[role_features]" id="edit[role_features]">
                                                <label class="form-check-label fs-13" for="edit[role_features]">
                                                    {{ trans('labels.edit') }}
                                                </label>
                                            </div>
                                            <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                <input class="form-check-input" type="checkbox" value="role_features"
                                                    name="delete[role_features]" id="delete[role_features]">
                                                <label class="form-check-label fs-13" for="delete[role_features]">
                                                    {{ trans('labels.delete') }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-block mb-3">
                                        <div class="row g-2">
                                            <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                <input class="form-check-input" type="checkbox"
                                                    value="role_promotional_banners"
                                                    name="modules[role_promotional_banners]"
                                                    id="manage[role_promotional_banners]">
                                                <label class="form-check-label fs-13"
                                                    for="manage[role_promotional_banners]">
                                                    {{ trans('labels.view') }}
                                                </label>
                                            </div>
                                            <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                <input class="form-check-input" type="checkbox"
                                                    value="role_promotional_banners"
                                                    name="add[role_promotional_banners]"
                                                    id="add[role_promotional_banners]">
                                                <label class="form-check-label fs-13"
                                                    for="add[role_promotional_banners]">
                                                    {{ trans('labels.add') }}
                                                </label>
                                            </div>
                                            <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                <input class="form-check-input" type="checkbox"
                                                    value="role_promotional_banners"
                                                    name="edit[role_promotional_banners]"
                                                    id="edit[role_promotional_banners]">
                                                <label class="form-check-label fs-13"
                                                    for="edit[role_promotional_banners]">
                                                    {{ trans('labels.edit') }}
                                                </label>
                                            </div>
                                            <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                <input class="form-check-input" type="checkbox"
                                                    value="role_promotional_banners"
                                                    name="delete[role_promotional_banners]"
                                                    id="delete[role_promotional_banners]">
                                                <label class="form-check-label fs-13"
                                                    for="delete[role_promotional_banners]">
                                                    {{ trans('labels.delete') }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    @if (@helper::checkaddons('blog'))
                                        <div class="d-block mb-3">
                                            <div class="row g-2">
                                                <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                    <input class="form-check-input" type="checkbox" value="role_blogs"
                                                        name="modules[role_blogs]" id="manage[role_blogs]">
                                                    <label class="form-check-label fs-13" for="manage[role_blogs]">
                                                        {{ trans('labels.view') }}
                                                    </label>
                                                </div>
                                                <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                    <input class="form-check-input" type="checkbox" value="role_blogs"
                                                        name="add[role_blogs]" id="add[role_blogs]">
                                                    <label class="form-check-label fs-13" for="add[role_blogs]">
                                                        {{ trans('labels.add') }}
                                                    </label>
                                                </div>
                                                <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                    <input class="form-check-input" type="checkbox" value="role_blogs"
                                                        name="edit[role_blogs]" id="edit[role_blogs]">
                                                    <label class="form-check-label fs-13" for="edit[role_blogs]">
                                                        {{ trans('labels.edit') }}
                                                    </label>
                                                </div>
                                                <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                    <input class="form-check-input" type="checkbox"
                                                        value="[role_blogs]" name="delete[role_blogs]"
                                                        id="delete[role_blogs]">
                                                    <label class="form-check-label fs-13" for="delete[role_blogs]">
                                                        {{ trans('labels.delete') }}
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endif
                                @if (Auth::user()->type == 2 || (Auth::user()->type == 4 && Auth::user()->vendor_id != 1))
                                    <div class="d-block mb-3">
                                        <div class="row g-2">
                                            <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                <input class="form-check-input" type="checkbox" value="role_choose_us"
                                                    name="modules[role_choose_us]" id="manage[role_choose_us]">
                                                <label class="form-check-label fs-13" for="manage[role_choose_us]">
                                                    {{ trans('labels.view') }}
                                                </label>
                                            </div>
                                            <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                <input class="form-check-input" type="checkbox" value="role_choose_us"
                                                    name="add[role_choose_us]" id="add[role_choose_us]">
                                                <label class="form-check-label fs-13" for="add[role_choose_us]">
                                                    {{ trans('labels.add') }}
                                                </label>
                                            </div>
                                            <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                <input class="form-check-input" type="checkbox" value="role_choose_us"
                                                    name="edit[role_choose_us]" id="edit[role_choose_us]">
                                                <label class="form-check-label fs-13" for="edit[role_choose_us]">
                                                    {{ trans('labels.edit') }}
                                                </label>
                                            </div>
                                            <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                <input class="form-check-input" type="checkbox" value="role_choose_us"
                                                    name="delete[role_choose_us]" id="delete[role_choose_us]">
                                                <label class="form-check-label fs-13" for="delete[role_choose_us]">
                                                    {{ trans('labels.delete') }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    @if (@helper::checkaddons('subscription'))
                                        @if (@helper::checkaddons('blog'))
                                            @php
                                                $checkplan = App\Models\Transaction::where('vendor_id', $vendor_id)
                                                    ->orderByDesc('id')
                                                    ->first();
                                                if (@$user->allow_without_subscription == 1) {
                                                    $blogs = 1;
                                                } else {
                                                    $blogs = @$checkplan->blogs;
                                                }
                                            @endphp
                                            @if ($blogs == 1)
                                                <div class="d-block mb-3">
                                                    <div class="row g-2">
                                                        <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                            <input class="form-check-input" type="checkbox"
                                                                value="role_blogs" name="modules[role_blogs]"
                                                                id="manage[role_blogs]">
                                                            <label class="form-check-label fs-13"
                                                                for="manage[role_blogs]">
                                                                {{ trans('labels.view') }}
                                                            </label>
                                                        </div>
                                                        <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                            <input class="form-check-input" type="checkbox"
                                                                value="role_blogs" name="add[role_blogs]"
                                                                id="add[role_blogs]">
                                                            <label class="form-check-label fs-13" for="add[role_blogs]">
                                                                {{ trans('labels.add') }}
                                                            </label>
                                                        </div>
                                                        <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                            <input class="form-check-input" type="checkbox"
                                                                value="role_blogs" name="edit[role_blogs]"
                                                                id="edit[role_blogs]">
                                                            <label class="form-check-label fs-13"
                                                                for="edit[role_blogs]">
                                                                {{ trans('labels.edit') }}
                                                            </label>
                                                        </div>
                                                        <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                            <input class="form-check-input" type="checkbox"
                                                                value="role_blogs" name="delete[role_blogs]"
                                                                id="delete[role_blogs]">
                                                            <label class="form-check-label fs-13"
                                                                for="delete[role_blogs]">
                                                                {{ trans('labels.delete') }}
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endif
                                    @else
                                        @if (@helper::checkaddons('blog'))
                                            <div class="d-block mb-3">
                                                <div class="row g-2">
                                                    <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                        <input class="form-check-input" type="checkbox"
                                                            value="role_blogs" name="modules[role_blogs]"
                                                            id="manage[role_blogs]">
                                                        <label class="form-check-label fs-13" for="manage[role_blogs]">
                                                            {{ trans('labels.view') }}
                                                        </label>
                                                    </div>
                                                    <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                        <input class="form-check-input" type="checkbox"
                                                            value="role_blogs" name="add[role_blogs]"
                                                            id="add[role_blogs]">
                                                        <label class="form-check-label fs-13" for="add[role_blogs]">
                                                            {{ trans('labels.add') }}
                                                        </label>
                                                    </div>
                                                    <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                        <input class="form-check-input" type="checkbox"
                                                            value="role_blogs" name="edit[role_blogs]"
                                                            id="edit[role_blogs]">
                                                        <label class="form-check-label fs-13" for="edit[role_blogs]">
                                                            {{ trans('labels.edit') }}
                                                        </label>
                                                    </div>
                                                    <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                        <input class="form-check-input" type="checkbox"
                                                            value="[role_blogs]" name="delete[role_blogs]"
                                                            id="delete[role_blogs]">
                                                        <label class="form-check-label fs-13" for="delete[role_blogs]">
                                                            {{ trans('labels.delete') }}
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endif
                                @endif
                                <div class="d-block mb-3">
                                    <div class="row g-2">
                                        <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                            <input class="form-check-input" type="checkbox" value="role_faqs"
                                                name="modules[role_faqs]" id="manage[role_faqs]">
                                            <label class="form-check-label fs-13" for="manage[role_faqs]">
                                                {{ trans('labels.view') }}
                                            </label>
                                        </div>
                                        <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                            <input class="form-check-input" type="checkbox" value="role_faqs"
                                                name="add[role_faqs]" id="add[role_faqs]">
                                            <label class="form-check-label fs-13" for="add[role_faqs]">
                                                {{ trans('labels.add') }}
                                            </label>
                                        </div>
                                        <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                            <input class="form-check-input" type="checkbox" value="role_faqs"
                                                name="edit[role_faqs]" id="edit[role_faqs]">
                                            <label class="form-check-label fs-13" for="edit[role_faqs]">
                                                {{ trans('labels.edit') }}
                                            </label>
                                        </div>
                                        <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                            <input class="form-check-input" type="checkbox" value="role_faqs"
                                                name="delete[role_faqs]" id="delete[role_faqs]">
                                            <label class="form-check-label fs-13" for="delete[role_faqs]">
                                                {{ trans('labels.delete') }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-block mb-3">
                                    <div class="row g-2">
                                        <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                            <input class="form-check-input" type="checkbox" value="role_testimonials"
                                                name="modules[role_testimonials]" id="manage[role_testimonials]">
                                            <label class="form-check-label fs-13" for="manage[role_testimonials]">
                                                {{ trans('labels.view') }}
                                            </label>
                                        </div>
                                        <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                            <input class="form-check-input" type="checkbox" value="role_testimonials"
                                                name="add[role_testimonials]" id="add[role_testimonials]">
                                            <label class="form-check-label fs-13" for="add[role_testimonials]">
                                                {{ trans('labels.add') }}
                                            </label>
                                        </div>
                                        <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                            <input class="form-check-input" type="checkbox" value="role_testimonials"
                                                name="edit[role_testimonials]" id="edit[role_testimonials]">
                                            <label class="form-check-label fs-13" for="edit[role_testimonials]">
                                                {{ trans('labels.edit') }}
                                            </label>
                                        </div>
                                        <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                            <input class="form-check-input" type="checkbox" value="role_testimonials"
                                                name="delete[role_testimonials]" id="delete[role_testimonials]">
                                            <label class="form-check-label fs-13" for="delete[role_testimonials]">
                                                {{ trans('labels.delete') }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                @if (Auth::user()->type == 2 || (Auth::user()->type == 4 && Auth::user()->vendor_id != 1))
                                    <div class="d-block mb-3">
                                        <div class="row g-2">
                                            <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                <input class="form-check-input" type="checkbox" value="role_gallery"
                                                    name="modules[role_gallery]" id="manage[role_gallery]">
                                                <label class="form-check-label fs-13" for="manage[role_gallery]">
                                                    {{ trans('labels.view') }}
                                                </label>
                                            </div>
                                            <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                <input class="form-check-input" type="checkbox" value="role_gallery"
                                                    name="add[role_gallery]" id="add[role_gallery]">
                                                <label class="form-check-label fs-13" for="add[role_gallery]">
                                                    {{ trans('labels.add') }}
                                                </label>
                                            </div>
                                            <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                <input class="form-check-input" type="checkbox" value="role_gallery"
                                                    name="edit[role_gallery]" id="edit[role_gallery]">
                                                <label class="form-check-label fs-13" for="edit[role_gallery]">
                                                    {{ trans('labels.edit') }}
                                                </label>
                                            </div>
                                            <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                <input class="form-check-input" type="checkbox" value="role_gallery"
                                                    name="delete[role_gallery]" id="delete[role_gallery]">
                                                <label class="form-check-label fs-13" for="delete[role_gallery]">
                                                    {{ trans('labels.delete') }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div class="d-block mb-3">
                                    <div class="row g-2">
                                        <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                            <input class="form-check-input" type="checkbox" value="role_cms_pages"
                                                name="modules[role_cms_pages]" id="manage[role_cms_pages]">
                                            <label class="form-check-label fs-13" for="manage[role_cms_pages]">
                                                {{ trans('labels.view') }}
                                            </label>
                                        </div>
                                        <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                            <input class="form-check-input" type="checkbox" value="role_cms_pages"
                                                name="edit[role_cms_pages]" id="edit[role_cms_pages]">
                                            <label class="form-check-label fs-13" for="edit[role_cms_pages]">
                                                {{ trans('labels.edit') }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                @if (Auth::user()->type == 1 || (Auth::user()->type == 4 && Auth::user()->vendor_id == 1))
                                    @if (@helper::checkaddons('coupon'))
                                        <div class="d-block mb-3">
                                            <div class="row g-2">
                                                <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                    <input class="form-check-input" type="checkbox"
                                                        value="role_coupons" name="modules[role_coupons]"
                                                        id="manage[role_coupons]">
                                                    <label class="form-check-label fs-13" for="manage[role_coupons]">
                                                        {{ trans('labels.view') }}
                                                    </label>
                                                </div>
                                                <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                    <input class="form-check-input" type="checkbox"
                                                        value="role_coupons" name="add[role_coupons]"
                                                        id="add[role_coupons]">
                                                    <label class="form-check-label fs-13" for="add[role_coupons]">
                                                        {{ trans('labels.add') }}
                                                    </label>
                                                </div>
                                                <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                    <input class="form-check-input" type="checkbox"
                                                        value="role_coupons" name="edit[role_coupons]"
                                                        id="edit[role_coupons]">
                                                    <label class="form-check-label fs-13" for="edit[role_coupons]">
                                                        {{ trans('labels.edit') }}
                                                    </label>
                                                </div>
                                                <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                    <input class="form-check-input" type="checkbox"
                                                        value="role_coupons" name="delete[role_coupons]"
                                                        id="delete[role_coupons]">
                                                    <label class="form-check-label fs-13" for="delete[role_coupons]">
                                                        {{ trans('labels.delete') }}
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    @if (@helper::checkaddons('employee'))
                                        <div class="d-block mb-3">
                                            <div class="row g-2">
                                                <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                    <input class="form-check-input" type="checkbox" value="role_roles"
                                                        name="modules[role_roles]" id="manage[role_roles]">
                                                    <label class="form-check-label fs-13" for="manage[role_roles]">
                                                        {{ trans('labels.view') }}
                                                    </label>
                                                </div>
                                                <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                    <input class="form-check-input" type="checkbox" value="role_roles"
                                                        name="add[role_roles]" id="add[role_roles]">
                                                    <label class="form-check-label fs-13" for="add[role_roles]">
                                                        {{ trans('labels.add') }}
                                                    </label>
                                                </div>
                                                <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                    <input class="form-check-input" type="checkbox" value="role_roles"
                                                        name="edit[role_roles]" id="edit[role_roles]">
                                                    <label class="form-check-label fs-13" for="edit[role_roles]">
                                                        {{ trans('labels.edit') }}
                                                    </label>
                                                </div>
                                                <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                    <input class="form-check-input" type="checkbox" value="role_roles"
                                                        name="delete[role_roles]" id="delete[role_roles]">
                                                    <label class="form-check-label fs-13" for="delete[role_roles]">
                                                        {{ trans('labels.delete') }}
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-block mb-3">
                                            <div class="row g-2">
                                                <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                    <input class="form-check-input" type="checkbox"
                                                        value="role_employees" name="modules[role_employees]"
                                                        id="manage[role_employees]">
                                                    <label class="form-check-label fs-13" for="manage[role_employees]">
                                                        {{ trans('labels.view') }}
                                                    </label>
                                                </div>
                                                <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                    <input class="form-check-input" type="checkbox"
                                                        value="role_employees" name="add[role_employees]"
                                                        id="add[role_employees]">
                                                    <label class="form-check-label fs-13" for="add[role_employees]">
                                                        {{ trans('labels.add') }}
                                                    </label>
                                                </div>
                                                <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                    <input class="form-check-input" type="checkbox"
                                                        value="role_employees" name="edit[role_employees]"
                                                        id="edit[role_employees]">
                                                    <label class="form-check-label fs-13" for="edit[role_employees]">
                                                        {{ trans('labels.edit') }}
                                                    </label>
                                                </div>
                                                <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                    <input class="form-check-input" type="checkbox"
                                                        value="role_employees" name="delete[role_employees]"
                                                        id="delete[role_employees]">
                                                    <label class="form-check-label fs-13" for="delete[role_employees]">
                                                        {{ trans('labels.delete') }}
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endif

                                @if (Auth::user()->type == 2 || (Auth::user()->type == 4 && Auth::user()->vendor_id != 1))
                                    @if (@helper::checkaddons('subscription'))
                                        @if (@helper::checkaddons('employee'))
                                            @php
                                                $checkplan = App\Models\Transaction::where('vendor_id', $vendor_id)
                                                    ->orderByDesc('id')
                                                    ->first();
                                                if (@$user->allow_without_subscription == 1) {
                                                    $employee = 1;
                                                } else {
                                                    $employee = @$checkplan->employee;
                                                }
                                            @endphp
                                            @if ($employee == 1)
                                                <div class="d-block mb-3">
                                                    <div class="row g-2">
                                                        <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                            <input class="form-check-input" type="checkbox"
                                                                value="role_roles" name="modules[role_roles]"
                                                                id="manage[role_roles]">
                                                            <label class="form-check-label fs-13"
                                                                for="manage[role_roles]">
                                                                {{ trans('labels.view') }}
                                                            </label>
                                                        </div>
                                                        <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                            <input class="form-check-input" type="checkbox"
                                                                value="role_roles" name="add[role_roles]"
                                                                id="add[role_roles]">
                                                            <label class="form-check-label fs-13" for="add[role_roles]">
                                                                {{ trans('labels.add') }}
                                                            </label>
                                                        </div>
                                                        <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                            <input class="form-check-input" type="checkbox"
                                                                value="role_roles" name="edit[role_roles]"
                                                                id="edit[role_roles]">
                                                            <label class="form-check-label fs-13"
                                                                for="edit[role_roles]">
                                                                {{ trans('labels.edit') }}
                                                            </label>
                                                        </div>
                                                        <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                            <input class="form-check-input" type="checkbox"
                                                                value="role_roles" name="delete[role_roles]"
                                                                id="delete[role_roles]">
                                                            <label class="form-check-label fs-13"
                                                                for="delete[role_roles]">
                                                                {{ trans('labels.delete') }}
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="d-block mb-3">
                                                    <div class="row g-2">
                                                        <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                            <input class="form-check-input" type="checkbox"
                                                                value="role_employees" name="modules[role_employees]"
                                                                id="manage[role_employees]">
                                                            <label class="form-check-label fs-13"
                                                                for="manage[role_employees]">
                                                                {{ trans('labels.view') }}
                                                            </label>
                                                        </div>
                                                        <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                            <input class="form-check-input" type="checkbox"
                                                                value="role_employees" name="add[role_employees]"
                                                                id="add[role_employees]">
                                                            <label class="form-check-label fs-13"
                                                                for="add[role_employees]">
                                                                {{ trans('labels.add') }}
                                                            </label>
                                                        </div>
                                                        <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                            <input class="form-check-input" type="checkbox"
                                                                value="role_employees" name="edit[role_employees]"
                                                                id="edit[role_employees]">
                                                            <label class="form-check-label fs-13"
                                                                for="edit[role_employees]">
                                                                {{ trans('labels.edit') }}
                                                            </label>
                                                        </div>
                                                        <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                            <input class="form-check-input" type="checkbox"
                                                                value="role_employees" name="delete[role_employees]"
                                                                id="delete[role_employees]">
                                                            <label class="form-check-label fs-13"
                                                                for="delete[role_employees]">
                                                                {{ trans('labels.delete') }}
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endif
                                    @else
                                        @if (@helper::checkaddons('employee'))
                                            <div class="d-block mb-3">
                                                <div class="row g-2">
                                                    <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                        <input class="form-check-input" type="checkbox"
                                                            value="role_roles" name="modules[role_roles]"
                                                            id="manage[role_roles]">
                                                        <label class="form-check-label fs-13" for="manage[role_roles]">
                                                            {{ trans('labels.view') }}
                                                        </label>
                                                    </div>
                                                    <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                        <input class="form-check-input" type="checkbox"
                                                            value="role_roles" name="add[role_roles]"
                                                            id="add[role_roles]">
                                                        <label class="form-check-label fs-13" for="add[role_roles]">
                                                            {{ trans('labels.add') }}
                                                        </label>
                                                    </div>
                                                    <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                        <input class="form-check-input" type="checkbox"
                                                            value="role_roles" name="edit[role_roles]"
                                                            id="edit[role_roles]">
                                                        <label class="form-check-label fs-13" for="edit[role_roles]">
                                                            {{ trans('labels.edit') }}
                                                        </label>
                                                    </div>
                                                    <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                        <input class="form-check-input" type="checkbox"
                                                            value="role_roles" name="delete[role_roles]"
                                                            id="delete[role_roles]">
                                                        <label class="form-check-label fs-13" for="delete[role_roles]">
                                                            {{ trans('labels.delete') }}
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-block mb-3">
                                                <div class="row g-2">
                                                    <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                        <input class="form-check-input" type="checkbox"
                                                            value="role_employees" name="modules[role_employees]"
                                                            id="manage[role_employees]">
                                                        <label class="form-check-label fs-13"
                                                            for="manage[role_employees]">
                                                            {{ trans('labels.view') }}
                                                        </label>
                                                    </div>
                                                    <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                        <input class="form-check-input" type="checkbox"
                                                            value="role_employees" name="add[role_employees]"
                                                            id="add[role_employees]">
                                                        <label class="form-check-label fs-13" for="add[role_employees]">
                                                            {{ trans('labels.add') }}
                                                        </label>
                                                    </div>
                                                    <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                        <input class="form-check-input" type="checkbox"
                                                            value="role_employees" name="edit[role_employees]"
                                                            id="edit[role_employees]">
                                                        <label class="form-check-label fs-13"
                                                            for="edit[role_employees]">
                                                            {{ trans('labels.edit') }}
                                                        </label>
                                                    </div>
                                                    <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                        <input class="form-check-input" type="checkbox"
                                                            value="role_employees" name="delete[role_employees]"
                                                            id="delete[role_employees]">
                                                        <label class="form-check-label fs-13"
                                                            for="delete[role_employees]">
                                                            {{ trans('labels.delete') }}
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endif
                                @endif
                                <div class="d-block mb-3">
                                    <div class="row g-2">
                                        <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                            <input class="form-check-input" type="checkbox" value="role_subscribers"
                                                name="modules[role_subscribers]" id="manage[role_subscribers]">
                                            <label class="form-check-label fs-13" for="manage[role_subscribers]">
                                                {{ trans('labels.view') }}
                                            </label>
                                        </div>
                                        <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                            <input class="form-check-input" type="checkbox" value="role_subscribers"
                                                name="delete[role_subscribers]" id="delete[role_subscribers]">
                                            <label class="form-check-label fs-13" for="delete[role_subscribers]">
                                                {{ trans('labels.delete') }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-block mb-3">
                                    <div class="row g-2">
                                        <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                            <input class="form-check-input" type="checkbox" value="role_inquiries"
                                                name="modules[role_inquiries]" id="manage[role_inquiries]">
                                            <label class="form-check-label fs-13" for="manage[role_inquiries]">
                                                {{ trans('labels.view') }}
                                            </label>
                                        </div>
                                        <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                            <input class="form-check-input" type="checkbox" value="role_inquiries"
                                                name="delete[role_inquiries]" id="delete[role_inquiries]">
                                            <label class="form-check-label fs-13" for="delete[role_inquiries]">
                                                {{ trans('labels.delete') }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                @if (Auth::user()->type == 2 || (Auth::user()->type == 4 && Auth::user()->vendor_id != 1))
                                    <div class="d-block mb-3">
                                        <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                            <input class="form-check-input" type="checkbox" value="role_share"
                                                name="modules[role_share]" id="manage[role_share]">
                                            <label class="form-check-label fs-13" for="manage[role_share]">
                                                {{ trans('labels.view') }}
                                            </label>
                                        </div>
                                    </div>
                                    @if (@helper::checkaddons('subscription'))
                                        @if (@helper::checkaddons('whatsapp_message'))
                                            @php
                                                $checkplan = App\Models\Transaction::where('vendor_id', $vendor_id)
                                                    ->orderByDesc('id')
                                                    ->first();

                                                if (@$user->allow_without_subscription == 1) {
                                                    $whatsapp_message = 1;
                                                } else {
                                                    $whatsapp_message = @$checkplan->whatsapp_message;
                                                }
                                            @endphp
                                            @if ($whatsapp_message == 1)
                                                <div class="d-block mb-3">
                                                    <div class="row g-2">
                                                        <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                            <input class="form-check-input" type="checkbox"
                                                                value="role_whatsapp_settings"
                                                                name="modules[role_whatsapp_settings]"
                                                                id="manage[role_whatsapp_settings]">
                                                            <label class="form-check-label fs-13"
                                                                for="manage[role_whatsapp_settings]">
                                                                {{ trans('labels.view') }}
                                                            </label>
                                                        </div>
                                                        <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                            <input class="form-check-input" type="checkbox"
                                                                value="role_whatsapp_settings"
                                                                name="edit[role_whatsapp_settings]"
                                                                id="edit[role_whatsapp_settings]">
                                                            <label class="form-check-label fs-13"
                                                                for="edit[role_whatsapp_settings]">
                                                                {{ trans('labels.edit') }}
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endif
                                    @else
                                        @if (@helper::checkaddons('whatsapp_message'))
                                            <div class="d-block mb-3">
                                                <div class="row g-2">
                                                    <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                        <input class="form-check-input" type="checkbox"
                                                            value="role_whatsapp_settings"
                                                            name="modules[role_whatsapp_settings]"
                                                            id="manage[role_whatsapp_settings]">
                                                        <label class="form-check-label fs-13"
                                                            for="manage[role_whatsapp_settings]">
                                                            {{ trans('labels.view') }}
                                                        </label>
                                                    </div>
                                                    <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                        <input class="form-check-input" type="checkbox"
                                                            value="role_whatsapp_settings"
                                                            name="edit[role_whatsapp_settings]"
                                                            id="edit[role_whatsapp_settings]">
                                                        <label class="form-check-label fs-13"
                                                            for="edit[role_whatsapp_settings]">
                                                            {{ trans('labels.edit') }}
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endif
                                    @if (@helper::checkaddons('subscription'))
                                        @if (@helper::checkaddons('telegram_message'))
                                            @php
                                                $checkplan = App\Models\Transaction::where('vendor_id', $vendor_id)
                                                    ->orderByDesc('id')
                                                    ->first();

                                                if (@$user->allow_without_subscription == 1) {
                                                    $telegram_message = 1;
                                                } else {
                                                    $telegram_message = @$checkplan->telegram_message;
                                                }
                                            @endphp
                                            @if ($telegram_message == 1)
                                                <div class="d-block mb-3">
                                                    <div class="row g-2">
                                                        <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                            <input class="form-check-input" type="checkbox"
                                                                value="role_telegram_settings"
                                                                name="modules[role_telegram_settings]"
                                                                id="manage[role_telegram_settings]">
                                                            <label class="form-check-label fs-13"
                                                                for="manage[role_telegram_settings]">
                                                                {{ trans('labels.view') }}
                                                            </label>
                                                        </div>
                                                        <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                            <input class="form-check-input" type="checkbox"
                                                                value="role_telegram_settings"
                                                                name="edit[role_telegram_settings]"
                                                                id="edit[role_telegram_settings]">
                                                            <label class="form-check-label fs-13"
                                                                for="edit[role_telegram_settings]">
                                                                {{ trans('labels.edit') }}
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endif
                                    @else
                                        @if (@helper::checkaddons('telegram_message'))
                                            <div class="d-block mb-3">
                                                <div class="row g-2">
                                                    <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                        <input class="form-check-input" type="checkbox"
                                                            value="role_telegram_settings"
                                                            name="modules[role_telegram_settings]"
                                                            id="manage[role_telegram_settings]">
                                                        <label class="form-check-label fs-13"
                                                            for="manage[role_telegram_settings]">
                                                            {{ trans('labels.view') }}
                                                        </label>
                                                    </div>
                                                    <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                        <input class="form-check-input" type="checkbox"
                                                            value="role_telegram_settings"
                                                            name="edit[role_telegram_settings]"
                                                            id="edit[role_telegram_settings]">
                                                        <label class="form-check-label fs-13"
                                                            for="edit[role_telegram_settings]">
                                                            {{ trans('labels.edit') }}
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endif
                                @endif
                                <div class="d-block mb-3">
                                    <div class="row g-2">
                                        <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                            <input class="form-check-input" type="checkbox"
                                                value="role_language_settings" name="modules[role_language_settings]"
                                                id="manage[role_language_settings]">
                                            <label class="form-check-label fs-13" for="manage[role_language_settings]">
                                                {{ trans('labels.view') }}
                                            </label>
                                        </div>
                                        @if (Auth::user()->type == 1 || (Auth::user()->type == 4 && Auth::user()->vendor_id == 1))
                                            <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                <input class="form-check-input" type="checkbox"
                                                    value="role_language_settings" name="add[role_language_settings]"
                                                    id="add[role_language_settings]">
                                                <label class="form-check-label fs-13" for="add[role_language_settings]">
                                                    {{ trans('labels.add') }}
                                                </label>
                                            </div>
                                        @endif
                                        <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                            <input class="form-check-input" type="checkbox"
                                                value="role_language_settings" name="edit[role_language_settings]"
                                                id="edit[role_language_settings]">
                                            <label class="form-check-label fs-13" for="edit[role_language_settings]">
                                                {{ trans('labels.edit') }}
                                            </label>
                                        </div>
                                        @if (Auth::user()->type == 1 || (Auth::user()->type == 4 && Auth::user()->vendor_id == 1))
                                            <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                <input class="form-check-input" type="checkbox"
                                                    value="role_language_settings" name="delete[role_language_settings]"
                                                    id="delete[role_language_settings]">
                                                <label class="form-check-label fs-13"
                                                    for="delete[role_language_settings]">
                                                    {{ trans('labels.delete') }}
                                                </label>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="d-block mb-3">
                                    <div class="row g-2">
                                        <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                            <input class="form-check-input" type="checkbox"
                                                value="role_currency_settings" name="modules[role_currency_settings]"
                                                id="manage[role_currency_settings]">
                                            <label class="form-check-label fs-13" for="manage[role_currency_settings]">
                                                {{ trans('labels.view') }}
                                            </label>
                                        </div>
                                        @if (Auth::user()->type == 1 || (Auth::user()->type == 4 && Auth::user()->vendor_id == 1))
                                            <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                <input class="form-check-input" type="checkbox"
                                                    value="role_currency_settings" name="add[role_currency_settings]"
                                                    id="add[role_currency_settings]">
                                                <label class="form-check-label fs-13" for="add[role_currency_settings]">
                                                    {{ trans('labels.add') }}
                                                </label>
                                            </div>
                                        @endif
                                        <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                            <input class="form-check-input" type="checkbox"
                                                value="role_currency_settings" name="edit[role_currency_settings]"
                                                id="edit[role_currency_settings]">
                                            <label class="form-check-label fs-13" for="edit[role_currency_settings]">
                                                {{ trans('labels.edit') }}
                                            </label>
                                        </div>
                                        @if (Auth::user()->type == 1 || (Auth::user()->type == 4 && Auth::user()->vendor_id == 1))
                                            <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                                <input class="form-check-input" type="checkbox"
                                                    value="role_currency_settings" name="delete[role_currency_settings]"
                                                    id="delete[role_currency_settings]">
                                                <label class="form-check-label fs-13"
                                                    for="delete[role_currency_settings]">
                                                    {{ trans('labels.delete') }}
                                                </label>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="d-block mb-3">
                                    <div class="row g-2">
                                        <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                            <input class="form-check-input" type="checkbox"
                                                value="role_general_settings" name="modules[role_general_settings]"
                                                id="manage[role_general_settings]">
                                            <label class="form-check-label fs-13" for="manage[role_general_settings]">
                                                {{ trans('labels.view') }}
                                            </label>
                                        </div>
                                        <div class="col-xl-2 col-lg-3 col-md-3 col-6">
                                            <input class="form-check-input" type="checkbox"
                                                value="role_general_settings" name="edit[role_general_settings]"
                                                id="edit[role_general_settings]">
                                            <label class="form-check-label fs-13" for="edit[role_general_settings]">
                                                {{ trans('labels.edit') }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @error('modules')
                                <br><span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group text-{{ session()->get('direction') == '2' ? 'start' : 'end' }} m-0">
                            <a href="{{ URL::to('admin/roles') }}"
                                class="btn btn-danger px-sm-4">{{ trans('labels.cancel') }}</a>
                            <button
                                class="btn btn-primary px-sm-4 {{ Auth::user()->type == 4 ? (helper::check_access('role_roles', Auth::user()->role_id, $vendor_id, 'add') == 1 ? '' : 'd-none') : '' }}"
                                @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif>{{ trans('labels.save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $('#checkall').on('click', function() {
            "use strict";
            var checked = $(this).prop('checked');
            $('input:checkbox').prop('checked', checked);
        }).change();
        $('#checkboxes input:checkbox').on('click', function() {
            var checked = $(this).prop('checked');
            var manageid = "manage[" + this.id + "]";
            var addid = "add[" + this.id + "]";
            var editid = "edit[" + this.id + "]";
            var deleteid = "delete[" + this.id + "]";
            $("[id='" + manageid + "']").prop('checked', checked);
            $("[id='" + addid + "']").prop('checked', checked);
            $("[id='" + editid + "']").prop('checked', checked);
            $("[id='" + deleteid + "']").prop('checked', checked);
        });
        $('#permissioncheckbox input:checkbox').on('click', function() {
            var checked = $(this).prop('checked');
            var value = $(this).val();
            var manageid = "manage[" + $(this).val() + "]";
            var addid = "add[" + $(this).val() + "]";
            var editid = "edit[" + $(this).val() + "]";
            var deleteid = "delete[" + $(this).val() + "]";
            if ($("[id='" + addid + "']").prop('checked') == true || $("[id='" + editid + "']").prop('checked') ==
                true || $("[id='" + deleteid + "']").prop('checked') == true) {
                $("[id='" + manageid + "']").prop('checked', true);
            }
        });
    </script>
@endsection
