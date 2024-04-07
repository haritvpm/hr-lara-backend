@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.administrativeOffice.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.administrative-offices.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.administrativeOffice.fields.id') }}
                        </th>
                        <td>
                            {{ $administrativeOffice->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.administrativeOffice.fields.office_name') }}
                        </th>
                        <td>
                            {{ $administrativeOffice->office_name }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.administrative-offices.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection