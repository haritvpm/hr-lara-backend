@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.employeeSectionHistory.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.employee-section-histories.update", [$employeeSectionHistory->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="employee_id">{{ trans('cruds.employeeSectionHistory.fields.employee') }}</label>
                <select class="form-control select2 {{ $errors->has('employee') ? 'is-invalid' : '' }}" name="employee_id" id="employee_id" required>
                    @foreach($employees as $id => $entry)
                        <option value="{{ $id }}" {{ (old('employee_id') ? old('employee_id') : $employeeSectionHistory->employee->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('employee'))
                    <div class="invalid-feedback">
                        {{ $errors->first('employee') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employeeSectionHistory.fields.employee_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="date_from">{{ trans('cruds.employeeSectionHistory.fields.date_from') }}</label>
                <input class="form-control date {{ $errors->has('date_from') ? 'is-invalid' : '' }}" type="text" name="date_from" id="date_from" value="{{ old('date_from', $employeeSectionHistory->date_from) }}" required>
                @if($errors->has('date_from'))
                    <div class="invalid-feedback">
                        {{ $errors->first('date_from') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employeeSectionHistory.fields.date_from_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="date_to">{{ trans('cruds.employeeSectionHistory.fields.date_to') }}</label>
                <input class="form-control date {{ $errors->has('date_to') ? 'is-invalid' : '' }}" type="text" name="date_to" id="date_to" value="{{ old('date_to', $employeeSectionHistory->date_to) }}">
                @if($errors->has('date_to'))
                    <div class="invalid-feedback">
                        {{ $errors->first('date_to') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employeeSectionHistory.fields.date_to_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="section_seat_id">{{ trans('cruds.employeeSectionHistory.fields.section_seat') }}</label>
                <select class="form-control select2 {{ $errors->has('section_seat') ? 'is-invalid' : '' }}" name="section_seat_id" id="section_seat_id" required>
                    @foreach($section_seats as $id => $entry)
                        <option value="{{ $id }}" {{ (old('section_seat_id') ? old('section_seat_id') : $employeeSectionHistory->section_seat->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('section_seat'))
                    <div class="invalid-feedback">
                        {{ $errors->first('section_seat') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employeeSectionHistory.fields.section_seat_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="remarks">{{ trans('cruds.employeeSectionHistory.fields.remarks') }}</label>
                <input class="form-control {{ $errors->has('remarks') ? 'is-invalid' : '' }}" type="text" name="remarks" id="remarks" value="{{ old('remarks', $employeeSectionHistory->remarks) }}">
                @if($errors->has('remarks'))
                    <div class="invalid-feedback">
                        {{ $errors->first('remarks') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.employeeSectionHistory.fields.remarks_helper') }}</span>
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