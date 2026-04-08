@extends('admin.layout.default')

@section('content')

    @include('admin.breadcrumb.breadcrumb')

    @php

        if (Auth::user()->type == 4) {

            $vendor_id = Auth::user()->vendor_id;

        } else {

            $vendor_id = Auth::user()->id;

        }

        $module = 'role_choose_us';

    @endphp

    <div class="row mt-3">

        <div class="col-12">

            <form action="{{ URL::to('admin/choose_us/savecontent') }}" method="POST" enctype="multipart/form-data">

                @csrf

                <div class="card border-0 mb-3 p-3 box-shadow">

                    <div class="row">

                        <div class="col-md-6 mb-lg-0">

                            <div class="form-group">

                                <label class="form-label">{{ trans('labels.title') }}<span class="text-danger"> *

                                    </span></label>

                                <input type="text"

                                    class="form-control {{ session()->get('direction') == 2 ? 'input-group-rtl' : '' }}"

                                    name="title" placeholder="{{ trans('labels.title') }}"

                                    value="{{ $content->why_choose_title }}" required>





                            </div>

                        </div>

                        <div class="col-md-6 mb-lg-0">

                            <div class="form-group">

                                <label class="form-label">{{ trans('labels.subtitle') }}<span class="text-danger"> *

                                    </span></label>

                                <input type="text"

                                    class="form-control {{ session()->get('direction') == 2 ? 'input-group-rtl' : '' }}"

                                    name="subtitle" placeholder="{{ trans('labels.subtitle') }}"

                                    value="{{ $content->why_choose_subtitle }}" required>



                            </div>

                        </div>

                        <div class="col-md-6 mb-lg-0">

                            <div class="form-group">

                                <label class="form-label">{{ trans('labels.image') }}<span class="text-danger"> *

                                    </span></label>

                                <input type="file" class="form-control" name="image">

                                @error('image')

                                    <span class="text-danger">{{ $message }}</span>

                                @enderror

                            </div>

                            <img src="{{ helper::image_path($content->why_choose_image) }}" class="img-fluid rounded hw-70"

                                alt="">

                        </div>

                        <div class="text-{{ session()->get('direction') == '2' ? 'start' : 'end' }}">

                            <button type="submit" class="btn btn-primary px-sm-4 {{ Auth::user()->type == 4 ? (helper::check_access('role_choose_us', Auth::user()->role_id, $vendor_id, 'add') == 1 ? '' : 'd-none') : '' }}">{{ trans('labels.save') }}</button>

                        </div>

                    </div>

                </div>

            </form>

            <div class="card border-0 mb-3 box-shadow">

                <div class="text-{{ session()->get('direction') == '2' ? 'start' : 'end' }}">

                    <a href="{{ URL::to(request()->url() . '/add') }}" class="btn btn-primary px-sm-4 mx-3 mt-3">

                        <i class="fa-regular fa-plus mx-1"></i>{{ trans('labels.add') }}</a>

                </div>

                <div class="card-body">

                    <div class="table-responsive">

                        <table class="table table-striped table-bordered py-3 zero-configuration w-100 dataTable no-footer">

                            <thead>

                                <tr class="text-capitalize fw-500 fs-15">

                                    <td></td>

                                    <td>{{ trans('labels.srno') }}</td>

                                    <td>{{ trans('labels.image') }}</td>

                                    <td>{{ trans('labels.title') }}</td>

                                    <td>{{ trans('labels.description') }}</td>

                                    <td>{{ trans('labels.created_date') }}</td>

                                    <td>{{ trans('labels.updated_date') }}</td>

                                    <td>{{ trans('labels.action') }}</td>

                                </tr>

                            </thead>

                            

                            <tbody id="tabledetails" data-url="{{ url('admin/choose_us/reorder_choose_us') }}">

                                @php

                                    $i = 1;

                                @endphp

                                @foreach ($allworkcontent as $content)

                                    <tr class="fs-7 row1 align-middle" id="dataid{{ $content->id }}" data-id="{{ $content->id }}">

                                        <td><a tooltip="{{ trans('labels.move') }}"><i

                                            class="fa-light fa-up-down-left-right mx-2"></i></a></td>

                                        <td>@php

                                            echo $i++;

                                        @endphp</td>

                                        <td><img src="{{ helper::image_path($content->image) }}"

                                                class="img-fluid rounded hw-50 object-fit-cover" alt=""></td>

                                        <td>{{ $content->title }}</td>

                                        <td>{{ $content->description }}</td>

                                        <td>{{ helper::date_formate($content->created_at,$vendor_id) }}<br>

                                            {{ helper::time_format($content->created_at, $vendor_id) }}

                                        </td>

                                        <td>{{ helper::date_formate($content->updated_at,$vendor_id) }}<br>

                                            {{ helper::time_format($content->updated_at, $vendor_id) }}

                                        </td>

                                        <td>

                                            <div class="d-flex flex-wrap gap-2">
                                                <a href="{{ URL::to('/admin/choose_us/edit-' . $content->id) }}"
    
                                                    tooltip="{{ trans('labels.edit') }}" class="btn btn-info btn-sm hov {{ Auth::user()->type == 4 ? (helper::check_access('role_choose_us', Auth::user()->role_id, Auth::user()->vendor_id, 'edit') == 1  ? '' : 'd-none') : '' }}">
    
                                                    <i class="fa-regular fa-pen-to-square"></i></a>
    
                                                <a href="javascript:void(0)" tooltip="{{ trans('labels.delete') }}"
    
                                                    @if (env('Environment') == 'sendbox') onclick="myFunction()" @else
    
                                                    onclick="statusupdate('{{ URL::to('/admin/choose_us/delete-' . $content->id) }}')" @endif
    
                                                    class="btn btn-danger btn-sm hov {{ Auth::user()->type == 4 ? (helper::check_access('role_choose_us', Auth::user()->role_id, Auth::user()->vendor_id, 'delete') == 1  ? '' : 'd-none') : '' }}"> <i
    
                                                        class="fa-regular fa-trash"></i></a>
                                            </div>

                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection

