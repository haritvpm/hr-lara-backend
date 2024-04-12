@extends('layouts.admin')
@section('content')

<div class="card_">
    <div class="card-header_">
        {{ trans('global.create') }} {{ trans('cruds.deptEmployee.title_singular') }}
    </div>

    <div class="card-body_">
        <form method="POST" action="{{ route("admin.dept-employees.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label>{{ trans('cruds.deptEmployee.fields.srismt') }}</label>
                <select class="form-control {{ $errors->has('srismt') ? 'is-invalid' : '' }}" name="srismt" id="srismt">
                    <option value disabled {{ old('srismt', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\DeptEmployee::SRISMT_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('srismt', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('srismt'))
                    <span class="text-danger">{{ $errors->first('srismt') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.deptEmployee.fields.srismt_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.deptEmployee.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}" required>
                @if($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.deptEmployee.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="pen">{{ trans('cruds.deptEmployee.fields.pen') }}</label>
                <input class="form-control {{ $errors->has('pen') ? 'is-invalid' : '' }}" type="text" name="pen" id="pen" value="{{ old('pen', '') }}" required>
                @if($errors->has('pen'))
                    <span class="text-danger">{{ $errors->first('pen') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.deptEmployee.fields.pen_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="designation_id">{{ trans('cruds.deptEmployee.fields.designation') }}</label>
                <select class="form-control select2 {{ $errors->has('designation') ? 'is-invalid' : '' }}" name="designation_id" id="designation_id">
                    @foreach($designations as $id => $entry)
                        <option value="{{ $id }}" {{ old('designation_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('designation'))
                    <span class="text-danger">{{ $errors->first('designation') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.deptEmployee.fields.designation_helper') }}</span>
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
