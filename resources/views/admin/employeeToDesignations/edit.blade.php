@extends('layouts.admin')
@section('content')

<div class="card_">
    <div class="card-header_">
        {{ trans('global.edit') }} {{ trans('cruds.employeeToDesignation.title_singular') }}
    </div>

    <div class="card-body_">
        <form method="POST" action="{{ route("admin.employee-to-designations.update", [$employeeToDesignation->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="employee_id">{{ trans('cruds.employeeToDesignation.fields.employee') }}</label>
                <select class="form-control select2 {{ $errors->has('employee') ? 'is-invalid' : '' }}" name="employee_id" id="employee_id" required>
                    @foreach($employees as $id => $entry)
                        <option value="{{ $id }}" {{ (old('employee_id') ? old('employee_id') : $employeeToDesignation->employee->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('employee'))
                    <span class="text-danger">{{ $errors->first('employee') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.employeeToDesignation.fields.employee_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="designation_id">{{ trans('cruds.employeeToDesignation.fields.designation') }}</label>
                <select class="form-control select2 {{ $errors->has('designation') ? 'is-invalid' : '' }}" name="designation_id" id="designation_id" required>
                    @foreach($designations as $id => $entry)
                        <option value="{{ $id }}" {{ (old('designation_id') ? old('designation_id') : $employeeToDesignation->designation->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('designation'))
                    <span class="text-danger">{{ $errors->first('designation') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.employeeToDesignation.fields.designation_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="start_date">{{ trans('cruds.employeeToDesignation.fields.start_date') }}</label>
                <input class="form-control date {{ $errors->has('start_date') ? 'is-invalid' : '' }}" type="text" name="start_date" id="start_date" value="{{ old('start_date', $employeeToDesignation->start_date) }}" required>
                @if($errors->has('start_date'))
                    <span class="text-danger">{{ $errors->first('start_date') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.employeeToDesignation.fields.start_date_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="end_date">{{ trans('cruds.employeeToDesignation.fields.end_date') }}</label>
                <input class="form-control date {{ $errors->has('end_date') ? 'is-invalid' : '' }}" type="text" name="end_date" id="end_date" value="{{ old('end_date', $employeeToDesignation->end_date) }}">
                @if($errors->has('end_date'))
                    <span class="text-danger">{{ $errors->first('end_date') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.employeeToDesignation.fields.end_date_helper') }}</span>
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
