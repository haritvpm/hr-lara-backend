@extends('layouts.admin')
@section('content')

<div class="card_">
    <div class="card-header_">
        {{ trans('global.show') }} {{ trans('cruds.seat.title') }}
    </div>

    <div class="card-body_">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.seats.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table  ">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.seat.fields.id') }}
                        </th>
                        <td>
                            {{ $seat->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.seat.fields.slug') }}
                        </th>
                        <td>
                            {{ $seat->slug }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.seat.fields.title') }}
                        </th>
                        <td>
                            {{ $seat->title }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.seat.fields.has_files') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $seat->has_files ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.seat.fields.has_office_with_employees') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $seat->has_office_with_employees ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.seat.fields.is_js_as_ss') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $seat->is_js_as_ss ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.seat.fields.is_controlling_officer') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $seat->is_controlling_officer ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.seat.fields.level') }}
                        </th>
                        <td>
                            {{ $seat->level }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.seats.index') }}">
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
            <a class="nav-link" href="#created_by_tax_entries" role="tab" data-toggle="tab">
                {{ trans('cruds.taxEntry.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#to_seats_ot_routings" role="tab" data-toggle="tab">
                {{ trans('cruds.otRouting.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="created_by_tax_entries">
            @includeIf('admin.seats.relationships.createdByTaxEntries', ['taxEntries' => $seat->createdByTaxEntries])
        </div>
        <div class="tab-pane" role="tabpanel" id="to_seats_ot_routings">
            @includeIf('admin.seats.relationships.toSeatsOtRoutings', ['otRoutings' => $seat->toSeatsOtRoutings])
        </div>
    </div>
</div>

@endsection
