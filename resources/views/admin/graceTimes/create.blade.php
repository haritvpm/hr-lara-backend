@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.graceTime.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.grace-times.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="title">{{ trans('cruds.graceTime.fields.title') }}</label>
                <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title" id="title" value="{{ old('title', '') }}" required>
                @if($errors->has('title'))
                    <span class="text-danger">{{ $errors->first('title') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.graceTime.fields.title_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="minutes">{{ trans('cruds.graceTime.fields.minutes') }}</label>
                <input class="form-control {{ $errors->has('minutes') ? 'is-invalid' : '' }}" type="number" name="minutes" id="minutes" value="{{ old('minutes', '300') }}" step="1" required>
                @if($errors->has('minutes'))
                    <span class="text-danger">{{ $errors->first('minutes') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.graceTime.fields.minutes_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="with_effect_from">{{ trans('cruds.graceTime.fields.with_effect_from') }}</label>
                <input class="form-control date {{ $errors->has('with_effect_from') ? 'is-invalid' : '' }}" type="text" name="with_effect_from" id="with_effect_from" value="{{ old('with_effect_from') }}" required>
                @if($errors->has('with_effect_from'))
                    <span class="text-danger">{{ $errors->first('with_effect_from') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.graceTime.fields.with_effect_from_helper') }}</span>
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