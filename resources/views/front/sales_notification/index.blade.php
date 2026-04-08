<div class="card-body p-0">
    <div class="d-flex align-items-center gap-2">
        <div class="col-auto">
            <img src="{{ helper::image_path($servicedata->image) }}" class="rounded sales-notification-img">
        </div>
        <div class="w-100">
            <h6 class="heading text-capitalize color-changer">
                @if (strlen($servicedata->name) > 30)
                    {{ substr($servicedata->name, 0, 30) . '...' }}
                @else
                    {{ $servicedata->name }}
                @endif
            </h6>
            <p class="info line-2 text-muted">
                {{ trans('labels.recently_booked') }}
            </p>
            <div class="read-more-wrapper">
                <a href="{{ URL::to($vendordata->slug . '/service-' . $servicedata->slug) }}">
                    <span
                        class="read-more text-primary text-decoration-underline">{{ trans('labels.view_service') }}</span>
                </a>
            </div>
        </div>
    </div>
</div>
