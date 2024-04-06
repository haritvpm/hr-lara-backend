@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.otFormOther.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.ot-form-others.update", [$otFormOther->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="creator">{{ trans('cruds.otFormOther.fields.creator') }}</label>
                <input class="form-control {{ $errors->has('creator') ? 'is-invalid' : '' }}" type="text" name="creator" id="creator" value="{{ old('creator', $otFormOther->creator) }}" required>
                @if($errors->has('creator'))
                    <span class="text-danger">{{ $errors->first('creator') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.otFormOther.fields.creator_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="owner">{{ trans('cruds.otFormOther.fields.owner') }}</label>
                <input class="form-control {{ $errors->has('owner') ? 'is-invalid' : '' }}" type="text" name="owner" id="owner" value="{{ old('owner', $otFormOther->owner) }}" required>
                @if($errors->has('owner'))
                    <span class="text-danger">{{ $errors->first('owner') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.otFormOther.fields.owner_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="session_id">{{ trans('cruds.otFormOther.fields.session') }}</label>
                <select class="form-control select2 {{ $errors->has('session') ? 'is-invalid' : '' }}" name="session_id" id="session_id">
                    @foreach($sessions as $id => $entry)
                        <option value="{{ $id }}" {{ (old('session_id') ? old('session_id') : $otFormOther->session->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('session'))
                    <span class="text-danger">{{ $errors->first('session') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.otFormOther.fields.session_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="submitted_by">{{ trans('cruds.otFormOther.fields.submitted_by') }}</label>
                <input class="form-control {{ $errors->has('submitted_by') ? 'is-invalid' : '' }}" type="text" name="submitted_by" id="submitted_by" value="{{ old('submitted_by', $otFormOther->submitted_by) }}">
                @if($errors->has('submitted_by'))
                    <span class="text-danger">{{ $errors->first('submitted_by') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.otFormOther.fields.submitted_by_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="submitted_on">{{ trans('cruds.otFormOther.fields.submitted_on') }}</label>
                <input class="form-control date {{ $errors->has('submitted_on') ? 'is-invalid' : '' }}" type="text" name="submitted_on" id="submitted_on" value="{{ old('submitted_on', $otFormOther->submitted_on) }}">
                @if($errors->has('submitted_on'))
                    <span class="text-danger">{{ $errors->first('submitted_on') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.otFormOther.fields.submitted_on_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="form_no">{{ trans('cruds.otFormOther.fields.form_no') }}</label>
                <input class="form-control {{ $errors->has('form_no') ? 'is-invalid' : '' }}" type="number" name="form_no" id="form_no" value="{{ old('form_no', $otFormOther->form_no) }}" step="1">
                @if($errors->has('form_no'))
                    <span class="text-danger">{{ $errors->first('form_no') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.otFormOther.fields.form_no_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="duty_date">{{ trans('cruds.otFormOther.fields.duty_date') }}</label>
                <input class="form-control date {{ $errors->has('duty_date') ? 'is-invalid' : '' }}" type="text" name="duty_date" id="duty_date" value="{{ old('duty_date', $otFormOther->duty_date) }}">
                @if($errors->has('duty_date'))
                    <span class="text-danger">{{ $errors->first('duty_date') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.otFormOther.fields.duty_date_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="date_from">{{ trans('cruds.otFormOther.fields.date_from') }}</label>
                <input class="form-control date {{ $errors->has('date_from') ? 'is-invalid' : '' }}" type="text" name="date_from" id="date_from" value="{{ old('date_from', $otFormOther->date_from) }}">
                @if($errors->has('date_from'))
                    <span class="text-danger">{{ $errors->first('date_from') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.otFormOther.fields.date_from_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="date_to">{{ trans('cruds.otFormOther.fields.date_to') }}</label>
                <input class="form-control date {{ $errors->has('date_to') ? 'is-invalid' : '' }}" type="text" name="date_to" id="date_to" value="{{ old('date_to', $otFormOther->date_to) }}">
                @if($errors->has('date_to'))
                    <span class="text-danger">{{ $errors->first('date_to') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.otFormOther.fields.date_to_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="remarks">{{ trans('cruds.otFormOther.fields.remarks') }}</label>
                <input class="form-control {{ $errors->has('remarks') ? 'is-invalid' : '' }}" type="text" name="remarks" id="remarks" value="{{ old('remarks', $otFormOther->remarks) }}">
                @if($errors->has('remarks'))
                    <span class="text-danger">{{ $errors->first('remarks') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.otFormOther.fields.remarks_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.otFormOther.fields.overtime_slot') }}</label>
                <select class="form-control {{ $errors->has('overtime_slot') ? 'is-invalid' : '' }}" name="overtime_slot" id="overtime_slot">
                    <option value disabled {{ old('overtime_slot', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\OtFormOther::OVERTIME_SLOT_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('overtime_slot', $otFormOther->overtime_slot) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('overtime_slot'))
                    <span class="text-danger">{{ $errors->first('overtime_slot') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.otFormOther.fields.overtime_slot_helper') }}</span>
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