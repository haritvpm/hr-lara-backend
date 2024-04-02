@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.exemption.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.exemptions.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="employee_id">{{ trans('cruds.exemption.fields.employee') }}</label>
                <select class="form-control select2 {{ $errors->has('employee') ? 'is-invalid' : '' }}" name="employee_id" id="employee_id">
                    @foreach($employees as $id => $entry)
                        <option value="{{ $id }}" {{ old('employee_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('employee'))
                    <div class="invalid-feedback">
                        {{ $errors->first('employee') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.exemption.fields.employee_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="date_from">{{ trans('cruds.exemption.fields.date_from') }}</label>
                <input class="form-control date {{ $errors->has('date_from') ? 'is-invalid' : '' }}" type="text" name="date_from" id="date_from" value="{{ old('date_from') }}">
                @if($errors->has('date_from'))
                    <div class="invalid-feedback">
                        {{ $errors->first('date_from') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.exemption.fields.date_from_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="date_to">{{ trans('cruds.exemption.fields.date_to') }}</label>
                <input class="form-control date {{ $errors->has('date_to') ? 'is-invalid' : '' }}" type="text" name="date_to" id="date_to" value="{{ old('date_to') }}">
                @if($errors->has('date_to'))
                    <div class="invalid-feedback">
                        {{ $errors->first('date_to') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.exemption.fields.date_to_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="session_id">{{ trans('cruds.exemption.fields.session') }}</label>
                <select class="form-control select2 {{ $errors->has('session') ? 'is-invalid' : '' }}" name="session_id" id="session_id">
                    @foreach($sessions as $id => $entry)
                        <option value="{{ $id }}" {{ old('session_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('session'))
                    <div class="invalid-feedback">
                        {{ $errors->first('session') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.exemption.fields.session_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="forwarded_by">{{ trans('cruds.exemption.fields.forwarded_by') }}</label>
                <input class="form-control {{ $errors->has('forwarded_by') ? 'is-invalid' : '' }}" type="text" name="forwarded_by" id="forwarded_by" value="{{ old('forwarded_by', '') }}">
                @if($errors->has('forwarded_by'))
                    <div class="invalid-feedback">
                        {{ $errors->first('forwarded_by') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.exemption.fields.forwarded_by_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('submitted_to_services') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="submitted_to_services" value="0">
                    <input class="form-check-input" type="checkbox" name="submitted_to_services" id="submitted_to_services" value="1" {{ old('submitted_to_services', 0) == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="submitted_to_services">{{ trans('cruds.exemption.fields.submitted_to_services') }}</label>
                </div>
                @if($errors->has('submitted_to_services'))
                    <div class="invalid-feedback">
                        {{ $errors->first('submitted_to_services') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.exemption.fields.submitted_to_services_helper') }}</span>
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