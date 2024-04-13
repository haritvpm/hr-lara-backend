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
                            {{ trans('cruds.punching.fields.aadhaarid') }}
                        </th>
                        <td>
                            {{ $punching->aadhaarid }}
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
                            {{ trans('cruds.punching.fields.designation') }}
                        </th>
                        <td>
                            {{ $punching->designation }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.punching.fields.section') }}
                        </th>
                        <td>
                            {{ $punching->section }}
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
                    <tr>
                        <th>
                            {{ trans('cruds.punching.fields.in_datetime') }}
                        </th>
                        <td>
                            {{ $punching->in_datetime }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.punching.fields.out_datetime') }}
                        </th>
                        <td>
                            {{ $punching->out_datetime }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.punching.fields.duration_sec') }}
                        </th>
                        <td>
                            {{ $punching->duration_sec }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.punching.fields.grace_sec') }}
                        </th>
                        <td>
                            {{ $punching->grace_sec }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.punching.fields.extra_sec') }}
                        </th>
                        <td>
                            {{ $punching->extra_sec }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.punching.fields.duration_str') }}
                        </th>
                        <td>
                            {{ $punching->duration_str }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.punching.fields.grace_str') }}
                        </th>
                        <td>
                            {{ $punching->grace_str }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.punching.fields.extra_str') }}
                        </th>
                        <td>
                            {{ $punching->extra_str }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.punching.fields.punching_count') }}
                        </th>
                        <td>
                            {{ $punching->punching_count }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.punching.fields.leave') }}
                        </th>
                        <td>
                            {{ $punching->leave->reason ?? '' }}
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
                            {{ trans('cruds.punching.fields.finalized_by_controller') }}
                        </th>
                        <td>
                            {{ $punching->finalized_by_controller }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.punching.fields.ot_sitting_sec') }}
                        </th>
                        <td>
                            {{ $punching->ot_sitting_sec }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.punching.fields.ot_nonsitting_sec') }}
                        </th>
                        <td>
                            {{ $punching->ot_nonsitting_sec }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.punching.fields.hint') }}
                        </th>
                        <td>
                            {{ App\Models\Punching::HINT_SELECT[$punching->hint] ?? '' }}
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