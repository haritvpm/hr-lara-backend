@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.attendanceRouting.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.attendance-routings.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="seats">{{ trans('cruds.attendanceRouting.fields.seats') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('seats') ? 'is-invalid' : '' }}" name="seats[]" id="seats" multiple required>
                    @foreach($seats as $id => $seat)
                        <option value="{{ $id }}" {{ in_array($id, old('seats', [])) ? 'selected' : '' }}>{{ $seat }}</option>
                    @endforeach
                </select>
                @if($errors->has('seats'))
                    <span class="text-danger">{{ $errors->first('seats') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.attendanceRouting.fields.seats_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="js_id">{{ trans('cruds.attendanceRouting.fields.js') }}</label>
                <select class="form-control select2 {{ $errors->has('js') ? 'is-invalid' : '' }}" name="js_id" id="js_id">
                    @foreach($js as $id => $entry)
                        <option value="{{ $id }}" {{ old('js_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('js'))
                    <span class="text-danger">{{ $errors->first('js') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.attendanceRouting.fields.js_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="as_id">{{ trans('cruds.attendanceRouting.fields.as') }}</label>
                <select class="form-control select2 {{ $errors->has('as') ? 'is-invalid' : '' }}" name="as_id" id="as_id">
                    @foreach($as as $id => $entry)
                        <option value="{{ $id }}" {{ old('as_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('as'))
                    <span class="text-danger">{{ $errors->first('as') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.attendanceRouting.fields.as_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="ss_id">{{ trans('cruds.attendanceRouting.fields.ss') }}</label>
                <select class="form-control select2 {{ $errors->has('ss') ? 'is-invalid' : '' }}" name="ss_id" id="ss_id">
                    @foreach($sses as $id => $entry)
                        <option value="{{ $id }}" {{ old('ss_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('ss'))
                    <span class="text-danger">{{ $errors->first('ss') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.attendanceRouting.fields.ss_helper') }}</span>
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