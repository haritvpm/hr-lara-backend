@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.employeeOtSetting.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.employee-ot-settings.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.employeeOtSetting.fields.id') }}
                        </th>
                        <td>
                            {{ $employeeOtSetting->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.employeeOtSetting.fields.employee') }}
                        </th>
                        <td>
                            {{ $employeeOtSetting->employee->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.employeeOtSetting.fields.is_admin_data_entry') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $employeeOtSetting->is_admin_data_entry ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.employeeOtSetting.fields.ot_excel_category') }}
                        </th>
                        <td>
                            {{ $employeeOtSetting->ot_excel_category->category ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.employee-ot-settings.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection