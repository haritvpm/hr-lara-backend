@extends('layouts.admin')
@section('content')

<div class="card_">
    <div class="card-header_">
        {{ trans('global.edit') }} {{ trans('cruds.monthlyAttendance.title_singular') }}
    </div>

    <div class="card-body_">
        <form method="POST" action="{{ route("admin.monthly-attendances.update", [$monthlyAttendance->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="employee_id">{{ trans('cruds.monthlyAttendance.fields.employee') }}</label>
                <select class="form-control select2 {{ $errors->has('employee') ? 'is-invalid' : '' }}" name="employee_id" id="employee_id" required>
                    @foreach($employees as $id => $entry)
                        <option value="{{ $id }}" {{ (old('employee_id') ? old('employee_id') : $monthlyAttendance->employee->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('employee'))
                    <span class="text-danger">{{ $errors->first('employee') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.monthlyAttendance.fields.employee_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="month">{{ trans('cruds.monthlyAttendance.fields.month') }}</label>
                <input class="form-control date {{ $errors->has('month') ? 'is-invalid' : '' }}" type="text" name="month" id="month" value="{{ old('month', $monthlyAttendance->month) }}" required>
                @if($errors->has('month'))
                    <span class="text-danger">{{ $errors->first('month') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.monthlyAttendance.fields.month_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="total_cl">{{ trans('cruds.monthlyAttendance.fields.total_cl') }}</label>
                <input class="form-control {{ $errors->has('total_cl') ? 'is-invalid' : '' }}" type="number" name="total_cl" id="total_cl" value="{{ old('total_cl', $monthlyAttendance->total_cl) }}" step="0.1" max="20">
                @if($errors->has('total_cl'))
                    <span class="text-danger">{{ $errors->first('total_cl') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.monthlyAttendance.fields.total_cl_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="total_compen">{{ trans('cruds.monthlyAttendance.fields.total_compen') }}</label>
                <input class="form-control {{ $errors->has('total_compen') ? 'is-invalid' : '' }}" type="number" name="total_compen" id="total_compen" value="{{ old('total_compen', $monthlyAttendance->total_compen) }}" step="1">
                @if($errors->has('total_compen'))
                    <span class="text-danger">{{ $errors->first('total_compen') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.monthlyAttendance.fields.total_compen_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="total_compen_off_granted">{{ trans('cruds.monthlyAttendance.fields.total_compen_off_granted') }}</label>
                <input class="form-control {{ $errors->has('total_compen_off_granted') ? 'is-invalid' : '' }}" type="number" name="total_compen_off_granted" id="total_compen_off_granted" value="{{ old('total_compen_off_granted', $monthlyAttendance->total_compen_off_granted) }}" step="1">
                @if($errors->has('total_compen_off_granted'))
                    <span class="text-danger">{{ $errors->first('total_compen_off_granted') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.monthlyAttendance.fields.total_compen_off_granted_helper') }}</span>
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
