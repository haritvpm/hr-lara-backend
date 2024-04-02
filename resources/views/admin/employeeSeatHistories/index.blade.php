@extends('layouts.admin')
@section('content')
@can('employee_seat_history_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.employee-seat-histories.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.employeeSeatHistory.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.employeeSeatHistory.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-EmployeeSeatHistory">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.employeeSeatHistory.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.employeeSeatHistory.fields.seat') }}
                        </th>
                        <th>
                            {{ trans('cruds.employeeSeatHistory.fields.employee') }}
                        </th>
                        <th>
                            {{ trans('cruds.employeeSeatHistory.fields.start_date') }}
                        </th>
                        <th>
                            {{ trans('cruds.employeeSeatHistory.fields.end_date') }}
                        </th>
                        <th>
                            {{ trans('cruds.employeeSeatHistory.fields.remarks') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($employeeSeatHistories as $key => $employeeSeatHistory)
                        <tr data-entry-id="{{ $employeeSeatHistory->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $employeeSeatHistory->id ?? '' }}
                            </td>
                            <td>
                                {{ $employeeSeatHistory->seat->title ?? '' }}
                            </td>
                            <td>
                                {{ $employeeSeatHistory->employee->name ?? '' }}
                            </td>
                            <td>
                                {{ $employeeSeatHistory->start_date ?? '' }}
                            </td>
                            <td>
                                {{ $employeeSeatHistory->end_date ?? '' }}
                            </td>
                            <td>
                                {{ $employeeSeatHistory->remarks ?? '' }}
                            </td>
                            <td>
                                @can('employee_seat_history_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.employee-seat-histories.show', $employeeSeatHistory->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('employee_seat_history_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.employee-seat-histories.edit', $employeeSeatHistory->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('employee_seat_history_delete')
                                    <form action="{{ route('admin.employee-seat-histories.destroy', $employeeSeatHistory->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('employee_seat_history_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.employee-seat-histories.massDestroy') }}",
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
  let table = $('.datatable-EmployeeSeatHistory:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection