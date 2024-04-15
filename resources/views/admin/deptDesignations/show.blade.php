@extends('layouts.admin')
@section('content')

<div class="card_">
    <div class="card-header_">
        {{ trans('global.show') }} {{ trans('cruds.deptDesignation.title') }}
    </div>

    <div class="card-body_">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.dept-designations.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table  ">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.deptDesignation.fields.id') }}
                        </th>
                        <td>
                            {{ $deptDesignation->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.deptDesignation.fields.title') }}
                        </th>
                        <td>
                            {{ $deptDesignation->title }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.deptDesignation.fields.max_persons') }}
                        </th>
                        <td>
                            {{ $deptDesignation->max_persons }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.deptDesignation.fields.user') }}
                        </th>
                        <td>
                            {{ $deptDesignation->user->username ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.dept-designations.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
