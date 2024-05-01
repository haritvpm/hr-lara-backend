@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.monthlyAttendance.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.monthly-attendances.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="aadhaarid">{{ trans('cruds.monthlyAttendance.fields.aadhaarid') }}</label>
                <input class="form-control {{ $errors->has('aadhaarid') ? 'is-invalid' : '' }}" type="text" name="aadhaarid" id="aadhaarid" value="{{ old('aadhaarid', '') }}" required>
                @if($errors->has('aadhaarid'))
                    <span class="text-danger">{{ $errors->first('aadhaarid') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.monthlyAttendance.fields.aadhaarid_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="cl_marked">{{ trans('cruds.monthlyAttendance.fields.cl_marked') }}</label>
                <input class="form-control {{ $errors->has('cl_marked') ? 'is-invalid' : '' }}" type="number" name="cl_marked" id="cl_marked" value="{{ old('cl_marked', '') }}" step="0.1">
                @if($errors->has('cl_marked'))
                    <span class="text-danger">{{ $errors->first('cl_marked') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.monthlyAttendance.fields.cl_marked_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="compen_marked">{{ trans('cruds.monthlyAttendance.fields.compen_marked') }}</label>
                <input class="form-control {{ $errors->has('compen_marked') ? 'is-invalid' : '' }}" type="number" name="compen_marked" id="compen_marked" value="{{ old('compen_marked', '') }}" step="1">
                @if($errors->has('compen_marked'))
                    <span class="text-danger">{{ $errors->first('compen_marked') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.monthlyAttendance.fields.compen_marked_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="compoff_granted">{{ trans('cruds.monthlyAttendance.fields.compoff_granted') }}</label>
                <input class="form-control {{ $errors->has('compoff_granted') ? 'is-invalid' : '' }}" type="number" name="compoff_granted" id="compoff_granted" value="{{ old('compoff_granted', '') }}" step="1">
                @if($errors->has('compoff_granted'))
                    <span class="text-danger">{{ $errors->first('compoff_granted') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.monthlyAttendance.fields.compoff_granted_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="total_grace_sec">{{ trans('cruds.monthlyAttendance.fields.total_grace_sec') }}</label>
                <input class="form-control {{ $errors->has('total_grace_sec') ? 'is-invalid' : '' }}" type="number" name="total_grace_sec" id="total_grace_sec" value="{{ old('total_grace_sec', '') }}" step="1">
                @if($errors->has('total_grace_sec'))
                    <span class="text-danger">{{ $errors->first('total_grace_sec') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.monthlyAttendance.fields.total_grace_sec_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="total_extra_sec">{{ trans('cruds.monthlyAttendance.fields.total_extra_sec') }}</label>
                <input class="form-control {{ $errors->has('total_extra_sec') ? 'is-invalid' : '' }}" type="number" name="total_extra_sec" id="total_extra_sec" value="{{ old('total_extra_sec', '') }}" step="1">
                @if($errors->has('total_extra_sec'))
                    <span class="text-danger">{{ $errors->first('total_extra_sec') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.monthlyAttendance.fields.total_extra_sec_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="total_grace_str">{{ trans('cruds.monthlyAttendance.fields.total_grace_str') }}</label>
                <input class="form-control {{ $errors->has('total_grace_str') ? 'is-invalid' : '' }}" type="text" name="total_grace_str" id="total_grace_str" value="{{ old('total_grace_str', '') }}">
                @if($errors->has('total_grace_str'))
                    <span class="text-danger">{{ $errors->first('total_grace_str') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.monthlyAttendance.fields.total_grace_str_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="total_extra_str">{{ trans('cruds.monthlyAttendance.fields.total_extra_str') }}</label>
                <input class="form-control {{ $errors->has('total_extra_str') ? 'is-invalid' : '' }}" type="text" name="total_extra_str" id="total_extra_str" value="{{ old('total_extra_str', '') }}">
                @if($errors->has('total_extra_str'))
                    <span class="text-danger">{{ $errors->first('total_extra_str') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.monthlyAttendance.fields.total_extra_str_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="grace_exceeded_sec">{{ trans('cruds.monthlyAttendance.fields.grace_exceeded_sec') }}</label>
                <input class="form-control {{ $errors->has('grace_exceeded_sec') ? 'is-invalid' : '' }}" type="number" name="grace_exceeded_sec" id="grace_exceeded_sec" value="{{ old('grace_exceeded_sec', '') }}" step="1">
                @if($errors->has('grace_exceeded_sec'))
                    <span class="text-danger">{{ $errors->first('grace_exceeded_sec') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.monthlyAttendance.fields.grace_exceeded_sec_helper') }}</span>
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
