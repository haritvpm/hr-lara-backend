@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.seat.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.seats.update", [$seat->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.seat.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $seat->name) }}" required>
                @if($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.seat.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="title">{{ trans('cruds.seat.fields.title') }}</label>
                <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title" id="title" value="{{ old('title', $seat->title) }}" required>
                @if($errors->has('title'))
                    <span class="text-danger">{{ $errors->first('title') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.seat.fields.title_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('has_files') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="has_files" value="0">
                    <input class="form-check-input" type="checkbox" name="has_files" id="has_files" value="1" {{ $seat->has_files || old('has_files', 0) === 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="has_files">{{ trans('cruds.seat.fields.has_files') }}</label>
                </div>
                @if($errors->has('has_files'))
                    <span class="text-danger">{{ $errors->first('has_files') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.seat.fields.has_files_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('has_office_with_employees') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="has_office_with_employees" value="0">
                    <input class="form-check-input" type="checkbox" name="has_office_with_employees" id="has_office_with_employees" value="1" {{ $seat->has_office_with_employees || old('has_office_with_employees', 0) === 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="has_office_with_employees">{{ trans('cruds.seat.fields.has_office_with_employees') }}</label>
                </div>
                @if($errors->has('has_office_with_employees'))
                    <span class="text-danger">{{ $errors->first('has_office_with_employees') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.seat.fields.has_office_with_employees_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="level">{{ trans('cruds.seat.fields.level') }}</label>
                <input class="form-control {{ $errors->has('level') ? 'is-invalid' : '' }}" type="number" name="level" id="level" value="{{ old('level', $seat->level) }}" step="1">
                @if($errors->has('level'))
                    <span class="text-danger">{{ $errors->first('level') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.seat.fields.level_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('is_js_as_ss') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="is_js_as_ss" value="0">
                    <input class="form-check-input" type="checkbox" name="is_js_as_ss" id="is_js_as_ss" value="1" {{ $seat->is_js_as_ss || old('is_js_as_ss', 0) === 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_js_as_ss">{{ trans('cruds.seat.fields.is_js_as_ss') }}</label>
                </div>
                @if($errors->has('is_js_as_ss'))
                    <span class="text-danger">{{ $errors->first('is_js_as_ss') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.seat.fields.is_js_as_ss_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('is_controlling_officer') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="is_controlling_officer" value="0">
                    <input class="form-check-input" type="checkbox" name="is_controlling_officer" id="is_controlling_officer" value="1" {{ $seat->is_controlling_officer || old('is_controlling_officer', 0) === 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_controlling_officer">{{ trans('cruds.seat.fields.is_controlling_officer') }}</label>
                </div>
                @if($errors->has('is_controlling_officer'))
                    <span class="text-danger">{{ $errors->first('is_controlling_officer') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.seat.fields.is_controlling_officer_helper') }}</span>
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