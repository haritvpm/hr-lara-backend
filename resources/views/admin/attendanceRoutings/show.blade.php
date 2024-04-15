@extends('layouts.admin')
@section('content')

<div class="card_">
    <div class="card-header_">
        {{ trans('global.show') }} {{ trans('cruds.attendanceRouting.title') }}
    </div>

    <div class="card-body_">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.attendance-routings.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table  ">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.attendanceRouting.fields.id') }}
                        </th>
                        <td>
                            {{ $attendanceRouting->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.attendanceRouting.fields.viewer_js_as_ss_employee') }}
                        </th>
                        <td>
                            {{ $attendanceRouting->viewer_js_as_ss_employee->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.attendanceRouting.fields.viewer_seat') }}
                        </th>
                        <td>
                            {{ $attendanceRouting->viewer_seat->title ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.attendanceRouting.fields.viewable_seats') }}
                        </th>
                        <td>
                            @foreach($attendanceRouting->viewable_seats as $key => $viewable_seats)
                                <span class="label label-info">{{ $viewable_seats->title }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.attendanceRouting.fields.viewable_js_as_ss_employees') }}
                        </th>
                        <td>
                            @foreach($attendanceRouting->viewable_js_as_ss_employees as $key => $viewable_js_as_ss_employees)
                                <span class="label label-info">{{ $viewable_js_as_ss_employees->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.attendance-routings.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
