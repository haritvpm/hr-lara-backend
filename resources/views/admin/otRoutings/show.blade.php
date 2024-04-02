@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.otRouting.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.ot-routings.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.otRouting.fields.id') }}
                        </th>
                        <td>
                            {{ $otRouting->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.otRouting.fields.seat') }}
                        </th>
                        <td>
                            {{ $otRouting->seat->title ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.otRouting.fields.routing_seats') }}
                        </th>
                        <td>
                            @foreach($otRouting->routing_seats as $key => $routing_seats)
                                <span class="label label-info">{{ $routing_seats->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.otRouting.fields.last_forwarded_to') }}
                        </th>
                        <td>
                            {{ $otRouting->last_forwarded_to }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.ot-routings.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection