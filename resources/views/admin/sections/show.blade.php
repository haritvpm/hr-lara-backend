@extends('layouts.admin')
@section('content')

<div class="card_">
    <div class="card-header_">
        {{ trans('global.show') }} {{ trans('cruds.section.title') }}
    </div>

    <div class="card-body_">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.sections.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table  ">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.section.fields.id') }}
                        </th>
                        <td>
                            {{ $section->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.section.fields.name') }}
                        </th>
                        <td>
                            {{ $section->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.section.fields.short_code') }}
                        </th>
                        <td>
                            {{ $section->short_code }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.section.fields.seat_of_controlling_officer') }}
                        </th>
                        <td>
                            {{ $section->seat_of_controlling_officer->title ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.section.fields.office_location') }}
                        </th>
                        <td>
                            {{ $section->office_location->location ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.section.fields.seat_of_reporting_officer') }}
                        </th>
                        <td>
                            {{ $section->seat_of_reporting_officer->title ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.section.fields.js_as_ss_employee') }}
                        </th>
                        <td>
                            {{ $section->js_as_ss_employee->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.section.fields.type') }}
                        </th>
                        <td>
                            {{ App\Models\Section::TYPE_SELECT[$section->type] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.section.fields.works_nights_during_session') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $section->works_nights_during_session ? 'checked' : '' }}>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.sections.index') }}">
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
            <a class="nav-link" href="#section_attendance_books" role="tab" data-toggle="tab">
                {{ trans('cruds.attendanceBook.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="section_attendance_books">
            @includeIf('admin.sections.relationships.sectionAttendanceBooks', ['attendanceBooks' => $section->sectionAttendanceBooks])
        </div>
    </div>
</div>

@endsection
