@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.employeeDetail.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.employee-details.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.employeeDetail.fields.id') }}
                        </th>
                        <td>
                            {{ $employeeDetail->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.employeeDetail.fields.employee') }}
                        </th>
                        <td>
                            {{ $employeeDetail->employee->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.employeeDetail.fields.election') }}
                        </th>
                        <td>
                            {{ $employeeDetail->election }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.employeeDetail.fields.kla_id_no') }}
                        </th>
                        <td>
                            {{ $employeeDetail->kla_id_no }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.employee-details.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection