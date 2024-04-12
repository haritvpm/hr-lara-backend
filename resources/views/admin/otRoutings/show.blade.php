@extends('layouts.admin')
@section('content')

<div class="card_">
    <div class="card-header_">
        {{ trans('global.show') }} {{ trans('cruds.otRouting.title') }}
    </div>

    <div class="card-body_">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.ot-routings.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table  ">
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
                            {{ trans('cruds.otRouting.fields.from_seat') }}
                        </th>
                        <td>
                            {{ $otRouting->from_seat->title ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.otRouting.fields.to_seats') }}
                        </th>
                        <td>
                            @foreach($otRouting->to_seats as $key => $to_seats)
                                <span class="label label-info">{{ $to_seats->title }}</span>
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
                    <tr>
                        <th>
                            {{ trans('cruds.otRouting.fields.js_as_ss') }}
                        </th>
                        <td>
                            {{ $otRouting->js_as_ss->name ?? '' }}
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
