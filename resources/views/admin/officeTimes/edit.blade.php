@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.officeTime.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.office-times.update", [$officeTime->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="groupname">{{ trans('cruds.officeTime.fields.groupname') }}</label>
                <input class="form-control {{ $errors->has('groupname') ? 'is-invalid' : '' }}" type="text" name="groupname" id="groupname" value="{{ old('groupname', $officeTime->groupname) }}" required>
                @if($errors->has('groupname'))
                    <span class="text-danger">{{ $errors->first('groupname') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.officeTime.fields.groupname_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="description">{{ trans('cruds.officeTime.fields.description') }}</label>
                <input class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" type="text" name="description" id="description" value="{{ old('description', $officeTime->description) }}">
                @if($errors->has('description'))
                    <span class="text-danger">{{ $errors->first('description') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.officeTime.fields.description_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="fn_from">{{ trans('cruds.officeTime.fields.fn_from') }}</label>
                <input class="form-control timepicker {{ $errors->has('fn_from') ? 'is-invalid' : '' }}" type="text" name="fn_from" id="fn_from" value="{{ old('fn_from', $officeTime->fn_from) }}">
                @if($errors->has('fn_from'))
                    <span class="text-danger">{{ $errors->first('fn_from') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.officeTime.fields.fn_from_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="fn_to">{{ trans('cruds.officeTime.fields.fn_to') }}</label>
                <input class="form-control timepicker {{ $errors->has('fn_to') ? 'is-invalid' : '' }}" type="text" name="fn_to" id="fn_to" value="{{ old('fn_to', $officeTime->fn_to) }}">
                @if($errors->has('fn_to'))
                    <span class="text-danger">{{ $errors->first('fn_to') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.officeTime.fields.fn_to_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="an_from">{{ trans('cruds.officeTime.fields.an_from') }}</label>
                <input class="form-control timepicker {{ $errors->has('an_from') ? 'is-invalid' : '' }}" type="text" name="an_from" id="an_from" value="{{ old('an_from', $officeTime->an_from) }}">
                @if($errors->has('an_from'))
                    <span class="text-danger">{{ $errors->first('an_from') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.officeTime.fields.an_from_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="an_to">{{ trans('cruds.officeTime.fields.an_to') }}</label>
                <input class="form-control timepicker {{ $errors->has('an_to') ? 'is-invalid' : '' }}" type="text" name="an_to" id="an_to" value="{{ old('an_to', $officeTime->an_to) }}">
                @if($errors->has('an_to'))
                    <span class="text-danger">{{ $errors->first('an_to') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.officeTime.fields.an_to_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="flexi_minutes">{{ trans('cruds.officeTime.fields.flexi_minutes') }}</label>
                <input class="form-control {{ $errors->has('flexi_minutes') ? 'is-invalid' : '' }}" type="number" name="flexi_minutes" id="flexi_minutes" value="{{ old('flexi_minutes', $officeTime->flexi_minutes) }}" step="1">
                @if($errors->has('flexi_minutes'))
                    <span class="text-danger">{{ $errors->first('flexi_minutes') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.officeTime.fields.flexi_minutes_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="with_effect_from">{{ trans('cruds.officeTime.fields.with_effect_from') }}</label>
                <input class="form-control date {{ $errors->has('with_effect_from') ? 'is-invalid' : '' }}" type="text" name="with_effect_from" id="with_effect_from" value="{{ old('with_effect_from', $officeTime->with_effect_from) }}" required>
                @if($errors->has('with_effect_from'))
                    <span class="text-danger">{{ $errors->first('with_effect_from') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.officeTime.fields.with_effect_from_helper') }}</span>
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