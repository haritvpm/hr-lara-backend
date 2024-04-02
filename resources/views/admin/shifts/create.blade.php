@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.shift.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.shifts.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.shift.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}" required>
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.shift.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="from">{{ trans('cruds.shift.fields.from') }}</label>
                <input class="form-control datetime {{ $errors->has('from') ? 'is-invalid' : '' }}" type="text" name="from" id="from" value="{{ old('from') }}">
                @if($errors->has('from'))
                    <div class="invalid-feedback">
                        {{ $errors->first('from') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.shift.fields.from_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="upto">{{ trans('cruds.shift.fields.upto') }}</label>
                <input class="form-control datetime {{ $errors->has('upto') ? 'is-invalid' : '' }}" type="text" name="upto" id="upto" value="{{ old('upto') }}">
                @if($errors->has('upto'))
                    <div class="invalid-feedback">
                        {{ $errors->first('upto') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.shift.fields.upto_helper') }}</span>
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