@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.employeeToSection.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.employee-to-sections.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="employee_id">{{ trans('cruds.employeeToSection.fields.employee') }}</label>
                <select class="form-control select2 {{ $errors->has('employee') ? 'is-invalid' : '' }}" name="employee_id" id="employee_id" required>
                    @foreach($employees as $id => $entry)
                        <option value="{{ $id }}" {{ old('employee_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('employee'))
                    <span class="text-danger">{{ $errors->first('employee') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.employeeToSection.fields.employee_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="section_seat_id">{{ trans('cruds.employeeToSection.fields.section_seat') }}</label>
                <select class="form-control select2 {{ $errors->has('section_seat') ? 'is-invalid' : '' }}" name="section_seat_id" id="section_seat_id" required>
                    @foreach($section_seats as $id => $entry)
                        <option value="{{ $id }}" {{ old('section_seat_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('section_seat'))
                    <span class="text-danger">{{ $errors->first('section_seat') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.employeeToSection.fields.section_seat_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="attendance_book_id">{{ trans('cruds.employeeToSection.fields.attendance_book') }}</label>
                <select class="form-control select2 {{ $errors->has('attendance_book') ? 'is-invalid' : '' }}" name="attendance_book_id" id="attendance_book_id" required>
                    @foreach($attendance_books as $id => $entry)
                        <option value="{{ $id }}" {{ old('attendance_book_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('attendance_book'))
                    <span class="text-danger">{{ $errors->first('attendance_book') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.employeeToSection.fields.attendance_book_helper') }}</span>
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