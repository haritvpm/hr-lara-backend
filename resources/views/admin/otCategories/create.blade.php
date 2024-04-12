@extends('layouts.admin')
@section('content')

<div class="card_">
    <div class="card-header_">
        {{ trans('global.create') }} {{ trans('cruds.otCategory.title_singular') }}
    </div>

    <div class="card-body_">
        <form method="POST" action="{{ route("admin.ot-categories.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="category">{{ trans('cruds.otCategory.fields.category') }}</label>
                <input class="form-control {{ $errors->has('category') ? 'is-invalid' : '' }}" type="text" name="category" id="category" value="{{ old('category', '') }}" required>
                @if($errors->has('category'))
                    <span class="text-danger">{{ $errors->first('category') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.otCategory.fields.category_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('has_punching') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="has_punching" value="0">
                    <input class="form-check-input" type="checkbox" name="has_punching" id="has_punching" value="1" {{ old('has_punching', 0) == 1 || old('has_punching') === null ? 'checked' : '' }}>
                    <label class="form-check-label" for="has_punching">{{ trans('cruds.otCategory.fields.has_punching') }}</label>
                </div>
                @if($errors->has('has_punching'))
                    <span class="text-danger">{{ $errors->first('has_punching') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.otCategory.fields.has_punching_helper') }}</span>
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
