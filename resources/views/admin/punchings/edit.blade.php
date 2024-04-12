@extends('layouts.admin')
@section('content')

<div class="card_">
    <div class="card-header_">
        {{ trans('global.edit') }} {{ trans('cruds.punching.title_singular') }}
    </div>

    <div class="card-body_">
        <form method="POST" action="{{ route("admin.punchings.update", [$punching->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="date">{{ trans('cruds.punching.fields.date') }}</label>
                <input class="form-control date {{ $errors->has('date') ? 'is-invalid' : '' }}" type="text" name="date" id="date" value="{{ old('date', $punching->date) }}" required>
                @if($errors->has('date'))
                    <span class="text-danger">{{ $errors->first('date') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.punching.fields.date_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="employee_id">{{ trans('cruds.punching.fields.employee') }}</label>
                <select class="form-control select2 {{ $errors->has('employee') ? 'is-invalid' : '' }}" name="employee_id" id="employee_id" required>
                    @foreach($employees as $id => $entry)
                        <option value="{{ $id }}" {{ (old('employee_id') ? old('employee_id') : $punching->employee->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('employee'))
                    <span class="text-danger">{{ $errors->first('employee') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.punching.fields.employee_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="duration">{{ trans('cruds.punching.fields.duration') }}</label>
                <input class="form-control {{ $errors->has('duration') ? 'is-invalid' : '' }}" type="text" name="duration" id="duration" value="{{ old('duration', $punching->duration) }}">
                @if($errors->has('duration'))
                    <span class="text-danger">{{ $errors->first('duration') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.punching.fields.duration_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.punching.fields.flexi') }}</label>
                <select class="form-control {{ $errors->has('flexi') ? 'is-invalid' : '' }}" name="flexi" id="flexi">
                    <option value disabled {{ old('flexi', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Punching::FLEXI_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('flexi', $punching->flexi) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('flexi'))
                    <span class="text-danger">{{ $errors->first('flexi') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.punching.fields.flexi_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="grace">{{ trans('cruds.punching.fields.grace') }}</label>
                <input class="form-control {{ $errors->has('grace') ? 'is-invalid' : '' }}" type="number" name="grace" id="grace" value="{{ old('grace', $punching->grace) }}" step="1">
                @if($errors->has('grace'))
                    <span class="text-danger">{{ $errors->first('grace') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.punching.fields.grace_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="extra">{{ trans('cruds.punching.fields.extra') }}</label>
                <input class="form-control {{ $errors->has('extra') ? 'is-invalid' : '' }}" type="number" name="extra" id="extra" value="{{ old('extra', $punching->extra) }}" step="1">
                @if($errors->has('extra'))
                    <span class="text-danger">{{ $errors->first('extra') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.punching.fields.extra_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="remarks">{{ trans('cruds.punching.fields.remarks') }}</label>
                <input class="form-control {{ $errors->has('remarks') ? 'is-invalid' : '' }}" type="text" name="remarks" id="remarks" value="{{ old('remarks', $punching->remarks) }}">
                @if($errors->has('remarks'))
                    <span class="text-danger">{{ $errors->first('remarks') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.punching.fields.remarks_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="calc_complete">{{ trans('cruds.punching.fields.calc_complete') }}</label>
                <input class="form-control {{ $errors->has('calc_complete') ? 'is-invalid' : '' }}" type="number" name="calc_complete" id="calc_complete" value="{{ old('calc_complete', $punching->calc_complete) }}" step="1">
                @if($errors->has('calc_complete'))
                    <span class="text-danger">{{ $errors->first('calc_complete') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.punching.fields.calc_complete_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="punchin_trace_id">{{ trans('cruds.punching.fields.punchin_trace') }}</label>
                <select class="form-control select2 {{ $errors->has('punchin_trace') ? 'is-invalid' : '' }}" name="punchin_trace_id" id="punchin_trace_id">
                    @foreach($punchin_traces as $id => $entry)
                        <option value="{{ $id }}" {{ (old('punchin_trace_id') ? old('punchin_trace_id') : $punching->punchin_trace->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
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
                        <option value="{{ $id }}" {{ (old('punchout_trace_id') ? old('punchout_trace_id') : $punching->punchout_trace->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('punchout_trace'))
                    <span class="text-danger">{{ $errors->first('punchout_trace') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.punching.fields.punchout_trace_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="ot_claimed_mins">{{ trans('cruds.punching.fields.ot_claimed_mins') }}</label>
                <input class="form-control {{ $errors->has('ot_claimed_mins') ? 'is-invalid' : '' }}" type="number" name="ot_claimed_mins" id="ot_claimed_mins" value="{{ old('ot_claimed_mins', $punching->ot_claimed_mins) }}" step="1">
                @if($errors->has('ot_claimed_mins'))
                    <span class="text-danger">{{ $errors->first('ot_claimed_mins') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.punching.fields.ot_claimed_mins_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="ot_extra_mins">{{ trans('cruds.punching.fields.ot_extra_mins') }}</label>
                <input class="form-control {{ $errors->has('ot_extra_mins') ? 'is-invalid' : '' }}" type="number" name="ot_extra_mins" id="ot_extra_mins" value="{{ old('ot_extra_mins', $punching->ot_extra_mins) }}" step="1">
                @if($errors->has('ot_extra_mins'))
                    <span class="text-danger">{{ $errors->first('ot_extra_mins') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.punching.fields.ot_extra_mins_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="punching_status">{{ trans('cruds.punching.fields.punching_status') }}</label>
                <input class="form-control {{ $errors->has('punching_status') ? 'is-invalid' : '' }}" type="number" name="punching_status" id="punching_status" value="{{ old('punching_status', $punching->punching_status) }}" step="1">
                @if($errors->has('punching_status'))
                    <span class="text-danger">{{ $errors->first('punching_status') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.punching.fields.punching_status_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="leave_id">{{ trans('cruds.punching.fields.leave') }}</label>
                <select class="form-control select2 {{ $errors->has('leave') ? 'is-invalid' : '' }}" name="leave_id" id="leave_id">
                    @foreach($leaves as $id => $entry)
                        <option value="{{ $id }}" {{ (old('leave_id') ? old('leave_id') : $punching->leave->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('leave'))
                    <span class="text-danger">{{ $errors->first('leave') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.punching.fields.leave_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="designation_id">{{ trans('cruds.punching.fields.designation') }}</label>
                <select class="form-control select2 {{ $errors->has('designation') ? 'is-invalid' : '' }}" name="designation_id" id="designation_id" required>
                    @foreach($designations as $id => $entry)
                        <option value="{{ $id }}" {{ (old('designation_id') ? old('designation_id') : $punching->designation->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('designation'))
                    <span class="text-danger">{{ $errors->first('designation') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.punching.fields.designation_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="section_id">{{ trans('cruds.punching.fields.section') }}</label>
                <select class="form-control select2 {{ $errors->has('section') ? 'is-invalid' : '' }}" name="section_id" id="section_id" required>
                    @foreach($sections as $id => $entry)
                        <option value="{{ $id }}" {{ (old('section_id') ? old('section_id') : $punching->section->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('section'))
                    <span class="text-danger">{{ $errors->first('section') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.punching.fields.section_helper') }}</span>
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
