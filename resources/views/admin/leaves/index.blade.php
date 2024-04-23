@extends('layouts.admin')
@section('content')
@can('leaf_create')
    <div style="margin-bottom: 10px;" class="row">
            <a class="ml-2 btn btn-success" href="{{ route('admin.leaves.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.leaf.title_singular') }}
            </a>


        <div class="ml-2 dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Actions
                </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item"  href="{{ route('admin.leaves.aebasdownload') }}">Download All Leaves from AEBAS</a>
                <!-- <a class="dropdown-item" href="#">Another action</a> -->
            </div>

            </div>

    </div>

    

@endcan
<div class="card_">
    <div class="card-header_">
        {{ trans('cruds.leaf.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body_">
        <div class="table-responsive_">
            <table class=" table   table-hover datatable datatable-Leaf">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.leaf.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.leaf.fields.employee') }}
                        </th>
                        <th>
                            {{ trans('cruds.employee.fields.pen') }}
                        </th>
                        <th>
                            {{ trans('cruds.employee.fields.aadhaarid') }}
                        </th>
                        <th>
                            {{ trans('cruds.leaf.fields.leave_type') }}
                        </th>
                        <th>
                            {{ trans('cruds.leaf.fields.start_date') }}
                        </th>
                        <th>
                            {{ trans('cruds.leaf.fields.end_date') }}
                        </th>
                        <th>
                            {{ trans('cruds.leaf.fields.reason') }}
                        </th>
                        <th>
                            {{ trans('cruds.leaf.fields.active_status') }}
                        </th>
                        <th>
                            {{ trans('cruds.leaf.fields.leave_cat') }}
                        </th>
                        <th>
                            {{ trans('cruds.leaf.fields.time_period') }}
                        </th>
                        <th>
                            {{ trans('cruds.leaf.fields.created_by') }}
                        </th>
                        <th>
                            {{ trans('cruds.employee.fields.aadhaarid') }}
                        </th>
                        <th>
                            {{ trans('cruds.leaf.fields.in_lieu_of') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($leaves as $key => $leaf)
                        <tr data-entry-id="{{ $leaf->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $leaf->id ?? '' }}
                            </td>
                            <td>
                                {{ $leaf->employee->name ?? '' }}
                            </td>
                            <td>
                                {{ $leaf->employee->pen ?? '' }}
                            </td>
                            <td>
                                {{ $leaf->employee->aadhaarid ?? '' }}
                            </td>
                            <td>
                                {{ App\Models\Leaf::LEAVE_TYPE_SELECT[$leaf->leave_type] ?? '' }}
                            </td>
                            <td>
                                {{ $leaf->start_date ?? '' }}
                            </td>
                            <td>
                                {{ $leaf->end_date ?? '' }}
                            </td>
                            <td>
                                {{ $leaf->reason ?? '' }}
                            </td>
                            <td>
                                {{ $leaf->active_status ?? '' }}
                            </td>
                            <td>
                                {{ App\Models\Leaf::LEAVE_CAT_SELECT[$leaf->leave_cat] ?? '' }}
                            </td>
                            <td>
                                {{ App\Models\Leaf::TIME_PERIOD_SELECT[$leaf->time_period] ?? '' }}
                            </td>
                            <td>
                                {{ $leaf->created_by->name ?? '' }}
                            </td>
                            <td>
                                {{ $leaf->created_by->aadhaarid ?? '' }}
                            </td>
                            <td>
                                {{ $leaf->in_lieu_of ?? '' }}
                            </td>
                            <td>
                                @can('leaf_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.leaves.show', $leaf->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('leaf_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.leaves.edit', $leaf->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('leaf_delete')
                                    <form action="{{ route('admin.leaves.destroy', $leaf->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('leaf_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.leaves.massDestroy') }}",
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
  let table = $('.datatable-Leaf:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

})

</script>
@endsection
