@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.punching.title_singular') }}
    </div>

    <div class="card-body">
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
                <label class="required" for="designation">{{ trans('cruds.punching.fields.designation') }}</label>
                <input class="form-control {{ $errors->has('designation') ? 'is-invalid' : '' }}" type="text" name="designation" id="designation" value="{{ old('designation', $punching->designation) }}" required>
                @if($errors->has('designation'))
                    <span class="text-danger">{{ $errors->first('designation') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.punching.fields.designation_helper') }}</span>
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
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection