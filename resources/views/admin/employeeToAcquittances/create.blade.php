@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.employeeToAcquittance.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.employee-to-acquittances.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="employee_id">{{ trans('cruds.employeeToAcquittance.fields.employee') }}</label>
                <select class="form-control select2 {{ $errors->has('employee') ? 'is-invalid' : '' }}" name="employee_id" id="employee_id" required>
                    @foreach($employees as $id => $entry)
                        <option value="{{ $id }}" {{ old('employee_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('employee'))
                    <span class="text-danger">{{ $errors->first('employee') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.employeeToAcquittance.fields.employee_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="acquittance_id">{{ trans('cruds.employeeToAcquittance.fields.acquittance') }}</label>
                <select class="form-control select2 {{ $errors->has('acquittance') ? 'is-invalid' : '' }}" name="acquittance_id" id="acquittance_id" required>
                    @foreach($acquittances as $id => $entry)
                        <option value="{{ $id }}" {{ old('acquittance_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('acquittance'))
                    <span class="text-danger">{{ $errors->first('acquittance') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.employeeToAcquittance.fields.acquittance_helper') }}</span>
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