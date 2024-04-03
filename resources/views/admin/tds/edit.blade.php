@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.td.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.tds.update", [$td->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="pan">{{ trans('cruds.td.fields.pan') }}</label>
                <input class="form-control {{ $errors->has('pan') ? 'is-invalid' : '' }}" type="text" name="pan" id="pan" value="{{ old('pan', $td->pan) }}" required>
                @if($errors->has('pan'))
                    <span class="text-danger">{{ $errors->first('pan') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.td.fields.pan_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="pen">{{ trans('cruds.td.fields.pen') }}</label>
                <input class="form-control {{ $errors->has('pen') ? 'is-invalid' : '' }}" type="text" name="pen" id="pen" value="{{ old('pen', $td->pen) }}" required>
                @if($errors->has('pen'))
                    <span class="text-danger">{{ $errors->first('pen') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.td.fields.pen_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.td.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', $td->name) }}" required>
                @if($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.td.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="gross">{{ trans('cruds.td.fields.gross') }}</label>
                <input class="form-control {{ $errors->has('gross') ? 'is-invalid' : '' }}" type="number" name="gross" id="gross" value="{{ old('gross', $td->gross) }}" step="0.01" required>
                @if($errors->has('gross'))
                    <span class="text-danger">{{ $errors->first('gross') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.td.fields.gross_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="tds">{{ trans('cruds.td.fields.tds') }}</label>
                <input class="form-control {{ $errors->has('tds') ? 'is-invalid' : '' }}" type="number" name="tds" id="tds" value="{{ old('tds', $td->tds) }}" step="0.01" required>
                @if($errors->has('tds'))
                    <span class="text-danger">{{ $errors->first('tds') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.td.fields.tds_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="slno">{{ trans('cruds.td.fields.slno') }}</label>
                <input class="form-control {{ $errors->has('slno') ? 'is-invalid' : '' }}" type="number" name="slno" id="slno" value="{{ old('slno', $td->slno) }}" step="1">
                @if($errors->has('slno'))
                    <span class="text-danger">{{ $errors->first('slno') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.td.fields.slno_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="date_id">{{ trans('cruds.td.fields.date') }}</label>
                <select class="form-control select2 {{ $errors->has('date') ? 'is-invalid' : '' }}" name="date_id" id="date_id" required>
                    @foreach($dates as $id => $entry)
                        <option value="{{ $id }}" {{ (old('date_id') ? old('date_id') : $td->date->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('date'))
                    <span class="text-danger">{{ $errors->first('date') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.td.fields.date_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="created_by_id">{{ trans('cruds.td.fields.created_by') }}</label>
                <select class="form-control select2 {{ $errors->has('created_by') ? 'is-invalid' : '' }}" name="created_by_id" id="created_by_id">
                    @foreach($created_bies as $id => $entry)
                        <option value="{{ $id }}" {{ (old('created_by_id') ? old('created_by_id') : $td->created_by->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('created_by'))
                    <span class="text-danger">{{ $errors->first('created_by') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.td.fields.created_by_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="remarks">{{ trans('cruds.td.fields.remarks') }}</label>
                <input class="form-control {{ $errors->has('remarks') ? 'is-invalid' : '' }}" type="text" name="remarks" id="remarks" value="{{ old('remarks', $td->remarks) }}">
                @if($errors->has('remarks'))
                    <span class="text-danger">{{ $errors->first('remarks') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.td.fields.remarks_helper') }}</span>
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