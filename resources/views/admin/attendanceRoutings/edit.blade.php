@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.attendanceRouting.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.attendance-routings.update", [$attendanceRouting->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="seats">{{ trans('cruds.attendanceRouting.fields.seats') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('seats') ? 'is-invalid' : '' }}" name="seats[]" id="seats" multiple required>
                    @foreach($seats as $id => $seat)
                        <option value="{{ $id }}" {{ (in_array($id, old('seats', [])) || $attendanceRouting->seats->contains($id)) ? 'selected' : '' }}>{{ $seat }}</option>
                    @endforeach
                </select>
                @if($errors->has('seats'))
                    <div class="invalid-feedback">
                        {{ $errors->first('seats') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.attendanceRouting.fields.seats_helper') }}</span>
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