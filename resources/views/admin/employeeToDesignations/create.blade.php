@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.employeeToDesignation.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.employee-to-designations.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="employee_id">{{ trans('cruds.employeeToDesignation.fields.employee') }}</label>
                <select class="form-control select2 {{ $errors->has('employee') ? 'is-invalid' : '' }}" name="employee_id" id="employee_id" required>
                    @foreach($employees as $id => $entry)
                        <option value="{{ $id }}" {{ old('employee_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('employee'))
                    <div class="invalid-feedback">
                        {{ $errors->first('employee') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employeeToDesignation.fields.employee_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="designation_id">{{ trans('cruds.employeeToDesignation.fields.designation') }}</label>
                <select class="form-control select2 {{ $errors->has('designation') ? 'is-invalid' : '' }}" name="designation_id" id="designation_id" required>
                    @foreach($designations as $id => $entry)
                        <option value="{{ $id }}" {{ old('designation_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('designation'))
                    <div class="invalid-feedback">
                        {{ $errors->first('designation') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employeeToDesignation.fields.designation_helper') }}</span>
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