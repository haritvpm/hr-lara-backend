@extends('layouts.admin')
@section('content')
@can('leave_group_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.leave-groups.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.leaveGroup.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.leaveGroup.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-LeaveGroup">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.leaveGroup.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.leaveGroup.fields.groupname') }}
                        </th>
                        <th>
                            {{ trans('cruds.leaveGroup.fields.allowed_casual_per_year') }}
                        </th>
                        <th>
                            {{ trans('cruds.leaveGroup.fields.allowed_compen_per_year') }}
                        </th>
                        <th>
                            {{ trans('cruds.leaveGroup.fields.allowed_special_casual_per_year') }}
                        </th>
                        <th>
                            {{ trans('cruds.leaveGroup.fields.allowed_earned_per_year') }}
                        </th>
                        <th>
                            {{ trans('cruds.leaveGroup.fields.allowed_halfpay_per_year') }}
                        </th>
                        <th>
                            {{ trans('cruds.leaveGroup.fields.allowed_continuous_casual_and_compen') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($leaveGroups as $key => $leaveGroup)
                        <tr data-entry-id="{{ $leaveGroup->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $leaveGroup->id ?? '' }}
                            </td>
                            <td>
                                {{ $leaveGroup->groupname ?? '' }}
                            </td>
                            <td>
                                {{ $leaveGroup->allowed_casual_per_year ?? '' }}
                            </td>
                            <td>
                                {{ $leaveGroup->allowed_compen_per_year ?? '' }}
                            </td>
                            <td>
                                {{ $leaveGroup->allowed_special_casual_per_year ?? '' }}
                            </td>
                            <td>
                                {{ $leaveGroup->allowed_earned_per_year ?? '' }}
                            </td>
                            <td>
                                {{ $leaveGroup->allowed_halfpay_per_year ?? '' }}
                            </td>
                            <td>
                                {{ $leaveGroup->allowed_continuous_casual_and_compen ?? '' }}
                            </td>
                            <td>
                                @can('leave_group_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.leave-groups.show', $leaveGroup->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('leave_group_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.leave-groups.edit', $leaveGroup->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('leave_group_delete')
                                    <form action="{{ route('admin.leave-groups.destroy', $leaveGroup->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('leave_group_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.leave-groups.massDestroy') }}",
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
  let table = $('.datatable-LeaveGroup:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection