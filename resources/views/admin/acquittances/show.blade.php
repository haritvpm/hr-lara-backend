@extends('layouts.admin')
@section('content')

<div class="card_">
    <div class="card-header_">
        {{ trans('global.show') }} {{ trans('cruds.acquittance.title') }}
    </div>

    <div class="card-body_">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.acquittances.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table  ">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.acquittance.fields.id') }}
                        </th>
                        <td>
                            {{ $acquittance->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.acquittance.fields.title') }}
                        </th>
                        <td>
                            {{ $acquittance->title }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.acquittance.fields.office') }}
                        </th>
                        <td>
                            {{ $acquittance->office->office_name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.acquittance.fields.ddo') }}
                        </th>
                        <td>
                            {{ $acquittance->ddo->code ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.acquittances.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
