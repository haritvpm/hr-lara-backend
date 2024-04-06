@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.employeeSectionHistory.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.employee-section-histories.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.employeeSectionHistory.fields.id') }}
                        </th>
                        <td>
                            {{ $employeeSectionHistory->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.employeeSectionHistory.fields.employee') }}
                        </th>
                        <td>
                            {{ $employeeSectionHistory->employee->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.employeeSectionHistory.fields.date_from') }}
                        </th>
                        <td>
                            {{ $employeeSectionHistory->date_from }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.employeeSectionHistory.fields.date_to') }}
                        </th>
                        <td>
                            {{ $employeeSectionHistory->date_to }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.employeeSectionHistory.fields.section_seat') }}
                        </th>
                        <td>
                            {{ $employeeSectionHistory->section_seat->title ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.employeeSectionHistory.fields.remarks') }}
                        </th>
                        <td>
                            {{ $employeeSectionHistory->remarks }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.employee-section-histories.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection