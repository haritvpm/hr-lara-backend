@extends('layouts.admin')
@section('content')

<div class="card_">
    <div class="card-header_">
        {{ trans('global.edit') }} {{ trans('cruds.employeeToSeat.title_singular') }}
    </div>

    <div class="card-body_">
        <form method="POST" action="{{ route("admin.employee-to-seats.update", [$employeeToSeat->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="seat_id">{{ trans('cruds.employeeToSeat.fields.seat') }}</label>
                <select class="form-control select2 {{ $errors->has('seat') ? 'is-invalid' : '' }}" name="seat_id" id="seat_id" required>
                    @foreach($seats as $id => $entry)
                        <option value="{{ $id }}" {{ (old('seat_id') ? old('seat_id') : $employeeToSeat->seat->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('seat'))
                    <span class="text-danger">{{ $errors->first('seat') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.employeeToSeat.fields.seat_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="employee_id">{{ trans('cruds.employeeToSeat.fields.employee') }}</label>
                <select class="form-control select2 {{ $errors->has('employee') ? 'is-invalid' : '' }}" name="employee_id" id="employee_id" >
                    @foreach($employees as $id => $entry)
                        <option value="{{ $id }}" {{ (old('employee_id') ? old('employee_id') : $employeeToSeat->employee->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('employee'))
                    <span class="text-danger">{{ $errors->first('employee') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.employeeToSeat.fields.employee_helper') }}</span>
            </div>
            <!-- <div class="form-group">
                <label for="start_date">{{ trans('cruds.employeeToSeat.fields.start_date') }}</label>
                <input class="form-control date {{ $errors->has('start_date') ? 'is-invalid' : '' }}" type="text" name="start_date" id="start_date" value="{{ old('start_date', $employeeToSeat->start_date) }}">
                @if($errors->has('start_date'))
                    <span class="text-danger">{{ $errors->first('start_date') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.employeeToSeat.fields.start_date_helper') }}</span>
            </div> -->
            <!-- <div class="form-group">
                <label for="end_date">{{ trans('cruds.employeeToSeat.fields.end_date') }}</label>
                <input class="form-control date {{ $errors->has('end_date') ? 'is-invalid' : '' }}" type="text" name="end_date" id="end_date" value="{{ old('end_date', $employeeToSeat->end_date) }}">
                @if($errors->has('end_date'))
                    <span class="text-danger">{{ $errors->first('end_date') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.employeeToSeat.fields.end_date_helper') }}</span>
            </div> -->
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection
