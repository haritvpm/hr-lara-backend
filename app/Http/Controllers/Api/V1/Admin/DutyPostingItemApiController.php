<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDutyPostingItemRequest;
use App\Http\Requests\UpdateDutyPostingItemRequest;
use App\Http\Resources\Admin\DutyPostingItemResource;
use App\Models\DutyPostingItem;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DutyPostingItemApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('duty_posting_item_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new DutyPostingItemResource(DutyPostingItem::with(['employee', 'form'])->get());
    }

    public function store(StoreDutyPostingItemRequest $request)
    {
        $dutyPostingItem = DutyPostingItem::create($request->all());

        return (new DutyPostingItemResource($dutyPostingItem))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(DutyPostingItem $dutyPostingItem)
    {
        abort_if(Gate::denies('duty_posting_item_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new DutyPostingItemResource($dutyPostingItem->load(['employee', 'form']));
    }

    public function update(UpdateDutyPostingItemRequest $request, DutyPostingItem $dutyPostingItem)
    {
        $dutyPostingItem->update($request->all());

        return (new DutyPostingItemResource($dutyPostingItem))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(DutyPostingItem $dutyPostingItem)
    {
        abort_if(Gate::denies('duty_posting_item_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $dutyPostingItem->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
