@extends('layouts.admin')
@section('content')
@can('employee_create')
    <div style="margin-bottom: 10px;" class="row">
            <a class="ml-2 btn btn-success" href="{{ route('admin.employees.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.employee.title_singular') }}
            </a>
            <button class="ml-2 btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'Employee', 'route' => 'admin.employees.parseCsvImport'])
           
        
            <div class="ml-2 dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Actions
                </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item"  href="{{ route('admin.employees.aebasfetch') }}">Sync From AEBAS</a>
                <!-- <a class="dropdown-item" href="#">Another action</a> -->
            </div>

            </div>
    </div>
@endcan



<div class="card_">


    <div class="card-body_">
        <table class=" table   table-hover ajaxTable datatable datatable-Employee">
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
                        {{ trans('cruds.employee.fields.aadhaarid') }}
                    </th>
                    <th>
                        {{ trans('cruds.employee.fields.pen') }}
                    </th>
                    <th>
                        {{ trans('cruds.employee.fields.desig_display') }}
                    </th>

                    <th>
                        {{ trans('cruds.employee.fields.has_punching') }}
                    </th>
                    <th>
                        {{ trans('cruds.employee.fields.status') }}
                    </th>
                    <th>
                        {{ trans('cruds.employee.fields.is_shift') }}
                    </th>
                    <th>
                        {{ trans('cruds.employee.fields.grace_group') }}
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
{ data: 'aadhaarid', name: 'aadhaarid' },
{ data: 'pen', name: 'pen' },
{ data: 'desig_display', name: 'desig_display' },
{ data: 'has_punching', name: 'has_punching' },
{ data: 'status', name: 'status' },
{ data: 'is_shift', name: 'is_shift' },
{ data: 'grace_group_title', name: 'grace_group.title' },
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
