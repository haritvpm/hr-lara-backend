@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.punching.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.punchings.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="date">{{ trans('cruds.punching.fields.date') }}</label>
                <input class="form-control date {{ $errors->has('date') ? 'is-invalid' : '' }}" type="text" name="date" id="date" value="{{ old('date') }}" required>
                @if($errors->has('date'))
                    <span class="text-danger">{{ $errors->first('date') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.punching.fields.date_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="aadhaarid">{{ trans('cruds.punching.fields.aadhaarid') }}</label>
                <input class="form-control {{ $errors->has('aadhaarid') ? 'is-invalid' : '' }}" type="text" name="aadhaarid" id="aadhaarid" value="{{ old('aadhaarid', '') }}" required>
                @if($errors->has('aadhaarid'))
                    <span class="text-danger">{{ $errors->first('aadhaarid') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.punching.fields.aadhaarid_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="employee_id">{{ trans('cruds.punching.fields.employee') }}</label>
                <select class="form-control select2 {{ $errors->has('employee') ? 'is-invalid' : '' }}" name="employee_id" id="employee_id">
                    @foreach($employees as $id => $entry)
                        <option value="{{ $id }}" {{ old('employee_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('employee'))
                    <span class="text-danger">{{ $errors->first('employee') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.punching.fields.employee_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="designation">{{ trans('cruds.punching.fields.designation') }}</label>
                <input class="form-control {{ $errors->has('designation') ? 'is-invalid' : '' }}" type="text" name="designation" id="designation" value="{{ old('designation', '') }}">
                @if($errors->has('designation'))
                    <span class="text-danger">{{ $errors->first('designation') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.punching.fields.designation_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="section">{{ trans('cruds.punching.fields.section') }}</label>
                <input class="form-control {{ $errors->has('section') ? 'is-invalid' : '' }}" type="text" name="section" id="section" value="{{ old('section', '') }}">
                @if($errors->has('section'))
                    <span class="text-danger">{{ $errors->first('section') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.punching.fields.section_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="punchin_trace_id">{{ trans('cruds.punching.fields.punchin_trace') }}</label>
                <select class="form-control select2 {{ $errors->has('punchin_trace') ? 'is-invalid' : '' }}" name="punchin_trace_id" id="punchin_trace_id">
                    @foreach($punchin_traces as $id => $entry)
                        <option value="{{ $id }}" {{ old('punchin_trace_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('punchin_trace'))
                    <span class="text-danger">{{ $errors->first('punchin_trace') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.punching.fields.punchin_trace_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="punchout_trace_id">{{ trans('cruds.punching.fields.punchout_trace') }}</label>
                <select class="form-control select2 {{ $errors->has('punchout_trace') ? 'is-invalid' : '' }}" name="punchout_trace_id" id="punchout_trace_id">
                    @foreach($punchout_traces as $id => $entry)
                        <option value="{{ $id }}" {{ old('punchout_trace_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('punchout_trace'))
                    <span class="text-danger">{{ $errors->first('punchout_trace') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.punching.fields.punchout_trace_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="in_datetime">{{ trans('cruds.punching.fields.in_datetime') }}</label>
                <input class="form-control datetime {{ $errors->has('in_datetime') ? 'is-invalid' : '' }}" type="text" name="in_datetime" id="in_datetime" value="{{ old('in_datetime') }}">
                @if($errors->has('in_datetime'))
                    <span class="text-danger">{{ $errors->first('in_datetime') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.punching.fields.in_datetime_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="out_datetime">{{ trans('cruds.punching.fields.out_datetime') }}</label>
                <input class="form-control datetime {{ $errors->has('out_datetime') ? 'is-invalid' : '' }}" type="text" name="out_datetime" id="out_datetime" value="{{ old('out_datetime') }}">
                @if($errors->has('out_datetime'))
                    <span class="text-danger">{{ $errors->first('out_datetime') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.punching.fields.out_datetime_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="duration_sec">{{ trans('cruds.punching.fields.duration_sec') }}</label>
                <input class="form-control {{ $errors->has('duration_sec') ? 'is-invalid' : '' }}" type="number" name="duration_sec" id="duration_sec" value="{{ old('duration_sec', '') }}" step="1">
                @if($errors->has('duration_sec'))
                    <span class="text-danger">{{ $errors->first('duration_sec') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.punching.fields.duration_sec_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="grace_sec">{{ trans('cruds.punching.fields.grace_sec') }}</label>
                <input class="form-control {{ $errors->has('grace_sec') ? 'is-invalid' : '' }}" type="number" name="grace_sec" id="grace_sec" value="{{ old('grace_sec', '') }}" step="1">
                @if($errors->has('grace_sec'))
                    <span class="text-danger">{{ $errors->first('grace_sec') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.punching.fields.grace_sec_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="extra_sec">{{ trans('cruds.punching.fields.extra_sec') }}</label>
                <input class="form-control {{ $errors->has('extra_sec') ? 'is-invalid' : '' }}" type="number" name="extra_sec" id="extra_sec" value="{{ old('extra_sec', '') }}" step="1">
                @if($errors->has('extra_sec'))
                    <span class="text-danger">{{ $errors->first('extra_sec') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.punching.fields.extra_sec_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="duration_str">{{ trans('cruds.punching.fields.duration_str') }}</label>
                <input class="form-control {{ $errors->has('duration_str') ? 'is-invalid' : '' }}" type="text" name="duration_str" id="duration_str" value="{{ old('duration_str', '') }}">
                @if($errors->has('duration_str'))
                    <span class="text-danger">{{ $errors->first('duration_str') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.punching.fields.duration_str_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="grace_str">{{ trans('cruds.punching.fields.grace_str') }}</label>
                <input class="form-control {{ $errors->has('grace_str') ? 'is-invalid' : '' }}" type="text" name="grace_str" id="grace_str" value="{{ old('grace_str', '') }}">
                @if($errors->has('grace_str'))
                    <span class="text-danger">{{ $errors->first('grace_str') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.punching.fields.grace_str_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="extra_str">{{ trans('cruds.punching.fields.extra_str') }}</label>
                <input class="form-control {{ $errors->has('extra_str') ? 'is-invalid' : '' }}" type="text" name="extra_str" id="extra_str" value="{{ old('extra_str', '') }}">
                @if($errors->has('extra_str'))
                    <span class="text-danger">{{ $errors->first('extra_str') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.punching.fields.extra_str_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="punching_count">{{ trans('cruds.punching.fields.punching_count') }}</label>
                <input class="form-control {{ $errors->has('punching_count') ? 'is-invalid' : '' }}" type="number" name="punching_count" id="punching_count" value="{{ old('punching_count', '') }}" step="1">
                @if($errors->has('punching_count'))
                    <span class="text-danger">{{ $errors->first('punching_count') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.punching.fields.punching_count_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="leave_id">{{ trans('cruds.punching.fields.leave') }}</label>
                <select class="form-control select2 {{ $errors->has('leave') ? 'is-invalid' : '' }}" name="leave_id" id="leave_id">
                    @foreach($leaves as $id => $entry)
                        <option value="{{ $id }}" {{ old('leave_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('leave'))
                    <span class="text-danger">{{ $errors->first('leave') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.punching.fields.leave_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="remarks">{{ trans('cruds.punching.fields.remarks') }}</label>
                <input class="form-control {{ $errors->has('remarks') ? 'is-invalid' : '' }}" type="text" name="remarks" id="remarks" value="{{ old('remarks', '') }}">
                @if($errors->has('remarks'))
                    <span class="text-danger">{{ $errors->first('remarks') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.punching.fields.remarks_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="finalized_by_controller">{{ trans('cruds.punching.fields.finalized_by_controller') }}</label>
                <input class="form-control {{ $errors->has('finalized_by_controller') ? 'is-invalid' : '' }}" type="number" name="finalized_by_controller" id="finalized_by_controller" value="{{ old('finalized_by_controller', '0') }}" step="1">
                @if($errors->has('finalized_by_controller'))
                    <span class="text-danger">{{ $errors->first('finalized_by_controller') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.punching.fields.finalized_by_controller_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="ot_sitting_sec">{{ trans('cruds.punching.fields.ot_sitting_sec') }}</label>
                <input class="form-control {{ $errors->has('ot_sitting_sec') ? 'is-invalid' : '' }}" type="number" name="ot_sitting_sec" id="ot_sitting_sec" value="{{ old('ot_sitting_sec', '') }}" step="1">
                @if($errors->has('ot_sitting_sec'))
                    <span class="text-danger">{{ $errors->first('ot_sitting_sec') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.punching.fields.ot_sitting_sec_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="ot_nonsitting_sec">{{ trans('cruds.punching.fields.ot_nonsitting_sec') }}</label>
                <input class="form-control {{ $errors->has('ot_nonsitting_sec') ? 'is-invalid' : '' }}" type="number" name="ot_nonsitting_sec" id="ot_nonsitting_sec" value="{{ old('ot_nonsitting_sec', '') }}" step="1">
                @if($errors->has('ot_nonsitting_sec'))
                    <span class="text-danger">{{ $errors->first('ot_nonsitting_sec') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.punching.fields.ot_nonsitting_sec_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.punching.fields.hint') }}</label>
                <select class="form-control {{ $errors->has('hint') ? 'is-invalid' : '' }}" name="hint" id="hint">
                    <option value disabled {{ old('hint', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Punching::HINT_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('hint', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('hint'))
                    <span class="text-danger">{{ $errors->first('hint') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.punching.fields.hint_helper') }}</span>
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