@extends('layouts.admin')
@section('content')
@can('office_location_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.office-locations.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.officeLocation.title_singular') }}
            </a>
            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'OfficeLocation', 'route' => 'admin.office-locations.parseCsvImport'])
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.officeLocation.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-OfficeLocation">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.officeLocation.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.officeLocation.fields.location') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($officeLocations as $key => $officeLocation)
                        <tr data-entry-id="{{ $officeLocation->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $officeLocation->id ?? '' }}
                            </td>
                            <td>
                                {{ $officeLocation->location ?? '' }}
                            </td>
                            <td>
                                @can('office_location_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.office-locations.show', $officeLocation->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('office_location_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.office-locations.edit', $officeLocation->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
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
  
  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-OfficeLocation:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection