@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.designation.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.designations.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.designation.fields.id') }}
                        </th>
                        <td>
                            {{ $designation->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.designation.fields.designation') }}
                        </th>
                        <td>
                            {{ $designation->designation }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.designation.fields.designation_mal') }}
                        </th>
                        <td>
                            {{ $designation->designation_mal }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.designation.fields.sort_index') }}
                        </th>
                        <td>
                            {{ $designation->sort_index }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.designation.fields.has_punching') }}
                        </th>
                        <td>
                            {{ $designation->has_punching }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.designation.fields.normal_office_hours') }}
                        </th>
                        <td>
                            {{ $designation->normal_office_hours }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.designation.fields.desig_line') }}
                        </th>
                        <td>
                            {{ $designation->desig_line->title ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.designations.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection