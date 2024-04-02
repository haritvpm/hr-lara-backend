@extends('layouts.admin')
@section('content')
@can('employee_ot_data_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.employee-ot-datas.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.employeeOtData.title_singular') }}
            </a>
            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'EmployeeOtData', 'route' => 'admin.employee-ot-datas.parseCsvImport'])
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.employeeOtData.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-EmployeeOtData">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.employeeOtData.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.employeeOtData.fields.employee') }}
                        </th>
                        <th>
                            {{ trans('cruds.employee.fields.pen') }}
                        </th>
                        <th>
                            {{ trans('cruds.employee.fields.aadhaarid') }}
                        </th>
                        <th>
                            {{ trans('cruds.employeeOtData.fields.is_admin_data_entry') }}
                        </th>
                        <th>
                            {{ trans('cruds.employeeOtData.fields.ot_excel_category') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($employeeOtDatas as $key => $employeeOtData)
                        <tr data-entry-id="{{ $employeeOtData->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $employeeOtData->id ?? '' }}
                            </td>
                            <td>
                                {{ $employeeOtData->employee->name ?? '' }}
                            </td>
                            <td>
                                {{ $employeeOtData->employee->pen ?? '' }}
                            </td>
                            <td>
                                {{ $employeeOtData->employee->aadhaarid ?? '' }}
                            </td>
                            <td>
                                <span style="display:none">{{ $employeeOtData->is_admin_data_entry ?? '' }}</span>
                                <input type="checkbox" disabled="disabled" {{ $employeeOtData->is_admin_data_entry ? 'checked' : '' }}>
                            </td>
                            <td>
                                {{ $employeeOtData->ot_excel_category->category ?? '' }}
                            </td>
                            <td>
                                @can('employee_ot_data_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.employee-ot-datas.show', $employeeOtData->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('employee_ot_data_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.employee-ot-datas.edit', $employeeOtData->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('employee_ot_data_delete')
                                    <form action="{{ route('admin.employee-ot-datas.destroy', $employeeOtData->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('employee_ot_data_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.employee-ot-datas.massDestroy') }}",
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
  let table = $('.datatable-EmployeeOtData:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection