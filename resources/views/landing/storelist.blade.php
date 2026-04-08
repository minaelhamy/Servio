@php
    $i = 1;
@endphp
@foreach (helper::storedata() as $user)
    <div class="col" data-aos="fade-up" data-aos-delay="{{ $i++ }}00" data-aos-duration="1000">
        <a href="@if (helper::checkcustomdomain($user->id) == null){{ URL::to($user->slug . '/') }} @else {{ '//' . helper::checkcustomdomain($user->id) }} @endif" target="_blank">
            <div class="post-slide h-100 card bg-transparent border-0">
                <div class="post-img rounded-3 overflow-hidden">
                    <span class="over-layer">
                    </span>
                    <img src="{{ @helper::image_path(@$user->cover_image) }}" alt="">
                </div>
                <div class="card-body pt-3 p-0">
                    <h3 class="fs-6 post-title text-capitalize color-changer fw-600 line-2 m-0">
                        {{ @$user->web_title }}
                    </h3>
                </div>
            </div>
        </a>
    </div>
@endforeach
