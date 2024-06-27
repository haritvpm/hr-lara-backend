@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.employeeToFlexi.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.employee-to-flexis.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="employee_id">{{ trans('cruds.employeeToFlexi.fields.employee') }}</label>
                <select class="form-control select2 {{ $errors->has('employee') ? 'is-invalid' : '' }}" name="employee_id" id="employee_id" required>
                    @foreach($employees as $id => $entry)
                        <option value="{{ $id }}" {{ old('employee_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('employee'))
                    <span class="text-danger">{{ $errors->first('employee') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.employeeToFlexi.fields.employee_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="flexi_minutes">{{ trans('cruds.employeeToFlexi.fields.flexi_minutes') }}</label>
                <input class="form-control {{ $errors->has('flexi_minutes') ? 'is-invalid' : '' }}" type="number" name="flexi_minutes" id="flexi_minutes" value="{{ old('flexi_minutes', '') }}" step="1" required>
                @if($errors->has('flexi_minutes'))
                    <span class="text-danger">{{ $errors->first('flexi_minutes') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.employeeToFlexi.fields.flexi_minutes_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="with_effect_from">{{ trans('cruds.employeeToFlexi.fields.with_effect_from') }}</label>
                <input class="form-control date {{ $errors->has('with_effect_from') ? 'is-invalid' : '' }}" type="text" name="with_effect_from" id="with_effect_from" value="{{ old('with_effect_from') }}" required>
                @if($errors->has('with_effect_from'))
                    <span class="text-danger">{{ $errors->first('with_effect_from') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.employeeToFlexi.fields.with_effect_from_helper') }}</span>
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