@extends('layouts.admin')
@section('content')
@can('employee_section_history_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.employee-section-histories.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.employeeSectionHistory.title_singular') }}
            </a>
            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'EmployeeSectionHistory', 'route' => 'admin.employee-section-histories.parseCsvImport'])
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.employeeSectionHistory.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-EmployeeSectionHistory">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.employeeSectionHistory.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.employeeSectionHistory.fields.employee') }}
                        </th>
                        <th>
                            {{ trans('cruds.employee.fields.aadhaarid') }}
                        </th>
                        <th>
                            {{ trans('cruds.employeeSectionHistory.fields.date_from') }}
                        </th>
                        <th>
                            {{ trans('cruds.employeeSectionHistory.fields.date_to') }}
                        </th>
                        <th>
                            {{ trans('cruds.employeeSectionHistory.fields.section_seat') }}
                        </th>
                        <th>
                            {{ trans('cruds.seat.fields.name') }}
                        </th>
                        <th>
                            {{ trans('cruds.employeeSectionHistory.fields.remarks') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($employeeSectionHistories as $key => $employeeSectionHistory)
                        <tr data-entry-id="{{ $employeeSectionHistory->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $employeeSectionHistory->id ?? '' }}
                            </td>
                            <td>
                                {{ $employeeSectionHistory->employee->name ?? '' }}
                            </td>
                            <td>
                                {{ $employeeSectionHistory->employee->aadhaarid ?? '' }}
                            </td>
                            <td>
                                {{ $employeeSectionHistory->date_from ?? '' }}
                            </td>
                            <td>
                                {{ $employeeSectionHistory->date_to ?? '' }}
                            </td>
                            <td>
                                {{ $employeeSectionHistory->section_seat->title ?? '' }}
                            </td>
                            <td>
                                {{ $employeeSectionHistory->section_seat->name ?? '' }}
                            </td>
                            <td>
                                {{ $employeeSectionHistory->remarks ?? '' }}
                            </td>
                            <td>
                                @can('employee_section_history_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.employee-section-histories.show', $employeeSectionHistory->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('employee_section_history_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.employee-section-histories.edit', $employeeSectionHistory->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('employee_section_history_delete')
                                    <form action="{{ route('admin.employee-section-histories.destroy', $employeeSectionHistory->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('employee_section_history_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.employee-section-histories.massDestroy') }}",
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
  let table = $('.datatable-EmployeeSectionHistory:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection