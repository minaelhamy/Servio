@extends('admin.layout.auth_default')
@section('content')

    <section>
        <div class="row align-items-center g-0 w-100 h-100vh position-relative">
            <div class="col-xl-7 col-lg-6 col-md-6 d-md-block d-none">
                <img src="{{ helper::image_path(helper::appdata('')->admin_auth_image) }}" class="object h-100vh w-100"
                    alt="">
            </div>
            <div class="col-xl-5 col-lg-6 col-md-6">
                <div class="d-flex h-100 justify-content-center align-items-center">
                    <div class="col-xl-8">
                        <div class="login-right-content h-100">
                            <div class="p-3">
                                <div class="text-primary d-flex align-items-center justify-content-between">
                                    <div>
                                        <h2 class="fw-bold text-color title-text mb-2 color-changer">{{ trans('labels.login') }}</h2>
                                        <p class="text-color color-changer">{{ trans('labels.please_login') }}</p>
                                    </div>
                                    <!-- FOR SMALL DEVICE TOP CATEGORIES -->
                                   
                                    @if (@helper::checkaddons('language'))
                                        <div class="lag-btn dropdown border-0 shadow-none login-lang">
                                            <button class="border-0 bg-transparent language-dropdown" type="button"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <img src="{{ helper::image_path(session()->get('flag')) }}" alt=""
                                                    class="lag-img rounded-circle w-25">
                                            </button>
                                            <ul
                                                class="dropdown-menu rounded-1 mt-1 p-0 bg-body-secondary shadow border-0 rounded-3 overflow-hidden">
                                                @foreach (helper::listoflanguage() as $languagelist)
                                                    <li>
                                                        <a class="dropdown-item text-dark d-flex align-items-center px-2 gap-2 py-2"
                                                            href="{{ URL::to('/lang/change?lang=' . $languagelist->code) }}">
                                                            <img src="{{ helper::image_path($languagelist->image) }}"
                                                                alt="" class="img-fluid lag-img w-25">
                                                            {{ $languagelist->name }}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                </div>
                                <form class="my-3" method="POST" action="{{ URL::to('/admin/checklogin') }}"
                                    id="login-form">
                                    @csrf
                                    <div class="form-group">
                                        <label for="email" class="form-label">{{ trans('labels.email') }}<span
                                                class="text-danger"> * </span></label>
                                        <input type="email" class="form-control extra-padding" name="email"
                                            placeholder="{{ trans('labels.email') }}" id="email" required>

                                    </div>
                                    <div class="form-group">
                                        <label for="password" class="form-label">{{ trans('labels.password') }}<span
                                                class="text-danger"> * </span></label>
                                        <div class="form-control extra-padding d-flex align-items-center gap-3">
                                            <input type="password" class="form-control border-0 p-0" name="password"
                                                placeholder="{{ trans('labels.password') }}" id="password" required>
                                            <span>
                                                <a href="javascript:void(0);">
                                                    <i class="fa-light fa-eye-slash color-changer" id="eye"></i></a>
                                            </span>
                                        </div>

                                    </div>
                                    <div class="d-flex">
                                        <div class="form-group mb-2 col-6 d-flex align-items-center">
                                            <input class="form-check-input mt-0" type="checkbox" value=""
                                                name="check_terms" id="check_terms" checked required>
                                            <label class="form-check-label cursor-pointer mx-1" for="check_terms">
                                                <span class="fs-7 text-color color-changer">
                                                    {{ trans('labels.remember_me') }}
                                                </span>
                                            </label>
                                        </div>
                                        <div
                                            class="{{ session()->get('direction') == 2 ? 'text-start' : 'text-end ' }} mb-2 col-6">
                                            <a href="{{ URL::to('/admin/forgot_password?redirect=admin') }}"
                                                class="fs-7 fw-600 color-changer">
                                                {{ trans('labels.forgot_password') }}
                                            </a>
                                        </div>
                                    </div>
                                    <button class="btn btn-primary w-100 mt-2 mb-3 padding"
                                        type="submit">{{ trans('labels.sign_in') }}</button>

                                    @if (helper::appdata('')->vendor_register == 1)
                                        <p class="fs-7 text-center mt-4 color-changer">{{ trans('labels.dont_have_account') }}
                                            <a href="{{ URL::to('admin/register') }}"
                                                class="text-secondary fw-semibold text-decoration fw-600">{{ trans('labels.create_new_account') }}</a>
                                        </p>
                                    @endif
                                </form>
                                @if (env('Environment') == 'sendbox')
                                    <div class="border-top my-3"></div>
                                    <p class="text-center text-danger">Explore with <b class="text-black color-changer">Included</b>
                                        addons</p>

                                    <div class="d-flex">
                                        <button class="btn btn-secondary w-50 mt-2 mb-3 padding mx-2"
                                            id="admin_free_addon_login">Admin login</button>

                                        <button class="btn btn-secondary w-50 mt-2 mb-3 padding mx-2"
                                            id="vendor_free_addon_login">Vendor login</button>
                                    </div>



                                    <p class="text-center text-danger">Explore with <b class="text-black color-changer">ALL</b> addons</p>

                                    <div class="d-flex">
                                        <button class="btn btn-secondary w-50 mt-2 mb-3 padding mx-2"
                                            id="admin_all_addon">Admin
                                            login</button>

                                        <button class="btn btn-secondary w-50 mt-2 mb-3 padding mx-2"
                                            id="vendor_all_addon">Vendor
                                            login</button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @if (env('Environment') == 'sendbox')
        <!-- themelabel trigar button -->
        <div data-bs-toggle="offcanvas" href="#themelabel" role="button" aria-controls="offcanvasExample">
            <div class="theme-label">
                <i class="fa-light fa-badge-percent text-white"></i>
                <div class="theme-label-name">theme</div>
            </div>
        </div>

        <!-- themelabel -->
        <div class="offcanvas {{ session()->get('direction') == 2 ? 'offcanvas-start' : 'offcanvas-end' }}" tabindex="-1"
            id="themelabel" aria-labelledby="offcanvasExampleLabel" data-bs-backdrop="false">
            <div class="offcanvas-header border-bottom">
                <h5 class="offcanvas-title text-capitalize" id="offcanvasExampleLabel">theme</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <div class="row px-3">
                    <a href="https://bookingdo.paponapps.co.in/theme-1" target="_blank"
                        class="card h-100 them-card-box overflow-hidden mb-3 rounded-5 border-0 p-0">
                        <img src="{{ url(env('ASSETPATHURL') . 'admin-assets/images/theme/theme-1.webp') }}"
                            class="card-img-top them-name-images">
                        <div class="card-body">
                            <h5 class="card-title text-center color-changer">Theme - 1</h5>
                        </div>
                    </a>

                    <a href="https://bookingdo.paponapps.co.in/theme-2" target="_blank"
                        class="card h-100 them-card-box overflow-hidden mb-3 rounded-5 border-0 p-0">
                        <img src="{{ url(env('ASSETPATHURL') . 'admin-assets/images/theme/theme-2.webp') }}"
                            class="card-img-top them-name-images">
                        <div class="card-body">
                            <h5 class="card-title text-center color-changer">Theme - 2</h5>
                        </div>
                    </a>

                    <a href="https://bookingdo.paponapps.co.in/theme-3" target="_blank"
                        class="card h-100 them-card-box overflow-hidden mb-3 rounded-5 border-0 p-0">
                        <img src="{{ url(env('ASSETPATHURL') . 'admin-assets/images/theme/theme-3.webp') }}"
                            class="card-img-top them-name-images">
                        <div class="card-body">
                            <h5 class="card-title text-center color-changer">Theme - 3</h5>
                        </div>
                    </a>

                    <a href="https://bookingdo.paponapps.co.in/theme-4" target="_blank"
                        class="card h-100 them-card-box overflow-hidden mb-3 rounded-5 border-0 p-0">
                        <img src="{{ url(env('ASSETPATHURL') . 'admin-assets/images/theme/theme-4.webp') }}"
                            class="card-img-top them-name-images">
                        <div class="card-body">
                            <h5 class="card-title text-center color-changer">Theme - 4</h5>
                        </div>
                    </a>

                    <a href="https://bookingdo.paponapps.co.in/theme-5" target="_blank"
                        class="card h-100 them-card-box overflow-hidden mb-3 rounded-5 border-0 p-0">
                        <img src="{{ url(env('ASSETPATHURL') . 'admin-assets/images/theme/theme-5.webp') }}"
                            class="card-img-top them-name-images">
                        <div class="card-body">
                            <h5 class="card-title text-center color-changer">Theme - 5</h5>
                        </div>
                    </a>

                </div>
            </div>
        </div>
    @endif


