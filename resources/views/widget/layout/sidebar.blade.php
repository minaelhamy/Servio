 <!--==================================== left side navbar start ====================================-->
 <div class="col-md-4 col-lg-3 col-12 left-side">
    <div class="left-heading">
        <a href="#" class="logo d-flex d-md-block justify-content-center">
            <img src="{{ helper::image_path(helper::appdata($vendordata->id)->frame_logo) }}" alt="logo" class="logo-img">
        </a>
    </div>

    <ul class="progress-bar pb-2 d-md-block d-none">
        @if( request()->is($vendordata->slug.'/embedded') )
            <li class="active">
                <span class="d-none d-md-block fw-medium">{{ trans('labels.category') }}</span>
            </li>
            <li>
                <span class="d-none d-md-block fw-medium font-color">{{ trans('labels.service') }}</span>
            </li>
            <li>
                <span class="d-none d-md-block fw-medium font-color">{{ trans('labels.date_time') }}</span>
            </li>
            <li>
                <span class="d-none d-md-block fw-medium font-color">{{ trans('labels.information') }}</span>
            </li>
            <li>
                <span class="d-none d-md-block fw-medium font-color">{{ trans('labels.confirmation') }}</span>
            </li>
        @endif

        @if( request()->is($vendordata->slug.'/embedded/services') )
            <li class="active">
                <span class="d-none d-md-block fw-medium">{{ trans('labels.category') }}</span>
            </li>
            <li class="active">
                <span class="d-none d-md-block fw-medium">{{ trans('labels.service') }}</span>
            </li>
            <li>
                <span class="d-none d-md-block fw-medium font-color">{{ trans('labels.date_time') }}</span>
            </li>
            <li>
                <span class="d-none d-md-block fw-medium font-color">{{ trans('labels.information') }}</span>
            </li>
            <li>
                <span class="d-none d-md-block fw-medium font-color">{{ trans('labels.confirmation') }}</span>
            </li>
        @endif

        @if( request()->is($vendordata->slug.'/embedded/datetime') )
            <li class="active">
                <span class="d-none d-md-block fw-medium">{{ trans('labels.category') }}</span>
            </li>
            <li class="active">
                <span class="d-none d-md-block fw-medium">{{ trans('labels.service') }}</span>
            </li>
            <li class="active">
                <span class="d-none d-md-block fw-medium">{{ trans('labels.date_time') }}</span>
            </li>
            <li>
                <span class="d-none d-md-block fw-medium font-color">{{ trans('labels.information') }}</span>
            </li>
            <li>
                <span class="d-none d-md-block fw-medium font-color">{{ trans('labels.confirmation') }}</span>
            </li>
        @endif

        @if( request()->is($vendordata->slug.'/embedded/information') )
            <li class="active">
                <span class="d-none d-md-block fw-medium">{{ trans('labels.category') }}</span>
            </li>
            <li class="active">
                <span class="d-none d-md-block fw-medium">{{ trans('labels.service') }}</span>
            </li>
            <li class="active">
                <span class="d-none d-md-block fw-medium">{{ trans('labels.date_time') }}</span>
            </li>
            <li class="active">
                <span class="d-none d-md-block fw-medium">{{ trans('labels.information') }}</span>
            </li>
            <li>
                <span class="d-none d-md-block fw-medium font-color">{{ trans('labels.confirmation') }}</span>
            </li>
        @endif

        @if( request()->is($vendordata->slug.'/embedded/confirmation') )
            <li class="active">
                <span class="d-none d-md-block fw-medium">{{ trans('labels.category') }}</span>
            </li>
            <li class="active">
                <span class="d-none d-md-block fw-medium">{{ trans('labels.service') }}</span>
            </li>
            <li class="active">
                <span class="d-none d-md-block fw-medium">{{ trans('labels.date_time') }}</span>
            </li>
            <li class="active">
                <span class="d-none d-md-block fw-medium">{{ trans('labels.information') }}</span>
            </li>
            <li class="active">
                <span class="d-none d-md-block fw-medium">{{ trans('labels.confirmation') }}</span>
            </li>
        @endif
        
    </ul>
</div>
<!--==================================== left side navbar end ====================================-->