@extends('layouts.admin')
@section('content')
@can('punching_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.punchings.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.punching.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.punching.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Punching">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.punching.fields.date') }}
                    </th>
                    <th>
                        {{ trans('cruds.punching.fields.employee') }}
                    </th>
                    <th>
                        {{ trans('cruds.employee.fields.pen') }}
                    </th>
                    <th>
                        {{ trans('cruds.employee.fields.aadhaarid') }}
                    </th>
                    <th>
                        {{ trans('cruds.punching.fields.duration') }}
                    </th>
                    <th>
                        {{ trans('cruds.punching.fields.flexi') }}
                    </th>
                    <th>
                        {{ trans('cruds.punching.fields.grace') }}
                    </th>
                    <th>
                        {{ trans('cruds.punching.fields.extra') }}
                    </th>
                    <th>
                        {{ trans('cruds.punching.fields.remarks') }}
                    </th>
                    <th>
                        {{ trans('cruds.punching.fields.calc_complete') }}
                    </th>
                    <th>
                        {{ trans('cruds.punching.fields.punchin_trace') }}
                    </th>
                    <th>
                        {{ trans('cruds.punchingTrace.fields.att_date') }}
                    </th>
                    <th>
                        {{ trans('cruds.punching.fields.punchout_trace') }}
                    </th>
                    <th>
                        {{ trans('cruds.punchingTrace.fields.att_date') }}
                    </th>
                    <th>
                        {{ trans('cruds.punching.fields.ot_claimed_mins') }}
                    </th>
                    <th>
                        {{ trans('cruds.punching.fields.ot_extra_mins') }}
                    </th>
                    <th>
                        {{ trans('cruds.punching.fields.punching_status') }}
                    </th>
                    <th>
                        {{ trans('cruds.punching.fields.leave') }}
                    </th>
                    <th>
                        {{ trans('cruds.leaf.fields.start_date') }}
                    </th>
                    <th>
                        {{ trans('cruds.leaf.fields.end_date') }}
                    </th>
                    <th>
                        {{ trans('cruds.punching.fields.designation') }}
                    </th>
                    <th>
                        {{ trans('cruds.punching.fields.section') }}
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
    ajax: "{{ route('admin.punchings.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'date', name: 'date' },
{ data: 'employee_name', name: 'employee.name' },
{ data: 'employee.pen', name: 'employee.pen' },
{ data: 'employee.aadhaarid', name: 'employee.aadhaarid' },
{ data: 'duration', name: 'duration' },
{ data: 'flexi', name: 'flexi' },
{ data: 'grace', name: 'grace' },
{ data: 'extra', name: 'extra' },
{ data: 'remarks', name: 'remarks' },
{ data: 'calc_complete', name: 'calc_complete' },
{ data: 'punchin_trace_att_time', name: 'punchin_trace.att_time' },
{ data: 'punchin_trace.att_date', name: 'punchin_trace.att_date' },
{ data: 'punchout_trace_att_time', name: 'punchout_trace.att_time' },
{ data: 'punchout_trace.att_date', name: 'punchout_trace.att_date' },
{ data: 'ot_claimed_mins', name: 'ot_claimed_mins' },
{ data: 'ot_extra_mins', name: 'ot_extra_mins' },
{ data: 'punching_status', name: 'punching_status' },
{ data: 'leave_reason', name: 'leave.reason' },
{ data: 'leave.start_date', name: 'leave.start_date' },
{ data: 'leave.end_date', name: 'leave.end_date' },
{ data: 'designation_designation', name: 'designation.designation' },
{ data: 'section_name', name: 'section.name' },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 2, 'desc' ]],
    pageLength: 100,
  };
  let table = $('.datatable-Punching').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
});

</script>
@endsection