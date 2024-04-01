@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.otForm.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.ot-forms.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.otForm.fields.id') }}
                        </th>
                        <td>
                            {{ $otForm->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.otForm.fields.creator') }}
                        </th>
                        <td>
                            {{ $otForm->creator }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.otForm.fields.owner') }}
                        </th>
                        <td>
                            {{ $otForm->owner }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.otForm.fields.session') }}
                        </th>
                        <td>
                            {{ $otForm->session->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.otForm.fields.submitted_by') }}
                        </th>
                        <td>
                            {{ $otForm->submitted_by }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.otForm.fields.submitted_names') }}
                        </th>
                        <td>
                            {{ $otForm->submitted_names }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.otForm.fields.submitted_on') }}
                        </th>
                        <td>
                            {{ $otForm->submitted_on }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.otForm.fields.form_no') }}
                        </th>
                        <td>
                            {{ $otForm->form_no }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.otForm.fields.duty_date') }}
                        </th>
                        <td>
                            {{ $otForm->duty_date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.otForm.fields.date_from') }}
                        </th>
                        <td>
                            {{ $otForm->date_from }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.otForm.fields.date_to') }}
                        </th>
                        <td>
                            {{ $otForm->date_to }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.otForm.fields.remarks') }}
                        </th>
                        <td>
                            {{ $otForm->remarks }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.otForm.fields.worknature') }}
                        </th>
                        <td>
                            {{ $otForm->worknature }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.ot-forms.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection