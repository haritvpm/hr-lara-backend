@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.employeeExtra.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.employee-extras.update", [$employeeExtra->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="employee_id">{{ trans('cruds.employeeExtra.fields.employee') }}</label>
                <select class="form-control select2 {{ $errors->has('employee') ? 'is-invalid' : '' }}" name="employee_id" id="employee_id">
                    @foreach($employees as $id => $entry)
                        <option value="{{ $id }}" {{ (old('employee_id') ? old('employee_id') : $employeeExtra->employee->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('employee'))
                    <span class="text-danger">{{ $errors->first('employee') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.employeeExtra.fields.employee_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="address">{{ trans('cruds.employeeExtra.fields.address') }}</label>
                <textarea class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" name="address" id="address">{{ old('address', $employeeExtra->address) }}</textarea>
                @if($errors->has('address'))
                    <span class="text-danger">{{ $errors->first('address') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.employeeExtra.fields.address_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="date_of_joining_kla">{{ trans('cruds.employeeExtra.fields.date_of_joining_kla') }}</label>
                <input class="form-control date {{ $errors->has('date_of_joining_kla') ? 'is-invalid' : '' }}" type="text" name="date_of_joining_kla" id="date_of_joining_kla" value="{{ old('date_of_joining_kla', $employeeExtra->date_of_joining_kla) }}">
                @if($errors->has('date_of_joining_kla'))
                    <span class="text-danger">{{ $errors->first('date_of_joining_kla') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.employeeExtra.fields.date_of_joining_kla_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="pan">{{ trans('cruds.employeeExtra.fields.pan') }}</label>
                <input class="form-control {{ $errors->has('pan') ? 'is-invalid' : '' }}" type="text" name="pan" id="pan" value="{{ old('pan', $employeeExtra->pan) }}" required>
                @if($errors->has('pan'))
                    <span class="text-danger">{{ $errors->first('pan') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.employeeExtra.fields.pan_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="klaid">{{ trans('cruds.employeeExtra.fields.klaid') }}</label>
                <input class="form-control {{ $errors->has('klaid') ? 'is-invalid' : '' }}" type="text" name="klaid" id="klaid" value="{{ old('klaid', $employeeExtra->klaid) }}" required>
                @if($errors->has('klaid'))
                    <span class="text-danger">{{ $errors->first('klaid') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.employeeExtra.fields.klaid_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="electionid">{{ trans('cruds.employeeExtra.fields.electionid') }}</label>
                <input class="form-control {{ $errors->has('electionid') ? 'is-invalid' : '' }}" type="text" name="electionid" id="electionid" value="{{ old('electionid', $employeeExtra->electionid) }}" required>
                @if($errors->has('electionid'))
                    <span class="text-danger">{{ $errors->first('electionid') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.employeeExtra.fields.electionid_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="mobile">{{ trans('cruds.employeeExtra.fields.mobile') }}</label>
                <input class="form-control {{ $errors->has('mobile') ? 'is-invalid' : '' }}" type="text" name="mobile" id="mobile" value="{{ old('mobile', $employeeExtra->mobile) }}" required>
                @if($errors->has('mobile'))
                    <span class="text-danger">{{ $errors->first('mobile') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.employeeExtra.fields.mobile_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="email">{{ trans('cruds.employeeExtra.fields.email') }}</label>
                <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="email" name="email" id="email" value="{{ old('email', $employeeExtra->email) }}">
                @if($errors->has('email'))
                    <span class="text-danger">{{ $errors->first('email') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.employeeExtra.fields.email_helper') }}</span>
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