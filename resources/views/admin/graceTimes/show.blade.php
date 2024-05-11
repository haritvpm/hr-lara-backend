@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.graceTime.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.grace-times.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.graceTime.fields.id') }}
                        </th>
                        <td>
                            {{ $graceTime->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.graceTime.fields.title') }}
                        </th>
                        <td>
                            {{ $graceTime->title }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.graceTime.fields.minutes') }}
                        </th>
                        <td>
                            {{ $graceTime->minutes }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.graceTime.fields.with_effect_from') }}
                        </th>
                        <td>
                            {{ $graceTime->with_effect_from }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.grace-times.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection