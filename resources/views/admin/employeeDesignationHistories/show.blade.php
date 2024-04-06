@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.employeeDesignationHistory.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.employee-designation-histories.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.employeeDesignationHistory.fields.id') }}
                        </th>
                        <td>
                            {{ $employeeDesignationHistory->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.employeeDesignationHistory.fields.employee') }}
                        </th>
                        <td>
                            {{ $employeeDesignationHistory->employee->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.employeeDesignationHistory.fields.designation') }}
                        </th>
                        <td>
                            {{ $employeeDesignationHistory->designation->designation ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.employeeDesignationHistory.fields.start_date') }}
                        </th>
                        <td>
                            {{ $employeeDesignationHistory->start_date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.employeeDesignationHistory.fields.end_date') }}
                        </th>
                        <td>
                            {{ $employeeDesignationHistory->end_date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.employeeDesignationHistory.fields.remarks') }}
                        </th>
                        <td>
                            {{ $employeeDesignationHistory->remarks }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.employee-designation-histories.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection