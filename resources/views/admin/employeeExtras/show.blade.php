@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.employeeExtra.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.employee-extras.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.employeeExtra.fields.id') }}
                        </th>
                        <td>
                            {{ $employeeExtra->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.employeeExtra.fields.employee') }}
                        </th>
                        <td>
                            {{ $employeeExtra->employee->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.employeeExtra.fields.address') }}
                        </th>
                        <td>
                            {{ $employeeExtra->address }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.employeeExtra.fields.date_of_joining_kla') }}
                        </th>
                        <td>
                            {{ $employeeExtra->date_of_joining_kla }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.employeeExtra.fields.pan') }}
                        </th>
                        <td>
                            {{ $employeeExtra->pan }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.employeeExtra.fields.klaid') }}
                        </th>
                        <td>
                            {{ $employeeExtra->klaid }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.employeeExtra.fields.electionid') }}
                        </th>
                        <td>
                            {{ $employeeExtra->electionid }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.employeeExtra.fields.mobile') }}
                        </th>
                        <td>
                            {{ $employeeExtra->mobile }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.employeeExtra.fields.email') }}
                        </th>
                        <td>
                            {{ $employeeExtra->email }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.employee-extras.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection