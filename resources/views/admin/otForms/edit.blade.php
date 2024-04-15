@extends('layouts.admin')
@section('content')

<div class="card_">
    <div class="card-header_">
        {{ trans('global.edit') }} {{ trans('cruds.otForm.title_singular') }}
    </div>

    <div class="card-body_">
        <form method="POST" action="{{ route("admin.ot-forms.update", [$otForm->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="creator">{{ trans('cruds.otForm.fields.creator') }}</label>
                <input class="form-control {{ $errors->has('creator') ? 'is-invalid' : '' }}" type="text" name="creator" id="creator" value="{{ old('creator', $otForm->creator) }}" required>
                @if($errors->has('creator'))
                    <span class="text-danger">{{ $errors->first('creator') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.otForm.fields.creator_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="owner">{{ trans('cruds.otForm.fields.owner') }}</label>
                <input class="form-control {{ $errors->has('owner') ? 'is-invalid' : '' }}" type="text" name="owner" id="owner" value="{{ old('owner', $otForm->owner) }}" required>
                @if($errors->has('owner'))
                    <span class="text-danger">{{ $errors->first('owner') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.otForm.fields.owner_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="session_id">{{ trans('cruds.otForm.fields.session') }}</label>
                <select class="form-control select2 {{ $errors->has('session') ? 'is-invalid' : '' }}" name="session_id" id="session_id">
                    @foreach($sessions as $id => $entry)
                        <option value="{{ $id }}" {{ (old('session_id') ? old('session_id') : $otForm->session->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('session'))
                    <span class="text-danger">{{ $errors->first('session') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.otForm.fields.session_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="submitted_by">{{ trans('cruds.otForm.fields.submitted_by') }}</label>
                <input class="form-control {{ $errors->has('submitted_by') ? 'is-invalid' : '' }}" type="text" name="submitted_by" id="submitted_by" value="{{ old('submitted_by', $otForm->submitted_by) }}">
                @if($errors->has('submitted_by'))
                    <span class="text-danger">{{ $errors->first('submitted_by') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.otForm.fields.submitted_by_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="submitted_names">{{ trans('cruds.otForm.fields.submitted_names') }}</label>
                <input class="form-control {{ $errors->has('submitted_names') ? 'is-invalid' : '' }}" type="text" name="submitted_names" id="submitted_names" value="{{ old('submitted_names', $otForm->submitted_names) }}">
                @if($errors->has('submitted_names'))
                    <span class="text-danger">{{ $errors->first('submitted_names') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.otForm.fields.submitted_names_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="submitted_on">{{ trans('cruds.otForm.fields.submitted_on') }}</label>
                <input class="form-control date {{ $errors->has('submitted_on') ? 'is-invalid' : '' }}" type="text" name="submitted_on" id="submitted_on" value="{{ old('submitted_on', $otForm->submitted_on) }}">
                @if($errors->has('submitted_on'))
                    <span class="text-danger">{{ $errors->first('submitted_on') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.otForm.fields.submitted_on_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="form_no">{{ trans('cruds.otForm.fields.form_no') }}</label>
                <input class="form-control {{ $errors->has('form_no') ? 'is-invalid' : '' }}" type="number" name="form_no" id="form_no" value="{{ old('form_no', $otForm->form_no) }}" step="1">
                @if($errors->has('form_no'))
                    <span class="text-danger">{{ $errors->first('form_no') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.otForm.fields.form_no_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="duty_date">{{ trans('cruds.otForm.fields.duty_date') }}</label>
                <input class="form-control date {{ $errors->has('duty_date') ? 'is-invalid' : '' }}" type="text" name="duty_date" id="duty_date" value="{{ old('duty_date', $otForm->duty_date) }}">
                @if($errors->has('duty_date'))
                    <span class="text-danger">{{ $errors->first('duty_date') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.otForm.fields.duty_date_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="date_from">{{ trans('cruds.otForm.fields.date_from') }}</label>
                <input class="form-control date {{ $errors->has('date_from') ? 'is-invalid' : '' }}" type="text" name="date_from" id="date_from" value="{{ old('date_from', $otForm->date_from) }}">
                @if($errors->has('date_from'))
                    <span class="text-danger">{{ $errors->first('date_from') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.otForm.fields.date_from_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="date_to">{{ trans('cruds.otForm.fields.date_to') }}</label>
                <input class="form-control date {{ $errors->has('date_to') ? 'is-invalid' : '' }}" type="text" name="date_to" id="date_to" value="{{ old('date_to', $otForm->date_to) }}">
                @if($errors->has('date_to'))
                    <span class="text-danger">{{ $errors->first('date_to') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.otForm.fields.date_to_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="remarks">{{ trans('cruds.otForm.fields.remarks') }}</label>
                <input class="form-control {{ $errors->has('remarks') ? 'is-invalid' : '' }}" type="text" name="remarks" id="remarks" value="{{ old('remarks', $otForm->remarks) }}">
                @if($errors->has('remarks'))
                    <span class="text-danger">{{ $errors->first('remarks') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.otForm.fields.remarks_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="worknature">{{ trans('cruds.otForm.fields.worknature') }}</label>
                <input class="form-control {{ $errors->has('worknature') ? 'is-invalid' : '' }}" type="text" name="worknature" id="worknature" value="{{ old('worknature', $otForm->worknature) }}">
                @if($errors->has('worknature'))
                    <span class="text-danger">{{ $errors->first('worknature') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.otForm.fields.worknature_helper') }}</span>
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
