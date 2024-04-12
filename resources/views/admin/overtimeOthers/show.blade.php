@extends('layouts.admin')
@section('content')

<div class="card_">
    <div class="card-header_">
        {{ trans('global.show') }} {{ trans('cruds.overtimeOther.title') }}
    </div>

    <div class="card-body_">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.overtime-others.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table  ">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.overtimeOther.fields.id') }}
                        </th>
                        <td>
                            {{ $overtimeOther->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.overtimeOther.fields.employee') }}
                        </th>
                        <td>
                            {{ $overtimeOther->employee->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.overtimeOther.fields.designation') }}
                        </th>
                        <td>
                            {{ $overtimeOther->designation }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.overtimeOther.fields.from') }}
                        </th>
                        <td>
                            {{ $overtimeOther->from }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.overtimeOther.fields.to') }}
                        </th>
                        <td>
                            {{ $overtimeOther->to }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.overtimeOther.fields.count') }}
                        </th>
                        <td>
                            {{ $overtimeOther->count }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.overtimeOther.fields.form') }}
                        </th>
                        <td>
                            {{ $overtimeOther->form->creator ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.overtime-others.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
