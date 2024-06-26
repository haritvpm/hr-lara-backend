<div class="m-3">
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
            <div class="table-responsive_">
                <table class=" table   table-hover datatable datatable-createdByTaxEntries">
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
                    <tbody>
                        @foreach($taxEntries as $key => $taxEntry)
                            <tr data-entry-id="{{ $taxEntry->id }}">
                                <td>

                                </td>
                                <td>
                                    {{ $taxEntry->id ?? '' }}
                                </td>
                                <td>
                                    {{ $taxEntry->date ?? '' }}
                                </td>
                                <td>
                                    {{ $taxEntry->status ?? '' }}
                                </td>
                                <td>
                                    {{ $taxEntry->acquittance ?? '' }}
                                </td>
                                <td>
                                    {{ $taxEntry->created_by->title ?? '' }}
                                </td>
                                <td>
                                    {{ $taxEntry->sparkcode ?? '' }}
                                </td>
                                <td>
                                    @can('tax_entry_show')
                                        <a class="btn btn-xs btn-primary" href="{{ route('admin.tax-entries.show', $taxEntry->id) }}">
                                            {{ trans('global.view') }}
                                        </a>
                                    @endcan

                                    @can('tax_entry_edit')
                                        <a class="btn btn-xs btn-info" href="{{ route('admin.tax-entries.edit', $taxEntry->id) }}">
                                            {{ trans('global.edit') }}
                                        </a>
                                    @endcan

                                    @can('tax_entry_delete')
                                        <form action="{{ route('admin.tax-entries.destroy', $taxEntry->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
</div>
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('tax_entry_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.tax-entries.massDestroy') }}",
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
  let table = $('.datatable-createdByTaxEntries:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

})

</script>
@endsection
