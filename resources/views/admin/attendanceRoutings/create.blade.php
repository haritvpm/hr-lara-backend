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
                <label for="viewer_js_as_ss_employee_id">{{ trans('cruds.attendanceRouting.fields.viewer_js_as_ss_employee') }}</label>
                <select class="form-control select2 {{ $errors->has('viewer_js_as_ss_employee') ? 'is-invalid' : '' }}" name="viewer_js_as_ss_employee_id" id="viewer_js_as_ss_employee_id">
                    @foreach($viewer_js_as_ss_employees as $id => $entry)
                        <option value="{{ $id }}" {{ old('viewer_js_as_ss_employee_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('viewer_js_as_ss_employee'))
                    <span class="text-danger">{{ $errors->first('viewer_js_as_ss_employee') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.attendanceRouting.fields.viewer_js_as_ss_employee_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="viewer_seat_id">{{ trans('cruds.attendanceRouting.fields.viewer_seat') }}</label>
                <select class="form-control select2 {{ $errors->has('viewer_seat') ? 'is-invalid' : '' }}" name="viewer_seat_id" id="viewer_seat_id">
                    @foreach($viewer_seats as $id => $entry)
                        <option value="{{ $id }}" {{ old('viewer_seat_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('viewer_seat'))
                    <span class="text-danger">{{ $errors->first('viewer_seat') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.attendanceRouting.fields.viewer_seat_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="viewable_seats">{{ trans('cruds.attendanceRouting.fields.viewable_seats') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('viewable_seats') ? 'is-invalid' : '' }}" name="viewable_seats[]" id="viewable_seats" multiple>
                    @foreach($viewable_seats as $id => $viewable_seat)
                        <option value="{{ $id }}" {{ in_array($id, old('viewable_seats', [])) ? 'selected' : '' }}>{{ $viewable_seat }}</option>
                    @endforeach
                </select>
                @if($errors->has('viewable_seats'))
                    <span class="text-danger">{{ $errors->first('viewable_seats') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.attendanceRouting.fields.viewable_seats_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="viewable_js_as_ss_employees">{{ trans('cruds.attendanceRouting.fields.viewable_js_as_ss_employees') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('viewable_js_as_ss_employees') ? 'is-invalid' : '' }}" name="viewable_js_as_ss_employees[]" id="viewable_js_as_ss_employees" multiple>
                    @foreach($viewable_js_as_ss_employees as $id => $viewable_js_as_ss_employee)
                        <option value="{{ $id }}" {{ in_array($id, old('viewable_js_as_ss_employees', [])) ? 'selected' : '' }}>{{ $viewable_js_as_ss_employee }}</option>
                    @endforeach
                </select>
                @if($errors->has('viewable_js_as_ss_employees'))
                    <span class="text-danger">{{ $errors->first('viewable_js_as_ss_employees') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.attendanceRouting.fields.viewable_js_as_ss_employees_helper') }}</span>
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