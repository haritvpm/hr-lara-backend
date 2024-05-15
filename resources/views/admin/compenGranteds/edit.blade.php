@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.compenGranted.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.compen-granteds.update", [$compenGranted->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="aadhaarid">{{ trans('cruds.compenGranted.fields.aadhaarid') }}</label>
                <input class="form-control {{ $errors->has('aadhaarid') ? 'is-invalid' : '' }}" type="text" name="aadhaarid" id="aadhaarid" value="{{ old('aadhaarid', $compenGranted->aadhaarid) }}" required>
                @if($errors->has('aadhaarid'))
                    <span class="text-danger">{{ $errors->first('aadhaarid') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.compenGranted.fields.aadhaarid_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="date_of_work">{{ trans('cruds.compenGranted.fields.date_of_work') }}</label>
                <input class="form-control date {{ $errors->has('date_of_work') ? 'is-invalid' : '' }}" type="text" name="date_of_work" id="date_of_work" value="{{ old('date_of_work', $compenGranted->date_of_work) }}" required>
                @if($errors->has('date_of_work'))
                    <span class="text-danger">{{ $errors->first('date_of_work') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.compenGranted.fields.date_of_work_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('is_for_extra_hours') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="is_for_extra_hours" value="0">
                    <input class="form-check-input" type="checkbox" name="is_for_extra_hours" id="is_for_extra_hours" value="1" {{ $compenGranted->is_for_extra_hours || old('is_for_extra_hours', 0) === 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_for_extra_hours">{{ trans('cruds.compenGranted.fields.is_for_extra_hours') }}</label>
                </div>
                @if($errors->has('is_for_extra_hours'))
                    <span class="text-danger">{{ $errors->first('is_for_extra_hours') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.compenGranted.fields.is_for_extra_hours_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="employee_id">{{ trans('cruds.compenGranted.fields.employee') }}</label>
                <select class="form-control select2 {{ $errors->has('employee') ? 'is-invalid' : '' }}" name="employee_id" id="employee_id">
                    @foreach($employees as $id => $entry)
                        <option value="{{ $id }}" {{ (old('employee_id') ? old('employee_id') : $compenGranted->employee->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('employee'))
                    <span class="text-danger">{{ $errors->first('employee') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.compenGranted.fields.employee_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="leave_id">{{ trans('cruds.compenGranted.fields.leave') }}</label>
                <select class="form-control select2 {{ $errors->has('leave') ? 'is-invalid' : '' }}" name="leave_id" id="leave_id">
                    @foreach($leaves as $id => $entry)
                        <option value="{{ $id }}" {{ (old('leave_id') ? old('leave_id') : $compenGranted->leave->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('leave'))
                    <span class="text-danger">{{ $errors->first('leave') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.compenGranted.fields.leave_helper') }}</span>
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