@endsection

@section('scripts')
    @if (count($errors) > 0)
        @foreach ($errors->all() as $error)
            toastr.error("{{ $error }}");
        @endforeach
    @endif
    <script>
        function AdminFill(email, password) {
            $('#email').val(email);
            $('#password').val(password);
        }
        // password eye hide
        $(function() {
            $('#eye').click(function() {
                if ($(this).hasClass('fa-eye-slash')) {
                    $(this).removeClass('fa-eye-slash');
                    $(this).addClass('fa-eye');
                    $('#password').attr('type', 'text');
                } else {
                    $(this).removeClass('fa-eye');
                    $(this).addClass('fa-eye-slash');
                    $('#password').attr('type', 'password');
                }
            });
        });

        $(document).on("click", "#admin_free_addon_login", function() {
            $("#admin_free_addon_login").attr("disabled", true);

            $("#email").val('admin@gmail.com');
            $("#password").val('123456');
            SessionSave('free-addon');
        });

        $(document).on("click", "#vendor_free_addon_login", function() {
            $("#vendor_free_addon_login").attr("disabled", true);

            $("#email").val('vendor1@yopmail.com');
            $("#password").val('123456');
            SessionSave('free-addon');
        });

        $(document).on("click", "#admin_free_with_extended_addon_login", function() {
            $("#admin_free_with_extended_addon_login").attr("disabled", true);

            $("#email").val('admin@gmail.com');
            $("#password").val('123456');
            SessionSave('free-with-extended-addon');
        });

        $(document).on("click", "#vendor_free_with_extended_addon_login", function() {
            $("#vendor_free_with_extended_addon_login").attr("disabled", true);

            $("#email").val('vendor1@yopmail.com');
            $("#password").val('123456');
            SessionSave('free-with-extended-addon');
        });

        $(document).on("click", "#admin_all_addon", function() {
            $("#admin_all_addon").attr("disabled", true);

            $("#email").val('admin@gmail.com');
            $("#password").val('123456');
            SessionSave('all-addon');
        });

        $(document).on("click", "#vendor_all_addon", function() {
            $("#vendor_all_addon").attr("disabled", true);

            $("#email").val('vendor1@yopmail.com');
            $("#password").val('123456');
            SessionSave('all-addon');
        });

        function SessionSave(addon = null) {

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: "POST",
                dataType: "json",
                url: "{{ URL::to('add-on/session/save') }}",
                data: {
                    'demo_type': addon,
                },
                success: function(response) {
                    $('#login-form').submit();
                }
            });
        }
    </script>
@endsection
