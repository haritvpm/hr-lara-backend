@extends('layouts.admin')
@section('content')
@can('punching_device_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.punching-devices.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.punchingDevice.title_singular') }}
            </a>
            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'PunchingDevice', 'route' => 'admin.punching-devices.parseCsvImport'])
        </div>
    </div>
@endcan
<div class="card_">
    <div class="card-header_">
        {{ trans('cruds.punchingDevice.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body_">
        <div class="table-responsive_">
            <table class=" table   table-hover datatable datatable-PunchingDevice">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.punchingDevice.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.punchingDevice.fields.device') }}
                        </th>
                        <th>
                            {{ trans('cruds.punchingDevice.fields.loc_name') }}
                        </th>
                        <th>
                            {{ trans('cruds.punchingDevice.fields.entry_name') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($punchingDevices as $key => $punchingDevice)
                        <tr data-entry-id="{{ $punchingDevice->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $punchingDevice->id ?? '' }}
                            </td>
                            <td>
                                {{ $punchingDevice->device ?? '' }}
                            </td>
                            <td>
                                {{ $punchingDevice->loc_name ?? '' }}
                            </td>
                            <td>
                                {{ $punchingDevice->entry_name ?? '' }}
                            </td>
                            <td>
                                @can('punching_device_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.punching-devices.show', $punchingDevice->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('punching_device_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.punching-devices.edit', $punchingDevice->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('punching_device_delete')
                                    <form action="{{ route('admin.punching-devices.destroy', $punchingDevice->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('punching_device_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.punching-devices.massDestroy') }}",
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
  let table = $('.datatable-PunchingDevice:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

})

</script>
@endsection
