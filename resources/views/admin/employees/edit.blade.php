@extends('layouts.admin')
@section('content')

<div class="card_">
    <div class="card-header_">
        {{ trans('global.edit') }} {{ trans('cruds.employee.title_singular') }}
    </div>

    <div class="card-body_">
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
                    <span class="text-danger">{{ $errors->first('srismt') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.srismt_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.employee.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $employee->name) }}" required>
                @if($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="name_mal">{{ trans('cruds.employee.fields.name_mal') }}</label>
                <input class="form-control {{ $errors->has('name_mal') ? 'is-invalid' : '' }}" type="text" name="name_mal" id="name_mal" value="{{ old('name_mal', $employee->name_mal) }}">
                @if($errors->has('name_mal'))
                    <span class="text-danger">{{ $errors->first('name_mal') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.name_mal_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="aadhaarid">{{ trans('cruds.employee.fields.aadhaarid') }}</label>
                <input class="form-control {{ $errors->has('aadhaarid') ? 'is-invalid' : '' }}" type="text" name="aadhaarid" id="aadhaarid" value="{{ old('aadhaarid', $employee->aadhaarid) }}" required>
                @if($errors->has('aadhaarid'))
                    <span class="text-danger">{{ $errors->first('aadhaarid') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.aadhaarid_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="pen">{{ trans('cruds.employee.fields.pen') }}</label>
                <input class="form-control {{ $errors->has('pen') ? 'is-invalid' : '' }}" type="text" name="pen" id="pen" value="{{ old('pen', $employee->pen) }}">
                @if($errors->has('pen'))
                    <span class="text-danger">{{ $errors->first('pen') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.pen_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="desig_display">{{ trans('cruds.employee.fields.desig_display') }}</label>
                <input class="form-control {{ $errors->has('desig_display') ? 'is-invalid' : '' }}" type="text" name="desig_display" id="desig_display" value="{{ old('desig_display', $employee->desig_display) }}">
                @if($errors->has('desig_display'))
                    <span class="text-danger">{{ $errors->first('desig_display') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.desig_display_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="has_punching">{{ trans('cruds.employee.fields.has_punching') }}</label>
                <input class="form-control {{ $errors->has('has_punching') ? 'is-invalid' : '' }}" type="number" name="has_punching" id="has_punching" value="{{ old('has_punching', $employee->has_punching) }}" step="1">
                @if($errors->has('has_punching'))
                    <span class="text-danger">{{ $errors->first('has_punching') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.has_punching_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.employee.fields.status') }}</label>
                <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" id="status">
                    <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Employee::STATUS_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('status', $employee->status) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('status'))
                    <span class="text-danger">{{ $errors->first('status') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.status_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('is_shift') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="is_shift" value="0">
                    <input class="form-check-input" type="checkbox" name="is_shift" id="is_shift" value="1" {{ $employee->is_shift || old('is_shift', 0) === 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_shift">{{ trans('cruds.employee.fields.is_shift') }}</label>
                </div>
                @if($errors->has('is_shift'))
                    <span class="text-danger">{{ $errors->first('is_shift') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.is_shift_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="grace_group_id">{{ trans('cruds.employee.fields.grace_group') }}</label>
                <select class="form-control select2 {{ $errors->has('grace_group') ? 'is-invalid' : '' }}" name="grace_group_id" id="grace_group_id">
                    @foreach($grace_groups as $id => $entry)
                        <option value="{{ $id }}" {{ (old('grace_group_id') ? old('grace_group_id') : $employee->grace_group->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('grace_group'))
                    <span class="text-danger">{{ $errors->first('grace_group') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.grace_group_helper') }}</span>
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
