@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.ddo.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.ddos.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.ddo.fields.id') }}
                        </th>
                        <td>
                            {{ $ddo->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.ddo.fields.code') }}
                        </th>
                        <td>
                            {{ $ddo->code }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.ddo.fields.office') }}
                        </th>
                        <td>
                            {{ $ddo->office->office_name ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.ddos.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection