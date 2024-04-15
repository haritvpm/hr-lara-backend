@extends('layouts.admin')
@section('content')

<div class="card_">
    <div class="card-header_">
        {{ trans('global.create') }} {{ trans('cruds.acquittance.title_singular') }}
    </div>

    <div class="card-body_">
        <form method="POST" action="{{ route("admin.acquittances.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="title">{{ trans('cruds.acquittance.fields.title') }}</label>
                <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title" id="title" value="{{ old('title', '') }}" required>
                @if($errors->has('title'))
                    <span class="text-danger">{{ $errors->first('title') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.acquittance.fields.title_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="office_id">{{ trans('cruds.acquittance.fields.office') }}</label>
                <select class="form-control select2 {{ $errors->has('office') ? 'is-invalid' : '' }}" name="office_id" id="office_id" required>
                    @foreach($offices as $id => $entry)
                        <option value="{{ $id }}" {{ old('office_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('office'))
                    <span class="text-danger">{{ $errors->first('office') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.acquittance.fields.office_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="ddo_id">{{ trans('cruds.acquittance.fields.ddo') }}</label>
                <select class="form-control select2 {{ $errors->has('ddo') ? 'is-invalid' : '' }}" name="ddo_id" id="ddo_id">
                    @foreach($ddos as $id => $entry)
                        <option value="{{ $id }}" {{ old('ddo_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('ddo'))
                    <span class="text-danger">{{ $errors->first('ddo') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.acquittance.fields.ddo_helper') }}</span>
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
