<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaxEntryRequest;
use App\Http\Requests\UpdateTaxEntryRequest;
use App\Http\Resources\Admin\TaxEntryResource;
use App\Models\TaxEntry;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TaxEntriesApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('tax_entry_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new TaxEntryResource(TaxEntry::with(['created_by'])->get());
    }

    public function store(StoreTaxEntryRequest $request)
    {
        $taxEntry = TaxEntry::create($request->all());

        return (new TaxEntryResource($taxEntry))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(TaxEntry $taxEntry)
    {
        abort_if(Gate::denies('tax_entry_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new TaxEntryResource($taxEntry->load(['created_by']));
    }

    public function update(UpdateTaxEntryRequest $request, TaxEntry $taxEntry)
    {
        $taxEntry->update($request->all());

        return (new TaxEntryResource($taxEntry))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(TaxEntry $taxEntry)
    {
        abort_if(Gate::denies('tax_entry_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $taxEntry->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
