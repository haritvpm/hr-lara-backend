@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.punchingRegister.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.punching-registers.update", [$punchingRegister->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="date">{{ trans('cruds.punchingRegister.fields.date') }}</label>
                <input class="form-control date {{ $errors->has('date') ? 'is-invalid' : '' }}" type="text" name="date" id="date" value="{{ old('date', $punchingRegister->date) }}" required>
                @if($errors->has('date'))
                    <div class="invalid-feedback">
                        {{ $errors->first('date') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.punchingRegister.fields.date_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="employee_id">{{ trans('cruds.punchingRegister.fields.employee') }}</label>
                <select class="form-control select2 {{ $errors->has('employee') ? 'is-invalid' : '' }}" name="employee_id" id="employee_id" required>
                    @foreach($employees as $id => $entry)
                        <option value="{{ $id }}" {{ (old('employee_id') ? old('employee_id') : $punchingRegister->employee->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('employee'))
                    <div class="invalid-feedback">
                        {{ $errors->first('employee') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.punchingRegister.fields.employee_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="duration">{{ trans('cruds.punchingRegister.fields.duration') }}</label>
                <input class="form-control {{ $errors->has('duration') ? 'is-invalid' : '' }}" type="text" name="duration" id="duration" value="{{ old('duration', $punchingRegister->duration) }}">
                @if($errors->has('duration'))
                    <div class="invalid-feedback">
                        {{ $errors->first('duration') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.punchingRegister.fields.duration_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.punchingRegister.fields.flexi') }}</label>
                <select class="form-control {{ $errors->has('flexi') ? 'is-invalid' : '' }}" name="flexi" id="flexi">
                    <option value disabled {{ old('flexi', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\PunchingRegister::FLEXI_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('flexi', $punchingRegister->flexi) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('flexi'))
                    <div class="invalid-feedback">
                        {{ $errors->first('flexi') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.punchingRegister.fields.flexi_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="grace_min">{{ trans('cruds.punchingRegister.fields.grace_min') }}</label>
                <input class="form-control {{ $errors->has('grace_min') ? 'is-invalid' : '' }}" type="text" name="grace_min" id="grace_min" value="{{ old('grace_min', $punchingRegister->grace_min) }}">
                @if($errors->has('grace_min'))
                    <div class="invalid-feedback">
                        {{ $errors->first('grace_min') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.punchingRegister.fields.grace_min_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="extra_min">{{ trans('cruds.punchingRegister.fields.extra_min') }}</label>
                <input class="form-control {{ $errors->has('extra_min') ? 'is-invalid' : '' }}" type="text" name="extra_min" id="extra_min" value="{{ old('extra_min', $punchingRegister->extra_min) }}">
                @if($errors->has('extra_min'))
                    <div class="invalid-feedback">
                        {{ $errors->first('extra_min') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.punchingRegister.fields.extra_min_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="success_punching_id">{{ trans('cruds.punchingRegister.fields.success_punching') }}</label>
                <select class="form-control select2 {{ $errors->has('success_punching') ? 'is-invalid' : '' }}" name="success_punching_id" id="success_punching_id">
                    @foreach($success_punchings as $id => $entry)
                        <option value="{{ $id }}" {{ (old('success_punching_id') ? old('success_punching_id') : $punchingRegister->success_punching->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('success_punching'))
                    <div class="invalid-feedback">
                        {{ $errors->first('success_punching') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.punchingRegister.fields.success_punching_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="punching_traces">{{ trans('cruds.punchingRegister.fields.punching_trace') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('punching_traces') ? 'is-invalid' : '' }}" name="punching_traces[]" id="punching_traces" multiple>
                    @foreach($punching_traces as $id => $punching_trace)
                        <option value="{{ $id }}" {{ (in_array($id, old('punching_traces', [])) || $punchingRegister->punching_traces->contains($id)) ? 'selected' : '' }}>{{ $punching_trace }}</option>
                    @endforeach
                </select>
                @if($errors->has('punching_traces'))
                    <div class="invalid-feedback">
                        {{ $errors->first('punching_traces') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.punchingRegister.fields.punching_trace_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="designation">{{ trans('cruds.punchingRegister.fields.designation') }}</label>
                <input class="form-control {{ $errors->has('designation') ? 'is-invalid' : '' }}" type="text" name="designation" id="designation" value="{{ old('designation', $punchingRegister->designation) }}" required>
                @if($errors->has('designation'))
                    <div class="invalid-feedback">
                        {{ $errors->first('designation') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.punchingRegister.fields.designation_helper') }}</span>
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