@extends('admin.layout.default')

@section('content')
    @include('admin.breadcrumb.breadcrumb')

    <div class="row">

        @php

            if (Auth::user()->type == 4) {
                $vendor_id = Auth::user()->vendor_id;
            } else {
                $vendor_id = Auth::user()->id;
            }

        @endphp

        <div class="col-12">

            <div class="card border-0 my-3 box-shadow">

                <div class="card-body">

                    <div class="alert alert-warning">

                        <small>You already have a custom domain

                            (<a target="_blank" href="//{{ helper::appdata($vendor_id)->custom_domain }}"
                                class="color-changer">{{ empty(helper::appdata($vendor_id)->custom_domain) ? '-' : helper::appdata($vendor_id)->custom_domain }}</a>)

                            connected with your website. <br>

                            if you request another domain now &amp; if it gets connected with our server, then

                            your current domain

                            (<a target="_blank" href="//{{ helper::appdata($vendor_id)->custom_domain }}"
                                class="color-changer">{{ empty(helper::appdata($vendor_id)->custom_domain) ? '-' : helper::appdata($vendor_id)->custom_domain }}</a>)

                            will be removed.</small>

                    </div>

                    <form class="col-md-12 mt-2" action="{{ URL::to('admin/custom_domain/save') }}">

                        <div class="my-2">

                            <label for="custom_domain" class="text-muted"> {{ trans('labels.custom_domain') }}</label>

                            <input type="text" name="custom_domain" class="form-control"
                                placeholder="{{ trans('labels.custom_domain') }}" required>

                            @error('custom_domain')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror

                        </div>

                        <p class="mb-0 text-muted"><i class="fas fa-exclamation-circle"></i> Do not use

                            <strong class="text-danger">http://</strong> or <strong class="text-danger">https://</strong>

                        </p>

                        <p class="mb-0 mb-2 text-muted"><i class="fas fa-exclamation-circle"></i>

                            The valid format will be exactly like this one - <strong class="text-danger">domain.tld,

                                www.domain.tld</strong> or <strong class="text-danger">subdomain.domain.tld,

                                www.subdomain.domain.tld</strong>

                        </p>
                        <div class="form-group text-{{ session()->get('direction') == '2' ? 'start' : 'end' }} m-0">
                            <button
                                @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif
                                class="btn btn-primary px-sm-4 {{ Auth::user()->type == 4 ? (helper::check_access('role_custom_domains', Auth::user()->role_id, Auth::user()->vendor_id, 'add') == 1 || helper::check_access(trans('labels.custom_domains'), Auth::user()->role_id, Auth::user()->vendor_id, 'edit') == 1 ? '' : 'd-none') : '' }}">{{ trans('labels.save') }}</button>
                        </div>
                    </form>

                </div>

            </div>

        </div>

    </div>
@endsection
