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
    <div class="row settings g-3 mt-3">
        <div class="col-xl-3 mb-3">
            <div class="card card-sticky-top h-auto border-0">
                <ul class="list-group list-options">
                    <a href="#themesettings" data-tab="themesettings"
                        class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center active"
                        aria-current="true">{{ trans('labels.theme_settings') }}
                        <i class="fa-regular fa-angle-right"></i></a>
                    <a href="#contactsettings" data-tab="contactsettings"
                        class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                        aria-current="true">{{ trans('labels.contact_settings') }}
                        <i class="fa-regular fa-angle-right"></i>
                    </a>
                    <a href="#seo" data-tab="seo"
                        class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                        aria-current="true">{{ trans('labels.seo') }}
                        <i class="fa-regular fa-angle-right"></i>
                    </a>
                    @if (Auth::user()->type == 1 || (Auth::user()->type == 4 && Auth::user()->vendor_id == 1))
                        @if (@helper::checkaddons('vendor_app'))
                            <a href="#mobile_section" data-tab="mobile_section"
                                class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                                aria-current="true">{{ trans('labels.mobile_section') }}
                                <i class="fa-regular fa-angle-right"></i>
                            </a>
                        @endif
                        <a href="#fun_fact" data-tab="fun_fact"
                            class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                            aria-current="true">{{ trans('labels.fun_fact') }} <i class="fa-regular fa-angle-right"></i></a>
                    @endif
                    @if (Auth::user()->type == 2 || (Auth::user()->type == 4 && Auth::user()->vendor_id != 1))
                        @if (@helper::checkaddons('subscription'))
                            @if (@helper::checkaddons('user_app'))
                                @php
                                    $checkplan = App\Models\Transaction::where('vendor_id', $vendor_id)
                                        ->orderByDesc('id')
                                        ->first();

                                    if (@$user->allow_without_subscription == 1) {
                                        $user_app = 1;
                                    } else {
                                        $user_app = @$checkplan->customer_app;
                                    }
                                @endphp
                                @if ($user_app == 1)
                                    <a href="#mobile_section" data-tab="mobile_section"
                                        class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                                        aria-current="true">{{ trans('labels.mobile_section') }}
                                        <i class="fa-regular fa-angle-right"></i>
                                    </a>
                                @endif
                            @endif
                        @else
                            @if (@helper::checkaddons('user_app'))
                                <a href="#mobile_section" data-tab="mobile_section"
                                    class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                                    aria-current="true">{{ trans('labels.mobile_section') }}
                                    <i class="fa-regular fa-angle-right"></i>
                                </a>
                            @endif
                        @endif
                        <a href="#footer_features" data-tab="footer_features"
                            class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                            aria-current="true">{{ trans('labels.footer_features') }}
                            <i class="fa-regular fa-angle-right"></i>
                        </a>
                        @if (@helper::checkaddons('subscription'))
                            @if (@helper::checkaddons('pwa'))
                                @php
                                    $checkplan = App\Models\Transaction::where('vendor_id', $vendor_id)
                                        ->orderByDesc('id')
                                        ->first();

                                    if (@$user->allow_without_subscription == 1) {
                                        $pwa = 1;
                                    } else {
                                        $pwa = @$checkplan->pwa;
                                    }
                                @endphp
                                @if ($pwa == 1)
                                    <a href="#pwa" data-tab="pwa"
                                        class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                                        aria-current="true">{{ trans('labels.pwa') }}
                                        <div class="d-flex align-items-center gap-1 justify-content-between">
                                            @if (env('Environment') == 'sendbox')
                                                <span class="badge badge bg-danger">{{ trans('labels.addon') }}</span>
                                            @endif
                                            <i class="fa-regular fa-angle-right"></i>
                                        </div>
                                    </a>
                                @endif
                            @endif
                        @else
                            @if (@helper::checkaddons('pwa'))
                                <a href="#pwa" data-tab="pwa"
                                    class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                                    aria-current="true">{{ trans('labels.pwa') }}<div
                                        class="d-flex align-items-center gap-1 justify-content-between">
                                        @if (env('Environment') == 'sendbox')
                                            <span class="badge badge bg-danger">{{ trans('labels.addon') }}</span>
                                        @endif
                                        <i class="fa-regular fa-angle-right"></i>
                                    </div>
                                </a>
                            @endif
                        @endif
                        @if (@helper::checkaddons('age_verification'))
                            <a href="#age_verification" data-tab="age_verification"
                                class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                                aria-current="true">{{ trans('labels.age_verification') }}<div
                                    class="d-flex align-items-center gap-1 justify-content-between">
                                    @if (env('Environment') == 'sendbox')
                                        <span class="badge badge bg-danger">{{ trans('labels.addon') }}</span>
                                    @endif
                                    <i class="fa-regular fa-angle-right"></i>
                                </div>
                            </a>
                        @endif
                    @endif
                    <a href="#social_links" data-tab="social_links"
                        class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                        aria-current="true">{{ trans('labels.social_link') }} <i class="fa-regular fa-angle-right"></i></a>
                    <a href="#other" data-tab="other"
                        class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                        aria-current="true">{{ trans('labels.other') }}
                        <i class="fa-regular fa-angle-right"></i>
                    </a>
                </ul>
            </div>
        </div>
        <div class="col-xl-9">
            <div id="settingmenuContent">
                <div id="themesettings">
                    <div class="row mb-5">
                        <div class="col-12">
                            <div class="card border-0 box-shadow">
                                <div class="card-header p-3 bg-secondary">
                                    <h5 class="text-capitalize fw-600 text-dark color-changer">
                                        {{ trans('labels.theme_settings') }}</h5>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="{{ URL::to('admin/themeupdate') }}"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="form-group">
                                                <label class="form-label">{{ trans('labels.web_title') }}<span
                                                        class="text-danger">
                                                        * </span></label>
                                                <input type="text" class="form-control" name="web_title"
                                                    value="{{ @$settingdata->web_title }}"
                                                    placeholder="{{ trans('labels.web_title') }}" required>

                                            </div>
                                            @if (Auth::user()->type == 1 || (Auth::user()->type == 4 && Auth::user()->vendor_id == 1))
                                                <div class="form-group col-sm-6">
                                                    <label class="form-label">{{ trans('labels.primary_color') }}</label>
                                                    <input type="color"
                                                        class="form-control form-control-color w-100 border-0"
                                                        name="landing_primary_color"
                                                        value="{{ $landingdata->primary_color }}">
                                                </div>
                                                <div class="form-group col-sm-6">
                                                    <label
                                                        class="form-label">{{ trans('labels.secondary_color') }}</label>
                                                    <input type="color"
                                                        class="form-control form-control-color w-100 border-0"
                                                        name="landing_secondary_color"
                                                        value="{{ $landingdata->secondary_color }}">
                                                </div>
                                            @else
                                                <div class="form-group col-sm-6">
                                                    <label class="form-label">{{ trans('labels.primary_color') }}</label>
                                                    <input type="color"
                                                        class="form-control form-control-color w-100 border-0"
                                                        name="landing_primary_color"
                                                        value="{{ $settingdata->primary_color }}">
                                                </div>
                                                <div class="form-group col-sm-6">
                                                    <label
                                                        class="form-label">{{ trans('labels.secondary_color') }}</label>
                                                    <input type="color"
                                                        class="form-control form-control-color w-100 border-0"
                                                        name="landing_secondary_color"
                                                        value="{{ $settingdata->secondary_color }}">
                                                </div>
                                            @endif
                                            <div class="form-group">
                                                <label class="form-label">{{ trans('labels.copyright') }}<span
                                                        class="text-danger">
                                                        * </span></label>
                                                <input type="text" class="form-control" name="copyright"
                                                    value="{{ @$settingdata->copyright }}"
                                                    placeholder="{{ trans('labels.copyright') }}" required>

                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label class="form-label">{{ trans('labels.logo') }}
                                                </label>
                                                <input type="file" class="form-control" name="logo">

                                                <img class="img-fluid rounded mt-1 logo-img-height"
                                                    src="{{ helper::image_path(@$settingdata->logo) }}" alt="">
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label class="form-label">{{ trans('labels.darklogo') }}
                                                </label>
                                                <input type="file" class="form-control" name="darklogo">

                                                <img class="img-fluid rounded mt-1 logo-img-height"
                                                    src="{{ helper::image_path(@$settingdata->darklogo) }}" alt="">
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label class="form-label">{{ trans('labels.favicon') }}
                                                </label>
                                                <input type="file" class="form-control" name="favicon">
                                                <img class="img-fluid rounded hw-70 mt-1"
                                                    src="{{ helper::image_path(@$settingdata->favicon) }}"
                                                    alt="">
                                            </div>

                                            @if (Auth::user()->type == 1 || (Auth::user()->type == 4 && Auth::user()->vendor_id == 1))
                                                <div class="form-group col-sm-6">
                                                    <label class="form-label"
                                                        for="">{{ trans('labels.landing_page') }}
                                                    </label>
                                                    <input id="landing-switch" type="checkbox" class="checkbox-switch"
                                                        name="landing" value="1"
                                                        {{ $settingdata->landing_page == 1 ? 'checked' : '' }}>
                                                    <label for="landing-switch" class="switch">
                                                        <span
                                                            class="{{ session()->get('direction') == 2 ? 'switch__circle-rtl' : 'switch__circle' }}"><span
                                                                class="switch__circle-inner"></span></span>
                                                        <span
                                                            class="switch__left {{ session()->get('direction') == 2 ? 'pe-2' : 'ps-2' }}">{{ trans('labels.off') }}</span>
                                                        <span
                                                            class="switch__right {{ session()->get('direction') == 2 ? 'ps-2' : 'pe-2' }}">{{ trans('labels.on') }}</span>
                                                    </label>
                                                </div>
                                            @endif
                                            @if (Auth::user()->type == 2 || (Auth::user()->type == 4 && Auth::user()->vendor_id != 1))
                                                @php
                                                    $availableThemes = @helper::availablePlanThemes('theme-');
                                                    $themes = [];
                                                    $transactionThemeIds = !empty(@$theme->themes_id) && @$theme->themes_id !== '0'
                                                        ? array_map('strval', explode('|', @$theme->themes_id))
                                                        : [];
                                                    $planThemeIds = !empty(@$currentPlan->themes_id) && @$currentPlan->themes_id !== '0'
                                                        ? array_map('strval', explode('|', @$currentPlan->themes_id))
                                                        : [];
                                                    if (Auth::user()->allow_without_subscription == 1) {
                                                        $themes = $availableThemes;
                                                    } else {
                                                        if (@helper::checkaddons('subscription')) {
                                                            if (!empty($planThemeIds)) {
                                                                $themes = array_values(array_intersect($availableThemes, $planThemeIds));
                                                            } elseif (!empty($transactionThemeIds)) {
                                                                $themes = array_values(array_intersect($availableThemes, $transactionThemeIds));
                                                            } else {
                                                                $themes = [!empty($settingdata->theme) ? (string) $settingdata->theme : '1'];
                                                            }
                                                        } else {
                                                            $themes = $availableThemes;
                                                        }
                                                    }

                                                    if (empty($themes)) {
                                                        $themes = [!empty($settingdata->theme) ? (string) $settingdata->theme : '1'];
                                                    }
                                                @endphp
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-label">{{ trans('labels.theme') }}
                                                            <span class="text-danger"> * </span> </label>
                                                        @if (env('Environment') == 'sendbox')
                                                            <span
                                                                class="badge badge bg-danger ms-2">{{ trans('labels.addon') }}</span>
                                                        @endif
                                                        <ul
                                                            class="theme-selection row row-cols-xxl-6 row-cols-xl-5 row-cols-lg-4 row-cols-md-3 row-cols-2 g-3 flex-wrap">
                                                            @foreach ($themes as $item)
                                                                <li class="col">
                                                                    <input type="radio" name="template"
                                                                        id="template{{ $item }}"
                                                                        value="{{ $item }}"
                                                                        {{ @$settingdata->theme == $item ? 'checked' : '' }}>
                                                                    <label for="template{{ $item }}">
                                                                        <img
                                                                            src="{{ helper::image_path('theme-' . $item . '.webp') }}">
                                                                    </label>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="text-{{ session()->get('direction') == '2' ? 'start' : 'end' }} m-0">
                                            <button
                                                @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif
                                                class="btn btn-primary px-sm-4 {{ Auth::user()->type == 4 ? (helper::check_access('role_basic_settings', Auth::user()->role_id, Auth::user()->vendor_id, 'edit') == 1 ? '' : 'd-none') : '' }}">{{ trans('labels.save') }}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="contactsettings">
                    <div class="row mb-5">
                        <div class="col-12">
                            <div class="card border-0 box-shadow">
                                <div class="card-header p-3 bg-secondary">
                                    <h5 class="text-capitalize fw-600 text-dark color-changer">
                                        {{ trans('labels.contact_settings') }}
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="{{ URL::to('admin/contact_settings') }}"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label class="form-label">{{ trans('labels.email') }}
                                                    <span class="text-danger"> * </span>
                                                </label>
                                                <input type="email" class="form-control" name="contact_email"
                                                    value="{{ @$settingdata->email }}"
                                                    placeholder="{{ trans('labels.email') }}" required>

                                            </div>
                                            <div class="form-group col-md-6">
                                                <label class="form-label">{{ trans('labels.mobile') }}
                                                    <span class="text-danger"> * </span>
                                                </label>
                                                <input type="text" class="form-control mobile-number"
                                                    name="contact_mobile" value="{{ @$settingdata->contact }}"
                                                    placeholder="{{ trans('labels.mobile') }}" required>

                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">{{ trans('labels.address') }}
                                                    <span class="text-danger"> * </span>
                                                </label>
                                                <textarea class="form-control" name="address" rows="3" placeholder="{{ trans('labels.address') }}" required>{{ $settingdata->address }}</textarea>
                                            </div>
                                        </div>


                                        <div class="text-{{ session()->get('direction') == '2' ? 'start' : 'end' }} m-0">
                                            <button
                                                @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif
                                                class="btn btn-primary px-sm-4 {{ Auth::user()->type == 4 ? (helper::check_access('role_basic_settings', Auth::user()->role_id, Auth::user()->vendor_id, 'edit') == 1 ? '' : 'd-none') : '' }}">{{ trans('labels.save') }}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="seo">
                    <div class="row mb-5">
                        <div class="col-12">
                            <div class="card border-0 box-shadow">
                                <div class="card-header p-3 bg-secondary">
                                    <h5 class="text-capitalize fw-600 text-dark color-changer">{{ trans('labels.seo') }}
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <form action="{{ URL::to('/admin/og_image') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf

                                        <div class="row">
                                            <div class="form-group">
                                                <label class="form-label">{{ trans('labels.meta_title') }}<span
                                                        class="text-danger"> * </span></label>
                                                <input type="text" class="form-control" name="meta_title"
                                                    value="{{ $settingdata->meta_title }}"
                                                    placeholder="{{ trans('labels.meta_title') }}" required>

                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">{{ trans('labels.meta_description') }}<span
                                                        class="text-danger"> * </span></label>
                                                <textarea class="form-control" name="meta_description" rows="3"
                                                    placeholder="{{ trans('labels.meta_description') }}" required>{{ $settingdata->meta_description }}</textarea>

                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">{{ trans('labels.og_image') }}
                                                    <span class="text-danger"> * </span></label>
                                                <input type="file" class="form-control" name="og_image">
                                                <img class="img-fluid rounded hw-70 mt-1 object-fit-cover"
                                                    src="{{ helper::image_Path($settingdata->og_image) }}"
                                                    alt="">
                                            </div>
                                        </div>
                                        <div class="text-{{ session()->get('direction') == '2' ? 'start' : 'end' }} m-0">
                                            <button
                                                @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif
                                                class="btn btn-primary px-sm-4 {{ Auth::user()->type == 4 ? (helper::check_access('role_basic_settings', Auth::user()->role_id, Auth::user()->vendor_id, 'edit') == 1 ? '' : 'd-none') : '' }}">{{ trans('labels.save') }}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if (Auth::user()->type == 1 || (Auth::user()->type == 4 && Auth::user()->vendor_id == 1))
                    @if (@helper::checkaddons('vendor_app'))
                        @include('admin.mobile_app.app_section')
                    @endif
                    <div id="fun_fact">
                        <div class="row mb-5">
                            <div class="col-12">
                                <div class="col-12">
                                    <div class="card border-0 box-shadow">
                                        <div class="card-header p-3 bg-secondary">
                                            <div class="d-flex align-items-center justify-content-between">
                                                <h5 class="text-capitalize fw-600 text-dark color-changer">
                                                    {{ trans('labels.fun_fact') }} <span class=""
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="Ex. <i class='fa-solid fa-truck-fast'></i> Visit https://fontawesome.com/ for more info">
                                                        <i class="fa-solid fa-circle-info"></i> </span></h5>
                                                <span>
                                                    <button class="btn btn-primary" type="button"
                                                        onclick="add_funfact('{{ trans('labels.icon') }}','{{ trans('labels.title') }}','{{ trans('labels.sub_title') }}')">
                                                        <i class="fa-sharp fa-solid fa-plus"></i>
                                                    </button>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="card-body">

                                            <form action="{{ URL::to('admin/fun_fact/update') }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <div class="row">
                                                    @foreach ($funfacts as $key => $facts)
                                                        <div class="col-12">
                                                            <div class="row">
                                                                <input type="hidden" name="edit_icon_key[]"
                                                                    value="{{ $facts->id }}">
                                                                <div class="col-md-4 form-group">
                                                                    <div class="input-group">
                                                                        <input type="text"
                                                                            class="form-control feature_required  {{ session()->get('direction') == 2 ? 'input-group-rtl' : '' }}"
                                                                            onkeyup="show_funfact_icon(this)"
                                                                            name="edi_funfact_icon[{{ $facts->id }}]"
                                                                            placeholder="{{ trans('labels.icon') }}"
                                                                            value="{{ $facts->icon }}" required>
                                                                        <p
                                                                            class="input-group-text input_icon_trnspernt {{ session()->get('direction') == 2 ? 'input-group-icon-rtl' : '' }}">
                                                                            {!! $facts->icon !!}
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4 form-group">
                                                                    <input type="text" class="form-control"
                                                                        name="edi_funfact_title[{{ $facts->id }}]"
                                                                        placeholder="{{ trans('labels.title') }}"
                                                                        value="{{ $facts->title }}" required>
                                                                </div>
                                                                <div class="col-md-4 form-group d-flex gap-sm-4 gap-2">
                                                                    <input type="text" class="form-control"
                                                                        name="edi_funfact_subtitle[{{ $facts->id }}]"
                                                                        placeholder="{{ trans('labels.sub_title') }}"
                                                                        value="{{ $facts->description }}" required>
                                                                    <button class="btn btn-danger" type="button"
                                                                        tooltip="{{ trans('labels.delete') }}"
                                                                        @if (env('Environment') == 'sendbox') onclick="myFunction()" @else onclick="statusupdate('{{ URL::to('admin/fun_fact/delete-' . $facts->id) }}')" @endif>
                                                                        <i class="fa fa-trash"></i> </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                    <span class="extra_footer_features"></span>
                                                    <div
                                                        class="form-group text-{{ session()->get('direction') == '2' ? 'start' : 'end' }} m-0">
                                                        <button
                                                            class="btn btn-primary px-sm-4 {{ Auth::user()->type == 4 ? (helper::check_access('role_basic_settings', Auth::user()->role_id, Auth::user()->vendor_id, 'edit') == 1 ? '' : 'd-none') : '' }}"
                                                            @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif>{{ trans('labels.save') }}</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                @if (Auth::user()->type == 2 || (Auth::user()->type == 4 && Auth::user()->vendor_id != 1))
                    @if (@helper::checkaddons('subscription'))
                        @if (@helper::checkaddons('user_app'))
                            @php
                                $checkplan = App\Models\Transaction::where('vendor_id', $vendor_id)
                                    ->orderByDesc('id')
                                    ->first();

                                if (@$user->allow_without_subscription == 1) {
                                    $user_app = 1;
                                } else {
                                    $user_app = @$checkplan->customer_app;
                                }
                            @endphp
                            @if ($user_app == 1)
                                @include('admin.mobile_app.app_section')
                            @endif
                        @endif
                    @else
                        @if (@helper::checkaddons('user_app'))
                            @include('admin.mobile_app.app_section')
                        @endif
                    @endif
                    <div id="footer_features">
                        <div class="row mb-5">
                            <div class="col-12">
                                <div class="card border-0 box-shadow">
                                    <div class="card-header p-3 bg-secondary">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <h5 class="text-capitalize fw-600 text-dark color-changer">
                                                {{ trans('labels.footer_features') }} <span class=""
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="Ex. <i class='fa-solid fa-truck-fast'></i> Visit https://fontawesome.com/ for more info">
                                                    <i class="fa-solid fa-circle-info"></i> </span></h5>
                                            <span class="col-auto"><button class="btn btn-primary" type="button"
                                                    onclick="add_features('{{ trans('labels.icon') }}','{{ trans('labels.title') }}','{{ trans('labels.description') }}')">
                                                    <i class="fa-sharp fa-solid fa-plus"></i></button></span>
                                        </div>
                                    </div>
                                    <div class="card-body">

                                        <form action="{{ URL::to('admin/footer_features/save') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="col-md-12">
                                                <div class="form-group">

                                                    @foreach ($getfooterfeatures as $key => $features)
                                                        <div class="row">
                                                            <input type="hidden" name="edit_icon_key[]"
                                                                value="{{ $features->id }}">
                                                            <div class="col-md-4 form-group">
                                                                <div class="input-group">
                                                                    <input type="text"
                                                                        class="form-control feature_required {{ session()->get('direction') == 2 ? 'input-group-rtl' : '' }}"
                                                                        onkeyup="show_feature_icon(this)"
                                                                        name="edi_feature_icon[{{ $features->id }}]"
                                                                        placeholder="{{ trans('labels.icon') }}"
                                                                        value="{{ $features->icon }}" required>
                                                                    <p
                                                                        class="input-group-text input_icon_trnspernt {{ session()->get('direction') == 2 ? 'input-group-icon-rtl' : '' }}">
                                                                        {!! $features->icon !!}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4 form-group">
                                                                <input type="text" class="form-control"
                                                                    name="edi_feature_title[{{ $features->id }}]"
                                                                    placeholder="{{ trans('labels.title') }}"
                                                                    value="{{ $features->title }}" required>
                                                            </div>
                                                            <div class="col-md-4 form-group gap-sm-4 gap-2 d-flex">
                                                                <input type="text" class="form-control"
                                                                    name="edi_feature_description[{{ $features->id }}]"
                                                                    placeholder="{{ trans('labels.description') }}"
                                                                    value="{{ $features->description }}" required>
                                                                <button class="btn btn-danger" type="button"
                                                                    onclick="statusupdate('{{ URL::to('admin/settings/delete-feature-' . $features->id) }}')">
                                                                    <i class="fa fa-trash"></i> </button>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                    <span class="extra_footer_features"></span>
                                                </div>
                                            </div>
                                            <div
                                                class="text-{{ session()->get('direction') == '2' ? 'start' : 'end' }} m-0">
                                                <button
                                                    @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif
                                                    class="btn btn-primary px-sm-4 {{ Auth::user()->type == 4 ? (helper::check_access('role_basic_settings', Auth::user()->role_id, Auth::user()->vendor_id, 'edit') == 1 ? '' : 'd-none') : '' }}">{{ trans('labels.save') }}</button>
                                            </div>

                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if (@helper::checkaddons('subscription'))
                        @if (@helper::checkaddons('pwa'))
                            @php
                                $checkplan = App\Models\Transaction::where('vendor_id', $vendor_id)
                                    ->orderByDesc('id')
                                    ->first();

                                if (@$user->allow_without_subscription == 1) {
                                    $pwa = 1;
                                } else {
                                    $pwa = @$checkplan->pwa;
                                }
                            @endphp
                            @if ($pwa == 1)
                                @include('admin.pwa.pwa_settings')
                            @endif
                        @endif
                    @else
                        @if (@helper::checkaddons('pwa'))
                            @include('admin.pwa.pwa_settings')
                        @endif
                    @endif
                    @if (@helper::checkaddons('age_verification'))
                        @include('admin.age_verification.index')
                    @endif
                @endif
                <div id="social_links">
                    <div class="row mb-5">
                        <div class="col-12">
                            <div class="card border-0 box-shadow">
                                <div class="card-header p-3 bg-secondary">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <h5 class="text-capitalize text-dark fw-600 color-changer">
                                            {{ trans('labels.social_link') }} <span class=""
                                                data-bs-toggle="tooltip" data-bs-placement="top"
                                                title="Ex. <i class='fa-solid fa-truck-fast'></i> Visit https://fontawesome.com/ for more info">
                                                <i class="fa-solid fa-circle-info"></i>
                                            </span>
                                        </h5>
                                        <span class="col-auto">
                                            <button class="btn btn-primary " type="button"
                                                onclick="add_social_links('{{ trans('labels.icon') }}','{{ trans('labels.link') }}')">
                                                <i class="fa-sharp fa-solid fa-plus"></i>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <form action="{{ URL::to('admin/social_links/update') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @foreach ($getsociallinks as $key => $links)
                                            <div class="row">
                                                <input type="hidden" name="edit_icon_key[]"
                                                    value="{{ $links->id }}">
                                                <div class="col-md-6 form-group">
                                                    <div class="input-group">
                                                        <input type="text"
                                                            class="form-control soaciallink_required  {{ session()->get('direction') == 2 ? 'input-group-rtl' : '' }}"
                                                            onkeyup="show_feature_icon(this)"
                                                            name="edi_sociallink_icon[{{ $links->id }}]"
                                                            placeholder="{{ trans('labels.icon') }}"
                                                            value="{{ $links->icon }}" required>
                                                        <p
                                                            class="input-group-text input_icon_trnspernt {{ session()->get('direction') == 2 ? 'input-group-icon-rtl' : '' }}">
                                                            {!! $links->icon !!}
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 d-flex align-items-center gap-sm-4 gap-2 form-group">
                                                    <input type="text" class="form-control"
                                                        name="edi_sociallink_link[{{ $links->id }}]"
                                                        placeholder="{{ trans('labels.link') }}"
                                                        value="{{ $links->link }}" required>
                                                    <button class="btn btn-danger" type="button"
                                                        tooltip="{{ trans('labels.delete') }}"
                                                        @if (env('Environment') == 'sendbox') onclick="myFunction()" @else onclick="statusupdate('{{ URL::to('admin/settings/delete-sociallinks-' . $links->id) }}')" @endif>
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        @endforeach
                                        <span class="extra_social_links"></span>
                                        <div
                                            class="form-group text-{{ session()->get('direction') == '2' ? 'start' : 'end' }} m-0">
                                            <button
                                                class="btn btn-primary px-sm-4 {{ Auth::user()->type == 4 ? (helper::check_access('role_basic_settings', Auth::user()->role_id, Auth::user()->vendor_id, 'edit') == 1 ? '' : 'd-none') : '' }}"
                                                @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif>{{ trans('labels.save') }}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="other">
                    <div class="row mb-5">
                        <div class="col-12">
                            <div class="card border-0 box-shadow">
                                <div class="card-header p-3 bg-secondary">
                                    <h5 class="text-capitalize fw-600 text-dark color-changer">
                                        {{ trans('labels.other') }}</h5>
                                </div>
                                <div class="card-body">
                                    <form action="{{ URL::to('/admin/other_settings') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            @if (Auth::user()->type == 2 || (Auth::user()->type == 4 && Auth::user()->vendor_id != 1))
                                                <div class="form-group col-sm-6">
                                                    <label class="form-label">{{ trans('labels.homepage_title') }}<span
                                                            class="text-danger"> * </span></label>
                                                    <input type="text" class="form-control" name="homepage_title"
                                                        value="{{ @$settingdata->homepage_title }}"
                                                        placeholder="{{ trans('labels.homepage_title') }}" required>

                                                </div>
                                                <div class="form-group col-sm-6">
                                                    <label
                                                        class="form-label">{{ trans('labels.homepage_subtitle') }}<span
                                                            class="text-danger"> * </span></label>
                                                    <input type="text" class="form-control" name="homepage_subtitle"
                                                        value="{{ @$settingdata->homepage_subtitle }}"
                                                        placeholder="{{ trans('labels.homepage_subtitle') }}" required>

                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <label
                                                        class="form-label">{{ trans('labels.subscription_title') }}<span
                                                            class="text-danger"> *
                                                        </span></label>
                                                    <input type="text"
                                                        class="form-control {{ session()->get('direction') == 2 ? 'input-group-rtl' : '' }}"
                                                        name="title"
                                                        placeholder="{{ trans('labels.subscription_title') }}"
                                                        value="{{ @$subscription->title }}" required>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <label
                                                        class="form-label">{{ trans('labels.subscription_subtitle') }}<span
                                                            class="text-danger"> *
                                                        </span></label>
                                                    <input type="text"
                                                        class="form-control {{ session()->get('direction') == 2 ? 'input-group-rtl' : '' }}"
                                                        name="subtitle"
                                                        placeholder="{{ trans('labels.subscription_subtitle') }}"
                                                        value="{{ @$subscription->subtitle }}" required>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label class="form-label">{{ trans('labels.homepage_banner') }}
                                                    </label>
                                                    <input type="file" class="form-control" name="homepage_banner">
                                                    <img class="img-fluid rounded hw-70 mt-1 object-fit-cover"
                                                        src="{{ helper::image_path(@$settingdata->home_banner) }}"
                                                        alt="">
                                                </div>

                                                <div class="col-md-6 form-group">
                                                    <label
                                                        class="form-label">{{ trans('labels.subscription_image') }}<span
                                                            class="text-danger"> * </span></label>
                                                    <input type="file" class="form-control" name="image">

                                                    <img src="{{ helper::image_path(@$subscription->image) }}"
                                                        class="img-fluid rounded hw-70 mt-1 object-fit-cover"
                                                        alt="">
                                                </div>
                                                <div class="form-group col-sm-6">
                                                    <label
                                                        class="form-label">{{ trans('labels.landing_page_cover_image') }}
                                                    </label>
                                                    <input type="file" class="form-control"
                                                        name="landin_page_cover_image">
                                                    <img class="img-fluid rounded hw-70 mt-1 object-fit-cover"
                                                        src="{{ helper::image_path(@$settingdata->cover_image) }}"
                                                        alt="">
                                                </div>
                                                <div class="form-group col-sm-6">
                                                    <label class="form-label">{{ trans('labels.contact_us_image') }}
                                                    </label>
                                                    <input type="file" class="form-control" name="contact_us_image">
                                                    <img class="img-fluid rounded hw-70 mt-1 object-fit-cover"
                                                        src="{{ helper::image_path(@$settingdata->contact_image) }}"
                                                        alt="">
                                                </div>
                                                <div class="form-group col-sm-6">
                                                    <label class="form-label">{{ trans('labels.web_auth_image') }}
                                                    </label>
                                                    <input type="file" class="form-control" name="auth_image">
                                                    <img class="img-fluid rounded hw-70 mt-1 object-fit-cover"
                                                        src="{{ helper::image_path(@$settingdata->auth_image) }}"
                                                        alt="">
                                                </div>
                                                <div class="form-group col-sm-6">
                                                    <label class="form-label">{{ trans('labels.referral_image') }}
                                                    </label>
                                                    <input type="file" class="form-control" name="referral_image">
                                                    <img class="img-fluid rounded hw-70 mt-1 object-fit-cover"
                                                        src="{{ helper::image_path(@$settingdata->referral_image) }}"
                                                        alt="">
                                                </div>
                                                @if (@helper::checkaddons('product_reviews'))
                                                    <div class="col-md-3 form-group">
                                                        @if (env('Environment') == 'sendbox')
                                                            <span
                                                                class="badge badge bg-danger me-5">{{ trans('labels.addon') }}</span>
                                                        @endif
                                                        <label class="form-label"
                                                            for="">{{ trans('labels.product_ratting_switch') }}
                                                        </label>
                                                        <div class="text-center">
                                                            <input id="product_ratting_switch" type="checkbox"
                                                                class="checkbox-switch" name="product_ratting_switch"
                                                                value="1"
                                                                {{ $settingdata->product_ratting_switch == 1 ? 'checked' : '' }}>
                                                            <label for="product_ratting_switch" class="switch">
                                                                <span
                                                                    class="{{ session()->get('direction') == 2 ? 'switch__circle-rtl' : 'switch__circle' }}"><span
                                                                        class="switch__circle-inner"></span></span>
                                                                <span
                                                                    class="switch__left {{ session()->get('direction') == 2 ? 'pe-1' : 'ps-1' }}">{{ trans('labels.off') }}</span>
                                                                <span
                                                                    class="switch__right {{ session()->get('direction') == 2 ? 'ps-2' : 'pe-2' }}">{{ trans('labels.on') }}</span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                @endif
                                                <div class="col-md-3 form-group">
                                                    <label class="form-label"
                                                        for="">{{ trans('labels.online_order') }}
                                                    </label>
                                                    <div class="text-center">
                                                        <input id="online_order_switch" type="checkbox"
                                                            class="checkbox-switch" name="online_order_switch"
                                                            value="1"
                                                            {{ $settingdata->online_order == 1 ? 'checked' : '' }}>
                                                        <label for="online_order_switch" class="switch">
                                                            <span
                                                                class="{{ session()->get('direction') == 2 ? 'switch__circle-rtl' : 'switch__circle' }}"><span
                                                                    class="switch__circle-inner"></span></span>
                                                            <span
                                                                class="switch__left {{ session()->get('direction') == 2 ? 'pe-1' : 'ps-1' }}">{{ trans('labels.off') }}</span>
                                                            <span
                                                                class="switch__right {{ session()->get('direction') == 2 ? 'ps-2' : 'pe-2' }}">{{ trans('labels.on') }}</span>
                                                        </label>
                                                    </div>

                                                </div>
                                                <div class="col-md-3 form-group">
                                                    <label class="form-label"
                                                        for="">{{ trans('labels.service_on_off') }}
                                                    </label>
                                                    <div class="text-center">
                                                        <input id="service_on_off" type="checkbox"
                                                            class="checkbox-switch" name="service_on_off" value="1"
                                                            {{ $settingdata->service_on_off == 1 ? 'checked' : '' }}>
                                                        <label for="service_on_off" class="switch">
                                                            <span
                                                                class="{{ session()->get('direction') == 2 ? 'switch__circle-rtl' : 'switch__circle' }}"><span
                                                                    class="switch__circle-inner"></span></span>
                                                            <span
                                                                class="switch__left {{ session()->get('direction') == 2 ? 'pe-1' : 'ps-1' }}">{{ trans('labels.off') }}</span>
                                                            <span
                                                                class="switch__right {{ session()->get('direction') == 2 ? 'ps-2' : 'pe-2' }}">{{ trans('labels.on') }}</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-3 form-group">
                                                    <label class="form-label"
                                                        for="">{{ trans('labels.shop_on_off') }}
                                                    </label>
                                                    <div class="text-center">
                                                        <input id="shop_on_off" type="checkbox" class="checkbox-switch"
                                                            name="shop_on_off" value="1"
                                                            {{ $settingdata->shop_on_off == 1 ? 'checked' : '' }}>
                                                        <label for="shop_on_off" class="switch">
                                                            <span
                                                                class="{{ session()->get('direction') == 2 ? 'switch__circle-rtl' : 'switch__circle' }}"><span
                                                                    class="switch__circle-inner"></span></span>
                                                            <span
                                                                class="switch__left {{ session()->get('direction') == 2 ? 'pe-1' : 'ps-1' }}">{{ trans('labels.off') }}</span>
                                                            <span
                                                                class="switch__right {{ session()->get('direction') == 2 ? 'ps-2' : 'pe-2' }}">{{ trans('labels.on') }}</span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-sm-6">
                                                    <label
                                                        class="form-label">{{ trans('labels.google_review_url') }}</label>
                                                    <input type="text" class="form-control"
                                                        placeholder="{{ trans('labels.google_review_url') }}"
                                                        name="google_review_url"
                                                        value="{{ $settingdata->google_review }}">
                                                </div>
                                                @if (helper::allpaymentcheckaddons($vendor_id))
                                                    <div class="form-group col-sm-6">
                                                        <label
                                                            class="form-label">{{ trans('labels.payment_process_options') }}</label>
                                                        <select class="form-select" name="payment_process_options">
                                                            <option>{{ trans('labels.select') }}</option>
                                                            <option value="1"
                                                                {{ $settingdata->payment_process_options == 1 ? 'selected' : '' }}>
                                                                {{ trans('labels.pay_now') }}</option>
                                                            <option value="2"
                                                                {{ $settingdata->payment_process_options == 2 ? 'selected' : '' }}>
                                                                {{ trans('labels.pay_later') }}</option>
                                                            <option value="3"
                                                                {{ $settingdata->payment_process_options == 3 ? 'selected' : '' }}>
                                                                {{ trans('labels.both') }}</option>
                                                        </select>
                                                    </div>
                                                @endif
                                                <div class="form-group">
                                                    <label
                                                        class="form-label">{{ trans('labels.footer_description') }}<span
                                                            class="text-danger"> * </span></label>
                                                    <textarea class="form-control" name="footer_description" rows="3"
                                                        placeholder="{{ trans('labels.footer_description') }}" required>{{ @$settingdata->footer_description }}</textarea>

                                                </div>
                                                <div class="form-group col-sm-6">
                                                    <label
                                                        class="form-label">{{ trans('labels.order_success_image') }}</label>
                                                    <input type="file" class="form-control"
                                                        name="order_success_image">

                                                    <img class="img-fluid rounded hw-70 mt-1 object-fit-cover"
                                                        src="{{ helper::image_path(@$settingdata->order_success_image) }}"
                                                        alt="">
                                                </div>
                                                <div class="form-group col-sm-6">
                                                    <label class="form-label">{{ trans('labels.no_data_image') }}</label>
                                                    <input type="file" class="form-control" name="no_data_image">

                                                    <img class="img-fluid rounded hw-70 mt-1 object-fit-cover"
                                                        src="{{ helper::image_path(@$settingdata->no_data_image) }}"
                                                        alt="">
                                                </div>
                                            @endif

                                            @if (Auth::user()->type == 1 || (Auth::user()->type == 4 && Auth::user()->vendor_id == 1))
                                                <div class="form-group col-sm-6">
                                                    <label
                                                        class="form-label">{{ trans('labels.landing_home_banner') }}</label>
                                                    <input type="file" class="form-control"
                                                        name="landing_home_banner">

                                                    <img class="img-fluid rounded hw-70 mt-1 object-fit-cover"
                                                        src="{{ helper::image_path(@$landingdata->landing_home_banner) }}"
                                                        alt="">
                                                </div>
                                                <div class="form-group col-sm-6">
                                                    <label
                                                        class="form-label">{{ trans('labels.subscribe_image') }}</label>
                                                    <input type="file" class="form-control" name="subscribe_image">

                                                    <img class="img-fluid rounded hw-70 mt-1 object-fit-cover"
                                                        src="{{ helper::image_path(@$landingdata->subscribe_image) }}"
                                                        alt="">
                                                </div>
                                                <div class="form-group col-sm-6">
                                                    <label class="form-label">{{ trans('labels.faq_image') }}</label>
                                                    <input type="file" class="form-control" name="faq_image">

                                                    <img class="img-fluid rounded hw-70 mt-1 object-fit-cover"
                                                        src="{{ helper::image_path(@$landingdata->faq_image) }}"
                                                        alt="">
                                                </div>
                                                <div class="form-group col-sm-6">
                                                    <label class="form-label">{{ trans('labels.admin_auth_image') }}
                                                    </label>
                                                    <input type="file" class="form-control" name="admin_auth_image">
                                                    <img class="img-fluid rounded hw-70 mt-1 object-fit-cover"
                                                        src="{{ helper::image_path(@$settingdata->admin_auth_image) }}"
                                                        alt="">
                                                </div>

                                                <div class="form-group col-sm-6">
                                                    <label
                                                        class="form-label">{{ trans('labels.store_unavailable_image') }}</label>
                                                    <input type="file" class="form-control"
                                                        name="store_unavailable_image">
                                                    <img class="img-fluid rounded hw-70 mt-1 object-fit-cover"
                                                        src="{{ helper::image_path(@$settingdata->store_unavailable_image) }}"
                                                        alt="">
                                                </div>
                                            @endif

                                        </div>
                                        <div class="text-{{ session()->get('direction') == '2' ? 'start' : 'end' }} m-0">
                                            <button
                                                @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif
                                                class="btn btn-primary px-sm-4 {{ Auth::user()->type == 4 ? (helper::check_access('role_basic_settings', Auth::user()->role_id, Auth::user()->vendor_id, 'edit') == 1 ? '' : 'd-none') : '' }}">{{ trans('labels.save') }}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        var role_type = "{{ Auth::user()->role_type }}";
    </script>
    <script src="{{ url(env('ASSETPATHURL') . 'admin-assets/js/funfact.js') }}"></script>
    <script src="{{ url(env('ASSETPATHURL') . 'admin-assets/js/settings.js') }}"></script>
@endsection
