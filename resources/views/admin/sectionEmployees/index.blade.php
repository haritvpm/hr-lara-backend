@extends('layouts.admin')
@section('content')
@can('section_employee_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.section-employees.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.sectionEmployee.title_singular') }}
            </a>
            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'SectionEmployee', 'route' => 'admin.section-employees.parseCsvImport'])
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.sectionEmployee.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-SectionEmployee">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.sectionEmployee.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.sectionEmployee.fields.employee') }}
                        </th>
                        <th>
                            {{ trans('cruds.employee.fields.aadhaarid') }}
                        </th>
                        <th>
                            {{ trans('cruds.sectionEmployee.fields.date_from') }}
                        </th>
                        <th>
                            {{ trans('cruds.sectionEmployee.fields.date_to') }}
                        </th>
                        <th>
                            {{ trans('cruds.sectionEmployee.fields.section') }}
                        </th>
                        <th>
                            {{ trans('cruds.sectionEmployee.fields.attendance_book') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sectionEmployees as $key => $sectionEmployee)
                        <tr data-entry-id="{{ $sectionEmployee->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $sectionEmployee->id ?? '' }}
                            </td>
                            <td>
                                {{ $sectionEmployee->employee->name ?? '' }}
                            </td>
                            <td>
                                {{ $sectionEmployee->employee->aadhaarid ?? '' }}
                            </td>
                            <td>
                                {{ $sectionEmployee->date_from ?? '' }}
                            </td>
                            <td>
                                {{ $sectionEmployee->date_to ?? '' }}
                            </td>
                            <td>
                                {{ $sectionEmployee->section->name ?? '' }}
                            </td>
                            <td>
                                {{ $sectionEmployee->attendance_book->title ?? '' }}
                            </td>
                            <td>
                                @can('section_employee_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.section-employees.show', $sectionEmployee->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('section_employee_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.section-employees.edit', $sectionEmployee->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('section_employee_delete')
                                    <form action="{{ route('admin.section-employees.destroy', $sectionEmployee->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('section_employee_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.section-employees.massDestroy') }}",
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
  let table = $('.datatable-SectionEmployee:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection