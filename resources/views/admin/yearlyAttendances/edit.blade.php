@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.yearlyAttendance.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.yearly-attendances.update", [$yearlyAttendance->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="aadhaarid">{{ trans('cruds.yearlyAttendance.fields.aadhaarid') }}</label>
                <input class="form-control {{ $errors->has('aadhaarid') ? 'is-invalid' : '' }}" type="text" name="aadhaarid" id="aadhaarid" value="{{ old('aadhaarid', $yearlyAttendance->aadhaarid) }}" required>
                @if($errors->has('aadhaarid'))
                    <span class="text-danger">{{ $errors->first('aadhaarid') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.yearlyAttendance.fields.aadhaarid_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="cl_marked">{{ trans('cruds.yearlyAttendance.fields.cl_marked') }}</label>
                <input class="form-control {{ $errors->has('cl_marked') ? 'is-invalid' : '' }}" type="number" name="cl_marked" id="cl_marked" value="{{ old('cl_marked', $yearlyAttendance->cl_marked) }}" step="0.1">
                @if($errors->has('cl_marked'))
                    <span class="text-danger">{{ $errors->first('cl_marked') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.yearlyAttendance.fields.cl_marked_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="cl_submitted">{{ trans('cruds.yearlyAttendance.fields.cl_submitted') }}</label>
                <input class="form-control {{ $errors->has('cl_submitted') ? 'is-invalid' : '' }}" type="number" name="cl_submitted" id="cl_submitted" value="{{ old('cl_submitted', $yearlyAttendance->cl_submitted) }}" step="0.1">
                @if($errors->has('cl_submitted'))
                    <span class="text-danger">{{ $errors->first('cl_submitted') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.yearlyAttendance.fields.cl_submitted_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="compen_marked">{{ trans('cruds.yearlyAttendance.fields.compen_marked') }}</label>
                <input class="form-control {{ $errors->has('compen_marked') ? 'is-invalid' : '' }}" type="number" name="compen_marked" id="compen_marked" value="{{ old('compen_marked', $yearlyAttendance->compen_marked) }}" step="1">
                @if($errors->has('compen_marked'))
                    <span class="text-danger">{{ $errors->first('compen_marked') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.yearlyAttendance.fields.compen_marked_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="compen_submitted">{{ trans('cruds.yearlyAttendance.fields.compen_submitted') }}</label>
                <input class="form-control {{ $errors->has('compen_submitted') ? 'is-invalid' : '' }}" type="number" name="compen_submitted" id="compen_submitted" value="{{ old('compen_submitted', $yearlyAttendance->compen_submitted) }}" step="1">
                @if($errors->has('compen_submitted'))
                    <span class="text-danger">{{ $errors->first('compen_submitted') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.yearlyAttendance.fields.compen_submitted_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="other_leaves_marked">{{ trans('cruds.yearlyAttendance.fields.other_leaves_marked') }}</label>
                <input class="form-control {{ $errors->has('other_leaves_marked') ? 'is-invalid' : '' }}" type="number" name="other_leaves_marked" id="other_leaves_marked" value="{{ old('other_leaves_marked', $yearlyAttendance->other_leaves_marked) }}" step="1">
                @if($errors->has('other_leaves_marked'))
                    <span class="text-danger">{{ $errors->first('other_leaves_marked') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.yearlyAttendance.fields.other_leaves_marked_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="other_leaves_submitted">{{ trans('cruds.yearlyAttendance.fields.other_leaves_submitted') }}</label>
                <input class="form-control {{ $errors->has('other_leaves_submitted') ? 'is-invalid' : '' }}" type="number" name="other_leaves_submitted" id="other_leaves_submitted" value="{{ old('other_leaves_submitted', $yearlyAttendance->other_leaves_submitted) }}" step="1">
                @if($errors->has('other_leaves_submitted'))
                    <span class="text-danger">{{ $errors->first('other_leaves_submitted') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.yearlyAttendance.fields.other_leaves_submitted_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="single_punchings">{{ trans('cruds.yearlyAttendance.fields.single_punchings') }}</label>
                <input class="form-control {{ $errors->has('single_punchings') ? 'is-invalid' : '' }}" type="number" name="single_punchings" id="single_punchings" value="{{ old('single_punchings', $yearlyAttendance->single_punchings) }}" step="1">
                @if($errors->has('single_punchings'))
                    <span class="text-danger">{{ $errors->first('single_punchings') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.yearlyAttendance.fields.single_punchings_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="start_with_cl">{{ trans('cruds.yearlyAttendance.fields.start_with_cl') }}</label>
                <input class="form-control {{ $errors->has('start_with_cl') ? 'is-invalid' : '' }}" type="number" name="start_with_cl" id="start_with_cl" value="{{ old('start_with_cl', $yearlyAttendance->start_with_cl) }}" step="0.1">
                @if($errors->has('start_with_cl'))
                    <span class="text-danger">{{ $errors->first('start_with_cl') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.yearlyAttendance.fields.start_with_cl_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="start_with_compen">{{ trans('cruds.yearlyAttendance.fields.start_with_compen') }}</label>
                <input class="form-control {{ $errors->has('start_with_compen') ? 'is-invalid' : '' }}" type="number" name="start_with_compen" id="start_with_compen" value="{{ old('start_with_compen', $yearlyAttendance->start_with_compen) }}" step="1">
                @if($errors->has('start_with_compen'))
                    <span class="text-danger">{{ $errors->first('start_with_compen') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.yearlyAttendance.fields.start_with_compen_helper') }}</span>
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