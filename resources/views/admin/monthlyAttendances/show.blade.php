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
                            {{ trans('cruds.monthlyAttendance.fields.total_cl') }}
                        </th>
                        <td>
                            {{ $monthlyAttendance->total_cl }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.monthlyAttendance.fields.total_compen') }}
                        </th>
                        <td>
                            {{ $monthlyAttendance->total_compen }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.monthlyAttendance.fields.total_compen_off_granted') }}
                        </th>
                        <td>
                            {{ $monthlyAttendance->total_compen_off_granted }}
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