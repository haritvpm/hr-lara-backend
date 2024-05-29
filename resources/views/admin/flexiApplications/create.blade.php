@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.flexiApplication.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.flexi-applications.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="employee_id">{{ trans('cruds.flexiApplication.fields.employee') }}</label>
                <select class="form-control select2 {{ $errors->has('employee') ? 'is-invalid' : '' }}" name="employee_id" id="employee_id">
                    @foreach($employees as $id => $entry)
                        <option value="{{ $id }}" {{ old('employee_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('employee'))
                    <span class="text-danger">{{ $errors->first('employee') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.flexiApplication.fields.employee_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="aadhaarid">{{ trans('cruds.flexiApplication.fields.aadhaarid') }}</label>
                <input class="form-control {{ $errors->has('aadhaarid') ? 'is-invalid' : '' }}" type="text" name="aadhaarid" id="aadhaarid" value="{{ old('aadhaarid', '') }}">
                @if($errors->has('aadhaarid'))
                    <span class="text-danger">{{ $errors->first('aadhaarid') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.flexiApplication.fields.aadhaarid_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="flexi_minutes">{{ trans('cruds.flexiApplication.fields.flexi_minutes') }}</label>
                <input class="form-control {{ $errors->has('flexi_minutes') ? 'is-invalid' : '' }}" type="number" name="flexi_minutes" id="flexi_minutes" value="{{ old('flexi_minutes', '') }}" step="1" required>
                @if($errors->has('flexi_minutes'))
                    <span class="text-danger">{{ $errors->first('flexi_minutes') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.flexiApplication.fields.flexi_minutes_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="with_effect_from">{{ trans('cruds.flexiApplication.fields.with_effect_from') }}</label>
                <input class="form-control date {{ $errors->has('with_effect_from') ? 'is-invalid' : '' }}" type="text" name="with_effect_from" id="with_effect_from" value="{{ old('with_effect_from') }}" required>
                @if($errors->has('with_effect_from'))
                    <span class="text-danger">{{ $errors->first('with_effect_from') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.flexiApplication.fields.with_effect_from_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="owner_seat">{{ trans('cruds.flexiApplication.fields.owner_seat') }}</label>
                <input class="form-control {{ $errors->has('owner_seat') ? 'is-invalid' : '' }}" type="text" name="owner_seat" id="owner_seat" value="{{ old('owner_seat', '') }}">
                @if($errors->has('owner_seat'))
                    <span class="text-danger">{{ $errors->first('owner_seat') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.flexiApplication.fields.owner_seat_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="approved_by">{{ trans('cruds.flexiApplication.fields.approved_by') }}</label>
                <input class="form-control {{ $errors->has('approved_by') ? 'is-invalid' : '' }}" type="text" name="approved_by" id="approved_by" value="{{ old('approved_by', '') }}">
                @if($errors->has('approved_by'))
                    <span class="text-danger">{{ $errors->first('approved_by') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.flexiApplication.fields.approved_by_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="approved_on">{{ trans('cruds.flexiApplication.fields.approved_on') }}</label>
                <input class="form-control date {{ $errors->has('approved_on') ? 'is-invalid' : '' }}" type="text" name="approved_on" id="approved_on" value="{{ old('approved_on') }}">
                @if($errors->has('approved_on'))
                    <span class="text-danger">{{ $errors->first('approved_on') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.flexiApplication.fields.approved_on_helper') }}</span>
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