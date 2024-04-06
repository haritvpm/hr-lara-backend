<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyTaxEntryRequest;
use App\Http\Requests\StoreTaxEntryRequest;
use App\Http\Requests\UpdateTaxEntryRequest;
use App\Models\Seat;
use App\Models\TaxEntry;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class TaxEntriesController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('tax_entry_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = TaxEntry::with(['created_by'])->select(sprintf('%s.*', (new TaxEntry)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'tax_entry_show';
                $editGate      = 'tax_entry_edit';
                $deleteGate    = 'tax_entry_delete';
                $crudRoutePart = 'tax-entries';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });

            $table->editColumn('status', function ($row) {
                return $row->status ? $row->status : '';
            });
            $table->editColumn('acquittance', function ($row) {
                return $row->acquittance ? $row->acquittance : '';
            });
            $table->addColumn('created_by_title', function ($row) {
                return $row->created_by ? $row->created_by->title : '';
            });

            $table->editColumn('sparkcode', function ($row) {
                return $row->sparkcode ? $row->sparkcode : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'created_by']);

            return $table->make(true);
        }

        return view('admin.taxEntries.index');
    }

    public function create()
    {
        abort_if(Gate::denies('tax_entry_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $created_bies = Seat::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.taxEntries.create', compact('created_bies'));
    }

    public function store(StoreTaxEntryRequest $request)
    {
        $taxEntry = TaxEntry::create($request->all());

        return redirect()->route('admin.tax-entries.index');
    }

    public function edit(TaxEntry $taxEntry)
    {
        abort_if(Gate::denies('tax_entry_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $created_bies = Seat::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $taxEntry->load('created_by');

        return view('admin.taxEntries.edit', compact('created_bies', 'taxEntry'));
    }

    public function update(UpdateTaxEntryRequest $request, TaxEntry $taxEntry)
    {
        $taxEntry->update($request->all());

        return redirect()->route('admin.tax-entries.index');
    }

    public function show(TaxEntry $taxEntry)
    {
        abort_if(Gate::denies('tax_entry_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $taxEntry->load('created_by', 'dateTds');

        return view('admin.taxEntries.show', compact('taxEntry'));
    }

    public function destroy(TaxEntry $taxEntry)
    {
        abort_if(Gate::denies('tax_entry_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $taxEntry->delete();

        return back();
    }

    public function massDestroy(MassDestroyTaxEntryRequest $request)
    {
        $taxEntries = TaxEntry::find(request('ids'));

        foreach ($taxEntries as $taxEntry) {
            $taxEntry->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
