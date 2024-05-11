@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.officeTime.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.office-times.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.officeTime.fields.id') }}
                        </th>
                        <td>
                            {{ $officeTime->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.officeTime.fields.groupname') }}
                        </th>
                        <td>
                            {{ $officeTime->groupname }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.officeTime.fields.description') }}
                        </th>
                        <td>
                            {{ $officeTime->description }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.officeTime.fields.fn_from') }}
                        </th>
                        <td>
                            {{ $officeTime->fn_from }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.officeTime.fields.fn_to') }}
                        </th>
                        <td>
                            {{ $officeTime->fn_to }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.officeTime.fields.an_from') }}
                        </th>
                        <td>
                            {{ $officeTime->an_from }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.officeTime.fields.an_to') }}
                        </th>
                        <td>
                            {{ $officeTime->an_to }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.officeTime.fields.flexi_minutes') }}
                        </th>
                        <td>
                            {{ $officeTime->flexi_minutes }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.officeTime.fields.with_effect_from') }}
                        </th>
                        <td>
                            {{ $officeTime->with_effect_from }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.office-times.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection