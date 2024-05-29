@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.leaveGroup.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.leave-groups.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.leaveGroup.fields.id') }}
                        </th>
                        <td>
                            {{ $leaveGroup->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.leaveGroup.fields.groupname') }}
                        </th>
                        <td>
                            {{ $leaveGroup->groupname }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.leaveGroup.fields.allowed_casual_per_year') }}
                        </th>
                        <td>
                            {{ $leaveGroup->allowed_casual_per_year }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.leaveGroup.fields.allowed_compen_per_year') }}
                        </th>
                        <td>
                            {{ $leaveGroup->allowed_compen_per_year }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.leaveGroup.fields.allowed_special_casual_per_year') }}
                        </th>
                        <td>
                            {{ $leaveGroup->allowed_special_casual_per_year }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.leaveGroup.fields.allowed_earned_per_year') }}
                        </th>
                        <td>
                            {{ $leaveGroup->allowed_earned_per_year }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.leaveGroup.fields.allowed_halfpay_per_year') }}
                        </th>
                        <td>
                            {{ $leaveGroup->allowed_halfpay_per_year }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.leaveGroup.fields.allowed_continuous_casual_and_compen') }}
                        </th>
                        <td>
                            {{ $leaveGroup->allowed_continuous_casual_and_compen }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.leave-groups.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection