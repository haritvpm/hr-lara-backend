@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.leaf.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.leaves.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.leaf.fields.id') }}
                        </th>
                        <td>
                            {{ $leaf->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.leaf.fields.aadhaarid') }}
                        </th>
                        <td>
                            {{ $leaf->aadhaarid }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.leaf.fields.employee') }}
                        </th>
                        <td>
                            {{ $leaf->employee->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.leaf.fields.leave_type') }}
                        </th>
                        <td>
                            {{ App\Models\Leaf::LEAVE_TYPE_SELECT[$leaf->leave_type] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.leaf.fields.start_date') }}
                        </th>
                        <td>
                            {{ $leaf->start_date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.leaf.fields.end_date') }}
                        </th>
                        <td>
                            {{ $leaf->end_date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.leaf.fields.reason') }}
                        </th>
                        <td>
                            {{ $leaf->reason }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.leaf.fields.active_status') }}
                        </th>
                        <td>
                            {{ $leaf->active_status }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.leaf.fields.leave_cat') }}
                        </th>
                        <td>
                            {{ App\Models\Leaf::LEAVE_CAT_SELECT[$leaf->leave_cat] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.leaf.fields.time_period') }}
                        </th>
                        <td>
                            {{ App\Models\Leaf::TIME_PERIOD_SELECT[$leaf->time_period] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.leaf.fields.in_lieu_of') }}
                        </th>
                        <td>
                            {{ $leaf->in_lieu_of }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.leaf.fields.last_updated') }}
                        </th>
                        <td>
                            {{ $leaf->last_updated }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.leaf.fields.creation_date') }}
                        </th>
                        <td>
                            {{ $leaf->creation_date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.leaf.fields.created_by_aadhaarid') }}
                        </th>
                        <td>
                            {{ $leaf->created_by_aadhaarid }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.leaf.fields.processed') }}
                        </th>
                        <td>
                            {{ $leaf->processed }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.leaf.fields.owner_seat') }}
                        </th>
                        <td>
                            {{ $leaf->owner_seat }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.leaf.fields.remarks') }}
                        </th>
                        <td>
                            {{ $leaf->remarks }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.leaves.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection