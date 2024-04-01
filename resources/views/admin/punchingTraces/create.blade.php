@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.punchingTrace.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.punching-traces.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="aadhaarid">{{ trans('cruds.punchingTrace.fields.aadhaarid') }}</label>
                <input class="form-control {{ $errors->has('aadhaarid') ? 'is-invalid' : '' }}" type="text" name="aadhaarid" id="aadhaarid" value="{{ old('aadhaarid', '') }}" required>
                @if($errors->has('aadhaarid'))
                    <div class="invalid-feedback">
                        {{ $errors->first('aadhaarid') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.punchingTrace.fields.aadhaarid_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="org_emp_code">{{ trans('cruds.punchingTrace.fields.org_emp_code') }}</label>
                <input class="form-control {{ $errors->has('org_emp_code') ? 'is-invalid' : '' }}" type="text" name="org_emp_code" id="org_emp_code" value="{{ old('org_emp_code', '') }}">
                @if($errors->has('org_emp_code'))
                    <div class="invalid-feedback">
                        {{ $errors->first('org_emp_code') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.punchingTrace.fields.org_emp_code_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="device">{{ trans('cruds.punchingTrace.fields.device') }}</label>
                <input class="form-control {{ $errors->has('device') ? 'is-invalid' : '' }}" type="text" name="device" id="device" value="{{ old('device', '') }}">
                @if($errors->has('device'))
                    <div class="invalid-feedback">
                        {{ $errors->first('device') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.punchingTrace.fields.device_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="attendance_type">{{ trans('cruds.punchingTrace.fields.attendance_type') }}</label>
                <input class="form-control {{ $errors->has('attendance_type') ? 'is-invalid' : '' }}" type="text" name="attendance_type" id="attendance_type" value="{{ old('attendance_type', '') }}">
                @if($errors->has('attendance_type'))
                    <div class="invalid-feedback">
                        {{ $errors->first('attendance_type') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.punchingTrace.fields.attendance_type_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="auth_status">{{ trans('cruds.punchingTrace.fields.auth_status') }}</label>
                <input class="form-control {{ $errors->has('auth_status') ? 'is-invalid' : '' }}" type="text" name="auth_status" id="auth_status" value="{{ old('auth_status', '') }}">
                @if($errors->has('auth_status'))
                    <div class="invalid-feedback">
                        {{ $errors->first('auth_status') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.punchingTrace.fields.auth_status_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="err_code">{{ trans('cruds.punchingTrace.fields.err_code') }}</label>
                <input class="form-control {{ $errors->has('err_code') ? 'is-invalid' : '' }}" type="text" name="err_code" id="err_code" value="{{ old('err_code', '') }}">
                @if($errors->has('err_code'))
                    <div class="invalid-feedback">
                        {{ $errors->first('err_code') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.punchingTrace.fields.err_code_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="att_date">{{ trans('cruds.punchingTrace.fields.att_date') }}</label>
                <input class="form-control date {{ $errors->has('att_date') ? 'is-invalid' : '' }}" type="text" name="att_date" id="att_date" value="{{ old('att_date') }}" required>
                @if($errors->has('att_date'))
                    <div class="invalid-feedback">
                        {{ $errors->first('att_date') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.punchingTrace.fields.att_date_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="att_time">{{ trans('cruds.punchingTrace.fields.att_time') }}</label>
                <input class="form-control timepicker {{ $errors->has('att_time') ? 'is-invalid' : '' }}" type="text" name="att_time" id="att_time" value="{{ old('att_time') }}" required>
                @if($errors->has('att_time'))
                    <div class="invalid-feedback">
                        {{ $errors->first('att_time') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.punchingTrace.fields.att_time_helper') }}</span>
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