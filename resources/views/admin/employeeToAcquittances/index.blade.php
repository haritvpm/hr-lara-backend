@extends('layouts.admin')
@section('content')
@can('employee_to_acquittance_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.employee-to-acquittances.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.employeeToAcquittance.title_singular') }}
            </a>
            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'EmployeeToAcquittance', 'route' => 'admin.employee-to-acquittances.parseCsvImport'])
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.employeeToAcquittance.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-EmployeeToAcquittance">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.employeeToAcquittance.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.employeeToAcquittance.fields.employee') }}
                        </th>
                        <th>
                            {{ trans('cruds.employee.fields.pen') }}
                        </th>
                        <th>
                            {{ trans('cruds.employeeToAcquittance.fields.acquittance') }}
                        </th>
                        <th>
                            {{ trans('cruds.employeeToAcquittance.fields.start_date') }}
                        </th>
                        <th>
                            {{ trans('cruds.employeeToAcquittance.fields.end_date') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($employeeToAcquittances as $key => $employeeToAcquittance)
                        <tr data-entry-id="{{ $employeeToAcquittance->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $employeeToAcquittance->id ?? '' }}
                            </td>
                            <td>
                                {{ $employeeToAcquittance->employee->name ?? '' }}
                            </td>
                            <td>
                                {{ $employeeToAcquittance->employee->pen ?? '' }}
                            </td>
                            <td>
                                {{ $employeeToAcquittance->acquittance->title ?? '' }}
                            </td>
                            <td>
                                {{ $employeeToAcquittance->start_date ?? '' }}
                            </td>
                            <td>
                                {{ $employeeToAcquittance->end_date ?? '' }}
                            </td>
                            <td>
                                @can('employee_to_acquittance_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.employee-to-acquittances.show', $employeeToAcquittance->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('employee_to_acquittance_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.employee-to-acquittances.edit', $employeeToAcquittance->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('employee_to_acquittance_delete')
                                    <form action="{{ route('admin.employee-to-acquittances.destroy', $employeeToAcquittance->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('employee_to_acquittance_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.employee-to-acquittances.massDestroy') }}",
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
  let table = $('.datatable-EmployeeToAcquittance:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection