@php
    $subscription = helper::subscription_details($vendordata->id);
@endphp
<section class="subscription my-5 extra-marginss">
    <div class="container">
        <div class="card rounded-4 border-0 bg-lights p-4">
            <div class="row align-items-center">
                <div class="col-4 d-none d-lg-block">
                    <img src="{{ helper::image_path(@$subscription->image) }}" alt=""
                        class="w-100 object-fit-cover rounded-4">
                </div>
                <div class="col-12 col-lg-8">
                    <h2 class="subscribe-title color-changer fs-3">{{ @$subscription->title }}</h2>
                    <p class="fw-light mb-3 text-muted">{{ @$subscription->subtitle }}</p>
                    <form action="{{ URL::to('/' . $vendordata->slug . '/subscribe') }}" method="POST">
                        @csrf
                        <div class="sub_changer rounded p-2 shadow-sm rounded mb-3 mb-md-0">
                            <div class="input-group gap-2">
                                <input class="form-control border-0 rounded" type="email" name="email"
                                    placeholder="{{ trans('labels.email') }}" required>
                                <button type="submit"
                                    class="btn btn-primary mb-0 btn-submit rounded d-none d-md-inline-block">{{ trans('labels.subscribe') }}!</button>
                            </div>
                        </div>
                        <button type="submit"
                            class="btn btn-primary w-100  mb-0 btn-submit rounded d-inline-block d-md-none">{{ trans('labels.subscribe') }}!</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
