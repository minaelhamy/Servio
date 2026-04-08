<table class="table table-striped table-bordered py-3 zero-configuration w-100 dataTable no-footer">
    <thead>
        <tr class="text-capitalize fw-500 fs-15">
            <td></td>
             @if (@helper::checkaddons('bulk_delete'))
                @if($getbanner->count() > 0)
                    <td> <input type="checkbox" id="selectAll" class="form-check-input checkbox-style"></td>
                @endif
            @endif
            <td>{{ trans('labels.srno') }}</td>
            <td>{{ trans('labels.image') }}</td>
            <td>{{ trans('labels.category') }}</td>
            <td>{{ trans('labels.service') }}</td>
            <td>{{ trans('labels.status') }}</td>
            <td>{{ trans('labels.created_date') }}</td>
            <td>{{ trans('labels.updated_date') }}</td>
            <td>{{ trans('labels.action') }}</td>
        </tr>
    </thead>
    <tbody id="tabledetails" data-url="{{ url('admin/'.$url.'/reorder_banner') }}">
         @php $i = 1;
         @endphp
        @foreach ($getbanner as $item)
            @if ($item->section == $section)
            <tr class="fs-7 row1 align-middle" id="dataid{{ $item->id }}" data-id="{{ $item->id }}">
                <td><a tooltip="{{ trans('labels.move') }}"><i
                    class="fa-light fa-up-down-left-right mx-2"></i></a></td>
                @if (@helper::checkaddons('bulk_delete'))
                    <td><input type="checkbox" class="row-checkbox form-check-input checkbox-style" value="{{ $item->id }}"></td>
                @endif
                <td>@php
                    echo $i++;
                @endphp</td>
                <td><img src="{{helper::image_path($item->image )}}" class="img-fluid rounded hight-50 object-fit-cover" alt=""></td>
                <td>
                    @if ($item->type == '1')
                        {{ @$item['category_info']->name }}
                    @else
                        --
                    @endif
                </td>
                <td>
                    @if ($item->type == '2')
                        {{ @$item['service_info']->name }}
                    @else
                        --
                    @endif
                </td>
                <td>
                    @if ($item->is_available == '1')
                        <a href="javascript:void(0)" tooltip="{{ trans('labels.active') }}" @if (env('Environment') == 'sendbox') onclick="myFunction()" @else
                            onclick="statusupdate('{{ URL::to('admin/'.$url.'/status_change-'.$item->id.'/2')}}')" @endif
                            class="btn btn-sm hov btn-outline-success {{Auth::user()->type == 4 ? (helper::check_access('role_banners',Auth::user()->role_id,$vendor_id,'edit') == 1 ? '' : 'd-none' ) : ''}}"><i class="fa-regular fa-check"></i></a>
                    @else
                        <a href="javascript:void(0)" tooltip="{{ trans('labels.inactive') }}" @if (env('Environment') == 'sendbox') onclick="myFunction()" @else
                            onclick="statusupdate('{{ URL::to('admin/'.$url.'/status_change-'.$item->id.'/1')}}')" @endif
                            class="btn btn-sm hov btn-outline-danger {{Auth::user()->type == 4 ? (helper::check_access('role_banners',Auth::user()->role_id,$vendor_id,'edit') == 1 ? '' : 'd-none' ) : ''}}"><i class="fa-regular fa-xmark"></i></a>
                    @endif
                </td>
                <td>
                    {{ helper::date_formate($item->created_at,$vendor_id) }}<br>
                    {{ helper::time_format($item->created_at,$vendor_id) }}
                    </td>
                    <td>{{ helper::date_formate($item->updated_at,$vendor_id) }}<br>
                    {{ helper::time_format($item->updated_at,$vendor_id) }}
                    </td>
                <td>
                    <div class="d-flex gap-2 flex-wrap">
                        <a href="{{ URL::to('admin/'.$url.'/edit-'.$item->id) }}" tooltip="{{trans('labels.edit')}}"
                            class="btn btn-info hov btn-sm {{Auth::user()->type == 4 ? (helper::check_access('role_banners',Auth::user()->role_id,$vendor_id,'edit') == 1 ? '' : 'd-none' ) : ''}}"> <i class="fa-regular fa-pen-to-square"></i></a>
                        <a href="javascript:void(0)" tooltip="{{trans('labels.delete')}}" @if (env('Environment') == 'sendbox') onclick="myFunction()" @else
                            onclick="statusupdate('{{ URL::to('admin/'.$url.'/delete-'.$item->id)}}')" @endif
                            class="btn btn-danger hov btn-sm {{Auth::user()->type == 4 ? (helper::check_access('role_banners',Auth::user()->role_id,$vendor_id,'delete') == 1 ? '' : 'd-none' ) : ''}}"> <i class="fa-regular fa-trash"></i></a>
                    </div>
                </td>
            </tr>
            @endif
            @endforeach
    </tbody>
</table>

