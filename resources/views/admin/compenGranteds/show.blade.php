@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.compenGranted.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.compen-granteds.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.compenGranted.fields.id') }}
                        </th>
                        <td>
                            {{ $compenGranted->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.compenGranted.fields.aadhaarid') }}
                        </th>
                        <td>
                            {{ $compenGranted->aadhaarid }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.compenGranted.fields.date_of_work') }}
                        </th>
                        <td>
                            {{ $compenGranted->date_of_work }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.compenGranted.fields.is_for_extra_hours') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $compenGranted->is_for_extra_hours ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.compenGranted.fields.employee') }}
                        </th>
                        <td>
                            {{ $compenGranted->employee->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.compenGranted.fields.leave') }}
                        </th>
                        <td>
                            {{ $compenGranted->leave->start_date ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.compen-granteds.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection