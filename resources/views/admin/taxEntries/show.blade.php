@extends('layouts.admin')
@section('content')

<div class="card_">
    <div class="card-header_">
        {{ trans('global.show') }} {{ trans('cruds.taxEntry.title') }}
    </div>

    <div class="card-body_">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.tax-entries.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table  ">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.taxEntry.fields.id') }}
                        </th>
                        <td>
                            {{ $taxEntry->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.taxEntry.fields.date') }}
                        </th>
                        <td>
                            {{ $taxEntry->date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.taxEntry.fields.status') }}
                        </th>
                        <td>
                            {{ $taxEntry->status }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.taxEntry.fields.acquittance') }}
                        </th>
                        <td>
                            {{ $taxEntry->acquittance }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.taxEntry.fields.created_by') }}
                        </th>
                        <td>
                            {{ $taxEntry->created_by->title ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.taxEntry.fields.sparkcode') }}
                        </th>
                        <td>
                            {{ $taxEntry->sparkcode }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.tax-entries.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

<div class="card_">
    <div class="card-header_">
        {{ trans('global.relatedData') }}
    </div>
    <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
        <li class="nav-item">
            <a class="nav-link" href="#date_tds" role="tab" data-toggle="tab">
                {{ trans('cruds.td.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="date_tds">
            @includeIf('admin.taxEntries.relationships.dateTds', ['tds' => $taxEntry->dateTds])
        </div>
    </div>
</div>

@endsection
