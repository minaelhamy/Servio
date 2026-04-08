<section class="footer-section bg-dark pt-5 d-lg-block d-none">
    @if (count(helper::footer_features(@$vendordata->id)) > 0)
    @endif
    <div class="container">
        <div class="row justify-content-between py-md-4">

            <div class="col-lg-3 mb-4 mb-lg-0">
            <script>
                document.addEventListener("DOMContentLoaded", function(event) {
                    if (localStorage.getItem('theme') === 'dark') {
                        var logo = "{{ helper::image_path(helper::appdata($vendordata->id)->logo) }}";
                    } else {
                        var logo = "{{ helper::image_path(helper::appdata($vendordata->id)->darklogo) }}";
                    }
                    $('#footerlogoimage').attr('src', logo);
                });
            </script>
                <a href="{{ URL::to($vendordata->slug) }}" class="d-flex align-items-center">
                    <img src="" class="logoimage" alt="" id="footerlogoimage">
                </a>
                <small
                    class="d-block mt-3 footer-description">{{ Str::limit(helper::appdata($vendordata->id)->footer_description, 200) }}</small>
            </div>
            <div class="col-xl-7 col-lg-8">
                <div class="row justify-content-between links">
                    <div class="col-md-4 col-lg-4 col-xl-4 col-6 mb-4 mb-sm-0">
                        <h5 class="text-white mb-2 mb-md-4 fw-bold">{{ trans('labels.pages') }}</h5>
                        <ul class="footer-text">
                            <li class="py-1"><a
                                    href="{{ URL::to($vendordata->slug . '/aboutus') }}">{{ trans('labels.about_us') }}</a>
                            </li>
                            <li class="py-1">
                                <a
                                    href="{{ URL::to($vendordata->slug . '/contact') }}">{{ trans('labels.help_contact') }}</a>
                            </li>
                            <li class="py-1">
                                <a
                                    href="{{ URL::to($vendordata->slug . '/termscondition') }}">{{ trans('labels.terms_condition') }}</a>
                            </li>
                            <li class="py-1">
                                <a
                                    href="{{ URL::to($vendordata->slug . '/privacypolicy') }}">{{ trans('labels.privacy_policy') }}</a>
                            </li>
                            <li class="py-1">
                                <a
                                    href="{{ URL::to($vendordata->slug . '/refund_policy') }}">{{ trans('labels.refund_policy') }}</a>
                            </li>

                        </ul>
                    </div>
                    <div class="col-md-3 col-lg-3 col-xl-3 col-6 mb-4 mb-sm-0">
                        <h5 class="text-white mb-2 mb-md-4 fw-bold">{{ trans('labels.link') }}</h5>
                        <ul class="footer-text">
                            <li class="py-1">
                                <a href="{{ URL::to($vendordata->slug . '/faq') }}">{{ trans('labels.faqs') }}</a>
                            </li>
                            <li class="py-1">
                                <a
                                    href="{{ URL::to($vendordata->slug . '/services') }}">{{ trans('labels.services') }}</a>
                            </li>
                            <li class="py-1">
                                <a
                                    href="{{ URL::to($vendordata->slug . '/categories') }}">{{ trans('labels.categories') }}</a>
                            </li>
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
                                        <li class="py-1">
                                            <a
                                                href="{{ URL::to($vendordata->slug . '/allblogs') }}">{{ trans('labels.blog') }}</a>
                                        </li>
                                    @endif
                                @endif
                            @else
                                @if (@helper::checkaddons('blog'))
                                    <li class="py-1">
                                        <a
                                            href="{{ URL::to($vendordata->slug . '/allblogs') }}">{{ trans('labels.blog') }}</a>
                                    </li>
                                @endif
                            @endif

                            <li class="py-1">
                                <a
                                    href="{{ URL::to($vendordata->slug . '/gallery') }}">{{ trans('labels.gallery') }}</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-5 col-lg-5 col-xl-5 col-12 mb-4 mb-sm-0">
                        <h5 class="text-white mb-2 mb-md-4 fw-bold">{{ trans('labels.contact_us') }}</h5>
                        <ul class="footer-text">
                            <li class="py-1"><a href="tel:{{ helper::appdata($vendordata->id)->contact }}">
                                    <i
                                        class="fa-light fa-phone {{ session()->get('direction') == 2 ? 'ms-2' : 'me-2' }}"></i>
                                    {{ helper::appdata($vendordata->id)->contact }}</a>
                            </li>
                            <li class="py-1"><a href="mailto:{{ helper::appdata($vendordata->id)->email }}">
                                    <i
                                        class="fa-regular fa-envelope {{ session()->get('direction') == 2 ? 'ms-2' : 'me-2' }}"></i>{{ helper::appdata($vendordata->id)->email }}</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        {{-- --------------------------------------- Payment card and Social media icon --------------------------------------- --}}
        <div class="row g-4 align-items-end justify-content-between mt-0 mt-md-4">
            <!-- Payment card -->
            <div class="col-sm-7 col-md-6 col-lg-4">
                <h5 class="mb-2 text-white fw-bold">{{ trans('labels.payment') }} &amp;
                    {{ trans('labels.security') }}</h5>
                @php
                    $paymentlist = helper::paymentlist($vendordata->id);
                @endphp
                <ul class="list-inline mb-0 mt-3 d-flex flex-wrap gap-2">
                    @foreach ($paymentlist as $payment)
                        <li class="list-inline-item m-0"><img src="{{ helper::image_path($payment->image) }}"
                                class="h-30px rounded border" alt=""></li>
                    @endforeach
                </ul>
            </div>

            <!-- Social media icon -->
            @if (helper::getsociallinks($vendordata->id)->count() > 0)
                <div
                    class="col-sm-5 col-md-6 col-lg-3 social-media {{ session()->get('direction') == 2 ? 'text-sm-start' : 'text-sm-end' }}">
                    <h5 class="mb-2 fw-bold text-white">{{ trans('labels.follow_us_on') }}</h5>
                    <ul class="list-inline mb-0 mt-3  d-flex flex-wrap gap-2 justify-content-sm-end">
                        @foreach (@helper::getsociallinks($vendordata->id) as $links)
                            <li class="list-inline-item m-0"> <a class="btn-social mb-0 fb"
                                    href="{{ $links->link }}">{!! $links->icon !!}</a> </li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="mt-4 border-top mb-0"></div>
        </div>
        {{-- --------- copyright --------- --}}
        <p class="copyright-text py-3 mb-0 text-center">{{ helper::appdata($vendordata->id)->copyright }}</p>
    </div>
