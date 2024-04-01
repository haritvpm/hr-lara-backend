@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.section.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.sections.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.section.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}" required>
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.section.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="administrative_office_id">{{ trans('cruds.section.fields.administrative_office') }}</label>
                <select class="form-control select2 {{ $errors->has('administrative_office') ? 'is-invalid' : '' }}" name="administrative_office_id" id="administrative_office_id" required>
                    @foreach($administrative_offices as $id => $entry)
                        <option value="{{ $id }}" {{ old('administrative_office_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('administrative_office'))
                    <div class="invalid-feedback">
                        {{ $errors->first('administrative_office') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.section.fields.administrative_office_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="seat_of_controling_officer_id">{{ trans('cruds.section.fields.seat_of_controling_officer') }}</label>
                <select class="form-control select2 {{ $errors->has('seat_of_controling_officer') ? 'is-invalid' : '' }}" name="seat_of_controling_officer_id" id="seat_of_controling_officer_id" required>
                    @foreach($seat_of_controling_officers as $id => $entry)
                        <option value="{{ $id }}" {{ old('seat_of_controling_officer_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('seat_of_controling_officer'))
                    <div class="invalid-feedback">
                        {{ $errors->first('seat_of_controling_officer') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.section.fields.seat_of_controling_officer_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="seat_of_reporting_officer_id">{{ trans('cruds.section.fields.seat_of_reporting_officer') }}</label>
                <select class="form-control select2 {{ $errors->has('seat_of_reporting_officer') ? 'is-invalid' : '' }}" name="seat_of_reporting_officer_id" id="seat_of_reporting_officer_id">
                    @foreach($seat_of_reporting_officers as $id => $entry)
                        <option value="{{ $id }}" {{ old('seat_of_reporting_officer_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('seat_of_reporting_officer'))
                    <div class="invalid-feedback">
                        {{ $errors->first('seat_of_reporting_officer') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.section.fields.seat_of_reporting_officer_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.section.fields.type') }}</label>
                <select class="form-control {{ $errors->has('type') ? 'is-invalid' : '' }}" name="type" id="type">
                    <option value disabled {{ old('type', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Section::TYPE_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('type', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('type'))
                    <div class="invalid-feedback">
                        {{ $errors->first('type') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.section.fields.type_helper') }}</span>
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