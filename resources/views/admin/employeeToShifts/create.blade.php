@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.employeeToShift.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.employee-to-shifts.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="employee_id">{{ trans('cruds.employeeToShift.fields.employee') }}</label>
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
                <span class="help-block">{{ trans('cruds.employeeToShift.fields.employee_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="shift_id">{{ trans('cruds.employeeToShift.fields.shift') }}</label>
                <select class="form-control select2 {{ $errors->has('shift') ? 'is-invalid' : '' }}" name="shift_id" id="shift_id" required>
                    @foreach($shifts as $id => $entry)
                        <option value="{{ $id }}" {{ old('shift_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('shift'))
                    <div class="invalid-feedback">
                        {{ $errors->first('shift') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employeeToShift.fields.shift_helper') }}</span>
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