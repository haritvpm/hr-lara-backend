@extends('layouts.admin')
@section('content')

<div class="card_">
    <div class="card-header_">
        {{ trans('global.edit') }} {{ trans('cruds.officeLocation.title_singular') }}
    </div>

    <div class="card-body_">
        <form method="POST" action="{{ route("admin.office-locations.update", [$officeLocation->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="location">{{ trans('cruds.officeLocation.fields.location') }}</label>
                <input class="form-control {{ $errors->has('location') ? 'is-invalid' : '' }}" type="text" name="location" id="location" value="{{ old('location', $officeLocation->location) }}" required>
                @if($errors->has('location'))
                    <span class="text-danger">{{ $errors->first('location') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.officeLocation.fields.location_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="administrative_office_id">{{ trans('cruds.officeLocation.fields.administrative_office') }}</label>
                <select class="form-control select2 {{ $errors->has('administrative_office') ? 'is-invalid' : '' }}" name="administrative_office_id" id="administrative_office_id" required>
                    @foreach($administrative_offices as $id => $entry)
                        <option value="{{ $id }}" {{ (old('administrative_office_id') ? old('administrative_office_id') : $officeLocation->administrative_office->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('administrative_office'))
                    <span class="text-danger">{{ $errors->first('administrative_office') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.officeLocation.fields.administrative_office_helper') }}</span>
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
