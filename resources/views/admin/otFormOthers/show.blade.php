@extends('layouts.admin')
@section('content')

<div class="card_">
    <div class="card-header_">
        {{ trans('global.show') }} {{ trans('cruds.otFormOther.title') }}
    </div>

    <div class="card-body_">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.ot-form-others.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table  ">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.otFormOther.fields.id') }}
                        </th>
                        <td>
                            {{ $otFormOther->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.otFormOther.fields.creator') }}
                        </th>
                        <td>
                            {{ $otFormOther->creator }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.otFormOther.fields.owner') }}
                        </th>
                        <td>
                            {{ $otFormOther->owner }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.otFormOther.fields.session') }}
                        </th>
                        <td>
                            {{ $otFormOther->session->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.otFormOther.fields.submitted_by') }}
                        </th>
                        <td>
                            {{ $otFormOther->submitted_by }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.otFormOther.fields.submitted_on') }}
                        </th>
                        <td>
                            {{ $otFormOther->submitted_on }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.otFormOther.fields.form_no') }}
                        </th>
                        <td>
                            {{ $otFormOther->form_no }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.otFormOther.fields.duty_date') }}
                        </th>
                        <td>
                            {{ $otFormOther->duty_date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.otFormOther.fields.date_from') }}
                        </th>
                        <td>
                            {{ $otFormOther->date_from }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.otFormOther.fields.date_to') }}
                        </th>
                        <td>
                            {{ $otFormOther->date_to }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.otFormOther.fields.remarks') }}
                        </th>
                        <td>
                            {{ $otFormOther->remarks }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.otFormOther.fields.overtime_slot') }}
                        </th>
                        <td>
                            {{ App\Models\OtFormOther::OVERTIME_SLOT_SELECT[$otFormOther->overtime_slot] ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.ot-form-others.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
