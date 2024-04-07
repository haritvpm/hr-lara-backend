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
                <label class="required" for="description">{{ trans('cruds.officeTime.fields.description') }}</label>
                <input class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" type="text" name="description" id="description" value="{{ old('description', $officeTime->description) }}" required>
                @if($errors->has('description'))
                    <span class="text-danger">{{ $errors->first('description') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.officeTime.fields.description_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="office_id">{{ trans('cruds.officeTime.fields.office') }}</label>
                <select class="form-control select2 {{ $errors->has('office') ? 'is-invalid' : '' }}" name="office_id" id="office_id" required>
                    @foreach($offices as $id => $entry)
                        <option value="{{ $id }}" {{ (old('office_id') ? old('office_id') : $officeTime->office->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('office'))
                    <span class="text-danger">{{ $errors->first('office') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.officeTime.fields.office_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="full_from">{{ trans('cruds.officeTime.fields.full_from') }}</label>
                <input class="form-control timepicker {{ $errors->has('full_from') ? 'is-invalid' : '' }}" type="text" name="full_from" id="full_from" value="{{ old('full_from', $officeTime->full_from) }}" required>
                @if($errors->has('full_from'))
                    <span class="text-danger">{{ $errors->first('full_from') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.officeTime.fields.full_from_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="full_to">{{ trans('cruds.officeTime.fields.full_to') }}</label>
                <input class="form-control timepicker {{ $errors->has('full_to') ? 'is-invalid' : '' }}" type="text" name="full_to" id="full_to" value="{{ old('full_to', $officeTime->full_to) }}" required>
                @if($errors->has('full_to'))
                    <span class="text-danger">{{ $errors->first('full_to') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.officeTime.fields.full_to_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="office_hours">{{ trans('cruds.officeTime.fields.office_hours') }}</label>
                <input class="form-control {{ $errors->has('office_hours') ? 'is-invalid' : '' }}" type="number" name="office_hours" id="office_hours" value="{{ old('office_hours', $officeTime->office_hours) }}" step="1" required>
                @if($errors->has('office_hours'))
                    <span class="text-danger">{{ $errors->first('office_hours') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.officeTime.fields.office_hours_helper') }}</span>
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
                <label for="flexi_from">{{ trans('cruds.officeTime.fields.flexi_from') }}</label>
                <input class="form-control timepicker {{ $errors->has('flexi_from') ? 'is-invalid' : '' }}" type="text" name="flexi_from" id="flexi_from" value="{{ old('flexi_from', $officeTime->flexi_from) }}">
                @if($errors->has('flexi_from'))
                    <span class="text-danger">{{ $errors->first('flexi_from') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.officeTime.fields.flexi_from_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="flexi_to">{{ trans('cruds.officeTime.fields.flexi_to') }}</label>
                <input class="form-control timepicker {{ $errors->has('flexi_to') ? 'is-invalid' : '' }}" type="text" name="flexi_to" id="flexi_to" value="{{ old('flexi_to', $officeTime->flexi_to) }}">
                @if($errors->has('flexi_to'))
                    <span class="text-danger">{{ $errors->first('flexi_to') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.officeTime.fields.flexi_to_helper') }}</span>
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