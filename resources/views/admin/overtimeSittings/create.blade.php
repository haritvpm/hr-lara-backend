@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.overtimeSitting.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.overtime-sittings.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="date">{{ trans('cruds.overtimeSitting.fields.date') }}</label>
                <input class="form-control date {{ $errors->has('date') ? 'is-invalid' : '' }}" type="text" name="date" id="date" value="{{ old('date') }}">
                @if($errors->has('date'))
                    <div class="invalid-feedback">
                        {{ $errors->first('date') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.overtimeSitting.fields.date_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('checked') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="checked" value="0">
                    <input class="form-check-input" type="checkbox" name="checked" id="checked" value="1" {{ old('checked', 0) == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="checked">{{ trans('cruds.overtimeSitting.fields.checked') }}</label>
                </div>
                @if($errors->has('checked'))
                    <div class="invalid-feedback">
                        {{ $errors->first('checked') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.overtimeSitting.fields.checked_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="overtime_id">{{ trans('cruds.overtimeSitting.fields.overtime') }}</label>
                <select class="form-control select2 {{ $errors->has('overtime') ? 'is-invalid' : '' }}" name="overtime_id" id="overtime_id">
                    @foreach($overtimes as $id => $entry)
                        <option value="{{ $id }}" {{ old('overtime_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('overtime'))
                    <div class="invalid-feedback">
                        {{ $errors->first('overtime') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.overtimeSitting.fields.overtime_helper') }}</span>
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