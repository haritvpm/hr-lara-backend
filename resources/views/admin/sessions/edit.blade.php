@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.session.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.sessions.update", [$session->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.session.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $session->name) }}" required>
                @if($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.session.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="kla_number">{{ trans('cruds.session.fields.kla_number') }}</label>
                <input class="form-control {{ $errors->has('kla_number') ? 'is-invalid' : '' }}" type="number" name="kla_number" id="kla_number" value="{{ old('kla_number', $session->kla_number) }}" step="1" required>
                @if($errors->has('kla_number'))
                    <span class="text-danger">{{ $errors->first('kla_number') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.session.fields.kla_number_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="session_number">{{ trans('cruds.session.fields.session_number') }}</label>
                <input class="form-control {{ $errors->has('session_number') ? 'is-invalid' : '' }}" type="number" name="session_number" id="session_number" value="{{ old('session_number', $session->session_number) }}" step="1">
                @if($errors->has('session_number'))
                    <span class="text-danger">{{ $errors->first('session_number') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.session.fields.session_number_helper') }}</span>
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