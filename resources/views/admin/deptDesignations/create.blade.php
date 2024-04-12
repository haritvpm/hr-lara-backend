@extends('layouts.admin')
@section('content')

<div class="card_">
    <div class="card-header_">
        {{ trans('global.create') }} {{ trans('cruds.deptDesignation.title_singular') }}
    </div>

    <div class="card-body_">
        <form method="POST" action="{{ route("admin.dept-designations.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="title">{{ trans('cruds.deptDesignation.fields.title') }}</label>
                <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title" id="title" value="{{ old('title', '') }}" required>
                @if($errors->has('title'))
                    <span class="text-danger">{{ $errors->first('title') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.deptDesignation.fields.title_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="max_persons">{{ trans('cruds.deptDesignation.fields.max_persons') }}</label>
                <input class="form-control {{ $errors->has('max_persons') ? 'is-invalid' : '' }}" type="number" name="max_persons" id="max_persons" value="{{ old('max_persons', '') }}" step="1">
                @if($errors->has('max_persons'))
                    <span class="text-danger">{{ $errors->first('max_persons') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.deptDesignation.fields.max_persons_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="user_id">{{ trans('cruds.deptDesignation.fields.user') }}</label>
                <select class="form-control select2 {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id" id="user_id">
                    @foreach($users as $id => $entry)
                        <option value="{{ $id }}" {{ old('user_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('user'))
                    <span class="text-danger">{{ $errors->first('user') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.deptDesignation.fields.user_helper') }}</span>
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
