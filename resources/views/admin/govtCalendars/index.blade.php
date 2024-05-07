@extends('layouts.admin')
@section('content')

<div class="card_">
    <div class="card-header_">
        {{ trans('cruds.govtCalendar.title_singular') }} {{ trans('global.list') }}
    </div>

    <form action="{{url('admin/govt-calendars/fetchmonth')}}" method="post" id="filter" class="form-inline">
      @csrf
      <button type="submit" class="btn btn-primary">CreateDates</button>

      </form>


    <div class="card-body_">
        <div class="table-responsive_">
            <table class=" table table-sm  table-hover datatable datatable-GovtCalendar">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <!-- <th>
                            {{ trans('cruds.govtCalendar.fields.id') }}
                        </th> -->
                        <th>
                            {{ trans('cruds.govtCalendar.fields.date') }}
                        </th>
                        <!-- <th>
                            {{ trans('cruds.govtCalendar.fields.govtholidaystatus') }}
                        </th> -->
                        <!-- <th>
                            {{ trans('cruds.govtCalendar.fields.success_attendance_lastfetchtime') }}
                        </th>
                        <th>
                            {{ trans('cruds.govtCalendar.fields.success_attendance_rows_fetched') }}
                        </th> -->
                        <th>
                            {{ trans('cruds.govtCalendar.fields.attendancetodaytrace_lastfetchtime') }}
                        </th>
                        <th>
                            {{ trans('cruds.govtCalendar.fields.attendance_today_trace_rows_fetched') }}
                        </th>
                        <th>
                            Fetch complete
                        </th>
                        <th>
                            Calc Count
                        </th>
                        <th>
                            {{ trans('cruds.govtCalendar.fields.is_sitting_day') }}
                        </th>
                        <th>
                            {{ trans('cruds.govtCalendar.fields.session') }}
                        </th>
                        <th>
                            {{ trans('cruds.govtCalendar.fields.office_ends_at') }}
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
                            <!-- <td>
                            <small> {{ $govtCalendar->id ?? '' }}   </small>
                            </td> -->
                            <td>
                                @if($govtCalendar->govtholidaystatus==1)
                                <span class="badge badge-danger">
                                    {{ \Carbon\Carbon::parse($govtCalendar->date)->format('Y M d') ?? '' }}
                                </span>

                                @else
                                <span class="badge badge-dark">
                                {{ \Carbon\Carbon::parse($govtCalendar->date)->format('Y M d')  ?? '' }}
                                </span>
                                @endif
                                @if(\Carbon\Carbon::parse($govtCalendar->date)->isToday())
                                <span class="badge badge-info">Today</span>
                                @endif
                            </td>
                            <!-- <td>
                                {{ $govtCalendar->govtholidaystatus ?? '' }}
                            </td> -->
                            <!-- <td>
                                {{ $govtCalendar->success_attendance_lastfetchtime ?? '' }}
                            </td>
                            <td>
                                {{ $govtCalendar->success_attendance_rows_fetched ?? '' }}
                            </td> -->
                            <td>
                                <small> {{ $govtCalendar->attendancetodaytrace_lastfetchtime ?? '' }}</small>
                            </td>
                            <td>
                                {{ $govtCalendar->attendance_today_trace_rows_fetched ?? '' }}
                            </td>
                            <td>
                                {{ $govtCalendar->attendance_trace_fetch_complete ?? '' }}
                            </td>
                            <td>
                                {{ $govtCalendar->calc_count ?? '' }}   
                            <td>
                                <span style="display:none">{{ $govtCalendar->is_sitting_day ?? '' }}</span>
                                <input type="checkbox" disabled="disabled" {{ $govtCalendar->is_sitting_day ? 'checked' : '' }}>
                            </td>
                            <td>
                                {{ $govtCalendar->session->name ?? '' }}
                            </td>
                            <td>
                                {{ App\Models\GovtCalendar::OFFICE_ENDS_AT_SELECT[$govtCalendar->office_ends_at] ?? '' }}
                            </td>
                            <td>
                                @can('govt_calendar_show')
                                    <!-- <a class="btn btn-xs btn-primary" href="{{ route('admin.govt-calendars.show', $govtCalendar->id) }}">
                                        {{ trans('global.view') }}
                                    </a> -->
                                @endcan

                                <a href="{{ route('admin.govt-calendars.fetch',['date'=> $govtCalendar->date ]) }}"  class="btn btn-sm btn-danger">Fetch</a>
                                <!-- <a href="{{ route('admin.govt-calendars.fetch-leaves',['date'=> $govtCalendar->date ]) }}"  class="btn btn-sm btn-info">FetchLeaves</a> -->
                                <a href="{{ route('admin.govt-calendars.calculate',['date'=> $govtCalendar->date ]) }}"  class="btn btn-sm btn-primary">Calc</a>
                                <!-- <a href="{{ route('admin.govt-calendars.download-leaves',['date'=> $govtCalendar->date ]) }}"  class="btn btn-sm btn-info">DownloadLeaves</a> -->

                                @can('govt_calendar_edit')
                                    <a class="btn btn-dark btn-sm " href="{{ route('admin.govt-calendars.edit', $govtCalendar->id) }}">
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
    order: [],
    //order: [[ 2, 'desc' ]],
    pageLength: 50,
  });
  let table = $('.datatable-GovtCalendar:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

})

</script>
@endsection
