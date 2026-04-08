<div class="card border p-4 p-sm-5 rounded-4 mb-5 extra-margins">

    <div class="row g-3 g-xl-4 align-items-center">

        <div class="col-xl-8">

            <!-- Title -->

            <div class="d-sm-flex gap-2 align-items-center mb-2">

                <h3 class="mb-2 mb-sm-0 fw-bold color-changer">{{ trans('labels.still_have_question') }}</h3>

                <!-- Avatar group -->

                <ul class="avatar-group mb-0 ms-sm-3">

                    @foreach ($reviewimage as $image)
                        <li class="avatar avatar-xs">

                            <img class="avatar-img rounded-circle" src="{{ helper::image_path($image->image) }}"
                                alt="avatar">

                        </li>
                    @endforeach

                </ul>

            </div>

            <p class="mb-0 text-muted fs-15">{{ trans('labels.footer_message') }}</p>

        </div>

        <!-- Content and input -->

        <div class="col-xl-4 {{ session()->get('direction') == 2 ? 'text-xl-start' : 'text-xl-end' }}">

            <a href="{{ URL::to($vendordata->slug . '/contact') }}" class="btn btn-primary mb-0 btn-submit rounded">
                <div class="d-flex gap-2 align-items-center">
                    {{ trans('labels.contactus') }}
                    <i class="fa-solid {{ session()->get('direction') == 2 ? 'fa-arrow-left' : 'fa-arrow-right' }}"></i>
                </div>
            </a>

        </div>

    </div> <!-- Row END -->

</div>
