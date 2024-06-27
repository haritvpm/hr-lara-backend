@extends('layouts.admin')
@section('content')
@can('leave_form_detail_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.leave-form-details.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.leaveFormDetail.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.leaveFormDetail.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-LeaveFormDetail">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.leaveFormDetail.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.leaveFormDetail.fields.dob') }}
                        </th>
                        <th>
                            {{ trans('cruds.leaveFormDetail.fields.post') }}
                        </th>
                        <th>
                            {{ trans('cruds.leaveFormDetail.fields.dept') }}
                        </th>
                        <th>
                            {{ trans('cruds.leaveFormDetail.fields.pay') }}
                        </th>
                        <th>
                            {{ trans('cruds.leaveFormDetail.fields.doe') }}
                        </th>
                        <th>
                            {{ trans('cruds.leaveFormDetail.fields.date_of_confirmation') }}
                        </th>
                        <th>
                            {{ trans('cruds.leaveFormDetail.fields.address') }}
                        </th>
                        <th>
                            {{ trans('cruds.leaveFormDetail.fields.hra') }}
                        </th>
                        <th>
                            {{ trans('cruds.leaveFormDetail.fields.nature') }}
                        </th>
                        <th>
                            {{ trans('cruds.leaveFormDetail.fields.prefix') }}
                        </th>
                        <th>
                            {{ trans('cruds.leaveFormDetail.fields.suffix') }}
                        </th>
                        <th>
                            {{ trans('cruds.leaveFormDetail.fields.last_leave_info') }}
                        </th>
                        <th>
                            {{ trans('cruds.leaveFormDetail.fields.leave') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($leaveFormDetails as $key => $leaveFormDetail)
                        <tr data-entry-id="{{ $leaveFormDetail->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $leaveFormDetail->id ?? '' }}
                            </td>
                            <td>
                                {{ $leaveFormDetail->dob ?? '' }}
                            </td>
                            <td>
                                {{ $leaveFormDetail->post ?? '' }}
                            </td>
                            <td>
                                {{ $leaveFormDetail->dept ?? '' }}
                            </td>
                            <td>
                                {{ $leaveFormDetail->pay ?? '' }}
                            </td>
                            <td>
                                {{ $leaveFormDetail->doe ?? '' }}
                            </td>
                            <td>
                                {{ $leaveFormDetail->date_of_confirmation ?? '' }}
                            </td>
                            <td>
                                {{ $leaveFormDetail->address ?? '' }}
                            </td>
                            <td>
                                {{ $leaveFormDetail->hra ?? '' }}
                            </td>
                            <td>
                                {{ $leaveFormDetail->nature ?? '' }}
                            </td>
                            <td>
                                {{ $leaveFormDetail->prefix ?? '' }}
                            </td>
                            <td>
                                {{ $leaveFormDetail->suffix ?? '' }}
                            </td>
                            <td>
                                {{ $leaveFormDetail->last_leave_info ?? '' }}
                            </td>
                            <td>
                                {{ $leaveFormDetail->leave->leave_type ?? '' }}
                            </td>
                            <td>
                                @can('leave_form_detail_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.leave-form-details.show', $leaveFormDetail->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('leave_form_detail_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.leave-form-details.edit', $leaveFormDetail->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('leave_form_detail_delete')
                                    <form action="{{ route('admin.leave-form-details.destroy', $leaveFormDetail->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('leave_form_detail_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.leave-form-details.massDestroy') }}",
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
  let table = $('.datatable-LeaveFormDetail:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection