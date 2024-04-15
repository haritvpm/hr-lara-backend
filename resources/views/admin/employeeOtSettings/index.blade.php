@extends('layouts.admin')
@section('content')
@can('employee_ot_setting_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.employee-ot-settings.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.employeeOtSetting.title_singular') }}
            </a>
            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'EmployeeOtSetting', 'route' => 'admin.employee-ot-settings.parseCsvImport'])
        </div>
    </div>
@endcan
<div class="card_">
    <div class="card-header_">
        {{ trans('cruds.employeeOtSetting.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body_">
        <div class="table-responsive_">
            <table class=" table   table-hover datatable datatable-EmployeeOtSetting">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.employeeOtSetting.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.employeeOtSetting.fields.employee') }}
                        </th>
                        <th>
                            {{ trans('cruds.employee.fields.pen') }}
                        </th>
                        <th>
                            {{ trans('cruds.employee.fields.aadhaarid') }}
                        </th>
                        <th>
                            {{ trans('cruds.employeeOtSetting.fields.is_admin_data_entry') }}
                        </th>
                        <th>
                            {{ trans('cruds.employeeOtSetting.fields.ot_excel_category') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($employeeOtSettings as $key => $employeeOtSetting)
                        <tr data-entry-id="{{ $employeeOtSetting->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $employeeOtSetting->id ?? '' }}
                            </td>
                            <td>
                                {{ $employeeOtSetting->employee->name ?? '' }}
                            </td>
                            <td>
                                {{ $employeeOtSetting->employee->pen ?? '' }}
                            </td>
                            <td>
                                {{ $employeeOtSetting->employee->aadhaarid ?? '' }}
                            </td>
                            <td>
                                <span style="display:none">{{ $employeeOtSetting->is_admin_data_entry ?? '' }}</span>
                                <input type="checkbox" disabled="disabled" {{ $employeeOtSetting->is_admin_data_entry ? 'checked' : '' }}>
                            </td>
                            <td>
                                {{ $employeeOtSetting->ot_excel_category->category ?? '' }}
                            </td>
                            <td>
                                @can('employee_ot_setting_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.employee-ot-settings.show', $employeeOtSetting->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('employee_ot_setting_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.employee-ot-settings.edit', $employeeOtSetting->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('employee_ot_setting_delete')
                                    <form action="{{ route('admin.employee-ot-settings.destroy', $employeeOtSetting->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('employee_ot_setting_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.employee-ot-settings.massDestroy') }}",
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
  let table = $('.datatable-EmployeeOtSetting:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

})

</script>
@endsection
