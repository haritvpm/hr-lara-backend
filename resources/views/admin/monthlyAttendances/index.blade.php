@extends('layouts.admin')
@section('content')
@can('monthly_attendance_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.monthly-attendances.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.monthlyAttendance.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card_">
    <div class="card-header_">
        {{ trans('cruds.monthlyAttendance.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body_">
        <table class=" table   table-hover ajaxTable datatable datatable-MonthlyAttendance">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.monthlyAttendance.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.monthlyAttendance.fields.employee') }}
                    </th>
                    <th>
                        {{ trans('cruds.employee.fields.aadhaarid') }}
                    </th>
                    <th>
                        {{ trans('cruds.monthlyAttendance.fields.month') }}
                    </th>
                    <th>
                        {{ trans('cruds.monthlyAttendance.fields.total_cl') }}
                    </th>
                    <th>
                        {{ trans('cruds.monthlyAttendance.fields.total_compen') }}
                    </th>
                    <th>
                        {{ trans('cruds.monthlyAttendance.fields.total_compen_off_granted') }}
                    </th>
                    <th>
                        &nbsp;
                    </th>
                </tr>
            </thead>
        </table>
    </div>
</div>



@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('monthly_attendance_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.monthly-attendances.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).data(), function (entry) {
          return entry.id
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

  let dtOverrideGlobals = {
    buttons: dtButtons,
    processing: true,
    serverSide: true,
    retrieve: true,
    aaSorting: [],
    ajax: "{{ route('admin.monthly-attendances.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'employee_name', name: 'employee.name' },
{ data: 'employee.aadhaarid', name: 'employee.aadhaarid' },
{ data: 'month', name: 'month' },
{ data: 'total_cl', name: 'total_cl' },
{ data: 'total_compen', name: 'total_compen' },
{ data: 'total_compen_off_granted', name: 'total_compen_off_granted' },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  };
  let table = $('.datatable-MonthlyAttendance').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

});

</script>
@endsection
