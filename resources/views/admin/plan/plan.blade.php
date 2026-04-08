@extends('admin.layout.default')
@section('content')
    @php
        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        $module = 'role_pricing_plan';
    @endphp
    @include('admin.breadcrumb.breadcrumb')
    <div class="row g-3 pb-3 pt-4 {{ Auth::user()->type == 1 || (Auth::user()->type == 4 && Auth::user()->vendor_id == 1) ? 'sort_menu' : '' }}"
        id="carddetails" data-url="{{ url('admin/plan/reorder_plan') }}">
        @if (count($allplan) > 0)
            @foreach ($allplan as $plandata)
                @php
                    if (Auth::user()->type == 4 && Auth::user()->vendor_id != 1) {
                        $plan = helper::getplantransaction(Auth::user()->vendor_id);
                        $plan_id = $plan->plan_id;
                        $purchase_amount = $plan->amount;
                    } else {
                        $plan_id = Auth::user()->plan_id;
                        $purchase_amount = Auth::user()->purchase_amount;
                    }
                    $check_vendorplan = helper::checkplan($vendor_id, '');
                    $data = json_decode(json_encode($check_vendorplan), true);
                @endphp
                @if (Auth::user()->type == 2 || (Auth::user()->type == 4 && Auth::user()->vendor_id != 1))
                    @if ($plandata->vendor_id != '' && $plandata->vendor_id != null)
                        @if (in_array($vendor_id, explode('|', $plandata->vendor_id)))
                            @include('admin.plan.plancommon')
                        @endif
                    @else
                        @include('admin.plan.plancommon')
                    @endif
                @else
                    @include('admin.plan.plancommon')
                @endif
            @endforeach
        @else
            @include('admin.layout.no_data')
        @endif
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $('.sort_menu').sortable({
                handle: '.handle',
                cursor: 'move',
                placeholder: 'highlight',
                axis: "x,y",

                update: function(e, ui) {
                    var sortData = $('.sort_menu').sortable('toArray', {
                        attribute: 'data-id'
                    })
                    updateToDatabase(sortData.join('|'))
                }
            })

            function updateToDatabase(idString) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    dataType: "json",
                    url: $('#carddetails').attr('data-url'),
                    data: {
                        ids: idString,
                    },
                    success: function(response) {
                        if (response.status == 1) {
                            toastr.success(response.msg);
                        } else {
                            toastr.success(wrong);
                        }
                    }
                });
            }

        })
    </script>
    <script>
        function themeinfo(id, theme_id, plan_name) {
            let string = theme_id;
            let arr = string.split('|');
            $('#themeinfoLabel').text(plan_name);
            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                },
                url: "{{ URL::to('admin/themeimages') }}",
                method: 'GET',
                data: {
                    theme_id: arr
                },
                dataType: 'json',
                success: function(data) {
                    $('#theme_modalbody').html(data.output);
                    $('#themeinfo').modal('show');
                }
            })
        }
    </script>
@endsection
