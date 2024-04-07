@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.leaf.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.leaves.update", [$leaf->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="employee_id">{{ trans('cruds.leaf.fields.employee') }}</label>
                <select class="form-control select2 {{ $errors->has('employee') ? 'is-invalid' : '' }}" name="employee_id" id="employee_id" required>
                    @foreach($employees as $id => $entry)
                        <option value="{{ $id }}" {{ (old('employee_id') ? old('employee_id') : $leaf->employee->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('employee'))
                    <span class="text-danger">{{ $errors->first('employee') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.leaf.fields.employee_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.leaf.fields.leave_type') }}</label>
                <select class="form-control {{ $errors->has('leave_type') ? 'is-invalid' : '' }}" name="leave_type" id="leave_type">
                    <option value disabled {{ old('leave_type', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Leaf::LEAVE_TYPE_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('leave_type', $leaf->leave_type) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('leave_type'))
                    <span class="text-danger">{{ $errors->first('leave_type') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.leaf.fields.leave_type_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="start_date">{{ trans('cruds.leaf.fields.start_date') }}</label>
                <input class="form-control date {{ $errors->has('start_date') ? 'is-invalid' : '' }}" type="text" name="start_date" id="start_date" value="{{ old('start_date', $leaf->start_date) }}" required>
                @if($errors->has('start_date'))
                    <span class="text-danger">{{ $errors->first('start_date') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.leaf.fields.start_date_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="end_date">{{ trans('cruds.leaf.fields.end_date') }}</label>
                <input class="form-control date {{ $errors->has('end_date') ? 'is-invalid' : '' }}" type="text" name="end_date" id="end_date" value="{{ old('end_date', $leaf->end_date) }}" required>
                @if($errors->has('end_date'))
                    <span class="text-danger">{{ $errors->first('end_date') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.leaf.fields.end_date_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="reason">{{ trans('cruds.leaf.fields.reason') }}</label>
                <input class="form-control {{ $errors->has('reason') ? 'is-invalid' : '' }}" type="text" name="reason" id="reason" value="{{ old('reason', $leaf->reason) }}">
                @if($errors->has('reason'))
                    <span class="text-danger">{{ $errors->first('reason') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.leaf.fields.reason_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="active_status">{{ trans('cruds.leaf.fields.active_status') }}</label>
                <input class="form-control {{ $errors->has('active_status') ? 'is-invalid' : '' }}" type="text" name="active_status" id="active_status" value="{{ old('active_status', $leaf->active_status) }}" required>
                @if($errors->has('active_status'))
                    <span class="text-danger">{{ $errors->first('active_status') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.leaf.fields.active_status_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required">{{ trans('cruds.leaf.fields.leave_cat') }}</label>
                <select class="form-control {{ $errors->has('leave_cat') ? 'is-invalid' : '' }}" name="leave_cat" id="leave_cat" required>
                    <option value disabled {{ old('leave_cat', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Leaf::LEAVE_CAT_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('leave_cat', $leaf->leave_cat) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('leave_cat'))
                    <span class="text-danger">{{ $errors->first('leave_cat') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.leaf.fields.leave_cat_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.leaf.fields.time_period') }}</label>
                <select class="form-control {{ $errors->has('time_period') ? 'is-invalid' : '' }}" name="time_period" id="time_period">
                    <option value disabled {{ old('time_period', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Leaf::TIME_PERIOD_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('time_period', $leaf->time_period) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('time_period'))
                    <span class="text-danger">{{ $errors->first('time_period') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.leaf.fields.time_period_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="created_by_id">{{ trans('cruds.leaf.fields.created_by') }}</label>
                <select class="form-control select2 {{ $errors->has('created_by') ? 'is-invalid' : '' }}" name="created_by_id" id="created_by_id" required>
                    @foreach($created_bies as $id => $entry)
                        <option value="{{ $id }}" {{ (old('created_by_id') ? old('created_by_id') : $leaf->created_by->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('created_by'))
                    <span class="text-danger">{{ $errors->first('created_by') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.leaf.fields.created_by_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="in_lieu_of">{{ trans('cruds.leaf.fields.in_lieu_of') }}</label>
                <input class="form-control date {{ $errors->has('in_lieu_of') ? 'is-invalid' : '' }}" type="text" name="in_lieu_of" id="in_lieu_of" value="{{ old('in_lieu_of', $leaf->in_lieu_of) }}">
                @if($errors->has('in_lieu_of'))
                    <span class="text-danger">{{ $errors->first('in_lieu_of') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.leaf.fields.in_lieu_of_helper') }}</span>
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