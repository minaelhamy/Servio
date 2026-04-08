{{-- @foreach ($blogs as $blog)
<div class="item h-100 px-2 mb-1">
        <div class="card h-100">
            <div class="overflow-hidden">
                <img src="{{ helper::image_path($blog->image) }}"
                    class="card-img-top blog-card-top-img blog-card-hover" height="300" alt="...">
            </div>
            <div class="card-body pb-0">
                <div class="d-flex align-items-baseline">
                    <i class="fa-solid fa-calendar-days card-date"></i>
                    <p class="card-date px-2">{{ helper::date_formate($blog->created_at,$blog->vendor_id) }}
                    </p>
                </div>
                <h5 class="card-title blog-card-title pt-2">
                    {{ $blog->title }}
                </h5>
            </div>
            <div class="card-footer pt-0 bg-white text-end border-top-0">
                <a href="{{URL::to('/blogdetail-'.$blog->slug)}}" class="text-primary-color fs-7">
                   {{ Str::contains(request()->url(), 'blog') ? trans('landing.read_more') : trans('landing.read_more') }} 
                   <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
        </div>
</div>
@endforeach --}}


@foreach ($blogs as $blog)
    <div class="item h-100 px-1">
        <div class="card rounded-3 h-100 p-3">
            <div class="overflow-hidden rounded-3">
                <img src="{{ helper::image_path($blog->image) }}"
                    class="card-img-top blog-card-top-img rounded-3 blog-card-hover" height="260" alt="...">
            </div>
            <div class="card-body p-0 pt-3">
                <a href="{{ URL::to('/blogdetail-' . $blog->slug) }}">
                    <h6 class="fw-500 pt-2 text-secondary-color">
                        {{ $blog->title }}
                    </h6>
                </a>
                <p class="fs-7 text_truncation2 color-changer">Lorem ipsum dolor sit amet consectetur adipisicing elit. Ducimus,
                    nesciunt debitis. Asperiores perferendis, sed iure aut maxime repellat sunt debitis placeat numquam
                    quam non aliquid commodi animi excepturi ab perspiciatis.</p>
            </div>
            <div class="card-footer pt-3 mt-3 p-0 bg-transparent text-end border-top">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex gap-2 align-items-center">
                        <i class="fa-solid fa-calendar-days fs-7"></i>
                        <p class="fs-7 text-muted">
                            {{ helper::date_formate($blog->created_at, $blog->vendor_id) }}
                        </p>
                    </div>
                    <a href="{{ URL::to('/blogdetail-' . $blog->slug) }}">
                        <div class="text-secondary-color fs-7 fw-600">
                            {{ Str::contains(request()->url(), 'blog') ? trans('landing.read_more') : trans('landing.read_more') }}
                            <i class="fa-solid {{ session()->get('direction') == 2 ? 'fa-arrow-left' : 'fa-arrow-right' }}"></i>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endforeach
