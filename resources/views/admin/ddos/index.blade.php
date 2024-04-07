@extends('layouts.admin')
@section('content')
@can('ddo_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.ddos.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.ddo.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.ddo.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Ddo">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.ddo.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.ddo.fields.code') }}
                        </th>
                        <th>
                            {{ trans('cruds.ddo.fields.office') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ddos as $key => $ddo)
                        <tr data-entry-id="{{ $ddo->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $ddo->id ?? '' }}
                            </td>
                            <td>
                                {{ $ddo->code ?? '' }}
                            </td>
                            <td>
                                {{ $ddo->office->office_name ?? '' }}
                            </td>
                            <td>
                                @can('ddo_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.ddos.show', $ddo->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('ddo_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.ddos.edit', $ddo->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('ddo_delete')
                                    <form action="{{ route('admin.ddos.destroy', $ddo->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('ddo_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.ddos.massDestroy') }}",
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
  let table = $('.datatable-Ddo:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection