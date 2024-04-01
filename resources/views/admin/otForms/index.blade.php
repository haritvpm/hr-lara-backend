@extends('layouts.admin')
@section('content')
@can('ot_form_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.ot-forms.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.otForm.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.otForm.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-OtForm">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.otForm.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.otForm.fields.creator') }}
                        </th>
                        <th>
                            {{ trans('cruds.otForm.fields.owner') }}
                        </th>
                        <th>
                            {{ trans('cruds.otForm.fields.session') }}
                        </th>
                        <th>
                            {{ trans('cruds.otForm.fields.submitted_by') }}
                        </th>
                        <th>
                            {{ trans('cruds.otForm.fields.submitted_names') }}
                        </th>
                        <th>
                            {{ trans('cruds.otForm.fields.submitted_on') }}
                        </th>
                        <th>
                            {{ trans('cruds.otForm.fields.form_no') }}
                        </th>
                        <th>
                            {{ trans('cruds.otForm.fields.duty_date') }}
                        </th>
                        <th>
                            {{ trans('cruds.otForm.fields.date_from') }}
                        </th>
                        <th>
                            {{ trans('cruds.otForm.fields.date_to') }}
                        </th>
                        <th>
                            {{ trans('cruds.otForm.fields.remarks') }}
                        </th>
                        <th>
                            {{ trans('cruds.otForm.fields.worknature') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($otForms as $key => $otForm)
                        <tr data-entry-id="{{ $otForm->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $otForm->id ?? '' }}
                            </td>
                            <td>
                                {{ $otForm->creator ?? '' }}
                            </td>
                            <td>
                                {{ $otForm->owner ?? '' }}
                            </td>
                            <td>
                                {{ $otForm->session->name ?? '' }}
                            </td>
                            <td>
                                {{ $otForm->submitted_by ?? '' }}
                            </td>
                            <td>
                                {{ $otForm->submitted_names ?? '' }}
                            </td>
                            <td>
                                {{ $otForm->submitted_on ?? '' }}
                            </td>
                            <td>
                                {{ $otForm->form_no ?? '' }}
                            </td>
                            <td>
                                {{ $otForm->duty_date ?? '' }}
                            </td>
                            <td>
                                {{ $otForm->date_from ?? '' }}
                            </td>
                            <td>
                                {{ $otForm->date_to ?? '' }}
                            </td>
                            <td>
                                {{ $otForm->remarks ?? '' }}
                            </td>
                            <td>
                                {{ $otForm->worknature ?? '' }}
                            </td>
                            <td>
                                @can('ot_form_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.ot-forms.show', $otForm->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('ot_form_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.ot-forms.edit', $otForm->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('ot_form_delete')
                                    <form action="{{ route('admin.ot-forms.destroy', $otForm->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('ot_form_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.ot-forms.massDestroy') }}",
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
  let table = $('.datatable-OtForm:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection