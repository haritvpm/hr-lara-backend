@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.designationWithoutGrade.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.designation-without-grades.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="title">{{ trans('cruds.designationWithoutGrade.fields.title') }}</label>
                <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title" id="title" value="{{ old('title', '') }}" required>
                @if($errors->has('title'))
                    <span class="text-danger">{{ $errors->first('title') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.designationWithoutGrade.fields.title_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="title_mal">{{ trans('cruds.designationWithoutGrade.fields.title_mal') }}</label>
                <input class="form-control {{ $errors->has('title_mal') ? 'is-invalid' : '' }}" type="text" name="title_mal" id="title_mal" value="{{ old('title_mal', '') }}" required>
                @if($errors->has('title_mal'))
                    <span class="text-danger">{{ $errors->first('title_mal') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.designationWithoutGrade.fields.title_mal_helper') }}</span>
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