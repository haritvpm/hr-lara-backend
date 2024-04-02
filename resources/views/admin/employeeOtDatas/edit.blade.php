@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.employeeOtData.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.employee-ot-datas.update", [$employeeOtData->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="employee_id">{{ trans('cruds.employeeOtData.fields.employee') }}</label>
                <select class="form-control select2 {{ $errors->has('employee') ? 'is-invalid' : '' }}" name="employee_id" id="employee_id" required>
                    @foreach($employees as $id => $entry)
                        <option value="{{ $id }}" {{ (old('employee_id') ? old('employee_id') : $employeeOtData->employee->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('employee'))
                    <div class="invalid-feedback">
                        {{ $errors->first('employee') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employeeOtData.fields.employee_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('is_admin_data_entry') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="is_admin_data_entry" value="0">
                    <input class="form-check-input" type="checkbox" name="is_admin_data_entry" id="is_admin_data_entry" value="1" {{ $employeeOtData->is_admin_data_entry || old('is_admin_data_entry', 0) === 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_admin_data_entry">{{ trans('cruds.employeeOtData.fields.is_admin_data_entry') }}</label>
                </div>
                @if($errors->has('is_admin_data_entry'))
                    <div class="invalid-feedback">
                        {{ $errors->first('is_admin_data_entry') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employeeOtData.fields.is_admin_data_entry_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="ot_excel_category_id">{{ trans('cruds.employeeOtData.fields.ot_excel_category') }}</label>
                <select class="form-control select2 {{ $errors->has('ot_excel_category') ? 'is-invalid' : '' }}" name="ot_excel_category_id" id="ot_excel_category_id" required>
                    @foreach($ot_excel_categories as $id => $entry)
                        <option value="{{ $id }}" {{ (old('ot_excel_category_id') ? old('ot_excel_category_id') : $employeeOtData->ot_excel_category->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('ot_excel_category'))
                    <div class="invalid-feedback">
                        {{ $errors->first('ot_excel_category') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employeeOtData.fields.ot_excel_category_helper') }}</span>
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