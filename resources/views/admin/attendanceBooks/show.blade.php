@extends('layouts.admin')
@section('content')

<div class="card_">
    <div class="card-header_">
        {{ trans('global.show') }} {{ trans('cruds.attendanceBook.title') }}
    </div>

    <div class="card-body_">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.attendance-books.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table  ">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.attendanceBook.fields.id') }}
                        </th>
                        <td>
                            {{ $attendanceBook->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.attendanceBook.fields.title') }}
                        </th>
                        <td>
                            {{ $attendanceBook->title }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.attendanceBook.fields.section') }}
                        </th>
                        <td>
                            {{ $attendanceBook->section->name ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.attendance-books.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
