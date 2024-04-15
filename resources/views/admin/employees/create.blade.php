@extends('layouts.admin')
@section('content')

<div class="card_">
    <div class="card-header_">
        {{ trans('global.create') }} {{ trans('cruds.employee.title_singular') }}
    </div>

    <div class="card-body_">
        <form method="POST" action="{{ route("admin.employees.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label>{{ trans('cruds.employee.fields.srismt') }}</label>
                <select class="form-control {{ $errors->has('srismt') ? 'is-invalid' : '' }}" name="srismt" id="srismt">
                    <option value disabled {{ old('srismt', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Employee::SRISMT_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('srismt', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('srismt'))
                    <span class="text-danger">{{ $errors->first('srismt') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.srismt_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.employee.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}" required>
                @if($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="name_mal">{{ trans('cruds.employee.fields.name_mal') }}</label>
                <input class="form-control {{ $errors->has('name_mal') ? 'is-invalid' : '' }}" type="text" name="name_mal" id="name_mal" value="{{ old('name_mal', '') }}">
                @if($errors->has('name_mal'))
                    <span class="text-danger">{{ $errors->first('name_mal') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.name_mal_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="aadhaarid">{{ trans('cruds.employee.fields.aadhaarid') }}</label>
                <input class="form-control {{ $errors->has('aadhaarid') ? 'is-invalid' : '' }}" type="text" name="aadhaarid" id="aadhaarid" value="{{ old('aadhaarid', '') }}" required>
                @if($errors->has('aadhaarid'))
                    <span class="text-danger">{{ $errors->first('aadhaarid') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.aadhaarid_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="pen">{{ trans('cruds.employee.fields.pen') }}</label>
                <input class="form-control {{ $errors->has('pen') ? 'is-invalid' : '' }}" type="text" name="pen" id="pen" value="{{ old('pen', '') }}">
                @if($errors->has('pen'))
                    <span class="text-danger">{{ $errors->first('pen') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.pen_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="desig_display">{{ trans('cruds.employee.fields.desig_display') }}</label>
                <input class="form-control {{ $errors->has('desig_display') ? 'is-invalid' : '' }}" type="text" name="desig_display" id="desig_display" value="{{ old('desig_display', '') }}">
                @if($errors->has('desig_display'))
                    <span class="text-danger">{{ $errors->first('desig_display') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.desig_display_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="pan">{{ trans('cruds.employee.fields.pan') }}</label>
                <input class="form-control {{ $errors->has('pan') ? 'is-invalid' : '' }}" type="text" name="pan" id="pan" value="{{ old('pan', '') }}">
                @if($errors->has('pan'))
                    <span class="text-danger">{{ $errors->first('pan') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.pan_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="has_punching">{{ trans('cruds.employee.fields.has_punching') }}</label>
                <input class="form-control {{ $errors->has('has_punching') ? 'is-invalid' : '' }}" type="number" name="has_punching" id="has_punching" value="{{ old('has_punching', '1') }}" step="1">
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
                        <option value="{{ $key }}" {{ old('status', 'active') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
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
                    <input class="form-check-input" type="checkbox" name="is_shift" id="is_shift" value="1" {{ old('is_shift', 0) == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_shift">{{ trans('cruds.employee.fields.is_shift') }}</label>
                </div>
                @if($errors->has('is_shift'))
                    <span class="text-danger">{{ $errors->first('is_shift') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.is_shift_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="klaid">{{ trans('cruds.employee.fields.klaid') }}</label>
                <input class="form-control {{ $errors->has('klaid') ? 'is-invalid' : '' }}" type="text" name="klaid" id="klaid" value="{{ old('klaid', '') }}">
                @if($errors->has('klaid'))
                    <span class="text-danger">{{ $errors->first('klaid') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.klaid_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="electionid">{{ trans('cruds.employee.fields.electionid') }}</label>
                <input class="form-control {{ $errors->has('electionid') ? 'is-invalid' : '' }}" type="text" name="electionid" id="electionid" value="{{ old('electionid', '') }}">
                @if($errors->has('electionid'))
                    <span class="text-danger">{{ $errors->first('electionid') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.employee.fields.electionid_helper') }}</span>
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
