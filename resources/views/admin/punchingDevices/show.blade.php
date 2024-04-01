@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.punchingDevice.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.punching-devices.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.punchingDevice.fields.id') }}
                        </th>
                        <td>
                            {{ $punchingDevice->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.punchingDevice.fields.device') }}
                        </th>
                        <td>
                            {{ $punchingDevice->device }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.punchingDevice.fields.loc_name') }}
                        </th>
                        <td>
                            {{ $punchingDevice->loc_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.punchingDevice.fields.entry_name') }}
                        </th>
                        <td>
                            {{ $punchingDevice->entry_name }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.punching-devices.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection