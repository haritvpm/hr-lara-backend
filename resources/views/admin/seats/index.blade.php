@extends('layouts.admin')
@section('content')
@can('seat_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.seats.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.seat.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="">

    <div class="">
        <div class="">
            <table class=" table table-hover datatable datatable-Seat">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.seat.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.seat.fields.slug') }}
                        </th>
                        <th>
                            {{ trans('cruds.seat.fields.title') }}
                        </th>
                        <th>
                            {{ trans('cruds.seat.fields.has_files') }}
                        </th>
                        <th>
                            {{ trans('cruds.seat.fields.has_office_with_employees') }}
                        </th>
                        <th>
                            {{ trans('cruds.seat.fields.is_js_as_ss') }}
                        </th>
                        <th>
                            {{ trans('cruds.seat.fields.is_controlling_officer') }}
                        </th>
                        <th>
                            {{ trans('cruds.seat.fields.level') }}
                        </th>
                        <th>
                            {{ trans('cruds.seat.fields.roles') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($seats as $key => $seat)
                        <tr data-entry-id="{{ $seat->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $seat->id ?? '' }}
                            </td>
                            <td>
                                {{ $seat->slug ?? '' }}
                            </td>
                            <td>
                                {{ $seat->title ?? '' }}
                            </td>
                            <td>
                                <span style="display:none">{{ $seat->has_files ?? '' }}</span>
                                <input type="checkbox" disabled="disabled" {{ $seat->has_files ? 'checked' : '' }}>
                            </td>
                            <td>
                                <span style="display:none">{{ $seat->has_office_with_employees ?? '' }}</span>
                                <input type="checkbox" disabled="disabled" {{ $seat->has_office_with_employees ? 'checked' : '' }}>
                            </td>
                            <td>
                                <span style="display:none">{{ $seat->is_js_as_ss ?? '' }}</span>
                                <input type="checkbox" disabled="disabled" {{ $seat->is_js_as_ss ? 'checked' : '' }}>
                            </td>
                            <td>
                                <span style="display:none">{{ $seat->is_controlling_officer ?? '' }}</span>
                                <input type="checkbox" disabled="disabled" {{ $seat->is_controlling_officer ? 'checked' : '' }}>
                            </td>
                            <td>
                                {{ $seat->level ?? '' }}
                            </td>
                            <td>
                                @foreach($seat->roles as $key => $item)
                                    <span class="badge badge-info">{{ $item->title }}</span>
                                @endforeach
                            </td>
                            <td>
                                @can('seat_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.seats.show', $seat->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('seat_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.seats.edit', $seat->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('seat_delete')
                                    <form action="{{ route('admin.seats.destroy', $seat->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('seat_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.seats.massDestroy') }}",
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
  let table = $('.datatable-Seat:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

})

</script>
@endsection
