@extends('layouts.admin')
@section('content')
@can('exemption_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.exemptions.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.exemption.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card_">
    <div class="card-header_">
        {{ trans('cruds.exemption.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body_">
        <div class="table-responsive_">
            <table class=" table   table-hover datatable datatable-Exemption">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.exemption.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.exemption.fields.employee') }}
                        </th>
                        <th>
                            {{ trans('cruds.exemption.fields.date_from') }}
                        </th>
                        <th>
                            {{ trans('cruds.exemption.fields.date_to') }}
                        </th>
                        <th>
                            {{ trans('cruds.exemption.fields.forwarded_by') }}
                        </th>
                        <th>
                            {{ trans('cruds.exemption.fields.submitted_to_services') }}
                        </th>
                        <th>
                            {{ trans('cruds.exemption.fields.session') }}
                        </th>
                        <th>
                            {{ trans('cruds.exemption.fields.approval_status') }}
                        </th>
                        <th>
                            {{ trans('cruds.exemption.fields.owner') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($exemptions as $key => $exemption)
                        <tr data-entry-id="{{ $exemption->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $exemption->id ?? '' }}
                            </td>
                            <td>
                                {{ $exemption->employee->name ?? '' }}
                            </td>
                            <td>
                                {{ $exemption->date_from ?? '' }}
                            </td>
                            <td>
                                {{ $exemption->date_to ?? '' }}
                            </td>
                            <td>
                                {{ $exemption->forwarded_by ?? '' }}
                            </td>
                            <td>
                                <span style="display:none">{{ $exemption->submitted_to_services ?? '' }}</span>
                                <input type="checkbox" disabled="disabled" {{ $exemption->submitted_to_services ? 'checked' : '' }}>
                            </td>
                            <td>
                                {{ $exemption->session->name ?? '' }}
                            </td>
                            <td>
                                {{ $exemption->approval_status ?? '' }}
                            </td>
                            <td>
                                {{ $exemption->owner->title ?? '' }}
                            </td>
                            <td>
                                @can('exemption_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.exemptions.show', $exemption->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('exemption_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.exemptions.edit', $exemption->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('exemption_delete')
                                    <form action="{{ route('admin.exemptions.destroy', $exemption->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('exemption_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.exemptions.massDestroy') }}",
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
  let table = $('.datatable-Exemption:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

})

</script>
@endsection
