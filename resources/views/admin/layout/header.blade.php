<header class="page-topbar">
    <div class="navbar-header">
        <button class="navbar-toggler d-lg-none d-md-block px-4" type="button" data-bs-toggle="collapse"
            data-bs-target="#sidebarcollapse" aria-expanded="false" aria-controls="sidebarcollapse">
            <i class="fa-regular fa-bars fs-4 color-changer"></i>
        </button>
        <div class="px-3 d-flex align-items-center gap-2">
            @if (session('vendor_login'))
                <a href="{{ URL::to('/admin/admin_back') }}" title="{{ trans('labels.back_to_admin') }}"
                    class="btn btn-primary header-btn-icon rounded btn-sm"><i class="fa-regular fa-user fs-6"></i></a>
            @endif
            @if (Auth::user()->type == 2)
                <a class="btn btn-primary header-btn-icon rounded btn-sm" href="@if (helper::checkcustomdomain($vendor_id) == null){{ URL::to('/' . Auth::user()->slug) }}@else {{ 'https://' . helper::checkcustomdomain($vendor_id) }} @endif"
                    title="{{ trans('labels.view_website') }}" target="_blank"><i class="fa-solid fa-link fs-6"></i>
                </a>
            @endif
            @if (@helper::checkaddons('language'))
                @if (helper::available_language('')->count() > 1)
                    <div class="dropdown lag-btn">
                        <a class="btn btn-sm btn-primary rounded header-btn-icon dropdown-toggle" href="#"
                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-regular fa-globe fs-6"></i>
                        </a>
                        <ul
                            class="dropdown-menu p-0 bg-body-secondary shadow border-0 mt-2 rounded-3 overflow-hidden {{ session()->get('direction') == 2 ? 'drop-menu-rtl' : 'drop-menu' }}">
                            @foreach (helper::available_language('') as $languagelist)
                                <li>
                                    <a class="dropdown-item d-flex align-items-center p-2 gap-2"
                                        href="{{ URL::to('/lang/change?lang=' . $languagelist->code) }}">
                                        <img src="{{ helper::image_path($languagelist->image) }}" alt=""
                                            class="img-fluid lags-img" width="25px">
                                        <span>
                                            {{ $languagelist->name }}
                                        </span>
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
                        <a class="btn btn-sm btn-primary rounded header-btn-icon dropdown-toggle" href="#"
                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="fs-5">
                            {{ session()->get('currency') }}
                        </span>
                        </a>
                        <ul
                            class="dropdown-menu p-0 bg-body-secondary shadow border-0 mt-2 rounded-3 overflow-hidden {{ session()->get('direction') == 2 ? 'drop-menu-rtl' : 'drop-menu' }}">
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
            <div class="dropdown lag-btn2">
                <a href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"
                    class="btn btn-sm btn-primary rounded header-btn-icon dropdown-toggle">
                    <i class="fa-regular fa-circle-half-stroke fs-6"></i>
                </a>
                <ul
                    class="dropdown-menu p-0 bg-body-secondary border-0 shadow mt-2 {{ session()->get('direction') == 2 ? 'drop-menu-rtl' : 'drop-menu' }}">
                    <li>
                        <a class="dropdown-item d-flex cursor-pointer align-items-center p-2 gap-2"
                            onclick="setLightMode()">
                            <i class="fa-light fa-lightbulb fs-6"></i>
                            <span>Light</span>
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item d-flex cursor-pointer align-items-center p-2 gap-2"
                            onclick="setDarkMode()">
                            <i class="fa-solid fa-moon fs-6"></i>
                            <span>Dark</span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="dropwdown d-inline-block lag-btn">
                <button class="btn header-item" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="{{ helper::image_path(Auth::user()->image) }}">
                    <span
                        class="d-none d-xxl-inline-block d-xl-inline-block ms-1 color-changer">{{ Auth::user()->name }}</span>
                    <i class="fa-regular fa-angle-down d-none d-xxl-inline-block d-xl-inline-block color-changer"></i>
                </button>
                <div class="dropdown-menu p-0 bg-body-secondary shadow border-0 mt-1 rounded-3 overflow-hidden">
                    <a href="{{ URL::to('admin/settings') }}#editprofile"
                        class="dropdown-item d-flex align-items-center gap-2 p-2">
                        <i class="fa-light fa-address-card fs-6"></i>
                        {{ trans('labels.edit_profile') }}
                    </a>
                    <a href="{{ URL::to('admin/settings') }}#changepasssword"
                        class="dropdown-item d-flex align-items-center gap-2 p-2">
                        <i class="fa-light fa-lock-keyhole fs-6"></i>
                        {{ trans('labels.change_password') }}
                    </a>
                    <a href="javascript:void(0)" onclick="statusupdate('{{ URL::to('/admin/logout') }}')"
                        class="dropdown-item d-flex align-items-center gap-2 p-2">
                        <i class="fa-light fa-right-from-bracket fs-6"></i>
                        {{ trans('labels.logout') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>
