@extends('layouts.admin')
@section('content')
@can('dept_employee_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.dept-employees.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.deptEmployee.title_singular') }}
            </a>
            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'DeptEmployee', 'route' => 'admin.dept-employees.parseCsvImport'])
        </div>
    </div>
@endcan
<div class="card_">
    <div class="card-header_">
        {{ trans('cruds.deptEmployee.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body_">
        <div class="table-responsive_">
            <table class=" table   table-hover datatable datatable-DeptEmployee">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.deptEmployee.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.deptEmployee.fields.srismt') }}
                        </th>
                        <th>
                            {{ trans('cruds.deptEmployee.fields.name') }}
                        </th>
                        <th>
                            {{ trans('cruds.deptEmployee.fields.pen') }}
                        </th>
                        <th>
                            {{ trans('cruds.deptEmployee.fields.designation') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($deptEmployees as $key => $deptEmployee)
                        <tr data-entry-id="{{ $deptEmployee->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $deptEmployee->id ?? '' }}
                            </td>
                            <td>
                                {{ App\Models\DeptEmployee::SRISMT_SELECT[$deptEmployee->srismt] ?? '' }}
                            </td>
                            <td>
                                {{ $deptEmployee->name ?? '' }}
                            </td>
                            <td>
                                {{ $deptEmployee->pen ?? '' }}
                            </td>
                            <td>
                                {{ $deptEmployee->designation->title ?? '' }}
                            </td>
                            <td>
                                @can('dept_employee_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.dept-employees.show', $deptEmployee->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('dept_employee_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.dept-employees.edit', $deptEmployee->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('dept_employee_delete')
                                    <form action="{{ route('admin.dept-employees.destroy', $deptEmployee->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('dept_employee_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.dept-employees.massDestroy') }}",
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
  let table = $('.datatable-DeptEmployee:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

})

</script>
@endsection
