@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.leaf.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.leaves.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="aadhaarid">{{ trans('cruds.leaf.fields.aadhaarid') }}</label>
                <input class="form-control {{ $errors->has('aadhaarid') ? 'is-invalid' : '' }}" type="text" name="aadhaarid" id="aadhaarid" value="{{ old('aadhaarid', '') }}" required>
                @if($errors->has('aadhaarid'))
                    <span class="text-danger">{{ $errors->first('aadhaarid') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.leaf.fields.aadhaarid_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="employee_id">{{ trans('cruds.leaf.fields.employee') }}</label>
                <select class="form-control select2 {{ $errors->has('employee') ? 'is-invalid' : '' }}" name="employee_id" id="employee_id" required>
                    @foreach($employees as $id => $entry)
                        <option value="{{ $id }}" {{ old('employee_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
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
                        <option value="{{ $key }}" {{ old('leave_type', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('leave_type'))
                    <span class="text-danger">{{ $errors->first('leave_type') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.leaf.fields.leave_type_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="start_date">{{ trans('cruds.leaf.fields.start_date') }}</label>
                <input class="form-control date {{ $errors->has('start_date') ? 'is-invalid' : '' }}" type="text" name="start_date" id="start_date" value="{{ old('start_date') }}" required>
                @if($errors->has('start_date'))
                    <span class="text-danger">{{ $errors->first('start_date') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.leaf.fields.start_date_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="end_date">{{ trans('cruds.leaf.fields.end_date') }}</label>
                <input class="form-control date {{ $errors->has('end_date') ? 'is-invalid' : '' }}" type="text" name="end_date" id="end_date" value="{{ old('end_date') }}" required>
                @if($errors->has('end_date'))
                    <span class="text-danger">{{ $errors->first('end_date') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.leaf.fields.end_date_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="reason">{{ trans('cruds.leaf.fields.reason') }}</label>
                <input class="form-control {{ $errors->has('reason') ? 'is-invalid' : '' }}" type="text" name="reason" id="reason" value="{{ old('reason', '') }}">
                @if($errors->has('reason'))
                    <span class="text-danger">{{ $errors->first('reason') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.leaf.fields.reason_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="active_status">{{ trans('cruds.leaf.fields.active_status') }}</label>
                <input class="form-control {{ $errors->has('active_status') ? 'is-invalid' : '' }}" type="text" name="active_status" id="active_status" value="{{ old('active_status', '') }}" required>
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
                        <option value="{{ $key }}" {{ old('leave_cat', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
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
                        <option value="{{ $key }}" {{ old('time_period', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('time_period'))
                    <span class="text-danger">{{ $errors->first('time_period') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.leaf.fields.time_period_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="in_lieu_of">{{ trans('cruds.leaf.fields.in_lieu_of') }}</label>
                <input class="form-control date {{ $errors->has('in_lieu_of') ? 'is-invalid' : '' }}" type="text" name="in_lieu_of" id="in_lieu_of" value="{{ old('in_lieu_of') }}">
                @if($errors->has('in_lieu_of'))
                    <span class="text-danger">{{ $errors->first('in_lieu_of') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.leaf.fields.in_lieu_of_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="last_updated">{{ trans('cruds.leaf.fields.last_updated') }}</label>
                <input class="form-control datetime {{ $errors->has('last_updated') ? 'is-invalid' : '' }}" type="text" name="last_updated" id="last_updated" value="{{ old('last_updated') }}">
                @if($errors->has('last_updated'))
                    <span class="text-danger">{{ $errors->first('last_updated') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.leaf.fields.last_updated_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="creation_date">{{ trans('cruds.leaf.fields.creation_date') }}</label>
                <input class="form-control datetime {{ $errors->has('creation_date') ? 'is-invalid' : '' }}" type="text" name="creation_date" id="creation_date" value="{{ old('creation_date') }}">
                @if($errors->has('creation_date'))
                    <span class="text-danger">{{ $errors->first('creation_date') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.leaf.fields.creation_date_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="created_by_aadhaarid">{{ trans('cruds.leaf.fields.created_by_aadhaarid') }}</label>
                <input class="form-control {{ $errors->has('created_by_aadhaarid') ? 'is-invalid' : '' }}" type="text" name="created_by_aadhaarid" id="created_by_aadhaarid" value="{{ old('created_by_aadhaarid', '') }}">
                @if($errors->has('created_by_aadhaarid'))
                    <span class="text-danger">{{ $errors->first('created_by_aadhaarid') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.leaf.fields.created_by_aadhaarid_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="processed">{{ trans('cruds.leaf.fields.processed') }}</label>
                <input class="form-control {{ $errors->has('processed') ? 'is-invalid' : '' }}" type="number" name="processed" id="processed" value="{{ old('processed', '') }}" step="1">
                @if($errors->has('processed'))
                    <span class="text-danger">{{ $errors->first('processed') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.leaf.fields.processed_helper') }}</span>
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