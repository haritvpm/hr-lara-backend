@extends('layouts.admin')
@section('content')
@can('overtime_other_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.overtime-others.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.overtimeOther.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card_">
    <div class="card-header_">
        {{ trans('cruds.overtimeOther.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body_">
        <table class=" table   table-hover ajaxTable datatable datatable-OvertimeOther">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.overtimeOther.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.overtimeOther.fields.employee') }}
                    </th>
                    <th>
                        {{ trans('cruds.deptEmployee.fields.pen') }}
                    </th>
                    <th>
                        {{ trans('cruds.overtimeOther.fields.designation') }}
                    </th>
                    <th>
                        {{ trans('cruds.overtimeOther.fields.from') }}
                    </th>
                    <th>
                        {{ trans('cruds.overtimeOther.fields.to') }}
                    </th>
                    <th>
                        {{ trans('cruds.overtimeOther.fields.count') }}
                    </th>
                    <th>
                        {{ trans('cruds.overtimeOther.fields.form') }}
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
@can('overtime_other_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.overtime-others.massDestroy') }}",
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
    ajax: "{{ route('admin.overtime-others.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'employee_name', name: 'employee.name' },
{ data: 'employee.pen', name: 'employee.pen' },
{ data: 'designation', name: 'designation' },
{ data: 'from', name: 'from' },
{ data: 'to', name: 'to' },
{ data: 'count', name: 'count' },
{ data: 'form_creator', name: 'form.creator' },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  };
  let table = $('.datatable-OvertimeOther').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

});

</script>
@endsection
