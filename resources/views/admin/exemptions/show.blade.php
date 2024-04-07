@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.exemption.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.exemptions.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.exemption.fields.id') }}
                        </th>
                        <td>
                            {{ $exemption->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.exemption.fields.employee') }}
                        </th>
                        <td>
                            {{ $exemption->employee->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.exemption.fields.date_from') }}
                        </th>
                        <td>
                            {{ $exemption->date_from }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.exemption.fields.date_to') }}
                        </th>
                        <td>
                            {{ $exemption->date_to }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.exemption.fields.forwarded_by') }}
                        </th>
                        <td>
                            {{ $exemption->forwarded_by }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.exemption.fields.submitted_to_services') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $exemption->submitted_to_services ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.exemption.fields.session') }}
                        </th>
                        <td>
                            {{ $exemption->session->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.exemption.fields.approval_status') }}
                        </th>
                        <td>
                            {{ $exemption->approval_status }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.exemption.fields.owner') }}
                        </th>
                        <td>
                            {{ $exemption->owner->title ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.exemptions.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection