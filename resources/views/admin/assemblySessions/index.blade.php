@extends('layouts.admin')
@section('content')
@can('assembly_session_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.assembly-sessions.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.assemblySession.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card_">
    <div class="card-header_">
        {{ trans('cruds.assemblySession.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body_">
        <div class="table-responsive_">
            <table class=" table   table-hover datatable datatable-AssemblySession">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.assemblySession.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.assemblySession.fields.name') }}
                        </th>
                        <th>
                            {{ trans('cruds.assemblySession.fields.kla_number') }}
                        </th>
                        <th>
                            {{ trans('cruds.assemblySession.fields.session_number') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($assemblySessions as $key => $assemblySession)
                        <tr data-entry-id="{{ $assemblySession->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $assemblySession->id ?? '' }}
                            </td>
                            <td>
                                {{ $assemblySession->name ?? '' }}
                            </td>
                            <td>
                                {{ $assemblySession->kla_number ?? '' }}
                            </td>
                            <td>
                                {{ $assemblySession->session_number ?? '' }}
                            </td>
                            <td>
                                @can('assembly_session_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.assembly-sessions.show', $assemblySession->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('assembly_session_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.assembly-sessions.edit', $assemblySession->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('assembly_session_delete')
                                    <form action="{{ route('admin.assembly-sessions.destroy', $assemblySession->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('assembly_session_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.assembly-sessions.massDestroy') }}",
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
  let table = $('.datatable-AssemblySession:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

})

</script>
@endsection
