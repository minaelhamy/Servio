{{-- @dd($vendordata->id) --}}
@if (helper::top_deals($vendordata->id) != null && count(helper::topdealitemlist($vendordata->id)) > 0)
    <nav class="background-black p-3">
        <div class="container">
            <div id="eapps-countdown-timer-1"
                class="rounded fix-color eapps-countdown-timer eapps-countdown-timer-align-center eapps-countdown-timer-position-bottom-bar-floating eapps-countdown-timer-animation-none eapps-countdown-timer-theme-default eapps-countdown-timer-finish-button-show   eapps-countdown-timer-style-combined eapps-countdown-timer-style-blocks eapps-countdown-timer-position-bar eapps-countdown-timer-area-clickable eapps-countdown-timer-has-background">
                <div class="eapps-countdown-timer-container d-flex">
                    <div class="eapps-countdown-timer-inner row g-3 flex-column flex-sm-row">
                        <div
                            class="eapps-countdown-timer-header d-sm-flex d-none col-md-4 align-items-center justify-content-center justify-content-md-start">
                            <div class="eapps-countdown-timer-header-title ">
                                <div class="eapps-countdown-timer-header-title-text text-center {{ session()->get('direction') == 2 ? 'text-md-end' : 'text-md-start' }}">
                                    <div class="line-2">{{ trans('labels.top_deals_title') }}
                                        {{ trans('labels.top_deals_description') }}</div>
                                </div>
                            </div>
                            <div class="eapps-countdown-timer-header-caption"></div>
                        </div>
                        <div class="eapps-countdown-timer-item-container col-md-4">
                            <div class="eapps-countdown-timer-item d-flex gap-2 justify-content-center countdowntime">
                            </div>
                        </div>
                        @if (request()->get('type') != 'topdeals')
                            <div
                                class="eapps-countdown-timer-button-container d-flex col-md-4 align-items-center justify-content-center justify-content-md-end">
                                <a href="{{ URL::to($vendordata->slug . '/services?type=topdeals') }}"
                                    class="eapps-countdown-timer-button rounded">
                                    {{ trans('labels.book_now') }}
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </nav>
@endif
