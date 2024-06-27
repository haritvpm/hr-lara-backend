@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.leaveFormDetail.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.leave-form-details.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.leaveFormDetail.fields.id') }}
                        </th>
                        <td>
                            {{ $leaveFormDetail->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.leaveFormDetail.fields.dob') }}
                        </th>
                        <td>
                            {{ $leaveFormDetail->dob }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.leaveFormDetail.fields.post') }}
                        </th>
                        <td>
                            {{ $leaveFormDetail->post }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.leaveFormDetail.fields.dept') }}
                        </th>
                        <td>
                            {{ $leaveFormDetail->dept }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.leaveFormDetail.fields.pay') }}
                        </th>
                        <td>
                            {{ $leaveFormDetail->pay }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.leaveFormDetail.fields.doe') }}
                        </th>
                        <td>
                            {{ $leaveFormDetail->doe }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.leaveFormDetail.fields.date_of_confirmation') }}
                        </th>
                        <td>
                            {{ $leaveFormDetail->date_of_confirmation }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.leaveFormDetail.fields.address') }}
                        </th>
                        <td>
                            {{ $leaveFormDetail->address }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.leaveFormDetail.fields.hra') }}
                        </th>
                        <td>
                            {{ $leaveFormDetail->hra }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.leaveFormDetail.fields.nature') }}
                        </th>
                        <td>
                            {{ $leaveFormDetail->nature }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.leaveFormDetail.fields.prefix') }}
                        </th>
                        <td>
                            {{ $leaveFormDetail->prefix }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.leaveFormDetail.fields.suffix') }}
                        </th>
                        <td>
                            {{ $leaveFormDetail->suffix }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.leaveFormDetail.fields.last_leave_info') }}
                        </th>
                        <td>
                            {{ $leaveFormDetail->last_leave_info }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.leaveFormDetail.fields.leave') }}
                        </th>
                        <td>
                            {{ $leaveFormDetail->leave->leave_type ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.leave-form-details.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection