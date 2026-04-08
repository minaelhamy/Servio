@extends('widget.layout.default')
@section('content')
    <!--==================================== Information section end ====================================-->

    <div class="main">
        <div class="header">
            <span class="fw-bold active header-title">{{ trans('labels.select_information') }}</span>
        </div>
        <div class="row align-items-center justify-content-between main-specing">
            <div class="col-md-6 mb-2">
                <label for="first_name" class="form-label fw-semibold fs-7">{{ trans('labels.first_name') }}</label>
                <input type="text" class="form-control fs-7 text-muted" id="first_name" name="first_name"
                    placeholder="{{ trans('labels.first_name') }}" value="{{ session()->get('embedded_name') }}" required>

            </div>
            <div class="col-md-6 mb-2">
                <label for="email" class="form-label fw-semibold fs-7">{{ trans('labels.email') }}</label>
                <input type="email" class="form-control fs-7 text-muted" id="email" name="email"
                    placeholder="{{ trans('labels.email') }}" value="{{ session()->get('embedded_email') }}" required>

            </div>
            <div class="col-md-12 mb-2">
                <label for="address" class="form-label fw-semibold fs-7">{{ trans('labels.address') }}</label>
                <textarea class="form-control fs-7 text-muted" id="address" rows="3" name="address"
                    placeholder="{{ trans('labels.address') }}" required>{{ session()->get('embedded_address') }}</textarea>

            </div>
            <div class="col-md-6 mb-2">
                <label for="landmark" class="form-label fw-semibold fs-7">{{ trans('labels.landmark') }}</label>
                <input type="text" class="form-control fs-7 text-muted" id="landmark" name="landmark"
                    placeholder="{{ trans('labels.landmark') }}" value="{{ session()->get('embedded_landmark') }}"
                    required>

            </div>
            <div class="col-md-6 mb-2">
                <label for="postal_code" class="form-label fw-semibold fs-7">{{ trans('labels.postal_code') }}</label>
                <input type="text" class="form-control fs-7 text-muted" id="postal_code" name="postal_code"
                    placeholder="{{ trans('labels.postal_code') }}" value="{{ session()->get('embedded_postalcode') }}"
                    required>

            </div>
            <div class="col-md-6 mb-2">
                <label for="city" class="form-label fw-semibold fs-7">{{ trans('labels.city') }}</label>
                <input type="text" class="form-control fs-7 text-muted" id="city" name="city"
                    placeholder="{{ trans('labels.city') }}" value="{{ session()->get('embedded_city') }}" required>

            </div>
            <div class="col-md-6 mb-2">
                <label for="state" class="form-label fw-semibold fs-7">{{ trans('labels.state') }}</label>
                <input type="text" class="form-control fs-7 text-muted" id="state" name="state"
                    placeholder="{{ trans('labels.state') }}" value="{{ session()->get('embedded_state') }}" required>

            </div>
            <div class="col-md-6 mb-2">
                <label for="country" class="form-label fw-semibold fs-7">{{ trans('labels.country') }}</label>
                <input type="text" class="form-control fs-7 text-muted" id="country" name="country"
                    placeholder="{{ trans('labels.country') }}" value="{{ session()->get('embedded_country') }}" required>

            </div>
            <div class="col-md-6 mb-2">
                <label for="mobile" class="form-label fw-semibold fs-7">{{ trans('labels.mobile') }}</label>
                <input type="tel" class="form-control fs-7 text-muted" id="mobile" name="mobile"
                    placeholder="{{ trans('labels.mobile') }}" value="{{ session()->get('embedded_mobile') }}" required>

            </div>
            <div class="col-md-12 mb-2">
                <label for="message" class="form-label fw-semibold fs-7">{{ trans('labels.message') }}</label>
                <textarea class="form-control fs-7 text-muted" id="message" name="message" rows="3"
                    placeholder="{{ trans('labels.message') }}">{{ session()->get('embedded_message') }}</textarea>
            </div>
        </div>
    </div>
    <!--==================================== Information section end ====================================-->
    <!--================================== footer section start ====================================-->
    <div class="footer">
        {{-- <div class="d-flex justify-content-between"> --}}
            <a href="{{ URL::to('/' . $vendordata->slug . '/embedded/datetime?selecteddate=' . session()->get('embedded_date') . '&selectedtime=' . session()->get('embedded_time').'&staff='. session()->get('embedded_time')) }}"
                class="btn btn-outline-primary px-4 back_button">{{ trans('labels.back') }}</a>
            <button type="submit" class="btn btn-secondary px-4 next_button"
                id="btn-infonext">{{ trans('labels.next_step') }}</button>
        {{-- </div> --}}
    </div>
    <!--==================================== footer section end ====================================-->
