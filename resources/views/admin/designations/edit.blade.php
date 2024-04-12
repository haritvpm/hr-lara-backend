@extends('layouts.admin')
@section('content')

<div class="card_">
    <div class="card-header_">
        {{ trans('global.edit') }} {{ trans('cruds.designation.title_singular') }}
    </div>

    <div class="card-body_">
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
                <label for="default_time_group_id">{{ trans('cruds.designation.fields.default_time_group') }}</label>
                <select class="form-control select2 {{ $errors->has('default_time_group') ? 'is-invalid' : '' }}" name="default_time_group_id" id="default_time_group_id">
                    @foreach($default_time_groups as $id => $entry)
                        <option value="{{ $id }}" {{ (old('default_time_group_id') ? old('default_time_group_id') : $designation->default_time_group->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('default_time_group'))
                    <span class="text-danger">{{ $errors->first('default_time_group') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.designation.fields.default_time_group_helper') }}</span>
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
                <label for="designation_without_grade">{{ trans('cruds.designation.fields.designation_without_grade') }}</label>
                <input class="form-control {{ $errors->has('designation_without_grade') ? 'is-invalid' : '' }}" type="text" name="designation_without_grade" id="designation_without_grade" value="{{ old('designation_without_grade', $designation->designation_without_grade) }}">
                @if($errors->has('designation_without_grade'))
                    <span class="text-danger">{{ $errors->first('designation_without_grade') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.designation.fields.designation_without_grade_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="designation_without_grade_mal">{{ trans('cruds.designation.fields.designation_without_grade_mal') }}</label>
                <input class="form-control {{ $errors->has('designation_without_grade_mal') ? 'is-invalid' : '' }}" type="text" name="designation_without_grade_mal" id="designation_without_grade_mal" value="{{ old('designation_without_grade_mal', $designation->designation_without_grade_mal) }}">
                @if($errors->has('designation_without_grade_mal'))
                    <span class="text-danger">{{ $errors->first('designation_without_grade_mal') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.designation.fields.designation_without_grade_mal_helper') }}</span>
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
