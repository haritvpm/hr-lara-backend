@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.yearlyAttendance.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.yearly-attendances.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.yearlyAttendance.fields.id') }}
                        </th>
                        <td>
                            {{ $yearlyAttendance->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.yearlyAttendance.fields.aadhaarid') }}
                        </th>
                        <td>
                            {{ $yearlyAttendance->aadhaarid }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.yearlyAttendance.fields.employee') }}
                        </th>
                        <td>
                            {{ $yearlyAttendance->employee->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.yearlyAttendance.fields.year') }}
                        </th>
                        <td>
                            {{ $yearlyAttendance->year }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.yearlyAttendance.fields.cl_marked') }}
                        </th>
                        <td>
                            {{ $yearlyAttendance->cl_marked }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.yearlyAttendance.fields.cl_submitted') }}
                        </th>
                        <td>
                            {{ $yearlyAttendance->cl_submitted }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.yearlyAttendance.fields.compen_marked') }}
                        </th>
                        <td>
                            {{ $yearlyAttendance->compen_marked }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.yearlyAttendance.fields.compen_submitted') }}
                        </th>
                        <td>
                            {{ $yearlyAttendance->compen_submitted }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.yearlyAttendance.fields.other_leaves_marked') }}
                        </th>
                        <td>
                            {{ $yearlyAttendance->other_leaves_marked }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.yearlyAttendance.fields.other_leaves_submitted') }}
                        </th>
                        <td>
                            {{ $yearlyAttendance->other_leaves_submitted }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.yearlyAttendance.fields.start_with_cl') }}
                        </th>
                        <td>
                            {{ $yearlyAttendance->start_with_cl }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.yearlyAttendance.fields.start_with_compen') }}
                        </th>
                        <td>
                            {{ $yearlyAttendance->start_with_compen }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.yearlyAttendance.fields.single_punchings') }}
                        </th>
                        <td>
                            {{ $yearlyAttendance->single_punchings }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.yearlyAttendance.fields.single_punchings_regularised') }}
                        </th>
                        <td>
                            {{ $yearlyAttendance->single_punchings_regularised }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.yearlyAttendance.fields.unauthorised_count') }}
                        </th>
                        <td>
                            {{ $yearlyAttendance->unauthorised_count }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.yearly-attendances.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection