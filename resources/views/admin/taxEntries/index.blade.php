@extends('layouts.admin')
@section('content')
@can('tax_entry_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.tax-entries.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.taxEntry.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card_">
    <div class="card-header_">
        {{ trans('cruds.taxEntry.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body_">
        <table class=" table   table-hover ajaxTable datatable datatable-TaxEntry">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.taxEntry.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.taxEntry.fields.date') }}
                    </th>
                    <th>
                        {{ trans('cruds.taxEntry.fields.status') }}
                    </th>
                    <th>
                        {{ trans('cruds.taxEntry.fields.acquittance') }}
                    </th>
                    <th>
                        {{ trans('cruds.taxEntry.fields.created_by') }}
                    </th>
                    <th>
                        {{ trans('cruds.taxEntry.fields.sparkcode') }}
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
@can('tax_entry_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.tax-entries.massDestroy') }}",
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
    ajax: "{{ route('admin.tax-entries.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'date', name: 'date' },
{ data: 'status', name: 'status' },
{ data: 'acquittance', name: 'acquittance' },
{ data: 'created_by_title', name: 'created_by.title' },
{ data: 'sparkcode', name: 'sparkcode' },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  };
  let table = $('.datatable-TaxEntry').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

});

</script>
@endsection
