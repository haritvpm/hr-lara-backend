@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.overtimeSitting.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.overtime-sittings.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.overtimeSitting.fields.id') }}
                        </th>
                        <td>
                            {{ $overtimeSitting->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.overtimeSitting.fields.date') }}
                        </th>
                        <td>
                            {{ $overtimeSitting->date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.overtimeSitting.fields.checked') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $overtimeSitting->checked ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.overtimeSitting.fields.overtime') }}
                        </th>
                        <td>
                            {{ $overtimeSitting->overtime->slots ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.overtime-sittings.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection