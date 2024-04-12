@extends('layouts.admin')
@section('content')
@can('success_punching_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.success-punchings.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.successPunching.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card_">
    <div class="card-header_">
        {{ trans('cruds.successPunching.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body_">
        <table class=" table   table-hover ajaxTable datatable datatable-SuccessPunching">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.successPunching.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.successPunching.fields.date') }}
                    </th>
                    <th>
                        {{ trans('cruds.successPunching.fields.punch_in') }}
                    </th>
                    <th>
                        {{ trans('cruds.successPunching.fields.punch_out') }}
                    </th>
                    <th>
                        {{ trans('cruds.successPunching.fields.pen') }}
                    </th>
                    <th>
                        {{ trans('cruds.successPunching.fields.name') }}
                    </th>
                    <th>
                        {{ trans('cruds.successPunching.fields.in_device') }}
                    </th>
                    <th>
                        {{ trans('cruds.successPunching.fields.in_time') }}
                    </th>
                    <th>
                        {{ trans('cruds.successPunching.fields.out_device') }}
                    </th>
                    <th>
                        {{ trans('cruds.successPunching.fields.out_time') }}
                    </th>
                    <th>
                        {{ trans('cruds.successPunching.fields.at_type') }}
                    </th>
                    <th>
                        {{ trans('cruds.successPunching.fields.duration') }}
                    </th>
                    <th>
                        {{ trans('cruds.successPunching.fields.aadhaarid') }}
                    </th>
                    <th>
                        {{ trans('cruds.successPunching.fields.punching') }}
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
@can('success_punching_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.success-punchings.massDestroy') }}",
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
    ajax: "{{ route('admin.success-punchings.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'date', name: 'date' },
{ data: 'punch_in', name: 'punch_in' },
{ data: 'punch_out', name: 'punch_out' },
{ data: 'pen', name: 'pen' },
{ data: 'name', name: 'name' },
{ data: 'in_device', name: 'in_device' },
{ data: 'in_time', name: 'in_time' },
{ data: 'out_device', name: 'out_device' },
{ data: 'out_time', name: 'out_time' },
{ data: 'at_type', name: 'at_type' },
{ data: 'duration', name: 'duration' },
{ data: 'aadhaarid', name: 'aadhaarid' },
{ data: 'punching_date', name: 'punching.date' },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  };
  let table = $('.datatable-SuccessPunching').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

});

</script>
@endsection
