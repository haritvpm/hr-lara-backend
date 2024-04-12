@extends('layouts.admin')
@section('content')

<div class="card_">
    <div class="card-header_">
        {{ trans('cruds.govtCalendar.title_singular') }} {{ trans('global.list') }}
    </div>

    <form action="{{url('admin/govt-calendars/fetchmonth')}}" method="post" id="filter" class="form-inline">
      @csrf
      <button type="submit" class="btn btn-primary">FetchMonth</button>

      </form>


    <div class="card-body_">
        <div class="table-responsive_">
            <table class=" table   table-hover datatable datatable-GovtCalendar">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.govtCalendar.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.govtCalendar.fields.date') }}
                        </th>
                        <th>
                            {{ trans('cruds.govtCalendar.fields.govtholidaystatus') }}
                        </th>
                        <th>
                            {{ trans('cruds.govtCalendar.fields.success_attendance_lastfetchtime') }}
                        </th>
                        <th>
                            {{ trans('cruds.govtCalendar.fields.success_attendance_rows_fetched') }}
                        </th>
                        <th>
                            {{ trans('cruds.govtCalendar.fields.attendancetodaytrace_lastfetchtime') }}
                        </th>
                        <th>
                            {{ trans('cruds.govtCalendar.fields.attendance_today_trace_rows_fetched') }}
                        </th>
                        <th>
                            {{ trans('cruds.govtCalendar.fields.is_sitting_day') }}
                        </th>
                        <th>
                            {{ trans('cruds.govtCalendar.fields.session') }}
                        </th>
                        <th>
                            {{ trans('cruds.govtCalendar.fields.office_ends_at_time') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($govtCalendars as $key => $govtCalendar)
                        <tr data-entry-id="{{ $govtCalendar->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $govtCalendar->id ?? '' }}
                            </td>
                            <td>
                                @if($govtCalendar->govtholidaystatus==1)
                                <span class="badge badge-danger">{{ $govtCalendar->date ?? '' }}</span>

                                @else
                                {{ $govtCalendar->date ?? '' }}
                                @endif
                            </td>
                            <td>
                                {{ $govtCalendar->govtholidaystatus ?? '' }}
                            </td>
                            <td>
                                {{ $govtCalendar->success_attendance_lastfetchtime ?? '' }}
                            </td>
                            <td>
                                {{ $govtCalendar->success_attendance_rows_fetched ?? '' }}
                            </td>
                            <td>
                                {{ $govtCalendar->attendancetodaytrace_lastfetchtime ?? '' }}
                            </td>
                            <td>
                                {{ $govtCalendar->attendance_today_trace_rows_fetched ?? '' }}
                            </td>
                            <td>
                                <span style="display:none">{{ $govtCalendar->is_sitting_day ?? '' }}</span>
                                <input type="checkbox" disabled="disabled" {{ $govtCalendar->is_sitting_day ? 'checked' : '' }}>
                            </td>
                            <td>
                                {{ $govtCalendar->session->name ?? '' }}
                            </td>
                            <td>
                                {{ $govtCalendar->office_ends_at_time ?? '' }}
                            </td>
                            <td>
                                @can('govt_calendar_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.govt-calendars.show', $govtCalendar->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                <a href="{{ route('admin.govt-calendars.fetch',['date'=> $govtCalendar->date ]) }}"  class="btn btn-sm btn-danger">Fetch</a>
                                <a href="{{ route('admin.govt-calendars.calculate',['date'=> $govtCalendar->date ]) }}"  class="btn btn-sm btn-info">calculate</a>

                                @can('govt_calendar_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.govt-calendars.edit', $govtCalendar->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan


                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>



@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)

  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-GovtCalendar:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

})

</script>
@endsection
