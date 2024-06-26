@extends('layouts.admin')
@section('content')

<div class="card_">
    <div class="card-header_">
        {{ trans('global.create') }} {{ trans('cruds.assemblySession.title_singular') }}
    </div>

    <div class="card-body_">
        <form method="POST" action="{{ route("admin.assembly-sessions.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.assemblySession.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}" required>
                @if($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.assemblySession.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="kla_number">{{ trans('cruds.assemblySession.fields.kla_number') }}</label>
                <input class="form-control {{ $errors->has('kla_number') ? 'is-invalid' : '' }}" type="number" name="kla_number" id="kla_number" value="{{ old('kla_number', '') }}" step="1" required>
                @if($errors->has('kla_number'))
                    <span class="text-danger">{{ $errors->first('kla_number') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.assemblySession.fields.kla_number_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="session_number">{{ trans('cruds.assemblySession.fields.session_number') }}</label>
                <input class="form-control {{ $errors->has('session_number') ? 'is-invalid' : '' }}" type="number" name="session_number" id="session_number" value="{{ old('session_number', '') }}" step="1">
                @if($errors->has('session_number'))
                    <span class="text-danger">{{ $errors->first('session_number') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.assemblySession.fields.session_number_helper') }}</span>
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
