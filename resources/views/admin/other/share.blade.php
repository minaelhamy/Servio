@extends('admin.layout.default')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="text-capitalize color-changer fw-600 fs-4">{{ trans('labels.share') }}</h5>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card border-0 box-shadow">
                <div class="card-body">
                    <div class="card-block text-center">
                        @php
                            if (helper::checkcustomdomain(Auth::user()->id) == null) {
                                $url = URL::to('/' . Auth::user()->slug);
                            } else {
                                $url = 'https://' . helper::checkcustomdomain(Auth::user()->id);
                            }
                        @endphp
                        <img src="@if (helper::checkcustomdomain(Auth::user()->id) == null) https://qrcode.tec-it.com/API/QRCode?data={{ $url}}&chs=180x180 @else https://qrcode.tec-it.com/API/QRCode?data={{ $url }}&chs=180x180 @endif"
                            width="230px" />
                        <div class="card-block mt-3">
                            <button class="btn btn-secondary mb-4" onclick="myFunction()">{{ trans('labels.share') }}
                                <i class="fa-sharp fa-solid fa-share-nodes ms-2"></i>
                            </button>
                            <a href="@if (helper::checkcustomdomain(Auth::user()->id) == null) https://qrcode.tec-it.com/API/QRCode?data={{ $url }}&chs=180x180 @else https://qrcode.tec-it.com/API/QRCode?data={{ $url  }}&chs=180x180 @endif"
                                target="_blank" class="btn btn-secondary mb-4">{{ trans('labels.download') }}
                                <i class="fa-solid fa-arrow-down-to-line ms-2"></i>
                            </a>
                            <div id="share-icons" class="d-none">
                                {!! $shareComponent !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        function myFunction() {
            $('#share-icons').toggleClass('d-none');
        }
    </script>
@endsection
