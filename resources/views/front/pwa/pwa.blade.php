<meta name="theme-color" content="{{ helper::appdata($vendordata->id)->theme_color }}">
<meta name="background-color" content="{{ helper::appdata($vendordata->id)->background_color }}">
<link rel="apple-touch-icon" href="{{ helper::image_path(helper::appdata($vendordata->id)->app_logo) }}">

<link rel="manifest"
    href='data:application/manifest+json,{"name": "{{ helper::appdata($vendordata->id)->app_name }}","short_name": "{{ helper::appdata($vendordata->id)->app_name }}","icons": [{"src": "{{ helper::image_path(helper::appdata($vendordata->id)->app_logo) }}", "sizes": "512x512", "type": "image/png"}, {"src": "{{ helper::image_path(helper::appdata($vendordata->id)->app_logo) }}", "sizes": "1024x1024", "type": "image/png"}, {"src": "{{ helper::image_path(helper::appdata($vendordata->id)->app_logo) }}", "sizes": "1024x1024", "type": "image/png"}], "start_url": "{{ request()->url() }}","display": "standalone","prefer_related_applications":"false" }'>


{{-- Popup --}}
<div class="d-block d-md-none">
    <div class="pwa-install gap-2">
        <div class="pwa-image">
            <img src="{{ helper::image_path($user->image) }}" class="w-100 h-100 object-fit-cover" alt="">
        </div>
        <div class="pwa-content">
            <h5 class="text-white mb-1 line-1 fs-7">{{ helper::appdata(@$vendordata->id)->app_title }}</h5>
            <p class="m-0 fs-8 line-1">Get our PWA in your device. It won't take up space in your device</p>
        </div>
        <a class="btn mobile-install-btn fs-7 fw-600" id="mobile-install-app">{{ trans('labels.install') }}</a>
        <a class="close-btn" id="close-btn">
            <i class="fa-solid fa-xmark fs-7"></i>
        </a>
    </div>
</div>

