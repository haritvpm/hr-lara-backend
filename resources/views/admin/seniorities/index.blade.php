@extends('layouts.admin')
@section('content')
@can('seniority_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.seniorities.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.seniority.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card_">
    <div class="card-header_">
        {{ trans('cruds.seniority.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body_">
        <div class="table-responsive_">
            <table class=" table   table-hover datatable datatable-Seniority">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.seniority.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.seniority.fields.employee') }}
                        </th>
                        <th>
                            {{ trans('cruds.employee.fields.pen') }}
                        </th>
                        <th>
                            {{ trans('cruds.seniority.fields.sortindex') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($seniorities as $key => $seniority)
                        <tr data-entry-id="{{ $seniority->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $seniority->id ?? '' }}
                            </td>
                            <td>
                                {{ $seniority->employee->name ?? '' }}
                            </td>
                            <td>
                                {{ $seniority->employee->pen ?? '' }}
                            </td>
                            <td>
                                {{ $seniority->sortindex ?? '' }}
                            </td>
                            <td>
                                @can('seniority_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.seniorities.show', $seniority->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('seniority_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.seniorities.edit', $seniority->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('seniority_delete')
                                    <form action="{{ route('admin.seniorities.destroy', $seniority->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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



@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('seniority_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.seniorities.massDestroy') }}",
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
  let table = $('.datatable-Seniority:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

})

</script>
@endsection
