@extends('layouts.admin')
@section('content')

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
                        {{ trans('cruds.employee.fields.aadhaarid') }}
                    </th>

                    <!-- <th>
                        {{ trans('cruds.punching.fields.designation') }}
                    </th> -->

                    <th>
                        {{ trans('cruds.punching.fields.punchin_trace') }}
                    </th>

                    <th>
                        {{ trans('cruds.punching.fields.punchout_trace') }}
                    </th>

                    <!-- <th>
                        {{ trans('cruds.punching.fields.in_datetime') }}
                    </th>
                    <th>
                        {{ trans('cruds.punching.fields.out_datetime') }}
                    </th> -->
                    <!-- <th>
                        {{ trans('cruds.punching.fields.duration_sec') }}
                    </th> -->
                    <th>
                        {{ trans('cruds.punching.fields.grace_sec') }}
                    </th>
                    <th>
                        {{ trans('cruds.punching.fields.extra_sec') }}
                    </th>
                    <!-- <th>
                        {{ trans('cruds.punching.fields.duration_str') }}
                    </th>
                    <th>
                        {{ trans('cruds.punching.fields.grace_str') }}
                    </th>
                    <th>
                        {{ trans('cruds.punching.fields.extra_str') }}
                    </th> -->
                    <th>
                        {{ trans('cruds.punching.fields.punching_count') }}
                    </th>
                    <th>
                        {{ trans('cruds.punching.fields.leave') }}
                    </th>
                    <!-- <th>
                        {{ trans('cruds.leaf.fields.start_date') }}
                    </th>
                    <th>
                        {{ trans('cruds.leaf.fields.end_date') }}
                    </th> -->
                    <th>
                        {{ trans('cruds.punching.fields.remarks') }}
                    </th>
                    <!-- <th>
                        {{ trans('cruds.punching.fields.finalized_by_controller') }}
                    </th> -->
                    <!-- <th>
                        {{ trans('cruds.punching.fields.ot_sitting_sec') }}
                    </th>
                    <th>
                        {{ trans('cruds.punching.fields.ot_nonsitting_sec') }}
                    </th> -->

                    <th>
                    computer_hint
                    </th>
                    <th>
                        {{ trans('cruds.punching.fields.hint') }}
                    </th>
                    <!-- <th>
                        {{ trans('cruds.punching.fields.controller_set_punch_in') }}
                    </th>
                    <th>
                        {{ trans('cruds.punching.fields.controller_set_punch_out') }}
                    </th> -->
                    <!-- <th>
                        {{ trans('cruds.punching.fields.grace_total_exceeded_one_hour') }}
                    </th> -->
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
{ data: 'employee.aadhaarid', name: 'employee.aadhaarid' },
// { data: 'designation', name: 'designation' },
{ data: 'punchin_trace_att_time', name: 'punchin_trace.att_time' },
// { data: 'punchin_trace.att_date', name: 'punchin_trace.att_date' },
{ data: 'punchout_trace_att_time', name: 'punchout_trace.att_time' },
// { data: 'punchout_trace.att_date', name: 'punchout_trace.att_date' },
// { data: 'in_datetime', name: 'in_datetime' },
// { data: 'out_datetime', name: 'out_datetime' },
// { data: 'duration_sec', name: 'duration_sec' },
{ data: 'grace_sec', name: 'grace_sec' },
{ data: 'extra_sec', name: 'extra_sec' },
// { data: 'duration_str', name: 'duration_str' },
// { data: 'grace_str', name: 'grace_str' },
// { data: 'extra_str', name: 'extra_str' },
{ data: 'punching_count', name: 'punching_count' },
{ data: 'leave_id', name: 'leave_id' },
// { data: 'leave.start_date', name: 'leave.start_date' },
// { data: 'leave.end_date', name: 'leave.end_date' },
{ data: 'remarks', name: 'remarks' },
// { data: 'finalized_by_controller', name: 'finalized_by_controller' },
// { data: 'ot_sitting_sec', name: 'ot_sitting_sec' },
// { data: 'ot_nonsitting_sec', name: 'ot_nonsitting_sec' },
{ data: 'computer_hint', name: 'computer_hint' },

{ data: 'hint', name: 'hint' },
// { data: 'controller_set_punch_in', name: 'controller_set_punch_in' },
// { data: 'controller_set_punch_out', name: 'controller_set_punch_out' },
// { data: 'grace_total_exceeded_one_hour', name: 'grace_total_exceeded_one_hour' },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 3, 'desc' ]],
    pageLength: 15,
  };
  let table = $('.datatable-Punching').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

});

</script>
@endsection
