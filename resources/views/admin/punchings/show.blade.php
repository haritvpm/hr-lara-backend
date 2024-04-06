@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.punching.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.punchings.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.punching.fields.id') }}
                        </th>
                        <td>
                            {{ $punching->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.punching.fields.date') }}
                        </th>
                        <td>
                            {{ $punching->date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.punching.fields.employee') }}
                        </th>
                        <td>
                            {{ $punching->employee->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.punching.fields.duration') }}
                        </th>
                        <td>
                            {{ $punching->duration }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.punching.fields.flexi') }}
                        </th>
                        <td>
                            {{ App\Models\Punching::FLEXI_SELECT[$punching->flexi] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.punching.fields.designation') }}
                        </th>
                        <td>
                            {{ $punching->designation }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.punching.fields.grace') }}
                        </th>
                        <td>
                            {{ $punching->grace }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.punching.fields.extra') }}
                        </th>
                        <td>
                            {{ $punching->extra }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.punching.fields.remarks') }}
                        </th>
                        <td>
                            {{ $punching->remarks }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.punching.fields.calc_complete') }}
                        </th>
                        <td>
                            {{ $punching->calc_complete }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.punching.fields.punchin_trace') }}
                        </th>
                        <td>
                            {{ $punching->punchin_trace->att_time ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.punching.fields.punchout_trace') }}
                        </th>
                        <td>
                            {{ $punching->punchout_trace->att_time ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.punchings.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection