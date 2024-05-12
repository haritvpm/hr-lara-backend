@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.monthlyAttendance.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.monthly-attendances.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.monthlyAttendance.fields.id') }}
                        </th>
                        <td>
                            {{ $monthlyAttendance->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.monthlyAttendance.fields.aadhaarid') }}
                        </th>
                        <td>
                            {{ $monthlyAttendance->aadhaarid }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.monthlyAttendance.fields.employee') }}
                        </th>
                        <td>
                            {{ $monthlyAttendance->employee->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.monthlyAttendance.fields.month') }}
                        </th>
                        <td>
                            {{ $monthlyAttendance->month }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.monthlyAttendance.fields.compoff_granted') }}
                        </th>
                        <td>
                            {{ $monthlyAttendance->compoff_granted }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.monthlyAttendance.fields.total_grace_sec') }}
                        </th>
                        <td>
                            {{ $monthlyAttendance->total_grace_sec }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.monthlyAttendance.fields.total_extra_sec') }}
                        </th>
                        <td>
                            {{ $monthlyAttendance->total_extra_sec }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.monthlyAttendance.fields.total_grace_str') }}
                        </th>
                        <td>
                            {{ $monthlyAttendance->total_grace_str }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.monthlyAttendance.fields.total_extra_str') }}
                        </th>
                        <td>
                            {{ $monthlyAttendance->total_extra_str }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.monthlyAttendance.fields.grace_exceeded_sec') }}
                        </th>
                        <td>
                            {{ $monthlyAttendance->grace_exceeded_sec }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.monthlyAttendance.fields.total_grace_exceeded_300_date') }}
                        </th>
                        <td>
                            {{ $monthlyAttendance->total_grace_exceeded_300_date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.monthlyAttendance.fields.compen_marked') }}
                        </th>
                        <td>
                            {{ $monthlyAttendance->compen_marked }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.monthlyAttendance.fields.compen_submitted') }}
                        </th>
                        <td>
                            {{ $monthlyAttendance->compen_submitted }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.monthlyAttendance.fields.other_leaves_marked') }}
                        </th>
                        <td>
                            {{ $monthlyAttendance->other_leaves_marked }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.monthlyAttendance.fields.other_leaves_submitted') }}
                        </th>
                        <td>
                            {{ $monthlyAttendance->other_leaves_submitted }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.monthlyAttendance.fields.cl_marked') }}
                        </th>
                        <td>
                            {{ $monthlyAttendance->cl_marked }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.monthlyAttendance.fields.cl_submitted') }}
                        </th>
                        <td>
                            {{ $monthlyAttendance->cl_submitted }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.monthlyAttendance.fields.grace_minutes') }}
                        </th>
                        <td>
                            {{ $monthlyAttendance->grace_minutes }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.monthlyAttendance.fields.single_punchings') }}
                        </th>
                        <td>
                            {{ $monthlyAttendance->single_punchings }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.monthlyAttendance.fields.single_punchings_regularised') }}
                        </th>
                        <td>
                            {{ $monthlyAttendance->single_punchings_regularised }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.monthlyAttendance.fields.unauthorised_count') }}
                        </th>
                        <td>
                            {{ $monthlyAttendance->unauthorised_count }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.monthly-attendances.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection