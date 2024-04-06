@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.successPunching.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.success-punchings.update", [$successPunching->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="date">{{ trans('cruds.successPunching.fields.date') }}</label>
                <input class="form-control date {{ $errors->has('date') ? 'is-invalid' : '' }}" type="text" name="date" id="date" value="{{ old('date', $successPunching->date) }}" required>
                @if($errors->has('date'))
                    <span class="text-danger">{{ $errors->first('date') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.successPunching.fields.date_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="punch_in">{{ trans('cruds.successPunching.fields.punch_in') }}</label>
                <input class="form-control {{ $errors->has('punch_in') ? 'is-invalid' : '' }}" type="text" name="punch_in" id="punch_in" value="{{ old('punch_in', $successPunching->punch_in) }}" required>
                @if($errors->has('punch_in'))
                    <span class="text-danger">{{ $errors->first('punch_in') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.successPunching.fields.punch_in_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="punch_out">{{ trans('cruds.successPunching.fields.punch_out') }}</label>
                <input class="form-control {{ $errors->has('punch_out') ? 'is-invalid' : '' }}" type="text" name="punch_out" id="punch_out" value="{{ old('punch_out', $successPunching->punch_out) }}" required>
                @if($errors->has('punch_out'))
                    <span class="text-danger">{{ $errors->first('punch_out') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.successPunching.fields.punch_out_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="pen">{{ trans('cruds.successPunching.fields.pen') }}</label>
                <input class="form-control {{ $errors->has('pen') ? 'is-invalid' : '' }}" type="text" name="pen" id="pen" value="{{ old('pen', $successPunching->pen) }}" required>
                @if($errors->has('pen'))
                    <span class="text-danger">{{ $errors->first('pen') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.successPunching.fields.pen_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="name">{{ trans('cruds.successPunching.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $successPunching->name) }}">
                @if($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.successPunching.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="out_time">{{ trans('cruds.successPunching.fields.out_time') }}</label>
                <input class="form-control datetime {{ $errors->has('out_time') ? 'is-invalid' : '' }}" type="text" name="out_time" id="out_time" value="{{ old('out_time', $successPunching->out_time) }}">
                @if($errors->has('out_time'))
                    <span class="text-danger">{{ $errors->first('out_time') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.successPunching.fields.out_time_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="at_type">{{ trans('cruds.successPunching.fields.at_type') }}</label>
                <input class="form-control {{ $errors->has('at_type') ? 'is-invalid' : '' }}" type="text" name="at_type" id="at_type" value="{{ old('at_type', $successPunching->at_type) }}">
                @if($errors->has('at_type'))
                    <span class="text-danger">{{ $errors->first('at_type') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.successPunching.fields.at_type_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="duration">{{ trans('cruds.successPunching.fields.duration') }}</label>
                <input class="form-control {{ $errors->has('duration') ? 'is-invalid' : '' }}" type="text" name="duration" id="duration" value="{{ old('duration', $successPunching->duration) }}">
                @if($errors->has('duration'))
                    <span class="text-danger">{{ $errors->first('duration') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.successPunching.fields.duration_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="aadhaarid">{{ trans('cruds.successPunching.fields.aadhaarid') }}</label>
                <input class="form-control {{ $errors->has('aadhaarid') ? 'is-invalid' : '' }}" type="text" name="aadhaarid" id="aadhaarid" value="{{ old('aadhaarid', $successPunching->aadhaarid) }}" required>
                @if($errors->has('aadhaarid'))
                    <span class="text-danger">{{ $errors->first('aadhaarid') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.successPunching.fields.aadhaarid_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="punching_id">{{ trans('cruds.successPunching.fields.punching') }}</label>
                <select class="form-control select2 {{ $errors->has('punching') ? 'is-invalid' : '' }}" name="punching_id" id="punching_id">
                    @foreach($punchings as $id => $entry)
                        <option value="{{ $id }}" {{ (old('punching_id') ? old('punching_id') : $successPunching->punching->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('punching'))
                    <span class="text-danger">{{ $errors->first('punching') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.successPunching.fields.punching_helper') }}</span>
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