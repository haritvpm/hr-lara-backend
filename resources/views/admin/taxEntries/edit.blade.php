@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.taxEntry.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.tax-entries.update", [$taxEntry->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="date">{{ trans('cruds.taxEntry.fields.date') }}</label>
                <input class="form-control date {{ $errors->has('date') ? 'is-invalid' : '' }}" type="text" name="date" id="date" value="{{ old('date', $taxEntry->date) }}" required>
                @if($errors->has('date'))
                    <div class="invalid-feedback">
                        {{ $errors->first('date') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.taxEntry.fields.date_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="status">{{ trans('cruds.taxEntry.fields.status') }}</label>
                <input class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" type="text" name="status" id="status" value="{{ old('status', $taxEntry->status) }}">
                @if($errors->has('status'))
                    <div class="invalid-feedback">
                        {{ $errors->first('status') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.taxEntry.fields.status_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="acquittance">{{ trans('cruds.taxEntry.fields.acquittance') }}</label>
                <input class="form-control {{ $errors->has('acquittance') ? 'is-invalid' : '' }}" type="text" name="acquittance" id="acquittance" value="{{ old('acquittance', $taxEntry->acquittance) }}">
                @if($errors->has('acquittance'))
                    <div class="invalid-feedback">
                        {{ $errors->first('acquittance') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.taxEntry.fields.acquittance_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="created_by_id">{{ trans('cruds.taxEntry.fields.created_by') }}</label>
                <select class="form-control select2 {{ $errors->has('created_by') ? 'is-invalid' : '' }}" name="created_by_id" id="created_by_id">
                    @foreach($created_bies as $id => $entry)
                        <option value="{{ $id }}" {{ (old('created_by_id') ? old('created_by_id') : $taxEntry->created_by->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('created_by'))
                    <div class="invalid-feedback">
                        {{ $errors->first('created_by') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.taxEntry.fields.created_by_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="sparkcode">{{ trans('cruds.taxEntry.fields.sparkcode') }}</label>
                <input class="form-control {{ $errors->has('sparkcode') ? 'is-invalid' : '' }}" type="text" name="sparkcode" id="sparkcode" value="{{ old('sparkcode', $taxEntry->sparkcode) }}">
                @if($errors->has('sparkcode'))
                    <div class="invalid-feedback">
                        {{ $errors->first('sparkcode') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.taxEntry.fields.sparkcode_helper') }}</span>
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