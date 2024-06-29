@extends('layouts.admin')
@section('content')
@can('attendance_routing_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.attendance-routings.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.attendanceRouting.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card_">
    <div class="card-header_">
        {{ trans('cruds.attendanceRouting.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body_">
        <div class="table-responsive_">
            <table class=" table   table-hover datatable datatable-AttendanceRouting">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.attendanceRouting.fields.id') }}
                        </th>
                        <!-- <th>
                            {{ trans('cruds.attendanceRouting.fields.viewer_js_as_ss_employee') }}
                        </th> -->
                        <!-- <th>
                            {{ trans('cruds.employee.fields.pen') }}
                        </th> -->
                        <th>
                            {{ trans('cruds.attendanceRouting.fields.viewer_seat') }}
                        </th>
                        <th>
                            {{ trans('cruds.attendanceRouting.fields.viewable_seats') }}
                        </th>
                        <th>
                            {{ trans('cruds.attendanceRouting.fields.viewable_js_as_ss_employees') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($attendanceRoutings as $key => $attendanceRouting)
                        <tr data-entry-id="{{ $attendanceRouting->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $attendanceRouting->id ?? '' }}
                            </td>
                            <!-- <td>
                                {{ $attendanceRouting->viewer_js_as_ss_employee->name ?? '' }}
                            </td>
                            <td>
                                {{ $attendanceRouting->viewer_js_as_ss_employee->pen ?? '' }}
                            </td> -->
                            <td>
                                {{ $attendanceRouting->viewer_seat->title ?? '' }}
                            </td>
                            <td>
                                @foreach($attendanceRouting->viewable_seats as $key => $item)
                                    <span class="badge badge-info">{{ $item->title }}</span>
                                @endforeach
                            </td>
                            <td>
                                @foreach($attendanceRouting->viewable_js_as_ss_employees as $key => $item)
                                    <span class="badge badge-info">{{ $item->name }}</span>
                                @endforeach
                            </td>
                            <td>
                                @can('attendance_routing_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.attendance-routings.show', $attendanceRouting->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('attendance_routing_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.attendance-routings.edit', $attendanceRouting->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('attendance_routing_delete')
                                    <form action="{{ route('admin.attendance-routings.destroy', $attendanceRouting->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
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
@can('attendance_routing_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.attendance-routings.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-AttendanceRouting:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

})

</script>
@endsection
