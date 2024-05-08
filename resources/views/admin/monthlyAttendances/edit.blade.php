@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.monthlyAttendance.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.monthly-attendances.update", [$monthlyAttendance->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="aadhaarid">{{ trans('cruds.monthlyAttendance.fields.aadhaarid') }}</label>
                <input class="form-control {{ $errors->has('aadhaarid') ? 'is-invalid' : '' }}" type="text" name="aadhaarid" id="aadhaarid" value="{{ old('aadhaarid', $monthlyAttendance->aadhaarid) }}" required>
                @if($errors->has('aadhaarid'))
                    <span class="text-danger">{{ $errors->first('aadhaarid') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.monthlyAttendance.fields.aadhaarid_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="compoff_granted">{{ trans('cruds.monthlyAttendance.fields.compoff_granted') }}</label>
                <input class="form-control {{ $errors->has('compoff_granted') ? 'is-invalid' : '' }}" type="number" name="compoff_granted" id="compoff_granted" value="{{ old('compoff_granted', $monthlyAttendance->compoff_granted) }}" step="1">
                @if($errors->has('compoff_granted'))
                    <span class="text-danger">{{ $errors->first('compoff_granted') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.monthlyAttendance.fields.compoff_granted_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="total_grace_sec">{{ trans('cruds.monthlyAttendance.fields.total_grace_sec') }}</label>
                <input class="form-control {{ $errors->has('total_grace_sec') ? 'is-invalid' : '' }}" type="number" name="total_grace_sec" id="total_grace_sec" value="{{ old('total_grace_sec', $monthlyAttendance->total_grace_sec) }}" step="1">
                @if($errors->has('total_grace_sec'))
                    <span class="text-danger">{{ $errors->first('total_grace_sec') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.monthlyAttendance.fields.total_grace_sec_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="total_extra_sec">{{ trans('cruds.monthlyAttendance.fields.total_extra_sec') }}</label>
                <input class="form-control {{ $errors->has('total_extra_sec') ? 'is-invalid' : '' }}" type="number" name="total_extra_sec" id="total_extra_sec" value="{{ old('total_extra_sec', $monthlyAttendance->total_extra_sec) }}" step="1">
                @if($errors->has('total_extra_sec'))
                    <span class="text-danger">{{ $errors->first('total_extra_sec') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.monthlyAttendance.fields.total_extra_sec_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="total_grace_str">{{ trans('cruds.monthlyAttendance.fields.total_grace_str') }}</label>
                <input class="form-control {{ $errors->has('total_grace_str') ? 'is-invalid' : '' }}" type="text" name="total_grace_str" id="total_grace_str" value="{{ old('total_grace_str', $monthlyAttendance->total_grace_str) }}">
                @if($errors->has('total_grace_str'))
                    <span class="text-danger">{{ $errors->first('total_grace_str') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.monthlyAttendance.fields.total_grace_str_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="total_extra_str">{{ trans('cruds.monthlyAttendance.fields.total_extra_str') }}</label>
                <input class="form-control {{ $errors->has('total_extra_str') ? 'is-invalid' : '' }}" type="text" name="total_extra_str" id="total_extra_str" value="{{ old('total_extra_str', $monthlyAttendance->total_extra_str) }}">
                @if($errors->has('total_extra_str'))
                    <span class="text-danger">{{ $errors->first('total_extra_str') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.monthlyAttendance.fields.total_extra_str_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="grace_exceeded_sec">{{ trans('cruds.monthlyAttendance.fields.grace_exceeded_sec') }}</label>
                <input class="form-control {{ $errors->has('grace_exceeded_sec') ? 'is-invalid' : '' }}" type="number" name="grace_exceeded_sec" id="grace_exceeded_sec" value="{{ old('grace_exceeded_sec', $monthlyAttendance->grace_exceeded_sec) }}" step="1">
                @if($errors->has('grace_exceeded_sec'))
                    <span class="text-danger">{{ $errors->first('grace_exceeded_sec') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.monthlyAttendance.fields.grace_exceeded_sec_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="total_grace_exceeded300_date">{{ trans('cruds.monthlyAttendance.fields.total_grace_exceeded300_date') }}</label>
                <input class="form-control date {{ $errors->has('total_grace_exceeded300_date') ? 'is-invalid' : '' }}" type="text" name="total_grace_exceeded300_date" id="total_grace_exceeded300_date" value="{{ old('total_grace_exceeded300_date', $monthlyAttendance->total_grace_exceeded300_date) }}">
                @if($errors->has('total_grace_exceeded300_date'))
                    <span class="text-danger">{{ $errors->first('total_grace_exceeded300_date') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.monthlyAttendance.fields.total_grace_exceeded_300_date_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="compen_marked">{{ trans('cruds.monthlyAttendance.fields.compen_marked') }}</label>
                <input class="form-control {{ $errors->has('compen_marked') ? 'is-invalid' : '' }}" type="number" name="compen_marked" id="compen_marked" value="{{ old('compen_marked', $monthlyAttendance->compen_marked) }}" step="1">
                @if($errors->has('compen_marked'))
                    <span class="text-danger">{{ $errors->first('compen_marked') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.monthlyAttendance.fields.compen_marked_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="compen_submitted">{{ trans('cruds.monthlyAttendance.fields.compen_submitted') }}</label>
                <input class="form-control {{ $errors->has('compen_submitted') ? 'is-invalid' : '' }}" type="number" name="compen_submitted" id="compen_submitted" value="{{ old('compen_submitted', $monthlyAttendance->compen_submitted) }}" step="1">
                @if($errors->has('compen_submitted'))
                    <span class="text-danger">{{ $errors->first('compen_submitted') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.monthlyAttendance.fields.compen_submitted_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="other_leaves_marked">{{ trans('cruds.monthlyAttendance.fields.other_leaves_marked') }}</label>
                <input class="form-control {{ $errors->has('other_leaves_marked') ? 'is-invalid' : '' }}" type="number" name="other_leaves_marked" id="other_leaves_marked" value="{{ old('other_leaves_marked', $monthlyAttendance->other_leaves_marked) }}" step="1">
                @if($errors->has('other_leaves_marked'))
                    <span class="text-danger">{{ $errors->first('other_leaves_marked') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.monthlyAttendance.fields.other_leaves_marked_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="other_leaves_submitted">{{ trans('cruds.monthlyAttendance.fields.other_leaves_submitted') }}</label>
                <input class="form-control {{ $errors->has('other_leaves_submitted') ? 'is-invalid' : '' }}" type="number" name="other_leaves_submitted" id="other_leaves_submitted" value="{{ old('other_leaves_submitted', $monthlyAttendance->other_leaves_submitted) }}" step="1">
                @if($errors->has('other_leaves_submitted'))
                    <span class="text-danger">{{ $errors->first('other_leaves_submitted') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.monthlyAttendance.fields.other_leaves_submitted_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="cl_marked">{{ trans('cruds.monthlyAttendance.fields.cl_marked') }}</label>
                <input class="form-control {{ $errors->has('cl_marked') ? 'is-invalid' : '' }}" type="number" name="cl_marked" id="cl_marked" value="{{ old('cl_marked', $monthlyAttendance->cl_marked) }}" step="0.1">
                @if($errors->has('cl_marked'))
                    <span class="text-danger">{{ $errors->first('cl_marked') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.monthlyAttendance.fields.cl_marked_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="cl_submitted">{{ trans('cruds.monthlyAttendance.fields.cl_submitted') }}</label>
                <input class="form-control {{ $errors->has('cl_submitted') ? 'is-invalid' : '' }}" type="number" name="cl_submitted" id="cl_submitted" value="{{ old('cl_submitted', $monthlyAttendance->cl_submitted) }}" step="0.1">
                @if($errors->has('cl_submitted'))
                    <span class="text-danger">{{ $errors->first('cl_submitted') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.monthlyAttendance.fields.cl_submitted_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="single_punchings">{{ trans('cruds.monthlyAttendance.fields.single_punchings') }}</label>
                <input class="form-control {{ $errors->has('single_punchings') ? 'is-invalid' : '' }}" type="number" name="single_punchings" id="single_punchings" value="{{ old('single_punchings', $monthlyAttendance->single_punchings) }}" step="1">
                @if($errors->has('single_punchings'))
                    <span class="text-danger">{{ $errors->first('single_punchings') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.monthlyAttendance.fields.single_punchings_helper') }}</span>
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