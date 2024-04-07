@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.designationWithoutGrade.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.designation-without-grades.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.designationWithoutGrade.fields.id') }}
                        </th>
                        <td>
                            {{ $designationWithoutGrade->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.designationWithoutGrade.fields.title') }}
                        </th>
                        <td>
                            {{ $designationWithoutGrade->title }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.designationWithoutGrade.fields.title_mal') }}
                        </th>
                        <td>
                            {{ $designationWithoutGrade->title_mal }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.designation-without-grades.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection