@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.leaveFormDetail.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.leave-form-details.update", [$leaveFormDetail->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="dob">{{ trans('cruds.leaveFormDetail.fields.dob') }}</label>
                <input class="form-control date {{ $errors->has('dob') ? 'is-invalid' : '' }}" type="text" name="dob" id="dob" value="{{ old('dob', $leaveFormDetail->dob) }}">
                @if($errors->has('dob'))
                    <span class="text-danger">{{ $errors->first('dob') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.leaveFormDetail.fields.dob_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="post">{{ trans('cruds.leaveFormDetail.fields.post') }}</label>
                <input class="form-control {{ $errors->has('post') ? 'is-invalid' : '' }}" type="text" name="post" id="post" value="{{ old('post', $leaveFormDetail->post) }}">
                @if($errors->has('post'))
                    <span class="text-danger">{{ $errors->first('post') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.leaveFormDetail.fields.post_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="dept">{{ trans('cruds.leaveFormDetail.fields.dept') }}</label>
                <input class="form-control {{ $errors->has('dept') ? 'is-invalid' : '' }}" type="text" name="dept" id="dept" value="{{ old('dept', $leaveFormDetail->dept) }}">
                @if($errors->has('dept'))
                    <span class="text-danger">{{ $errors->first('dept') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.leaveFormDetail.fields.dept_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="pay">{{ trans('cruds.leaveFormDetail.fields.pay') }}</label>
                <input class="form-control {{ $errors->has('pay') ? 'is-invalid' : '' }}" type="text" name="pay" id="pay" value="{{ old('pay', $leaveFormDetail->pay) }}">
                @if($errors->has('pay'))
                    <span class="text-danger">{{ $errors->first('pay') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.leaveFormDetail.fields.pay_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="doe">{{ trans('cruds.leaveFormDetail.fields.doe') }}</label>
                <input class="form-control date {{ $errors->has('doe') ? 'is-invalid' : '' }}" type="text" name="doe" id="doe" value="{{ old('doe', $leaveFormDetail->doe) }}">
                @if($errors->has('doe'))
                    <span class="text-danger">{{ $errors->first('doe') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.leaveFormDetail.fields.doe_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="date_of_confirmation">{{ trans('cruds.leaveFormDetail.fields.date_of_confirmation') }}</label>
                <input class="form-control date {{ $errors->has('date_of_confirmation') ? 'is-invalid' : '' }}" type="text" name="date_of_confirmation" id="date_of_confirmation" value="{{ old('date_of_confirmation', $leaveFormDetail->date_of_confirmation) }}">
                @if($errors->has('date_of_confirmation'))
                    <span class="text-danger">{{ $errors->first('date_of_confirmation') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.leaveFormDetail.fields.date_of_confirmation_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="address">{{ trans('cruds.leaveFormDetail.fields.address') }}</label>
                <input class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" type="text" name="address" id="address" value="{{ old('address', $leaveFormDetail->address) }}">
                @if($errors->has('address'))
                    <span class="text-danger">{{ $errors->first('address') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.leaveFormDetail.fields.address_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="hra">{{ trans('cruds.leaveFormDetail.fields.hra') }}</label>
                <input class="form-control {{ $errors->has('hra') ? 'is-invalid' : '' }}" type="text" name="hra" id="hra" value="{{ old('hra', $leaveFormDetail->hra) }}">
                @if($errors->has('hra'))
                    <span class="text-danger">{{ $errors->first('hra') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.leaveFormDetail.fields.hra_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="nature">{{ trans('cruds.leaveFormDetail.fields.nature') }}</label>
                <input class="form-control {{ $errors->has('nature') ? 'is-invalid' : '' }}" type="text" name="nature" id="nature" value="{{ old('nature', $leaveFormDetail->nature) }}">
                @if($errors->has('nature'))
                    <span class="text-danger">{{ $errors->first('nature') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.leaveFormDetail.fields.nature_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="prefix">{{ trans('cruds.leaveFormDetail.fields.prefix') }}</label>
                <input class="form-control {{ $errors->has('prefix') ? 'is-invalid' : '' }}" type="text" name="prefix" id="prefix" value="{{ old('prefix', $leaveFormDetail->prefix) }}">
                @if($errors->has('prefix'))
                    <span class="text-danger">{{ $errors->first('prefix') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.leaveFormDetail.fields.prefix_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="suffix">{{ trans('cruds.leaveFormDetail.fields.suffix') }}</label>
                <input class="form-control {{ $errors->has('suffix') ? 'is-invalid' : '' }}" type="text" name="suffix" id="suffix" value="{{ old('suffix', $leaveFormDetail->suffix) }}">
                @if($errors->has('suffix'))
                    <span class="text-danger">{{ $errors->first('suffix') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.leaveFormDetail.fields.suffix_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="last_leave_info">{{ trans('cruds.leaveFormDetail.fields.last_leave_info') }}</label>
                <input class="form-control {{ $errors->has('last_leave_info') ? 'is-invalid' : '' }}" type="text" name="last_leave_info" id="last_leave_info" value="{{ old('last_leave_info', $leaveFormDetail->last_leave_info) }}">
                @if($errors->has('last_leave_info'))
                    <span class="text-danger">{{ $errors->first('last_leave_info') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.leaveFormDetail.fields.last_leave_info_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="leave_id">{{ trans('cruds.leaveFormDetail.fields.leave') }}</label>
                <select class="form-control select2 {{ $errors->has('leave') ? 'is-invalid' : '' }}" name="leave_id" id="leave_id" required>
                    @foreach($leaves as $id => $entry)
                        <option value="{{ $id }}" {{ (old('leave_id') ? old('leave_id') : $leaveFormDetail->leave->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('leave'))
                    <span class="text-danger">{{ $errors->first('leave') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.leaveFormDetail.fields.leave_helper') }}</span>
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