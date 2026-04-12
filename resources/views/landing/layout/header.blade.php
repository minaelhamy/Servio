{{-- <div c  --}}
<nav class="navbar navbar-expand-lg header sticky-top">
    <div class="container">
        <div class="d-flex w-100 justify-content-between">
            <div class="d-flex gap-2 align-items-center">
                <div class="d-xl-none">
                    <button class="bg-transparent border-0 text-white m-0" type="button" data-bs-toggle="offcanvas"
                        data-bs-target="#offcanvaslanding" aria-controls="footersiderbar">
                        <i class="fa-solid fa-bars fs-3"></i>
                    </button>
                </div>
                <script>
                    document.addEventListener("DOMContentLoaded", function(event) {
                        if (localStorage.getItem('theme') === 'dark') {
                            var logo = "{{ helper::image_path(helper::appdata('')->darklogo) }}";
                        } else {
                            var logo = "{{ helper::image_path(helper::appdata('')->logo) }}";
                        }
                        $('#logoimage').attr('src', logo);
                    });
                </script>
                <a class="navbar-brand m-0" href="#">
                    <img src="" height="46" alt="" id="logoimage">
                </a>
            </div>
            @if (@helper::checkaddons('language'))
                <div class="d-flex align-items-center gap-3">
                    @if (helper::available_language('')->count() > 1)
                        <div class="language-button-icon d-xl-none d-block">
                            <div class="p-0 lag-btn dropdown">
                                <a class="border-0 rounded-1 text-white" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="{{ helper::image_path(session()->get('flag')) }}" alt=""
                                        class="rounded-circle" width="25px" height="25px">
                                </a>
                                <div class="dropdown-menu rounded-1 mt-2 p-0 border-0 overflow-hidden bg-body-secondary shadow {{ session()->get('direction') == '2' ? 'min-dropdown-rtl' : 'min-dropdown-ltr' }}"
                                    aria-labelledby="dropdownMenuLink">
                                    @foreach (helper::available_language('') as $languagelist)
                                        <li>
                                            <a class="dropdown-item text-dark d-flex align-items-center p-2 gap-2"
                                                href="{{ URL::to('/lang/change?lang=' . $languagelist->code) }}">
                                                <img src="{{ helper::image_path($languagelist->image) }}" alt=""
                                                    class="lag-img"> {{ $languagelist->name }}
                                            </a>
                                        </li>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
            @endif
            <div class="d-xl-none d-block">
                @if (@helper::checkaddons('currency_settigns'))
                    @if (helper::available_currency('')->count() > 1)
                        <div class="dropdown lag-btn">
                            <a class="p-0 border-0 rounded-1 language-drop" href="#" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="fs-5 text-white">
                                    {{ session()->get('currency') }}
                                </span>
                            </a>
                            <ul
                                class="dropdown-menu p-0 bg-body-secondary border-0 mt-2 {{ session()->get('direction') == 2 ? 'drop-menu-rtl' : 'drop-menu' }}">
                                @foreach (helper::available_currency() as $currencylist)
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center p-2 gap-2"
                                            href="{{ URL::to('/currency/change?currency=' . $currencylist['code']) }}">
                                            <p>{{ $currencylist['currency'] }}</p>
                                            <p>{{ $currencylist['name'] }}</p>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                @endif
            </div>

            <div class="d-xl-none d-block">
                <div class="dropdown lag-btn">
                    <a class="p-0 border-0 rounded-1 language-drop" href="#" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-regular fa-circle-half-stroke fs-3 text-white"></i>
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
        <div class="d-none d-xl-flex">
            <div class="collapse w-100 justify-content-xl-between gap-3 justify-content-end navbar-collapse">
                <div class="d-none w-100 d-xl-block mx-auto">
                    <ul class="navbar-nav justify-content-center mb-2 mb-lg-0">
                        <li class="nav-item dropdown px-2">
                            <a class="nav-link text-white fs-15 fw-500 active" href="{{ URL::to('/') }}"
                                role="button">
                                {{ trans('landing.home') }}
                            </a>
                        </li>
                        <li class="nav-item dropdown px-2">
                            <a class="nav-link text-white fs-15 fw-500" href="{{ URL::to('/#features') }}"
                                role="button">
                                {{ trans('landing.features') }}
                            </a>
                        </li>
                        @if (@helper::checkaddons('subscription'))
                            <li class="nav-item dropdown px-2">
                                <a class="nav-link text-white fs-15 fw-500" href="{{ URL::to('/#our-stores') }}"
                                    role="button">
                                    {{ trans('landing.our_stores') }}
                                </a>
                            </li>
                            <li class="nav-item dropdown px-2">
                                <a class="nav-link text-white fs-15 fw-500" href="{{ URL::to('/#pricing-plans') }}"
                                    role="button">
                                    {{ trans('landing.pricing_plan') }}
                                </a>
                            </li>
                        @endif
                        @if (@helper::checkaddons('blog'))
                            <li class="nav-item dropdown px-2">
                                <a class="nav-link text-white fs-15 fw-500" href="{{ URL::to('/#blogs') }}"
                                    role="button">
                                    {{ trans('landing.blogs') }}
                                </a>
                            </li>
                        @endif
                        <li class="nav-item dropdown px-2">
                            <a class="nav-link text-white fs-15 fw-500" href="{{ URL::to('/#contact-us') }}"
                                role="button">
                                {{ trans('landing.contact_us') }}
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="d-none d-xl-flex col-auto align-items-center gap-3">
                    @if (@helper::checkaddons('language'))
                        @if (helper::available_language('')->count() > 1)
                            <div class="lag-btn  dropdown rounded-2">
                                <a class="p-0 border-0 rounded-1 language-drop" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa-solid fa-globe fs-5"></i>
                                </a>
                                <ul
                                    class="dropdown-menu mt-2 rounded-1 p-0 border-0 overflow-hidden bg-body-secondary shadow {{ session()->get('direction') == '2' ? 'min-dropdown-rtl' : 'min-dropdown-ltr' }}">
                                    @foreach (helper::available_language('') as $languagelist)
                                        <li>
                                            <a class="dropdown-item text-dark p-2 d-flex align-items-center gap-2"
                                                href="{{ URL::to('/lang/change?lang=' . $languagelist->code) }}">
                                                <img src="{{ helper::image_path($languagelist->image) }}"
                                                    alt="" class="lag-img">
                                                {{ $languagelist->name }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    @endif
                    @if (@helper::checkaddons('currency_settigns'))
                        @if (helper::available_currency('')->count() > 1)
                            <div class="dropdown lag-btn">
                                <a class="p-0 border-0 rounded-1 language-drop" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class="fs-5 text-white">
                                        {{ session()->get('currency') }}
                                    </span>
                                </a>
                                <ul
                                    class="dropdown-menu p-0 bg-body-secondary border-0 mt-2 {{ session()->get('direction') == 2 ? 'drop-menu-rtl' : 'drop-menu' }}">
                                    @foreach (helper::available_currency() as $currencylist)
                                        <li>
                                            <a class="dropdown-item d-flex align-items-center p-2 gap-2"
                                                href="{{ URL::to('/currency/change?currency=' . $currencylist['code']) }}">
                                                <p>{{ $currencylist['currency'] }}</p>
                                                <p>{{ $currencylist['name'] }}</p>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    @endif
                    <div class="dropdown lag-btn">
                        <a class="p-0 border-0 rounded-1 language-drop" href="#" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-regular fa-circle-half-stroke fs-5 text-white"></i>
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
                    <a href="{{ URL::to('/admin') }}"
                        target="_blank" class="btn-secondary text-center w-100 fs-7 m-0 btn-class rounded-2">
                        {{ trans('landing.get_started') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
    </div>
</nav>

<div class="offcanvas bg-changer {{ session()->get('direction') == 2 ? 'offcanvas-end' : 'offcanvas-start' }}"
    tabindex="-1" id="offcanvaslanding" aria-labelledby="offcanvasExampleLabel">
    <div class="offcanvas-header d-flex justify-content-between align-items-center bg-black bg-changer border-bottom">
        <img src="{{ helper::image_path(helper::appdata('')->logo) }}" height="35px" alt="">
        <button type="button"
            class="text-white border-0 bg-transparent d-flex justify-content-center align-items-center m-0"
            data-bs-dismiss="offcanvas" aria-label="Close">
            <i class="fs-4 fa-solid fa-xmark"></i>
        </button>
    </div>
    <div class="offcanvas-body">
        <ul class="list-group list-add list-group-flush border-bottom">
            <li
                class="list-group-item bg-transparent px-0 py-3 {{ session()->get('direction') == 2 ? 'pe-3' : 'ps-3' }}">
                <a class="fs-7 fw-500 d-flex gap-2 align-items-center text-dark color-changer"
                    href="{{ URL::to('/') }}">
                    <i class="fa-solid fa-circle-dot fs-7"></i>
                    {{ trans('landing.home') }}
                </a>
            </li>
            <li
                class="list-group-item bg-transparent px-0 py-3 {{ session()->get('direction') == 2 ? 'pe-3' : 'ps-3' }}">
                <a class="fs-7 fw-500 d-flex gap-2 align-items-center text-dark color-changer"
                    href="{{ URL::to('/#features') }}">
                    <i class="fa-solid fa-circle-dot fs-7"></i>
                    {{ trans('landing.features') }}
                </a>
            </li>
            <li
                class="list-group-item bg-transparent px-0 py-3 {{ session()->get('direction') == 2 ? 'pe-3' : 'ps-3' }}">
                <a class="fs-7 fw-500 d-flex gap-2 align-items-center text-dark color-changer"
                    href="{{ URL::to('/#our-stores') }}">
                    <i class="fa-solid fa-circle-dot fs-7"></i>
                    {{ trans('landing.our_stores') }}
                </a>
            </li>
            <li
                class="list-group-item bg-transparent px-0 py-3 {{ session()->get('direction') == 2 ? 'pe-3' : 'ps-3' }}">
                <a class="fs-7 fw-500 d-flex gap-2 align-items-center text-dark color-changer"
                    href="{{ URL::to('/#pricing-plans') }}">
                    <i class="fa-solid fa-circle-dot fs-7"></i>
                    {{ trans('landing.pricing_plan') }}
                </a>
            </li>
            <li
                class="list-group-item bg-transparent px-0 py-3 {{ session()->get('direction') == 2 ? 'pe-3' : 'ps-3' }}">
                <a class="fs-7 fw-500 d-flex gap-2 align-items-center text-dark color-changer"
                    href="{{ URL::to('/#blogs') }}">
                    <i class="fa-solid fa-circle-dot fs-7"></i>
                    {{ trans('landing.blogs') }}
                </a>
            </li>
            <li
                class="list-group-item bg-transparent px-0 py-3 {{ session()->get('direction') == 2 ? 'pe-3' : 'ps-3' }}">
                <a class="fs-7 fw-500 d-flex gap-2 align-items-center text-dark color-changer"
                    href="{{ URL::to('/#contact-us') }}">
                    <i class="fa-solid fa-circle-dot fs-7"></i>
                    {{ trans('landing.contact_us') }}
                </a>
            </li>
        </ul>
    </div>
    <div class="offcanvas-footer bg-black p-2">
        <h5 class="fs-8 text-center text-white m-0">{{ helper::appdata('')->copyright }}</h5>
    </div>
</div>
@include('cookie-consent::index')

<script>
    document.querySelectorAll('.nav-link').forEach(link => {
        link.addEventListener('click', function() {
            // Remove 'active' class from all links
            document.querySelectorAll('.nav-link').forEach(nav => nav.classList.remove('active'));

            // Add 'active' class to the clicked link
            this.classList.add('active');
        });
    });
</script>
