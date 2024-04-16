@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.govtCalendar.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.govt-calendars.update", [$govtCalendar->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="date">{{ trans('cruds.govtCalendar.fields.date') }}</label>
                <input class="form-control date {{ $errors->has('date') ? 'is-invalid' : '' }}" type="text" name="date" id="date" value="{{ old('date', $govtCalendar->date) }}">
                @if($errors->has('date'))
                    <span class="text-danger">{{ $errors->first('date') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.govtCalendar.fields.date_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="govtholidaystatus">{{ trans('cruds.govtCalendar.fields.govtholidaystatus') }}</label>
                <input class="form-control {{ $errors->has('govtholidaystatus') ? 'is-invalid' : '' }}" type="number" name="govtholidaystatus" id="govtholidaystatus" value="{{ old('govtholidaystatus', $govtCalendar->govtholidaystatus) }}" step="1">
                @if($errors->has('govtholidaystatus'))
                    <span class="text-danger">{{ $errors->first('govtholidaystatus') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.govtCalendar.fields.govtholidaystatus_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="restrictedholidaystatus">{{ trans('cruds.govtCalendar.fields.restrictedholidaystatus') }}</label>
                <input class="form-control {{ $errors->has('restrictedholidaystatus') ? 'is-invalid' : '' }}" type="number" name="restrictedholidaystatus" id="restrictedholidaystatus" value="{{ old('restrictedholidaystatus', $govtCalendar->restrictedholidaystatus) }}" step="1">
                @if($errors->has('restrictedholidaystatus'))
                    <span class="text-danger">{{ $errors->first('restrictedholidaystatus') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.govtCalendar.fields.restrictedholidaystatus_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="festivallist">{{ trans('cruds.govtCalendar.fields.festivallist') }}</label>
                <textarea class="form-control {{ $errors->has('festivallist') ? 'is-invalid' : '' }}" name="festivallist" id="festivallist">{{ old('festivallist', $govtCalendar->festivallist) }}</textarea>
                @if($errors->has('festivallist'))
                    <span class="text-danger">{{ $errors->first('festivallist') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.govtCalendar.fields.festivallist_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="success_attendance_lastfetchtime">{{ trans('cruds.govtCalendar.fields.success_attendance_lastfetchtime') }}</label>
                <input class="form-control datetime {{ $errors->has('success_attendance_lastfetchtime') ? 'is-invalid' : '' }}" type="text" name="success_attendance_lastfetchtime" id="success_attendance_lastfetchtime" value="{{ old('success_attendance_lastfetchtime', $govtCalendar->success_attendance_lastfetchtime) }}">
                @if($errors->has('success_attendance_lastfetchtime'))
                    <span class="text-danger">{{ $errors->first('success_attendance_lastfetchtime') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.govtCalendar.fields.success_attendance_lastfetchtime_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="success_attendance_rows_fetched">{{ trans('cruds.govtCalendar.fields.success_attendance_rows_fetched') }}</label>
                <input class="form-control {{ $errors->has('success_attendance_rows_fetched') ? 'is-invalid' : '' }}" type="number" name="success_attendance_rows_fetched" id="success_attendance_rows_fetched" value="{{ old('success_attendance_rows_fetched', $govtCalendar->success_attendance_rows_fetched) }}" step="1">
                @if($errors->has('success_attendance_rows_fetched'))
                    <span class="text-danger">{{ $errors->first('success_attendance_rows_fetched') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.govtCalendar.fields.success_attendance_rows_fetched_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="attendancetodaytrace_lastfetchtime">{{ trans('cruds.govtCalendar.fields.attendancetodaytrace_lastfetchtime') }}</label>
                <input class="form-control datetime {{ $errors->has('attendancetodaytrace_lastfetchtime') ? 'is-invalid' : '' }}" type="text" name="attendancetodaytrace_lastfetchtime" id="attendancetodaytrace_lastfetchtime" value="{{ old('attendancetodaytrace_lastfetchtime', $govtCalendar->attendancetodaytrace_lastfetchtime) }}">
                @if($errors->has('attendancetodaytrace_lastfetchtime'))
                    <span class="text-danger">{{ $errors->first('attendancetodaytrace_lastfetchtime') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.govtCalendar.fields.attendancetodaytrace_lastfetchtime_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="attendance_today_trace_rows_fetched">{{ trans('cruds.govtCalendar.fields.attendance_today_trace_rows_fetched') }}</label>
                <input class="form-control {{ $errors->has('attendance_today_trace_rows_fetched') ? 'is-invalid' : '' }}" type="number" name="attendance_today_trace_rows_fetched" id="attendance_today_trace_rows_fetched" value="{{ old('attendance_today_trace_rows_fetched', $govtCalendar->attendance_today_trace_rows_fetched) }}" step="1">
                @if($errors->has('attendance_today_trace_rows_fetched'))
                    <span class="text-danger">{{ $errors->first('attendance_today_trace_rows_fetched') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.govtCalendar.fields.attendance_today_trace_rows_fetched_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('is_sitting_day') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="is_sitting_day" value="0">
                    <input class="form-check-input" type="checkbox" name="is_sitting_day" id="is_sitting_day" value="1" {{ $govtCalendar->is_sitting_day || old('is_sitting_day', 0) === 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_sitting_day">{{ trans('cruds.govtCalendar.fields.is_sitting_day') }}</label>
                </div>
                @if($errors->has('is_sitting_day'))
                    <span class="text-danger">{{ $errors->first('is_sitting_day') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.govtCalendar.fields.is_sitting_day_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="punching">{{ trans('cruds.govtCalendar.fields.punching') }}</label>
                <input class="form-control {{ $errors->has('punching') ? 'is-invalid' : '' }}" type="number" name="punching" id="punching" value="{{ old('punching', $govtCalendar->punching) }}" step="1">
                @if($errors->has('punching'))
                    <span class="text-danger">{{ $errors->first('punching') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.govtCalendar.fields.punching_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="session_id">{{ trans('cruds.govtCalendar.fields.session') }}</label>
                <select class="form-control select2 {{ $errors->has('session') ? 'is-invalid' : '' }}" name="session_id" id="session_id">
                    @foreach($sessions as $id => $entry)
                        <option value="{{ $id }}" {{ (old('session_id') ? old('session_id') : $govtCalendar->session->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('session'))
                    <span class="text-danger">{{ $errors->first('session') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.govtCalendar.fields.session_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.govtCalendar.fields.office_ends_at') }}</label>
                <select class="form-control {{ $errors->has('office_ends_at') ? 'is-invalid' : '' }}" name="office_ends_at" id="office_ends_at">
                    <option value disabled {{ old('office_ends_at', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\GovtCalendar::OFFICE_ENDS_AT_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('office_ends_at', $govtCalendar->office_ends_at) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('office_ends_at'))
                    <span class="text-danger">{{ $errors->first('office_ends_at') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.govtCalendar.fields.office_ends_at_helper') }}</span>
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