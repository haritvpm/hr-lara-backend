@extends('layouts.admin')
@section('content')

<div class="card_">
    <div class="card-header_">
        {{ trans('global.create') }} {{ trans('cruds.administrativeOffice.title_singular') }}
    </div>

    <div class="card-body_">
        <form method="POST" action="{{ route("admin.administrative-offices.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="office_name">{{ trans('cruds.administrativeOffice.fields.office_name') }}</label>
                <input class="form-control {{ $errors->has('office_name') ? 'is-invalid' : '' }}" type="text" name="office_name" id="office_name" value="{{ old('office_name', '') }}" required>
                @if($errors->has('office_name'))
                    <span class="text-danger">{{ $errors->first('office_name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.administrativeOffice.fields.office_name_helper') }}</span>
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