@endsection
@section('scripts')
    <script>
        var infourl = "{{ URL::to('/' . $vendordata->slug . '/embedded/info') }}";
        var vendor_id = "{{ $vendordata->id }}";
        var confirmationurl = "{{ URL::to('/' . $vendordata->slug . '/embedded/confirmation') }}"
       
    </script>
    <script>
        $('#btn-infonext').on('click', function() {

            if (validate_information()) {
                store_information();
            }
        });

        function validate_information() {
            "use strict";
            var isValid = true;
            $(".is-invalid").removeClass("is-invalid");
            var name = $("#first_name").val();
            var email = $("#email").val();
            var address = $("#address").val();
            var landmark = $("#landmark").val();
            var postalcode = $("#postalcode").val();
            var city = $("#city").val();
            var state = $("#state").val();
            var country = $("#country").val();
            var mobile = $("#mobile").val();
            if (name == "") {
                $("#first_name").addClass("is-invalid").focus();
                isValid = false;
            } else if (email == "") {
                $("#email").addClass("is-invalid").focus();
                isValid = false;
            } else if (address == "") {
                $("#address").addClass("is-invalid").focus();
                isValid = false;
            } else if (landmark == "") {
                $("#landmark").addClass("is-invalid").focus();
                isValid = false;
            } else if (postalcode == "") {
                $("#posatcode").addClass("is-invalid").focus();
                isValid = false;
            } else if (city == "") {
                $("#city").addClass("is-invalid").focus();
                isValid = false;
            } else if (state == "") {
                $("#state").addClass("is-invalid").focus();
                isValid = false;
            } else if (country == "") {
                $("#country").addClass("is-invalid").focus();
                isValid = false;
            } else if (mobile == "") {
                $("#mobile").addClass("is-invalid").focus();
                isValid = false;
            }

            return isValid;
        }

        function store_information() {
            "use strict";
            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                },
                url: infourl,
                type: "post",
                dataType: "json",
                data: {
                    name: $('#first_name').val(),
                    email: $('#email').val(),
                    address: $('#address').val(),
                    landmark: $('#landmark').val(),
                    postalcode: $('#postal_code').val(),
                    city: $('#city').val(),
                    country: $('#country').val(),
                    state: $('#city').val(),
                    mobile: $('#mobile').val(),
                    message: $('#message').val()
                },
                success: function(response) {
                    location.href = confirmationurl;
                }

            });
        }
        
        var sendbox = "{{ env('Environment') }}";
        
        $(document).ready(function () {
            $(window).on("load", function () {
                "use strict";
                if (sendbox == "sendbox") {
                    $("#first_name").val("Juliana F. Jones");
                    $("#email").val("JulianaFJones@yopmail.com");
                    $("#address").val("2409 Medical Center Drive Sarasota, FL");
                    $("#landmark").val("Bee Ridge Rd");
                    $("#postal_code").val("34236");
                    $("#city").val("Los Angeles");
                    $("#state").val("California");
                    $("#country").val("United States");
                    $("#mobile").val("9413651362");
                    $("#message").val(
                      "Lorem Ipsum is simply dummy text of the printing and typesetting industry."
                    );
                }
            });
        });
    </script>
@endsection
