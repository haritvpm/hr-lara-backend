@extends('layouts.admin')
@section('content')
@can('ot_form_other_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.ot-form-others.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.otFormOther.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card_">
    <div class="card-header_">
        {{ trans('cruds.otFormOther.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body_">
        <div class="table-responsive_">
            <table class=" table   table-hover datatable datatable-OtFormOther">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.otFormOther.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.otFormOther.fields.creator') }}
                        </th>
                        <th>
                            {{ trans('cruds.otFormOther.fields.owner') }}
                        </th>
                        <th>
                            {{ trans('cruds.otFormOther.fields.session') }}
                        </th>
                        <th>
                            {{ trans('cruds.otFormOther.fields.submitted_by') }}
                        </th>
                        <th>
                            {{ trans('cruds.otFormOther.fields.submitted_on') }}
                        </th>
                        <th>
                            {{ trans('cruds.otFormOther.fields.form_no') }}
                        </th>
                        <th>
                            {{ trans('cruds.otFormOther.fields.duty_date') }}
                        </th>
                        <th>
                            {{ trans('cruds.otFormOther.fields.date_from') }}
                        </th>
                        <th>
                            {{ trans('cruds.otFormOther.fields.date_to') }}
                        </th>
                        <th>
                            {{ trans('cruds.otFormOther.fields.remarks') }}
                        </th>
                        <th>
                            {{ trans('cruds.otFormOther.fields.overtime_slot') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($otFormOthers as $key => $otFormOther)
                        <tr data-entry-id="{{ $otFormOther->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $otFormOther->id ?? '' }}
                            </td>
                            <td>
                                {{ $otFormOther->creator ?? '' }}
                            </td>
                            <td>
                                {{ $otFormOther->owner ?? '' }}
                            </td>
                            <td>
                                {{ $otFormOther->session->name ?? '' }}
                            </td>
                            <td>
                                {{ $otFormOther->submitted_by ?? '' }}
                            </td>
                            <td>
                                {{ $otFormOther->submitted_on ?? '' }}
                            </td>
                            <td>
                                {{ $otFormOther->form_no ?? '' }}
                            </td>
                            <td>
                                {{ $otFormOther->duty_date ?? '' }}
                            </td>
                            <td>
                                {{ $otFormOther->date_from ?? '' }}
                            </td>
                            <td>
                                {{ $otFormOther->date_to ?? '' }}
                            </td>
                            <td>
                                {{ $otFormOther->remarks ?? '' }}
                            </td>
                            <td>
                                {{ App\Models\OtFormOther::OVERTIME_SLOT_SELECT[$otFormOther->overtime_slot] ?? '' }}
                            </td>
                            <td>
                                @can('ot_form_other_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.ot-form-others.show', $otFormOther->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('ot_form_other_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.ot-form-others.edit', $otFormOther->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('ot_form_other_delete')
                                    <form action="{{ route('admin.ot-form-others.destroy', $otFormOther->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('ot_form_other_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.ot-form-others.massDestroy') }}",
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
  let table = $('.datatable-OtFormOther:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

})

</script>
@endsection
