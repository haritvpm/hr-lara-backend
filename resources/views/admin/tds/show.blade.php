@extends('layouts.admin')
@section('content')

<div class="card_">
    <div class="card-header_">
        {{ trans('global.show') }} {{ trans('cruds.td.title') }}
    </div>

    <div class="card-body_">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.tds.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table  ">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.td.fields.id') }}
                        </th>
                        <td>
                            {{ $td->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.td.fields.pan') }}
                        </th>
                        <td>
                            {{ $td->pan }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.td.fields.pen') }}
                        </th>
                        <td>
                            {{ $td->pen }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.td.fields.name') }}
                        </th>
                        <td>
                            {{ $td->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.td.fields.gross') }}
                        </th>
                        <td>
                            {{ $td->gross }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.td.fields.tds') }}
                        </th>
                        <td>
                            {{ $td->tds }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.td.fields.slno') }}
                        </th>
                        <td>
                            {{ $td->slno }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.td.fields.date') }}
                        </th>
                        <td>
                            {{ $td->date->date ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.td.fields.created_by') }}
                        </th>
                        <td>
                            {{ $td->created_by->title ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.td.fields.remarks') }}
                        </th>
                        <td>
                            {{ $td->remarks }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.tds.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
