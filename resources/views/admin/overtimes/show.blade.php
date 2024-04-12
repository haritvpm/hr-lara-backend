@extends('layouts.admin')
@section('content')

<div class="card_">
    <div class="card-header_">
        {{ trans('global.show') }} {{ trans('cruds.overtime.title') }}
    </div>

    <div class="card-body_">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.overtimes.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table  ">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.overtime.fields.id') }}
                        </th>
                        <td>
                            {{ $overtime->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.overtime.fields.employee') }}
                        </th>
                        <td>
                            {{ $overtime->employee->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.overtime.fields.designation') }}
                        </th>
                        <td>
                            {{ $overtime->designation }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.overtime.fields.from') }}
                        </th>
                        <td>
                            {{ $overtime->from }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.overtime.fields.to') }}
                        </th>
                        <td>
                            {{ $overtime->to }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.overtime.fields.count') }}
                        </th>
                        <td>
                            {{ $overtime->count }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.overtime.fields.form') }}
                        </th>
                        <td>
                            {{ $overtime->form->creator ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.overtime.fields.punchin') }}
                        </th>
                        <td>
                            {{ $overtime->punchin->att_date ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.overtime.fields.punchout') }}
                        </th>
                        <td>
                            {{ $overtime->punchout->att_date ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.overtime.fields.slots') }}
                        </th>
                        <td>
                            {{ $overtime->slots }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.overtime.fields.has_punching') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $overtime->has_punching ? 'checked' : '' }}>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.overtimes.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
