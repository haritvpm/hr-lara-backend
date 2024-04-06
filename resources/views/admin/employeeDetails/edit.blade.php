@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.employeeDetail.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.employee-details.update", [$employeeDetail->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="employee_id">{{ trans('cruds.employeeDetail.fields.employee') }}</label>
                <select class="form-control select2 {{ $errors->has('employee') ? 'is-invalid' : '' }}" name="employee_id" id="employee_id" required>
                    @foreach($employees as $id => $entry)
                        <option value="{{ $id }}" {{ (old('employee_id') ? old('employee_id') : $employeeDetail->employee->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('employee'))
                    <span class="text-danger">{{ $errors->first('employee') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.employeeDetail.fields.employee_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="election">{{ trans('cruds.employeeDetail.fields.election') }}</label>
                <input class="form-control {{ $errors->has('election') ? 'is-invalid' : '' }}" type="text" name="election" id="election" value="{{ old('election', $employeeDetail->election) }}" required>
                @if($errors->has('election'))
                    <span class="text-danger">{{ $errors->first('election') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.employeeDetail.fields.election_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="kla_id_no">{{ trans('cruds.employeeDetail.fields.kla_id_no') }}</label>
                <input class="form-control {{ $errors->has('kla_id_no') ? 'is-invalid' : '' }}" type="text" name="kla_id_no" id="kla_id_no" value="{{ old('kla_id_no', $employeeDetail->kla_id_no) }}">
                @if($errors->has('kla_id_no'))
                    <span class="text-danger">{{ $errors->first('kla_id_no') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.employeeDetail.fields.kla_id_no_helper') }}</span>
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