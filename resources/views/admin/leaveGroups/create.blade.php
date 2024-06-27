@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.leaveGroup.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.leave-groups.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="groupname">{{ trans('cruds.leaveGroup.fields.groupname') }}</label>
                <input class="form-control {{ $errors->has('groupname') ? 'is-invalid' : '' }}" type="text" name="groupname" id="groupname" value="{{ old('groupname', '') }}" required>
                @if($errors->has('groupname'))
                    <span class="text-danger">{{ $errors->first('groupname') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.leaveGroup.fields.groupname_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="allowed_casual_per_year">{{ trans('cruds.leaveGroup.fields.allowed_casual_per_year') }}</label>
                <input class="form-control {{ $errors->has('allowed_casual_per_year') ? 'is-invalid' : '' }}" type="number" name="allowed_casual_per_year" id="allowed_casual_per_year" value="{{ old('allowed_casual_per_year', '') }}" step="1" required>
                @if($errors->has('allowed_casual_per_year'))
                    <span class="text-danger">{{ $errors->first('allowed_casual_per_year') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.leaveGroup.fields.allowed_casual_per_year_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="allowed_compen_per_year">{{ trans('cruds.leaveGroup.fields.allowed_compen_per_year') }}</label>
                <input class="form-control {{ $errors->has('allowed_compen_per_year') ? 'is-invalid' : '' }}" type="number" name="allowed_compen_per_year" id="allowed_compen_per_year" value="{{ old('allowed_compen_per_year', '') }}" step="1" required>
                @if($errors->has('allowed_compen_per_year'))
                    <span class="text-danger">{{ $errors->first('allowed_compen_per_year') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.leaveGroup.fields.allowed_compen_per_year_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="allowed_special_casual_per_year">{{ trans('cruds.leaveGroup.fields.allowed_special_casual_per_year') }}</label>
                <input class="form-control {{ $errors->has('allowed_special_casual_per_year') ? 'is-invalid' : '' }}" type="number" name="allowed_special_casual_per_year" id="allowed_special_casual_per_year" value="{{ old('allowed_special_casual_per_year', '') }}" step="1">
                @if($errors->has('allowed_special_casual_per_year'))
                    <span class="text-danger">{{ $errors->first('allowed_special_casual_per_year') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.leaveGroup.fields.allowed_special_casual_per_year_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="allowed_earned_per_year">{{ trans('cruds.leaveGroup.fields.allowed_earned_per_year') }}</label>
                <input class="form-control {{ $errors->has('allowed_earned_per_year') ? 'is-invalid' : '' }}" type="text" name="allowed_earned_per_year" id="allowed_earned_per_year" value="{{ old('allowed_earned_per_year', '') }}">
                @if($errors->has('allowed_earned_per_year'))
                    <span class="text-danger">{{ $errors->first('allowed_earned_per_year') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.leaveGroup.fields.allowed_earned_per_year_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="allowed_halfpay_per_year">{{ trans('cruds.leaveGroup.fields.allowed_halfpay_per_year') }}</label>
                <input class="form-control {{ $errors->has('allowed_halfpay_per_year') ? 'is-invalid' : '' }}" type="number" name="allowed_halfpay_per_year" id="allowed_halfpay_per_year" value="{{ old('allowed_halfpay_per_year', '') }}" step="1">
                @if($errors->has('allowed_halfpay_per_year'))
                    <span class="text-danger">{{ $errors->first('allowed_halfpay_per_year') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.leaveGroup.fields.allowed_halfpay_per_year_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="allowed_continuous_casual_and_compen">{{ trans('cruds.leaveGroup.fields.allowed_continuous_casual_and_compen') }}</label>
                <input class="form-control {{ $errors->has('allowed_continuous_casual_and_compen') ? 'is-invalid' : '' }}" type="number" name="allowed_continuous_casual_and_compen" id="allowed_continuous_casual_and_compen" value="{{ old('allowed_continuous_casual_and_compen', '') }}" step="1">
                @if($errors->has('allowed_continuous_casual_and_compen'))
                    <span class="text-danger">{{ $errors->first('allowed_continuous_casual_and_compen') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.leaveGroup.fields.allowed_continuous_casual_and_compen_helper') }}</span>
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