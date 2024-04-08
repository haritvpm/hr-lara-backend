@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.officeTime.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.office-times.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="time_group_id">{{ trans('cruds.officeTime.fields.time_group') }}</label>
                <select class="form-control select2 {{ $errors->has('time_group') ? 'is-invalid' : '' }}" name="time_group_id" id="time_group_id" required>
                    @foreach($time_groups as $id => $entry)
                        <option value="{{ $id }}" {{ old('time_group_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('time_group'))
                    <span class="text-danger">{{ $errors->first('time_group') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.officeTime.fields.time_group_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="description">{{ trans('cruds.officeTime.fields.description') }}</label>
                <input class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" type="text" name="description" id="description" value="{{ old('description', '') }}">
                @if($errors->has('description'))
                    <span class="text-danger">{{ $errors->first('description') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.officeTime.fields.description_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="full_from">{{ trans('cruds.officeTime.fields.full_from') }}</label>
                <input class="form-control timepicker {{ $errors->has('full_from') ? 'is-invalid' : '' }}" type="text" name="full_from" id="full_from" value="{{ old('full_from') }}" required>
                @if($errors->has('full_from'))
                    <span class="text-danger">{{ $errors->first('full_from') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.officeTime.fields.full_from_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="full_to">{{ trans('cruds.officeTime.fields.full_to') }}</label>
                <input class="form-control timepicker {{ $errors->has('full_to') ? 'is-invalid' : '' }}" type="text" name="full_to" id="full_to" value="{{ old('full_to') }}" required>
                @if($errors->has('full_to'))
                    <span class="text-danger">{{ $errors->first('full_to') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.officeTime.fields.full_to_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="office_hours">{{ trans('cruds.officeTime.fields.office_hours') }}</label>
                <input class="form-control {{ $errors->has('office_hours') ? 'is-invalid' : '' }}" type="number" name="office_hours" id="office_hours" value="{{ old('office_hours', '7') }}" step="1" required>
                @if($errors->has('office_hours'))
                    <span class="text-danger">{{ $errors->first('office_hours') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.officeTime.fields.office_hours_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="fn_from">{{ trans('cruds.officeTime.fields.fn_from') }}</label>
                <input class="form-control timepicker {{ $errors->has('fn_from') ? 'is-invalid' : '' }}" type="text" name="fn_from" id="fn_from" value="{{ old('fn_from') }}">
                @if($errors->has('fn_from'))
                    <span class="text-danger">{{ $errors->first('fn_from') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.officeTime.fields.fn_from_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="fn_to">{{ trans('cruds.officeTime.fields.fn_to') }}</label>
                <input class="form-control timepicker {{ $errors->has('fn_to') ? 'is-invalid' : '' }}" type="text" name="fn_to" id="fn_to" value="{{ old('fn_to') }}">
                @if($errors->has('fn_to'))
                    <span class="text-danger">{{ $errors->first('fn_to') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.officeTime.fields.fn_to_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="an_from">{{ trans('cruds.officeTime.fields.an_from') }}</label>
                <input class="form-control timepicker {{ $errors->has('an_from') ? 'is-invalid' : '' }}" type="text" name="an_from" id="an_from" value="{{ old('an_from') }}">
                @if($errors->has('an_from'))
                    <span class="text-danger">{{ $errors->first('an_from') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.officeTime.fields.an_from_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="an_to">{{ trans('cruds.officeTime.fields.an_to') }}</label>
                <input class="form-control timepicker {{ $errors->has('an_to') ? 'is-invalid' : '' }}" type="text" name="an_to" id="an_to" value="{{ old('an_to') }}">
                @if($errors->has('an_to'))
                    <span class="text-danger">{{ $errors->first('an_to') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.officeTime.fields.an_to_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="flexi_from">{{ trans('cruds.officeTime.fields.flexi_from') }}</label>
                <input class="form-control timepicker {{ $errors->has('flexi_from') ? 'is-invalid' : '' }}" type="text" name="flexi_from" id="flexi_from" value="{{ old('flexi_from') }}">
                @if($errors->has('flexi_from'))
                    <span class="text-danger">{{ $errors->first('flexi_from') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.officeTime.fields.flexi_from_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="flexi_to">{{ trans('cruds.officeTime.fields.flexi_to') }}</label>
                <input class="form-control timepicker {{ $errors->has('flexi_to') ? 'is-invalid' : '' }}" type="text" name="flexi_to" id="flexi_to" value="{{ old('flexi_to') }}">
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