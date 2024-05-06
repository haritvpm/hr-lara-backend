@extends('layouts.admin')
@section('content')
@can('yearly_attendance_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.yearly-attendances.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.yearlyAttendance.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.yearlyAttendance.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-YearlyAttendance">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.yearlyAttendance.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.yearlyAttendance.fields.aadhaarid') }}
                    </th>
                    <th>
                        {{ trans('cruds.yearlyAttendance.fields.employee') }}
                    </th>
                    <th>
                        {{ trans('cruds.employee.fields.aadhaarid') }}
                    </th>
                    <th>
                        {{ trans('cruds.yearlyAttendance.fields.year') }}
                    </th>
                    <th>
                        {{ trans('cruds.yearlyAttendance.fields.cl_marked') }}
                    </th>
                    <th>
                        {{ trans('cruds.yearlyAttendance.fields.cl_submitted') }}
                    </th>
                    <th>
                        {{ trans('cruds.yearlyAttendance.fields.compen_marked') }}
                    </th>
                    <th>
                        {{ trans('cruds.yearlyAttendance.fields.compen_submitted') }}
                    </th>
                    <th>
                        {{ trans('cruds.yearlyAttendance.fields.other_leaves_marked') }}
                    </th>
                    <th>
                        {{ trans('cruds.yearlyAttendance.fields.other_leaves_submitted') }}
                    </th>
                    <th>
                        {{ trans('cruds.yearlyAttendance.fields.single_punchings') }}
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
@can('yearly_attendance_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.yearly-attendances.massDestroy') }}",
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
    ajax: "{{ route('admin.yearly-attendances.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'aadhaarid', name: 'aadhaarid' },
{ data: 'employee_name', name: 'employee.name' },
{ data: 'employee.aadhaarid', name: 'employee.aadhaarid' },
{ data: 'year', name: 'year' },
{ data: 'cl_marked', name: 'cl_marked' },
{ data: 'cl_submitted', name: 'cl_submitted' },
{ data: 'compen_marked', name: 'compen_marked' },
{ data: 'compen_submitted', name: 'compen_submitted' },
{ data: 'other_leaves_marked', name: 'other_leaves_marked' },
{ data: 'other_leaves_submitted', name: 'other_leaves_submitted' },
{ data: 'single_punchings', name: 'single_punchings' },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  };
  let table = $('.datatable-YearlyAttendance').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
});

</script>
@endsection