@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.punchingDevice.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.punching-devices.update", [$punchingDevice->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="device">{{ trans('cruds.punchingDevice.fields.device') }}</label>
                <input class="form-control {{ $errors->has('device') ? 'is-invalid' : '' }}" type="text" name="device" id="device" value="{{ old('device', $punchingDevice->device) }}" required>
                @if($errors->has('device'))
                    <div class="invalid-feedback">
                        {{ $errors->first('device') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.punchingDevice.fields.device_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="loc_name">{{ trans('cruds.punchingDevice.fields.loc_name') }}</label>
                <input class="form-control {{ $errors->has('loc_name') ? 'is-invalid' : '' }}" type="text" name="loc_name" id="loc_name" value="{{ old('loc_name', $punchingDevice->loc_name) }}">
                @if($errors->has('loc_name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('loc_name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.punchingDevice.fields.loc_name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="entry_name">{{ trans('cruds.punchingDevice.fields.entry_name') }}</label>
                <input class="form-control {{ $errors->has('entry_name') ? 'is-invalid' : '' }}" type="text" name="entry_name" id="entry_name" value="{{ old('entry_name', $punchingDevice->entry_name) }}">
                @if($errors->has('entry_name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('entry_name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.punchingDevice.fields.entry_name_helper') }}</span>
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