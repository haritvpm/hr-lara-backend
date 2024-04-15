@extends('layouts.admin')
@section('content')

<div class="card_">
    <div class="card-header_">
        {{ trans('global.show') }} {{ trans('cruds.deptEmployee.title') }}
    </div>

    <div class="card-body_">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.dept-employees.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table  ">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.deptEmployee.fields.id') }}
                        </th>
                        <td>
                            {{ $deptEmployee->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.deptEmployee.fields.srismt') }}
                        </th>
                        <td>
                            {{ App\Models\DeptEmployee::SRISMT_SELECT[$deptEmployee->srismt] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.deptEmployee.fields.name') }}
                        </th>
                        <td>
                            {{ $deptEmployee->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.deptEmployee.fields.pen') }}
                        </th>
                        <td>
                            {{ $deptEmployee->pen }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.deptEmployee.fields.designation') }}
                        </th>
                        <td>
                            {{ $deptEmployee->designation->title ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.dept-employees.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
