@extends('layouts.admin')
@section('content')
@can('employee_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.employees.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.employee.title_singular') }}
            </a>
            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'Employee', 'route' => 'admin.employees.parseCsvImport'])
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.employee.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Employee">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.employee.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.employee.fields.srismt') }}
                    </th>
                    <th>
                        {{ trans('cruds.employee.fields.name') }}
                    </th>
                    <th>
                        {{ trans('cruds.employee.fields.name_mal') }}
                    </th>
                    <th>
                        {{ trans('cruds.employee.fields.pen') }}
                    </th>
                    <th>
                        {{ trans('cruds.employee.fields.designation') }}
                    </th>
                    <th>
                        {{ trans('cruds.employee.fields.category') }}
                    </th>
                    <th>
                        {{ trans('cruds.employee.fields.aadhaarid') }}
                    </th>
                    <th>
                        {{ trans('cruds.employee.fields.has_punching') }}
                    </th>
                    <th>
                        {{ trans('cruds.employee.fields.status') }}
                    </th>
                    <th>
                        {{ trans('cruds.employee.fields.ot_data_entry_by_admin') }}
                    </th>
                    <th>
                        {{ trans('cruds.employee.fields.desig_display') }}
                    </th>
                    <th>
                        {{ trans('cruds.employee.fields.pan') }}
                    </th>
                    <th>
                        {{ trans('cruds.employee.fields.employee_type') }}
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
@can('employee_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.employees.massDestroy') }}",
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
    ajax: "{{ route('admin.employees.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'srismt', name: 'srismt' },
{ data: 'name', name: 'name' },
{ data: 'name_mal', name: 'name_mal' },
{ data: 'pen', name: 'pen' },
{ data: 'designation_designation', name: 'designation.designation' },
{ data: 'category_category', name: 'category.category' },
{ data: 'aadhaarid', name: 'aadhaarid' },
{ data: 'has_punching', name: 'has_punching' },
{ data: 'status', name: 'status' },
{ data: 'ot_data_entry_by_admin', name: 'ot_data_entry_by_admin' },
{ data: 'desig_display', name: 'desig_display' },
{ data: 'pan', name: 'pan' },
{ data: 'employee_type', name: 'employee_type' },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  };
  let table = $('.datatable-Employee').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
});

</script>
@endsection