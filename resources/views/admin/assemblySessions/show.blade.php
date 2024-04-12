@extends('layouts.admin')
@section('content')

<div class="card_">
    <div class="card-header_">
        {{ trans('global.show') }} {{ trans('cruds.assemblySession.title') }}
    </div>

    <div class="card-body_">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.assembly-sessions.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table  ">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.assemblySession.fields.id') }}
                        </th>
                        <td>
                            {{ $assemblySession->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.assemblySession.fields.name') }}
                        </th>
                        <td>
                            {{ $assemblySession->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.assemblySession.fields.kla_number') }}
                        </th>
                        <td>
                            {{ $assemblySession->kla_number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.assemblySession.fields.session_number') }}
                        </th>
                        <td>
                            {{ $assemblySession->session_number }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.assembly-sessions.index') }}">
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
            <a class="nav-link" href="#session_govt_calendars" role="tab" data-toggle="tab">
                {{ trans('cruds.govtCalendar.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="session_govt_calendars">
            @includeIf('admin.assemblySessions.relationships.sessionGovtCalendars', ['govtCalendars' => $assemblySession->sessionGovtCalendars])
        </div>
    </div>
</div>

@endsection
