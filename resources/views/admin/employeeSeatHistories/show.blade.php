@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.employeeSeatHistory.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.employee-seat-histories.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.employeeSeatHistory.fields.id') }}
                        </th>
                        <td>
                            {{ $employeeSeatHistory->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.employeeSeatHistory.fields.seat') }}
                        </th>
                        <td>
                            {{ $employeeSeatHistory->seat->title ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.employeeSeatHistory.fields.employee') }}
                        </th>
                        <td>
                            {{ $employeeSeatHistory->employee->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.employeeSeatHistory.fields.start_date') }}
                        </th>
                        <td>
                            {{ $employeeSeatHistory->start_date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.employeeSeatHistory.fields.end_date') }}
                        </th>
                        <td>
                            {{ $employeeSeatHistory->end_date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.employeeSeatHistory.fields.remarks') }}
                        </th>
                        <td>
                            {{ $employeeSeatHistory->remarks }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.employee-seat-histories.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection