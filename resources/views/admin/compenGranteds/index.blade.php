@extends('layouts.admin')
@section('content')
@can('compen_granted_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.compen-granteds.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.compenGranted.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.compenGranted.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-CompenGranted">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.compenGranted.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.compenGranted.fields.aadhaarid') }}
                    </th>
                    <th>
                        {{ trans('cruds.compenGranted.fields.date_of_work') }}
                    </th>
                    <th>
                        {{ trans('cruds.compenGranted.fields.is_for_extra_hours') }}
                    </th>
                    <th>
                        {{ trans('cruds.compenGranted.fields.employee') }}
                    </th>
                    <th>
                        {{ trans('cruds.employee.fields.pen') }}
                    </th>
                    <th>
                        {{ trans('cruds.compenGranted.fields.leave') }}
                    </th>
                    <th>
                        {{ trans('cruds.leaf.fields.start_date') }}
                    </th>
                    <th>
                        {{ trans('cruds.leaf.fields.end_date') }}
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
@can('compen_granted_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.compen-granteds.massDestroy') }}",
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
    ajax: "{{ route('admin.compen-granteds.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'aadhaarid', name: 'aadhaarid' },
{ data: 'date_of_work', name: 'date_of_work' },
{ data: 'is_for_extra_hours', name: 'is_for_extra_hours' },
{ data: 'employee_name', name: 'employee.name' },
{ data: 'employee.pen', name: 'employee.pen' },
{ data: 'leave_start_date', name: 'leave.start_date' },
{ data: 'leave.start_date', name: 'leave.start_date' },
{ data: 'leave.end_date', name: 'leave.end_date' },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  };
  let table = $('.datatable-CompenGranted').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
});

</script>
@endsection