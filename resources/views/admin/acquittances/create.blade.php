@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.acquittance.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.acquittances.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="title">{{ trans('cruds.acquittance.fields.title') }}</label>
                <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title" id="title" value="{{ old('title', '') }}" required>
                @if($errors->has('title'))
                    <div class="invalid-feedback">
                        {{ $errors->first('title') }}
                    </div>
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
                    <div class="invalid-feedback">
                        {{ $errors->first('office') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.acquittance.fields.office_helper') }}</span>
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