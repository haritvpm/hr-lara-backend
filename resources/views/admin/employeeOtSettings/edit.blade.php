@extends('layouts.admin')
@section('content')

<div class="card_">
    <div class="card-header_">
        {{ trans('global.edit') }} {{ trans('cruds.employeeOtSetting.title_singular') }}
    </div>

    <div class="card-body_">
        <form method="POST" action="{{ route("admin.employee-ot-settings.update", [$employeeOtSetting->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="employee_id">{{ trans('cruds.employeeOtSetting.fields.employee') }}</label>
                <select class="form-control select2 {{ $errors->has('employee') ? 'is-invalid' : '' }}" name="employee_id" id="employee_id" required>
                    @foreach($employees as $id => $entry)
                        <option value="{{ $id }}" {{ (old('employee_id') ? old('employee_id') : $employeeOtSetting->employee->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('employee'))
                    <span class="text-danger">{{ $errors->first('employee') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.employeeOtSetting.fields.employee_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('is_admin_data_entry') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="is_admin_data_entry" value="0">
                    <input class="form-check-input" type="checkbox" name="is_admin_data_entry" id="is_admin_data_entry" value="1" {{ $employeeOtSetting->is_admin_data_entry || old('is_admin_data_entry', 0) === 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_admin_data_entry">{{ trans('cruds.employeeOtSetting.fields.is_admin_data_entry') }}</label>
                </div>
                @if($errors->has('is_admin_data_entry'))
                    <span class="text-danger">{{ $errors->first('is_admin_data_entry') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.employeeOtSetting.fields.is_admin_data_entry_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="ot_excel_category_id">{{ trans('cruds.employeeOtSetting.fields.ot_excel_category') }}</label>
                <select class="form-control select2 {{ $errors->has('ot_excel_category') ? 'is-invalid' : '' }}" name="ot_excel_category_id" id="ot_excel_category_id" required>
                    @foreach($ot_excel_categories as $id => $entry)
                        <option value="{{ $id }}" {{ (old('ot_excel_category_id') ? old('ot_excel_category_id') : $employeeOtSetting->ot_excel_category->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('ot_excel_category'))
                    <span class="text-danger">{{ $errors->first('ot_excel_category') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.employeeOtSetting.fields.ot_excel_category_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection
