@extends('layouts.admin')
@section('content')
@can('punching_register_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.punching-registers.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.punchingRegister.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.punchingRegister.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-PunchingRegister">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.punchingRegister.fields.date') }}
                    </th>
                    <th>
                        {{ trans('cruds.punchingRegister.fields.employee') }}
                    </th>
                    <th>
                        {{ trans('cruds.employee.fields.pen') }}
                    </th>
                    <th>
                        {{ trans('cruds.employee.fields.aadhaarid') }}
                    </th>
                    <th>
                        {{ trans('cruds.punchingRegister.fields.duration') }}
                    </th>
                    <th>
                        {{ trans('cruds.punchingRegister.fields.flexi') }}
                    </th>
                    <th>
                        {{ trans('cruds.punchingRegister.fields.grace_min') }}
                    </th>
                    <th>
                        {{ trans('cruds.punchingRegister.fields.extra_min') }}
                    </th>
                    <th>
                        {{ trans('cruds.punchingRegister.fields.success_punching') }}
                    </th>
                    <th>
                        {{ trans('cruds.punchingRegister.fields.punching_trace') }}
                    </th>
                    <th>
                        {{ trans('cruds.punchingRegister.fields.designation') }}
                    </th>
                    <th>
                        &nbsp;
                    </th>
                </tr>
            </thead>
        </table>
    </div>
</div>



@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
  
  let dtOverrideGlobals = {
    buttons: dtButtons,
    processing: true,
    serverSide: true,
    retrieve: true,
    aaSorting: [],
    ajax: "{{ route('admin.punching-registers.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'date', name: 'date' },
{ data: 'employee_name', name: 'employee.name' },
{ data: 'employee.pen', name: 'employee.pen' },
{ data: 'employee.aadhaarid', name: 'employee.aadhaarid' },
{ data: 'duration', name: 'duration' },
{ data: 'flexi', name: 'flexi' },
{ data: 'grace_min', name: 'grace_min' },
{ data: 'extra_min', name: 'extra_min' },
{ data: 'success_punching_date', name: 'success_punching.date' },
{ data: 'punching_trace', name: 'punching_traces.att_date' },
{ data: 'designation', name: 'designation' },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 2, 'desc' ]],
    pageLength: 100,
  };
  let table = $('.datatable-PunchingRegister').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
});

</script>
@endsection