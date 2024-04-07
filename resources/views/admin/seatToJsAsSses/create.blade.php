@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.seatToJsAsSs.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.seat-to-js-as-sses.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="seat_id">{{ trans('cruds.seatToJsAsSs.fields.seat') }}</label>
                <select class="form-control select2 {{ $errors->has('seat') ? 'is-invalid' : '' }}" name="seat_id" id="seat_id" required>
                    @foreach($seats as $id => $entry)
                        <option value="{{ $id }}" {{ old('seat_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('seat'))
                    <span class="text-danger">{{ $errors->first('seat') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.seatToJsAsSs.fields.seat_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="employee_id">{{ trans('cruds.seatToJsAsSs.fields.employee') }}</label>
                <select class="form-control select2 {{ $errors->has('employee') ? 'is-invalid' : '' }}" name="employee_id" id="employee_id" required>
                    @foreach($employees as $id => $entry)
                        <option value="{{ $id }}" {{ old('employee_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('employee'))
                    <span class="text-danger">{{ $errors->first('employee') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.seatToJsAsSs.fields.employee_helper') }}</span>
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