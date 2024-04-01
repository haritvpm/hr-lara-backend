@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.designation.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.designations.update", [$designation->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="designation">{{ trans('cruds.designation.fields.designation') }}</label>
                <input class="form-control {{ $errors->has('designation') ? 'is-invalid' : '' }}" type="text" name="designation" id="designation" value="{{ old('designation', $designation->designation) }}" required>
                @if($errors->has('designation'))
                    <div class="invalid-feedback">
                        {{ $errors->first('designation') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.designation.fields.designation_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="designation_mal">{{ trans('cruds.designation.fields.designation_mal') }}</label>
                <input class="form-control {{ $errors->has('designation_mal') ? 'is-invalid' : '' }}" type="text" name="designation_mal" id="designation_mal" value="{{ old('designation_mal', $designation->designation_mal) }}">
                @if($errors->has('designation_mal'))
                    <div class="invalid-feedback">
                        {{ $errors->first('designation_mal') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.designation.fields.designation_mal_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="sort_index">{{ trans('cruds.designation.fields.sort_index') }}</label>
                <input class="form-control {{ $errors->has('sort_index') ? 'is-invalid' : '' }}" type="number" name="sort_index" id="sort_index" value="{{ old('sort_index', $designation->sort_index) }}" step="1">
                @if($errors->has('sort_index'))
                    <div class="invalid-feedback">
                        {{ $errors->first('sort_index') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.designation.fields.sort_index_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="has_punching">{{ trans('cruds.designation.fields.has_punching') }}</label>
                <input class="form-control {{ $errors->has('has_punching') ? 'is-invalid' : '' }}" type="number" name="has_punching" id="has_punching" value="{{ old('has_punching', $designation->has_punching) }}" step="1">
                @if($errors->has('has_punching'))
                    <div class="invalid-feedback">
                        {{ $errors->first('has_punching') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.designation.fields.has_punching_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="normal_office_hours">{{ trans('cruds.designation.fields.normal_office_hours') }}</label>
                <input class="form-control {{ $errors->has('normal_office_hours') ? 'is-invalid' : '' }}" type="number" name="normal_office_hours" id="normal_office_hours" value="{{ old('normal_office_hours', $designation->normal_office_hours) }}" step="1">
                @if($errors->has('normal_office_hours'))
                    <div class="invalid-feedback">
                        {{ $errors->first('normal_office_hours') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.designation.fields.normal_office_hours_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="desig_line_id">{{ trans('cruds.designation.fields.desig_line') }}</label>
                <select class="form-control select2 {{ $errors->has('desig_line') ? 'is-invalid' : '' }}" name="desig_line_id" id="desig_line_id">
                    @foreach($desig_lines as $id => $entry)
                        <option value="{{ $id }}" {{ (old('desig_line_id') ? old('desig_line_id') : $designation->desig_line->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('desig_line'))
                    <div class="invalid-feedback">
                        {{ $errors->first('desig_line') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.designation.fields.desig_line_helper') }}</span>
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