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
                    <span class="text-danger">{{ $errors->first('designation') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.designation.fields.designation_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="designation_mal">{{ trans('cruds.designation.fields.designation_mal') }}</label>
                <input class="form-control {{ $errors->has('designation_mal') ? 'is-invalid' : '' }}" type="text" name="designation_mal" id="designation_mal" value="{{ old('designation_mal', $designation->designation_mal) }}">
                @if($errors->has('designation_mal'))
                    <span class="text-danger">{{ $errors->first('designation_mal') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.designation.fields.designation_mal_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="sort_index">{{ trans('cruds.designation.fields.sort_index') }}</label>
                <input class="form-control {{ $errors->has('sort_index') ? 'is-invalid' : '' }}" type="number" name="sort_index" id="sort_index" value="{{ old('sort_index', $designation->sort_index) }}" step="1">
                @if($errors->has('sort_index'))
                    <span class="text-danger">{{ $errors->first('sort_index') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.designation.fields.sort_index_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="has_punching">{{ trans('cruds.designation.fields.has_punching') }}</label>
                <input class="form-control {{ $errors->has('has_punching') ? 'is-invalid' : '' }}" type="number" name="has_punching" id="has_punching" value="{{ old('has_punching', $designation->has_punching) }}" step="1">
                @if($errors->has('has_punching'))
                    <span class="text-danger">{{ $errors->first('has_punching') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.designation.fields.has_punching_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="desig_line_id">{{ trans('cruds.designation.fields.desig_line') }}</label>
                <select class="form-control select2 {{ $errors->has('desig_line') ? 'is-invalid' : '' }}" name="desig_line_id" id="desig_line_id">
                    @foreach($desig_lines as $id => $entry)
                        <option value="{{ $id }}" {{ (old('desig_line_id') ? old('desig_line_id') : $designation->desig_line->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('desig_line'))
                    <span class="text-danger">{{ $errors->first('desig_line') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.designation.fields.desig_line_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="office_times_id">{{ trans('cruds.designation.fields.office_times') }}</label>
                <select class="form-control select2 {{ $errors->has('office_times') ? 'is-invalid' : '' }}" name="office_times_id" id="office_times_id" required>
                    @foreach($office_times as $id => $entry)
                        <option value="{{ $id }}" {{ (old('office_times_id') ? old('office_times_id') : $designation->office_times->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('office_times'))
                    <span class="text-danger">{{ $errors->first('office_times') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.designation.fields.office_times_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="designation_wo_grade_id">{{ trans('cruds.designation.fields.designation_wo_grade') }}</label>
                <select class="form-control select2 {{ $errors->has('designation_wo_grade') ? 'is-invalid' : '' }}" name="designation_wo_grade_id" id="designation_wo_grade_id">
                    @foreach($designation_wo_grades as $id => $entry)
                        <option value="{{ $id }}" {{ (old('designation_wo_grade_id') ? old('designation_wo_grade_id') : $designation->designation_wo_grade->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('designation_wo_grade'))
                    <span class="text-danger">{{ $errors->first('designation_wo_grade') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.designation.fields.designation_wo_grade_helper') }}</span>
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