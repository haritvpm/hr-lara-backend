@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.overtime.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.overtimes.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="employee_id">{{ trans('cruds.overtime.fields.employee') }}</label>
                <select class="form-control select2 {{ $errors->has('employee') ? 'is-invalid' : '' }}" name="employee_id" id="employee_id" required>
                    @foreach($employees as $id => $entry)
                        <option value="{{ $id }}" {{ old('employee_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('employee'))
                    <div class="invalid-feedback">
                        {{ $errors->first('employee') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.overtime.fields.employee_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="designation">{{ trans('cruds.overtime.fields.designation') }}</label>
                <input class="form-control {{ $errors->has('designation') ? 'is-invalid' : '' }}" type="text" name="designation" id="designation" value="{{ old('designation', '') }}" required>
                @if($errors->has('designation'))
                    <div class="invalid-feedback">
                        {{ $errors->first('designation') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.overtime.fields.designation_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="from">{{ trans('cruds.overtime.fields.from') }}</label>
                <input class="form-control {{ $errors->has('from') ? 'is-invalid' : '' }}" type="text" name="from" id="from" value="{{ old('from', '') }}">
                @if($errors->has('from'))
                    <div class="invalid-feedback">
                        {{ $errors->first('from') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.overtime.fields.from_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="to">{{ trans('cruds.overtime.fields.to') }}</label>
                <input class="form-control {{ $errors->has('to') ? 'is-invalid' : '' }}" type="text" name="to" id="to" value="{{ old('to', '') }}">
                @if($errors->has('to'))
                    <div class="invalid-feedback">
                        {{ $errors->first('to') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.overtime.fields.to_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="count">{{ trans('cruds.overtime.fields.count') }}</label>
                <input class="form-control {{ $errors->has('count') ? 'is-invalid' : '' }}" type="text" name="count" id="count" value="{{ old('count', '') }}">
                @if($errors->has('count'))
                    <div class="invalid-feedback">
                        {{ $errors->first('count') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.overtime.fields.count_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="form_id">{{ trans('cruds.overtime.fields.form') }}</label>
                <select class="form-control select2 {{ $errors->has('form') ? 'is-invalid' : '' }}" name="form_id" id="form_id">
                    @foreach($forms as $id => $entry)
                        <option value="{{ $id }}" {{ old('form_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('form'))
                    <div class="invalid-feedback">
                        {{ $errors->first('form') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.overtime.fields.form_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="punchin_id">{{ trans('cruds.overtime.fields.punchin') }}</label>
                <select class="form-control select2 {{ $errors->has('punchin') ? 'is-invalid' : '' }}" name="punchin_id" id="punchin_id">
                    @foreach($punchins as $id => $entry)
                        <option value="{{ $id }}" {{ old('punchin_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('punchin'))
                    <div class="invalid-feedback">
                        {{ $errors->first('punchin') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.overtime.fields.punchin_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="punchout_id">{{ trans('cruds.overtime.fields.punchout') }}</label>
                <select class="form-control select2 {{ $errors->has('punchout') ? 'is-invalid' : '' }}" name="punchout_id" id="punchout_id">
                    @foreach($punchouts as $id => $entry)
                        <option value="{{ $id }}" {{ old('punchout_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('punchout'))
                    <div class="invalid-feedback">
                        {{ $errors->first('punchout') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.overtime.fields.punchout_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="slots">{{ trans('cruds.overtime.fields.slots') }}</label>
                <input class="form-control {{ $errors->has('slots') ? 'is-invalid' : '' }}" type="text" name="slots" id="slots" value="{{ old('slots', '') }}" required>
                @if($errors->has('slots'))
                    <div class="invalid-feedback">
                        {{ $errors->first('slots') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.overtime.fields.slots_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('has_punching') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="has_punching" value="0">
                    <input class="form-check-input" type="checkbox" name="has_punching" id="has_punching" value="1" {{ old('has_punching', 0) == 1 || old('has_punching') === null ? 'checked' : '' }}>
                    <label class="form-check-label" for="has_punching">{{ trans('cruds.overtime.fields.has_punching') }}</label>
                </div>
                @if($errors->has('has_punching'))
                    <div class="invalid-feedback">
                        {{ $errors->first('has_punching') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.overtime.fields.has_punching_helper') }}</span>
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