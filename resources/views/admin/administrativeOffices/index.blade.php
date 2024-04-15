@extends('layouts.admin')
@section('content')
@can('administrative_office_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.administrative-offices.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.administrativeOffice.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card_">
    <div class="card-header_">
        {{ trans('cruds.administrativeOffice.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body_">
        <div class="table-responsive_">
            <table class=" table   table-hover datatable datatable-AdministrativeOffice">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.administrativeOffice.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.administrativeOffice.fields.office_name') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($administrativeOffices as $key => $administrativeOffice)
                        <tr data-entry-id="{{ $administrativeOffice->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $administrativeOffice->id ?? '' }}
                            </td>
                            <td>
                                {{ $administrativeOffice->office_name ?? '' }}
                            </td>
                            <td>
                                @can('administrative_office_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.administrative-offices.show', $administrativeOffice->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('administrative_office_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.administrative-offices.edit', $administrativeOffice->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('administrative_office_delete')
                                    <form action="{{ route('admin.administrative-offices.destroy', $administrativeOffice->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('administrative_office_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.administrative-offices.massDestroy') }}",
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
  let table = $('.datatable-AdministrativeOffice:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

})

</script>
@endsection
