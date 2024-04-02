@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.ddo.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.ddos.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="code">{{ trans('cruds.ddo.fields.code') }}</label>
                <input class="form-control {{ $errors->has('code') ? 'is-invalid' : '' }}" type="text" name="code" id="code" value="{{ old('code', '') }}" required>
                @if($errors->has('code'))
                    <div class="invalid-feedback">
                        {{ $errors->first('code') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.ddo.fields.code_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="acquittance_id">{{ trans('cruds.ddo.fields.acquittance') }}</label>
                <select class="form-control select2 {{ $errors->has('acquittance') ? 'is-invalid' : '' }}" name="acquittance_id" id="acquittance_id" required>
                    @foreach($acquittances as $id => $entry)
                        <option value="{{ $id }}" {{ old('acquittance_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('acquittance'))
                    <div class="invalid-feedback">
                        {{ $errors->first('acquittance') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.ddo.fields.acquittance_helper') }}</span>
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