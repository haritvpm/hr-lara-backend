@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.successPunching.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.success-punchings.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.successPunching.fields.id') }}
                        </th>
                        <td>
                            {{ $successPunching->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.successPunching.fields.date') }}
                        </th>
                        <td>
                            {{ $successPunching->date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.successPunching.fields.punch_in') }}
                        </th>
                        <td>
                            {{ $successPunching->punch_in }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.successPunching.fields.punch_out') }}
                        </th>
                        <td>
                            {{ $successPunching->punch_out }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.successPunching.fields.pen') }}
                        </th>
                        <td>
                            {{ $successPunching->pen }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.successPunching.fields.name') }}
                        </th>
                        <td>
                            {{ $successPunching->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.successPunching.fields.in_device') }}
                        </th>
                        <td>
                            {{ $successPunching->in_device }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.successPunching.fields.in_time') }}
                        </th>
                        <td>
                            {{ $successPunching->in_time }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.successPunching.fields.out_device') }}
                        </th>
                        <td>
                            {{ $successPunching->out_device }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.successPunching.fields.out_time') }}
                        </th>
                        <td>
                            {{ $successPunching->out_time }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.successPunching.fields.at_type') }}
                        </th>
                        <td>
                            {{ $successPunching->at_type }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.successPunching.fields.duration') }}
                        </th>
                        <td>
                            {{ $successPunching->duration }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.successPunching.fields.aadhaarid') }}
                        </th>
                        <td>
                            {{ $successPunching->aadhaarid }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.success-punchings.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection