@extends('layouts.admin')
@section('content')
@can('ot_routing_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.ot-routings.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.otRouting.title_singular') }}
            </a>
            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'OtRouting', 'route' => 'admin.ot-routings.parseCsvImport'])
        </div>
    </div>
@endcan
<div class="card_">
    <div class="card-header_">
        {{ trans('cruds.otRouting.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body_">
        <div class="table-responsive_">
            <table class=" table   table-hover datatable datatable-OtRouting">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.otRouting.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.otRouting.fields.from_seat') }}
                        </th>
                        <th>
                            {{ trans('cruds.seat.fields.name') }}
                        </th>
                        <th>
                            {{ trans('cruds.otRouting.fields.to_seats') }}
                        </th>
                        <th>
                            {{ trans('cruds.otRouting.fields.last_forwarded_to') }}
                        </th>
                        <th>
                            {{ trans('cruds.otRouting.fields.js_as_ss') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($otRoutings as $key => $otRouting)
                        <tr data-entry-id="{{ $otRouting->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $otRouting->id ?? '' }}
                            </td>
                            <td>
                                {{ $otRouting->from_seat->title ?? '' }}
                            </td>
                            <td>
                                {{ $otRouting->from_seat->name ?? '' }}
                            </td>
                            <td>
                                @foreach($otRouting->to_seats as $key => $item)
                                    <span class="badge badge-info">{{ $item->title }}</span>
                                @endforeach
                            </td>
                            <td>
                                {{ $otRouting->last_forwarded_to ?? '' }}
                            </td>
                            <td>
                                {{ $otRouting->js_as_ss->name ?? '' }}
                            </td>
                            <td>
                                @can('ot_routing_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.ot-routings.show', $otRouting->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('ot_routing_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.ot-routings.edit', $otRouting->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('ot_routing_delete')
                                    <form action="{{ route('admin.ot-routings.destroy', $otRouting->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('ot_routing_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.ot-routings.massDestroy') }}",
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
  let table = $('.datatable-OtRouting:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

})

</script>
@endsection
