@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.overtimeOther.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.overtime-others.update", [$overtimeOther->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="employee_id">{{ trans('cruds.overtimeOther.fields.employee') }}</label>
                <select class="form-control select2 {{ $errors->has('employee') ? 'is-invalid' : '' }}" name="employee_id" id="employee_id" required>
                    @foreach($employees as $id => $entry)
                        <option value="{{ $id }}" {{ (old('employee_id') ? old('employee_id') : $overtimeOther->employee->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('employee'))
                    <span class="text-danger">{{ $errors->first('employee') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.overtimeOther.fields.employee_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="designation">{{ trans('cruds.overtimeOther.fields.designation') }}</label>
                <input class="form-control {{ $errors->has('designation') ? 'is-invalid' : '' }}" type="text" name="designation" id="designation" value="{{ old('designation', $overtimeOther->designation) }}" required>
                @if($errors->has('designation'))
                    <span class="text-danger">{{ $errors->first('designation') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.overtimeOther.fields.designation_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="from">{{ trans('cruds.overtimeOther.fields.from') }}</label>
                <input class="form-control {{ $errors->has('from') ? 'is-invalid' : '' }}" type="text" name="from" id="from" value="{{ old('from', $overtimeOther->from) }}">
                @if($errors->has('from'))
                    <span class="text-danger">{{ $errors->first('from') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.overtimeOther.fields.from_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="to">{{ trans('cruds.overtimeOther.fields.to') }}</label>
                <input class="form-control {{ $errors->has('to') ? 'is-invalid' : '' }}" type="text" name="to" id="to" value="{{ old('to', $overtimeOther->to) }}">
                @if($errors->has('to'))
                    <span class="text-danger">{{ $errors->first('to') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.overtimeOther.fields.to_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="count">{{ trans('cruds.overtimeOther.fields.count') }}</label>
                <input class="form-control {{ $errors->has('count') ? 'is-invalid' : '' }}" type="text" name="count" id="count" value="{{ old('count', $overtimeOther->count) }}">
                @if($errors->has('count'))
                    <span class="text-danger">{{ $errors->first('count') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.overtimeOther.fields.count_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="form_id">{{ trans('cruds.overtimeOther.fields.form') }}</label>
                <select class="form-control select2 {{ $errors->has('form') ? 'is-invalid' : '' }}" name="form_id" id="form_id">
                    @foreach($forms as $id => $entry)
                        <option value="{{ $id }}" {{ (old('form_id') ? old('form_id') : $overtimeOther->form->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('form'))
                    <span class="text-danger">{{ $errors->first('form') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.overtimeOther.fields.form_helper') }}</span>
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