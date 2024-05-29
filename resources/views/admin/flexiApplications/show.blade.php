@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.flexiApplication.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.flexi-applications.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.flexiApplication.fields.id') }}
                        </th>
                        <td>
                            {{ $flexiApplication->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.flexiApplication.fields.employee') }}
                        </th>
                        <td>
                            {{ $flexiApplication->employee->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.flexiApplication.fields.aadhaarid') }}
                        </th>
                        <td>
                            {{ $flexiApplication->aadhaarid }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.flexiApplication.fields.flexi_minutes') }}
                        </th>
                        <td>
                            {{ $flexiApplication->flexi_minutes }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.flexiApplication.fields.with_effect_from') }}
                        </th>
                        <td>
                            {{ $flexiApplication->with_effect_from }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.flexiApplication.fields.owner_seat') }}
                        </th>
                        <td>
                            {{ $flexiApplication->owner_seat }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.flexiApplication.fields.approved_by') }}
                        </th>
                        <td>
                            {{ $flexiApplication->approved_by }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.flexiApplication.fields.approved_on') }}
                        </th>
                        <td>
                            {{ $flexiApplication->approved_on }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.flexi-applications.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection