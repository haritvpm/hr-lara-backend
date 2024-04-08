@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.officeTimeGroup.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.office-time-groups.update", [$officeTimeGroup->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="groupname">{{ trans('cruds.officeTimeGroup.fields.groupname') }}</label>
                <input class="form-control {{ $errors->has('groupname') ? 'is-invalid' : '' }}" type="text" name="groupname" id="groupname" value="{{ old('groupname', $officeTimeGroup->groupname) }}" required>
                @if($errors->has('groupname'))
                    <span class="text-danger">{{ $errors->first('groupname') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.officeTimeGroup.fields.groupname_helper') }}</span>
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