@extends('layouts.admin')
@section('content')

<div class="card_">
    <div class="card-header_">
        {{ trans('global.show') }} {{ trans('cruds.designation.title') }}
    </div>

    <div class="card-body_">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.designations.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table  ">
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
                            {{ trans('cruds.designation.fields.default_time_group') }}
                        </th>
                        <td>
                            {{ $designation->default_time_group->groupname ?? '' }}
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
                            {{ trans('cruds.designation.fields.designation_without_grade') }}
                        </th>
                        <td>
                            {{ $designation->designation_without_grade }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.designation.fields.designation_without_grade_mal') }}
                        </th>
                        <td>
                            {{ $designation->designation_without_grade_mal }}
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
