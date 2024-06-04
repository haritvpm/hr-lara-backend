@extends('layouts.admin')

@section('styles')

<link rel="stylesheet" type="text/css" href="https://fabianlindfors.se/multijs/multi.min.css">

@endsection

@section('content')


<div class="card_">
    <div class="card-header_">
        {{ trans('global.create') }} {{ trans('cruds.exemption.title_singular') }}
    </div>

    <div class="card-body_">
        <form method="POST" action="{{ route("admin.exemptions.storeexemption") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="employee_id">{{ trans('cruds.exemption.fields.employee') }}</label>
                <select multiple="multiple"  name="employees[]" id="employee_id">
                    @foreach($employees as $id => $entry)
                        <option value="{{ $id }}" {{ old('employee_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('employee'))
                    <span class="text-danger">{{ $errors->first('employee') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.exemption.fields.employee_helper') }}</span>
            </div>

            <div class="form-group">
                <label for="session_id">{{ trans('cruds.exemption.fields.session') }}</label>
                <select required class="form-control select2 {{ $errors->has('session') ? 'is-invalid' : '' }}" name="session_id" id="session_id">
                    @foreach($sessions as $id => $entry)
                        <option value="{{ $id }}" {{ old('session_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('session'))
                    <span class="text-danger">{{ $errors->first('session') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.exemption.fields.session_helper') }}</span>
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

@section('scripts')

<script src="https://fabianlindfors.se/multijs/multi.min.js"></script>

<script>

    document.addEventListener('DOMContentLoaded', function() {
        var select = document.getElementById( 'employee_id' );
        multi( select, {
            search_placeholder: 'Search ...',
        });
    });

		</script>

@endsection
