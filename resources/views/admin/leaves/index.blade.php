@extends('layouts.admin')
@section('content')
@can('leaf_create')
    <div style="margin-bottom: 10px;" class="row">
      


        <div class="ml-2 dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Actions
                </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item"  href="{{ route('admin.leaves.aebasdownload') }}">Download All Leaves from AEBAS</a>
                <a class="dropdown-item"  href="{{ route('admin.leaves.aebasfetch') }}">Fetch All Leaves from AEBAS</a>
                <a class="dropdown-item"  href="{{ route('admin.leaves.calc') }}">Calc Leaves</a>
                <!-- <a class="dropdown-item" href="#">Another action</a> -->
            </div>

            </div>

    </div>



@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.leaf.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Leaf">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.leaf.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.leaf.fields.aadhaarid') }}
                    </th>
                    <!-- <th>
                        {{ trans('cruds.leaf.fields.employee') }}
                    </th> -->
                    <th>
                        {{ trans('cruds.leaf.fields.leave_type') }}
                    </th>
                    <th>
                        {{ trans('cruds.leaf.fields.start_date') }}
                    </th>
                    <th>
                        {{ trans('cruds.leaf.fields.end_date') }}
                    </th>
                    <th>
                        {{ trans('cruds.leaf.fields.reason') }}
                    </th>
                    <th>
                        {{ trans('cruds.leaf.fields.active_status') }}
                    </th>
                    <th>
                        {{ trans('cruds.leaf.fields.leave_cat') }}
                    </th>
                    <th>
                        {{ trans('cruds.leaf.fields.time_period') }}
                    </th>
                    <th>
                        {{ trans('cruds.leaf.fields.in_lieu_of') }}
                    </th>
                    <th>
                        {{ trans('cruds.leaf.fields.last_updated') }}
                    </th>
                    <th>
                        {{ trans('cruds.leaf.fields.creation_date') }}
                    </th>
                    <!-- <th>
                        {{ trans('cruds.leaf.fields.created_by_aadhaarid') }}
                    </th>
                    <th>
                        {{ trans('cruds.leaf.fields.processed') }}
                    </th>
                    <th>
                        {{ trans('cruds.leaf.fields.owner_seat') }}
                    </th>
                    <th>
                        {{ trans('cruds.leaf.fields.remarks') }}
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
@can('leaf_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.leaves.massDestroy') }}",
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
    ajax: "{{ route('admin.leaves.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'aadhaarid', name: 'aadhaarid' },
// { data: 'employee_name', name: 'employee.name' },
{ data: 'leave_type', name: 'leave_type' },
{ data: 'start_date', name: 'start_date' },
{ data: 'end_date', name: 'end_date' },
{ data: 'reason', name: 'reason' },
{ data: 'active_status', name: 'active_status' },
{ data: 'leave_cat', name: 'leave_cat' },
{ data: 'time_period', name: 'time_period' },
{ data: 'in_lieu_of', name: 'in_lieu_of' },
{ data: 'last_updated', name: 'last_updated' },
{ data: 'creation_date', name: 'creation_date' },
//{ data: 'created_by_aadhaarid', name: 'created_by_aadhaarid' },
{ data: 'processed', name: 'processed' },
{ data: 'owner_seat', name: 'owner_seat' },
{ data: 'remarks', name: 'remarks' },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  };
  let table = $('.datatable-Leaf').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

});

</script>
@endsection
