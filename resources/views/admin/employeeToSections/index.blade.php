@extends('layouts.admin')
@section('content')
@can('employee_to_section_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.employee-to-sections.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.employeeToSection.title_singular') }}
            </a>
            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'EmployeeToSection', 'route' => 'admin.employee-to-sections.parseCsvImport'])
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.employeeToSection.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-EmployeeToSection">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.employeeToSection.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.employeeToSection.fields.employee') }}
                        </th>
                        <th>
                            {{ trans('cruds.employee.fields.aadhaarid') }}
                        </th>
                        <th>
                            {{ trans('cruds.employeeToSection.fields.section_seat') }}
                        </th>
                        <th>
                            {{ trans('cruds.seat.fields.name') }}
                        </th>
                        <th>
                            {{ trans('cruds.employeeToSection.fields.attendance_book') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($employeeToSections as $key => $employeeToSection)
                        <tr data-entry-id="{{ $employeeToSection->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $employeeToSection->id ?? '' }}
                            </td>
                            <td>
                                {{ $employeeToSection->employee->name ?? '' }}
                            </td>
                            <td>
                                {{ $employeeToSection->employee->aadhaarid ?? '' }}
                            </td>
                            <td>
                                {{ $employeeToSection->section_seat->title ?? '' }}
                            </td>
                            <td>
                                {{ $employeeToSection->section_seat->name ?? '' }}
                            </td>
                            <td>
                                {{ $employeeToSection->attendance_book->title ?? '' }}
                            </td>
                            <td>
                                @can('employee_to_section_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.employee-to-sections.show', $employeeToSection->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('employee_to_section_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.employee-to-sections.edit', $employeeToSection->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('employee_to_section_delete')
                                    <form action="{{ route('admin.employee-to-sections.destroy', $employeeToSection->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('employee_to_section_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.employee-to-sections.massDestroy') }}",
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
  let table = $('.datatable-EmployeeToSection:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection