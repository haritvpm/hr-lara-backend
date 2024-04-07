@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.seatToJsAsSs.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.seat-to-js-as-sses.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.seatToJsAsSs.fields.id') }}
                        </th>
                        <td>
                            {{ $seatToJsAsSs->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.seatToJsAsSs.fields.seat') }}
                        </th>
                        <td>
                            {{ $seatToJsAsSs->seat->title ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.seatToJsAsSs.fields.employee') }}
                        </th>
                        <td>
                            {{ $seatToJsAsSs->employee->name ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.seat-to-js-as-sses.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection