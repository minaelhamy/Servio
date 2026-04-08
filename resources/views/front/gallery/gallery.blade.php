@extends('front.layout.master')
@section('content')
    <div class="container">
        <div class="breadcrumb-div pt-4">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ URL::to($vendordata->slug) }}" class="text-primary-color"><i
                                class="fa-solid fa-house fs-7 {{ session()->get('direction') == 2 ? 'ms-2' : 'me-2' }}"></i>{{ trans('labels.home') }}</a>
                    </li>
                    <li class="breadcrumb-item active {{ session()->get('direction') == 2 ? 'breadcrumb-item-right' : 'breadcrumb-item-left' }}"
                        aria-current="page">{{ trans('labels.gallery') }}</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--------------------------------------------------- Gallery section start --------------------------------------------------->
    <section class="gallery">
        <!-- gallery-title -->
        <div class="container">
            <h2 class="section-title fw-bold fs-3">{{ trans('labels.gallery') }}</h2>
        </div>
        <!-- gallery-content -->
        @if ($allgallery->count() > 0)
            <div class="container py-4">
                <div class="grid-wrapper">
                    @foreach ($allgallery as $key => $gallery)
                        <?php
                        $rdiv = ['', 'tall', 'big','wide'];
                        $rand_keys = array_rand($rdiv);
                        ?>
                        <div class="{{ $rdiv[$rand_keys] }} rounded">
                            <a id="gallery" class="glightbox w-100" data-glightbox="type: image"
                                href="{{ helper::image_path($gallery->image) }}">
                                <img src="{{ helper::image_path($gallery->image) }}" alt=""
                                    class="w-100 rounded object-fit-cover" />
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            @include('admin.layout.no_data')
        @endif
        <!-- question box start -->
        <div class="container">
            @include('front.contact.index')
        </div>
        <!-- question box end -->
    </section>
    <!---------------------------------------------------- Gallery section end ---------------------------------------------------->
@endsection
