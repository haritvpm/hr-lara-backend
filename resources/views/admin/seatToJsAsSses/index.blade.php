@extends('layouts.admin')
@section('content')
@can('seat_to_js_as_ss_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.seat-to-js-as-sses.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.seatToJsAsSs.title_singular') }}
            </a>
            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'SeatToJsAsSs', 'route' => 'admin.seat-to-js-as-sses.parseCsvImport'])
        </div>
    </div>
@endcan
<div class="card_">
    <div class="card-header_">
        {{ trans('cruds.seatToJsAsSs.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body_">
        <div class="table-responsive_">
            <table class=" table   table-hover datatable datatable-SeatToJsAsSs">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.seatToJsAsSs.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.seatToJsAsSs.fields.seat') }}
                        </th>
                        <th>
                            {{ trans('cruds.seatToJsAsSs.fields.employee') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($seatToJsAsSses as $key => $seatToJsAsSs)
                        <tr data-entry-id="{{ $seatToJsAsSs->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $seatToJsAsSs->id ?? '' }}
                            </td>
                            <td>
                                {{ $seatToJsAsSs->seat->title ?? '' }}
                            </td>
                            <td>
                                {{ $seatToJsAsSs->employee->name ?? '' }}
                            </td>
                            <td>
                                @can('seat_to_js_as_ss_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.seat-to-js-as-sses.show', $seatToJsAsSs->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('seat_to_js_as_ss_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.seat-to-js-as-sses.edit', $seatToJsAsSs->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('seat_to_js_as_ss_delete')
                                    <form action="{{ route('admin.seat-to-js-as-sses.destroy', $seatToJsAsSs->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('seat_to_js_as_ss_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.seat-to-js-as-sses.massDestroy') }}",
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
  let table = $('.datatable-SeatToJsAsSs:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

})

</script>
@endsection
