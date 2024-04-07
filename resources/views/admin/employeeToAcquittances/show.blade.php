@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.employeeToAcquittance.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.employee-to-acquittances.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.employeeToAcquittance.fields.id') }}
                        </th>
                        <td>
                            {{ $employeeToAcquittance->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.employeeToAcquittance.fields.employee') }}
                        </th>
                        <td>
                            {{ $employeeToAcquittance->employee->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.employeeToAcquittance.fields.acquittance') }}
                        </th>
                        <td>
                            {{ $employeeToAcquittance->acquittance->title ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.employeeToAcquittance.fields.start_date') }}
                        </th>
                        <td>
                            {{ $employeeToAcquittance->start_date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.employeeToAcquittance.fields.end_date') }}
                        </th>
                        <td>
                            {{ $employeeToAcquittance->end_date }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.employee-to-acquittances.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection