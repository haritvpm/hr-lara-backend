@extends('layouts.admin')
@section('content')
@can('designation_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.designations.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.designation.title_singular') }}
            </a>
            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'Designation', 'route' => 'admin.designations.parseCsvImport'])
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.designation.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Designation">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.designation.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.designation.fields.designation') }}
                        </th>
                        <th>
                            {{ trans('cruds.designation.fields.designation_mal') }}
                        </th>
                        <th>
                            {{ trans('cruds.designation.fields.sort_index') }}
                        </th>
                        <th>
                            {{ trans('cruds.designation.fields.has_punching') }}
                        </th>
                        <th>
                            {{ trans('cruds.designation.fields.desig_line') }}
                        </th>
                        <th>
                            {{ trans('cruds.designation.fields.designation_wo_grade') }}
                        </th>
                        <th>
                            {{ trans('cruds.designation.fields.time_group') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($designations as $key => $designation)
                        <tr data-entry-id="{{ $designation->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $designation->id ?? '' }}
                            </td>
                            <td>
                                {{ $designation->designation ?? '' }}
                            </td>
                            <td>
                                {{ $designation->designation_mal ?? '' }}
                            </td>
                            <td>
                                {{ $designation->sort_index ?? '' }}
                            </td>
                            <td>
                                {{ $designation->has_punching ?? '' }}
                            </td>
                            <td>
                                {{ $designation->desig_line->title ?? '' }}
                            </td>
                            <td>
                                {{ $designation->designation_wo_grade->title ?? '' }}
                            </td>
                            <td>
                                {{ $designation->time_group->groupname ?? '' }}
                            </td>
                            <td>
                                @can('designation_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.designations.show', $designation->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('designation_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.designations.edit', $designation->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('designation_delete')
                                    <form action="{{ route('admin.designations.destroy', $designation->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('designation_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.designations.massDestroy') }}",
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
  let table = $('.datatable-Designation:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection