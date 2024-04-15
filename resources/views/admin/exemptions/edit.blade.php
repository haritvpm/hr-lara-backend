@extends('layouts.admin')
@section('content')

<div class="card_">
    <div class="card-header_">
        {{ trans('global.edit') }} {{ trans('cruds.exemption.title_singular') }}
    </div>

    <div class="card-body_">
        <form method="POST" action="{{ route("admin.exemptions.update", [$exemption->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="employee_id">{{ trans('cruds.exemption.fields.employee') }}</label>
                <select class="form-control select2 {{ $errors->has('employee') ? 'is-invalid' : '' }}" name="employee_id" id="employee_id">
                    @foreach($employees as $id => $entry)
                        <option value="{{ $id }}" {{ (old('employee_id') ? old('employee_id') : $exemption->employee->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('employee'))
                    <span class="text-danger">{{ $errors->first('employee') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.exemption.fields.employee_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="date_from">{{ trans('cruds.exemption.fields.date_from') }}</label>
                <input class="form-control date {{ $errors->has('date_from') ? 'is-invalid' : '' }}" type="text" name="date_from" id="date_from" value="{{ old('date_from', $exemption->date_from) }}">
                @if($errors->has('date_from'))
                    <span class="text-danger">{{ $errors->first('date_from') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.exemption.fields.date_from_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="date_to">{{ trans('cruds.exemption.fields.date_to') }}</label>
                <input class="form-control date {{ $errors->has('date_to') ? 'is-invalid' : '' }}" type="text" name="date_to" id="date_to" value="{{ old('date_to', $exemption->date_to) }}">
                @if($errors->has('date_to'))
                    <span class="text-danger">{{ $errors->first('date_to') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.exemption.fields.date_to_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="forwarded_by">{{ trans('cruds.exemption.fields.forwarded_by') }}</label>
                <input class="form-control {{ $errors->has('forwarded_by') ? 'is-invalid' : '' }}" type="text" name="forwarded_by" id="forwarded_by" value="{{ old('forwarded_by', $exemption->forwarded_by) }}">
                @if($errors->has('forwarded_by'))
                    <span class="text-danger">{{ $errors->first('forwarded_by') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.exemption.fields.forwarded_by_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('submitted_to_services') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="submitted_to_services" value="0">
                    <input class="form-check-input" type="checkbox" name="submitted_to_services" id="submitted_to_services" value="1" {{ $exemption->submitted_to_services || old('submitted_to_services', 0) === 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="submitted_to_services">{{ trans('cruds.exemption.fields.submitted_to_services') }}</label>
                </div>
                @if($errors->has('submitted_to_services'))
                    <span class="text-danger">{{ $errors->first('submitted_to_services') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.exemption.fields.submitted_to_services_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="session_id">{{ trans('cruds.exemption.fields.session') }}</label>
                <select class="form-control select2 {{ $errors->has('session') ? 'is-invalid' : '' }}" name="session_id" id="session_id">
                    @foreach($sessions as $id => $entry)
                        <option value="{{ $id }}" {{ (old('session_id') ? old('session_id') : $exemption->session->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('session'))
                    <span class="text-danger">{{ $errors->first('session') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.exemption.fields.session_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="approval_status">{{ trans('cruds.exemption.fields.approval_status') }}</label>
                <input class="form-control {{ $errors->has('approval_status') ? 'is-invalid' : '' }}" type="number" name="approval_status" id="approval_status" value="{{ old('approval_status', $exemption->approval_status) }}" step="1">
                @if($errors->has('approval_status'))
                    <span class="text-danger">{{ $errors->first('approval_status') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.exemption.fields.approval_status_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="owner_id">{{ trans('cruds.exemption.fields.owner') }}</label>
                <select class="form-control select2 {{ $errors->has('owner') ? 'is-invalid' : '' }}" name="owner_id" id="owner_id">
                    @foreach($owners as $id => $entry)
                        <option value="{{ $id }}" {{ (old('owner_id') ? old('owner_id') : $exemption->owner->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('owner'))
                    <span class="text-danger">{{ $errors->first('owner') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.exemption.fields.owner_helper') }}</span>
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