</section>


<div class="offcanvas bg-changer {{ session()->get('direction') == 2 ? 'offcanvas-end' : 'offcanvas-start' }}"
    data-bs-backdrop="static" tabindex="-1" id="footer_sidebar" aria-labelledby="staticBackdropLabel">
    <div class="offcanvas-header justify-content-between border-bottom">
        <a href="{{ URL::to($vendordata->slug) }}" class="d-flex align-items-center offcanvas-title"
            id="staticBackdropLabel">
            <img src="{{ helper::image_Path(helper::appdata($vendordata->id)->logo) }}" class="logoimage"
                alt="">
        </a>
        <button type="button" class="bg-transparent border-0 m-0" data-bs-dismiss="offcanvas" aria-label="Close">
            <i class="fa-regular fa-xmark fs-4 color-changer"></i>
        </button>
    </div>
    <div class="offcanvas-body">
        <h5 class="text-dark text-capitalize border-bottom pb-3 m-0 fw-600 color-changer">{{ trans('labels.pages') }}
        </h5>
        <ul class="list-group list-group-flush border-bottom">
            <li class="list-group-item px-0 py-3 {{ session()->get('direction') == 2 ? 'pe-3' : 'ps-3' }}">
                <a class="fs-7 fw-500 d-flex gap-2 align-items-center color-changer"
                    href="{{ URL::to($vendordata->slug . '/aboutus') }}">
                    <i class="fa-solid fa-circle-dot fs-7"></i>
                    {{ trans('labels.about_us') }}
                </a>
            </li>
            @if (@helper::checkaddons('product_shop'))
                <li
                    class="list-group-item px-0 py-3 {{ session()->get('direction') == 2 ? 'pe-3' : 'ps-3' }} dropdown">
                    <a class="fs-7 fw-500 d-flex gap-2 align-items-center color-changer"
                        href="{{ URL::to($vendordata->slug . '/product') }}">
                        <i class="fa-solid fa-circle-dot fs-7"></i>
                        {{ trans('labels.shop') }}
                    </a>
                </li>
            @endif
            <li class="list-group-item px-0 py-3 {{ session()->get('direction') == 2 ? 'pe-3' : 'ps-3' }}">
                <a class="fs-7 fw-500 d-flex gap-2 align-items-center color-changer"
                    href="{{ URL::to($vendordata->slug . '/contact') }}">
                    <i class="fa-solid fa-circle-dot fs-7"></i>
                    {{ trans('labels.help_contact') }}
                </a>
            </li>
            <li class="list-group-item px-0 py-3 {{ session()->get('direction') == 2 ? 'pe-3' : 'ps-3' }}">
                <a class="fs-7 fw-500 d-flex gap-2 align-items-center color-changer"
                    href="{{ URL::to($vendordata->slug . '/termscondition') }}">
                    <i class="fa-solid fa-circle-dot fs-7"></i>
                    {{ trans('labels.terms_condition') }}
                </a>
            </li>
            <li class="list-group-item px-0 py-3 {{ session()->get('direction') == 2 ? 'pe-3' : 'ps-3' }}">
                <a class="fs-7 fw-500 d-flex gap-2 align-items-center color-changer"
                    href="{{ URL::to($vendordata->slug . '/privacypolicy') }}">
                    <i class="fa-solid fa-circle-dot fs-7"></i>
                    {{ trans('labels.privacy_policy') }}
                </a>
            </li>
            <li class="list-group-item px-0 py-3 {{ session()->get('direction') == 2 ? 'pe-3' : 'ps-3' }}">
                <a class="fs-7 fw-500 d-flex gap-2 align-items-center color-changer"
                    href="{{ URL::to($vendordata->slug . '/refund_policy') }}">
                    <i class="fa-solid fa-circle-dot fs-7"></i>
                    {{ trans('labels.refund_policy') }}
                </a>
            </li>

        </ul>
        <h5 class="text-dark text-capitalize border-bottom py-3 m-0 fw-600 color-changer">{{ trans('labels.link') }}
        </h5>
        <ul class="list-group list-group-flush border-bottom">
            <li class="list-group-item px-0 py-3 {{ session()->get('direction') == 2 ? 'pe-3' : 'ps-3' }}">
                <a class="fs-7 fw-500 d-flex gap-2 align-items-center color-changer"
                    href="{{ URL::to($vendordata->slug . '/faq') }}">
                    <i class="fa-solid fa-circle-dot fs-7"></i>
                    {{ trans('labels.faqs') }}
                </a>
            </li>
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
                        <li
                            class="list-group-item px-0 py-3 {{ session()->get('direction') == 2 ? 'pe-3' : 'ps-3' }}">
                            <a class="fs-7 fw-500 d-flex gap-2 align-items-center color-changer"
                                href="{{ URL::to($vendordata->slug . '/allblogs') }}">
                                <i class="fa-solid fa-circle-dot fs-7"></i>
                                {{ trans('labels.blog') }}
                            </a>
                        </li>
                    @endif
                @endif
            @else
                @if (@helper::checkaddons('blog'))
                    <li class="list-group-item px-0 py-3 {{ session()->get('direction') == 2 ? 'pe-3' : 'ps-3' }}">
                        <a class="fs-7 fw-500 d-flex gap-2 align-items-center color-changer"
                            href="{{ URL::to($vendordata->slug . '/allblogs') }}">
                            <i class="fa-solid fa-circle-dot fs-7"></i>
                            {{ trans('labels.blog') }}
                        </a>
                    </li>
                @endif
            @endif

            <li class="list-group-item px-0 py-3 {{ session()->get('direction') == 2 ? 'pe-3' : 'ps-3' }}">
                <a class="fs-7 fw-500 d-flex gap-2 align-items-center color-changer"
                    href="{{ URL::to($vendordata->slug . '/gallery') }}">
                    <i class="fa-solid fa-circle-dot fs-7"></i>
                    {{ trans('labels.gallery') }}
                </a>
            </li>
        </ul>
        <h5 class="text-dark text-capitalize py-3 m-0 fw-600 color-changer">{{ trans('labels.contact_us') }}</h5>
        <ul class="">
            <li class="py-2">
                <a class="fs-7 fw-500 d-flex gap-2 align-items-center color-changer"
                    href="tel:{{ helper::appdata($vendordata->id)->contact }}">
                    <i class="fa-solid fa-phone fs-7"></i>
                    {{ helper::appdata($vendordata->id)->contact }}
                </a>
            </li>
            <li class="py-2">
                <a class="fs-7 fw-500 d-flex gap-2 align-items-center color-changer"
                    href="mailto:{{ helper::appdata($vendordata->id)->email }}">
                    <i class="fa-solid fa-envelope fs-7"></i>
                    {{ helper::appdata($vendordata->id)->email }}
                </a>
            </li>
        </ul>
        <!-- Social media icon -->
        @if (helper::getsociallinks($vendordata->id)->count() > 0)
            <div class="social-media">
                <h5 class="text-dark text-capitalize pt-3 m-0 fw-600 color-changer">{{ trans('labels.follow_us_on') }}
                </h5>
                <ul class="list-inline mb-0 mt-3 d-flex flex-wrap gap-2">
                    @foreach (@helper::getsociallinks($vendordata->id) as $links)
                        <li class="list-inline-item m-0">
                            <a class="btn-social mb-0 fb" href="{{ $links->link }}">{!! $links->icon !!}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="mt-4">
        </div>
        <div class="offcanvas-footer border-top">
            <p class="text-dark py-3 fs-13 mb-0 text-center color-changer">
                {{ helper::appdata($vendordata->id)->copyright }}</p>
        </div>
    </div>
</div>
