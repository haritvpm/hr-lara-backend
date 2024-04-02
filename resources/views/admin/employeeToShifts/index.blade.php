@extends('layouts.admin')
@section('content')
@can('employee_to_shift_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.employee-to-shifts.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.employeeToShift.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.employeeToShift.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-EmployeeToShift">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.employeeToShift.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.employeeToShift.fields.employee') }}
                        </th>
                        <th>
                            {{ trans('cruds.employee.fields.pen') }}
                        </th>
                        <th>
                            {{ trans('cruds.employeeToShift.fields.shift') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($employeeToShifts as $key => $employeeToShift)
                        <tr data-entry-id="{{ $employeeToShift->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $employeeToShift->id ?? '' }}
                            </td>
                            <td>
                                {{ $employeeToShift->employee->name ?? '' }}
                            </td>
                            <td>
                                {{ $employeeToShift->employee->pen ?? '' }}
                            </td>
                            <td>
                                {{ $employeeToShift->shift->name ?? '' }}
                            </td>
                            <td>
                                @can('employee_to_shift_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.employee-to-shifts.show', $employeeToShift->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('employee_to_shift_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.employee-to-shifts.edit', $employeeToShift->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('employee_to_shift_delete')
                                    <form action="{{ route('admin.employee-to-shifts.destroy', $employeeToShift->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('employee_to_shift_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.employee-to-shifts.massDestroy') }}",
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
  let table = $('.datatable-EmployeeToShift:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection