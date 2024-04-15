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
                <label for="cl_taken">{{ trans('cruds.monthlyAttendance.fields.cl_taken') }}</label>
                <input class="form-control {{ $errors->has('cl_taken') ? 'is-invalid' : '' }}" type="number" name="cl_taken" id="cl_taken" value="{{ old('cl_taken', '') }}" step="0.1">
                @if($errors->has('cl_taken'))
                    <span class="text-danger">{{ $errors->first('cl_taken') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.monthlyAttendance.fields.cl_taken_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="compen_taken">{{ trans('cruds.monthlyAttendance.fields.compen_taken') }}</label>
                <input class="form-control {{ $errors->has('compen_taken') ? 'is-invalid' : '' }}" type="number" name="compen_taken" id="compen_taken" value="{{ old('compen_taken', '') }}" step="1">
                @if($errors->has('compen_taken'))
                    <span class="text-danger">{{ $errors->first('compen_taken') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.monthlyAttendance.fields.compen_taken_helper') }}</span>
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
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection