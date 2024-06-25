@extends('layouts.admin')
@section('content')
@can('employee_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.employee-extras.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.employeeExtra.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.employeeExtra.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-EmployeeExtra">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.employeeExtra.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.employeeExtra.fields.employee') }}
                        </th>
                        <th>
                            {{ trans('cruds.employee.fields.pen') }}
                        </th>
                        <th>
                            {{ trans('cruds.employee.fields.aadhaarid') }}
                        </th>
                        <th>
                            {{ trans('cruds.employeeExtra.fields.address') }}
                        </th>
                        <th>
                            {{ trans('cruds.employeeExtra.fields.date_of_joining_kla') }}
                        </th>
                        <th>
                            {{ trans('cruds.employeeExtra.fields.pan') }}
                        </th>
                        <th>
                            {{ trans('cruds.employeeExtra.fields.klaid') }}
                        </th>
                        <th>
                            {{ trans('cruds.employeeExtra.fields.electionid') }}
                        </th>
                        <th>
                            {{ trans('cruds.employeeExtra.fields.mobile') }}
                        </th>
                        <th>
                            {{ trans('cruds.employeeExtra.fields.email') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($employeeExtras as $key => $employeeExtra)
                        <tr data-entry-id="{{ $employeeExtra->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $employeeExtra->id ?? '' }}
                            </td>
                            <td>
                                {{ $employeeExtra->employee->name ?? '' }}
                            </td>
                            <td>
                                {{ $employeeExtra->employee->pen ?? '' }}
                            </td>
                            <td>
                                {{ $employeeExtra->employee->aadhaarid ?? '' }}
                            </td>
                            <td>
                                {{ $employeeExtra->address ?? '' }}
                            </td>
                            <td>
                                {{ $employeeExtra->date_of_joining_kla ?? '' }}
                            </td>
                            <td>
                                {{ $employeeExtra->pan ?? '' }}
                            </td>
                            <td>
                                {{ $employeeExtra->klaid ?? '' }}
                            </td>
                            <td>
                                {{ $employeeExtra->electionid ?? '' }}
                            </td>
                            <td>
                                {{ $employeeExtra->mobile ?? '' }}
                            </td>
                            <td>
                                {{ $employeeExtra->email ?? '' }}
                            </td>
                            <td>
                                @can('employee_extra_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.employee-extras.show', $employeeExtra->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('employee_extra_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.employee-extras.edit', $employeeExtra->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('employee_extra_delete')
                                    <form action="{{ route('admin.employee-extras.destroy', $employeeExtra->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('employee_extra_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.employee-extras.massDestroy') }}",
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
  let table = $('.datatable-EmployeeExtra:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

})

</script>
@endsection
