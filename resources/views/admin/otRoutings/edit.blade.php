@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.otRouting.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.ot-routings.update", [$otRouting->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="seat_id">{{ trans('cruds.otRouting.fields.seat') }}</label>
                <select class="form-control select2 {{ $errors->has('seat') ? 'is-invalid' : '' }}" name="seat_id" id="seat_id" required>
                    @foreach($seats as $id => $entry)
                        <option value="{{ $id }}" {{ (old('seat_id') ? old('seat_id') : $otRouting->seat->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('seat'))
                    <div class="invalid-feedback">
                        {{ $errors->first('seat') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.otRouting.fields.seat_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="routes">{{ trans('cruds.otRouting.fields.routes') }}</label>
                <input class="form-control {{ $errors->has('routes') ? 'is-invalid' : '' }}" type="text" name="routes" id="routes" value="{{ old('routes', $otRouting->routes) }}">
                @if($errors->has('routes'))
                    <div class="invalid-feedback">
                        {{ $errors->first('routes') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.otRouting.fields.routes_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="last_forwarded_to">{{ trans('cruds.otRouting.fields.last_forwarded_to') }}</label>
                <input class="form-control {{ $errors->has('last_forwarded_to') ? 'is-invalid' : '' }}" type="text" name="last_forwarded_to" id="last_forwarded_to" value="{{ old('last_forwarded_to', $otRouting->last_forwarded_to) }}">
                @if($errors->has('last_forwarded_to'))
                    <div class="invalid-feedback">
                        {{ $errors->first('last_forwarded_to') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.otRouting.fields.last_forwarded_to_helper') }}</span>
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