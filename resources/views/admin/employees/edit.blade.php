@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.employee.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.employees.update", [$employee->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label>{{ trans('cruds.employee.fields.srismt') }}</label>
                <select class="form-control {{ $errors->has('srismt') ? 'is-invalid' : '' }}" name="srismt" id="srismt">
                    <option value disabled {{ old('srismt', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Employee::SRISMT_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('srismt', $employee->srismt) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('srismt'))
                    <div class="invalid-feedback">
                        {{ $errors->first('srismt') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.srismt_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.employee.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $employee->name) }}" required>
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="name_mal">{{ trans('cruds.employee.fields.name_mal') }}</label>
                <input class="form-control {{ $errors->has('name_mal') ? 'is-invalid' : '' }}" type="text" name="name_mal" id="name_mal" value="{{ old('name_mal', $employee->name_mal) }}">
                @if($errors->has('name_mal'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name_mal') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.name_mal_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="pen">{{ trans('cruds.employee.fields.pen') }}</label>
                <input class="form-control {{ $errors->has('pen') ? 'is-invalid' : '' }}" type="text" name="pen" id="pen" value="{{ old('pen', $employee->pen) }}">
                @if($errors->has('pen'))
                    <div class="invalid-feedback">
                        {{ $errors->first('pen') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.pen_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="aadhaarid">{{ trans('cruds.employee.fields.aadhaarid') }}</label>
                <input class="form-control {{ $errors->has('aadhaarid') ? 'is-invalid' : '' }}" type="text" name="aadhaarid" id="aadhaarid" value="{{ old('aadhaarid', $employee->aadhaarid) }}" required>
                @if($errors->has('aadhaarid'))
                    <div class="invalid-feedback">
                        {{ $errors->first('aadhaarid') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.aadhaarid_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required">{{ trans('cruds.employee.fields.employee_type') }}</label>
                <select class="form-control {{ $errors->has('employee_type') ? 'is-invalid' : '' }}" name="employee_type" id="employee_type" required>
                    <option value disabled {{ old('employee_type', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Employee::EMPLOYEE_TYPE_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('employee_type', $employee->employee_type) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('employee_type'))
                    <div class="invalid-feedback">
                        {{ $errors->first('employee_type') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.employee_type_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="desig_display">{{ trans('cruds.employee.fields.desig_display') }}</label>
                <input class="form-control {{ $errors->has('desig_display') ? 'is-invalid' : '' }}" type="text" name="desig_display" id="desig_display" value="{{ old('desig_display', $employee->desig_display) }}">
                @if($errors->has('desig_display'))
                    <div class="invalid-feedback">
                        {{ $errors->first('desig_display') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.desig_display_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="pan">{{ trans('cruds.employee.fields.pan') }}</label>
                <input class="form-control {{ $errors->has('pan') ? 'is-invalid' : '' }}" type="text" name="pan" id="pan" value="{{ old('pan', $employee->pan) }}">
                @if($errors->has('pan'))
                    <div class="invalid-feedback">
                        {{ $errors->first('pan') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.pan_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="has_punching">{{ trans('cruds.employee.fields.has_punching') }}</label>
                <input class="form-control {{ $errors->has('has_punching') ? 'is-invalid' : '' }}" type="number" name="has_punching" id="has_punching" value="{{ old('has_punching', $employee->has_punching) }}" step="1">
                @if($errors->has('has_punching'))
                    <div class="invalid-feedback">
                        {{ $errors->first('has_punching') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.has_punching_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="status_id">{{ trans('cruds.employee.fields.status') }}</label>
                <select class="form-control select2 {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status_id" id="status_id" required>
                    @foreach($statuses as $id => $entry)
                        <option value="{{ $id }}" {{ (old('status_id') ? old('status_id') : $employee->status->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('status'))
                    <div class="invalid-feedback">
                        {{ $errors->first('status') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.status_helper') }}</span>
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