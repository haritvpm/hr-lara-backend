@extends('layouts.admin')
@section('content')

<div class="card_">
    <div class="card-header_">
        {{ trans('global.edit') }} {{ trans('cruds.section.title_singular') }}
    </div>

    <div class="card-body_">
        <form method="POST" action="{{ route("admin.sections.update", [$section->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.section.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $section->name) }}" required>
                @if($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.section.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="short_code">{{ trans('cruds.section.fields.short_code') }}</label>
                <input class="form-control {{ $errors->has('short_code') ? 'is-invalid' : '' }}" type="text" name="short_code" id="short_code" value="{{ old('short_code', $section->short_code) }}">
                @if($errors->has('short_code'))
                    <span class="text-danger">{{ $errors->first('short_code') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.section.fields.short_code_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="seat_of_controlling_officer_id">{{ trans('cruds.section.fields.seat_of_controlling_officer') }}</label>
                <select class="form-control select2 {{ $errors->has('seat_of_controlling_officer') ? 'is-invalid' : '' }}" name="seat_of_controlling_officer_id" id="seat_of_controlling_officer_id" required>
                    @foreach($seat_of_controlling_officers as $id => $entry)
                        <option value="{{ $id }}" {{ (old('seat_of_controlling_officer_id') ? old('seat_of_controlling_officer_id') : $section->seat_of_controlling_officer->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('seat_of_controlling_officer'))
                    <span class="text-danger">{{ $errors->first('seat_of_controlling_officer') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.section.fields.seat_of_controlling_officer_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="office_location_id">{{ trans('cruds.section.fields.office_location') }}</label>
                <select class="form-control select2 {{ $errors->has('office_location') ? 'is-invalid' : '' }}" name="office_location_id" id="office_location_id" required>
                    @foreach($office_locations as $id => $entry)
                        <option value="{{ $id }}" {{ (old('office_location_id') ? old('office_location_id') : $section->office_location->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('office_location'))
                    <span class="text-danger">{{ $errors->first('office_location') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.section.fields.office_location_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="seat_of_reporting_officer_id">{{ trans('cruds.section.fields.seat_of_reporting_officer') }}</label>
                <select class="form-control select2 {{ $errors->has('seat_of_reporting_officer') ? 'is-invalid' : '' }}" name="seat_of_reporting_officer_id" id="seat_of_reporting_officer_id">
                    @foreach($seat_of_reporting_officers as $id => $entry)
                        <option value="{{ $id }}" {{ (old('seat_of_reporting_officer_id') ? old('seat_of_reporting_officer_id') : $section->seat_of_reporting_officer->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('seat_of_reporting_officer'))
                    <span class="text-danger">{{ $errors->first('seat_of_reporting_officer') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.section.fields.seat_of_reporting_officer_helper') }}</span>
            </div>
            <!-- <div class="form-group">
                <label for="js_as_ss_employee_id">{{ trans('cruds.section.fields.js_as_ss_employee') }}</label>
                <select class="form-control select2 {{ $errors->has('js_as_ss_employee') ? 'is-invalid' : '' }}" name="js_as_ss_employee_id" id="js_as_ss_employee_id">
                    @foreach($js_as_ss_employees as $id => $entry)
                        <option value="{{ $id }}" {{ (old('js_as_ss_employee_id') ? old('js_as_ss_employee_id') : $section->js_as_ss_employee->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('js_as_ss_employee'))
                    <span class="text-danger">{{ $errors->first('js_as_ss_employee') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.section.fields.js_as_ss_employee_helper') }}</span>
            </div> -->
            <div class="form-group">
                <label>{{ trans('cruds.section.fields.type') }}</label>
                <select class="form-control {{ $errors->has('type') ? 'is-invalid' : '' }}" name="type" id="type">
                    <option value disabled {{ old('type', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Section::TYPE_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('type', $section->type) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('type'))
                    <span class="text-danger">{{ $errors->first('type') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.section.fields.type_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('works_nights_during_session') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="works_nights_during_session" value="0">
                    <input class="form-check-input" type="checkbox" name="works_nights_during_session" id="works_nights_during_session" value="1" {{ $section->works_nights_during_session || old('works_nights_during_session', 0) === 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="works_nights_during_session">{{ trans('cruds.section.fields.works_nights_during_session') }}</label>
                </div>
                @if($errors->has('works_nights_during_session'))
                    <span class="text-danger">{{ $errors->first('works_nights_during_session') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.section.fields.works_nights_during_session_helper') }}</span>
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
