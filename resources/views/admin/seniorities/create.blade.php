@extends('layouts.admin')
@section('content')

<div class="card_">
    <div class="card-header_">
        {{ trans('global.create') }} {{ trans('cruds.seniority.title_singular') }}
    </div>

    <div class="card-body_">
        <form method="POST" action="{{ route("admin.seniorities.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="employee_id">{{ trans('cruds.seniority.fields.employee') }}</label>
                <select class="form-control select2 {{ $errors->has('employee') ? 'is-invalid' : '' }}" name="employee_id" id="employee_id" required>
                    @foreach($employees as $id => $entry)
                        <option value="{{ $id }}" {{ old('employee_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('employee'))
                    <span class="text-danger">{{ $errors->first('employee') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.seniority.fields.employee_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="sortindex">{{ trans('cruds.seniority.fields.sortindex') }}</label>
                <input class="form-control {{ $errors->has('sortindex') ? 'is-invalid' : '' }}" type="number" name="sortindex" id="sortindex" value="{{ old('sortindex', '') }}" step="1" required>
                @if($errors->has('sortindex'))
                    <span class="text-danger">{{ $errors->first('sortindex') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.seniority.fields.sortindex_helper') }}</span>
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
