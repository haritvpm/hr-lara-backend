@extends('layouts.admin')
@section('content')

<div class="card_">
    <div class="card-header_">
        {{ trans('global.show') }} {{ trans('cruds.officeLocation.title') }}
    </div>

    <div class="card-body_">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.office-locations.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table  ">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.officeLocation.fields.id') }}
                        </th>
                        <td>
                            {{ $officeLocation->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.officeLocation.fields.location') }}
                        </th>
                        <td>
                            {{ $officeLocation->location }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.officeLocation.fields.administrative_office') }}
                        </th>
                        <td>
                            {{ $officeLocation->administrative_office->office_name ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.office-locations.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
