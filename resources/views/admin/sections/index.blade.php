@extends('layouts.admin')
@section('content')
@can('section_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.sections.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.section.title_singular') }}
            </a>
            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'Section', 'route' => 'admin.sections.parseCsvImport'])
        </div>
    </div>
@endcan
<div class="card_">
    <div class="card-header_">
        {{ trans('cruds.section.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body_">
        <div class="table-responsive_">
            <table class=" table   table-hover datatable datatable-Section">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.section.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.section.fields.name') }}
                        </th>
                        <th>
                            {{ trans('cruds.section.fields.short_name') }}
                        </th>
                        <th>
                            {{ trans('cruds.section.fields.seat_of_controlling_officer') }}
                        </th>
                        <th>
                            {{ trans('cruds.section.fields.office_location') }}
                        </th>
                        <th>
                            {{ trans('cruds.section.fields.seat_of_reporting_officer') }}
                        </th>
                     
                        <th>
                            {{ trans('cruds.section.fields.type') }}
                        </th>
                       
                        <th>
                            {{ trans('cruds.section.fields.start_date') }}
                        </th>
                        <th>
                            {{ trans('cruds.section.fields.end_date') }}
                        </th>
                        <th>
                            {{ trans('cruds.section.fields.status') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sections as $key => $section)
                        <tr data-entry-id="{{ $section->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $section->id ?? '' }}
                            </td>
                            <td>
                                {{ $section->name ?? '' }}
                            </td>
                            <td>
                                {{ $section->short_name ?? '' }}
                            </td>
                            <td>
                                {{ $section->seat_of_controlling_officer->title ?? '' }}
                            </td>
                            <td>
                                {{ $section->office_location->location ?? '' }}
                            </td>
                            <td>
                                {{ $section->seat_of_reporting_officer->title ?? '' }}
                            </td>
                            
                            <td>
                                {{ App\Models\Section::TYPE_SELECT[$section->type] ?? '' }}
                            </td>
                           
                            <td>
                                {{ $section->start_date ?? '' }}
                            </td>
                            <td>
                                {{ $section->end_date ?? '' }}
                            </td>
                            <td>
                                {{ App\Models\Section::STATUS_SELECT[$section->status] ?? '' }}
                            </td>
                            <td>
                                @can('section_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.sections.show', $section->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('section_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.sections.edit', $section->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('section_delete')
                                    <form action="{{ route('admin.sections.destroy', $section->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('section_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.sections.massDestroy') }}",
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
  let table = $('.datatable-Section:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

})

</script>
@endsection
