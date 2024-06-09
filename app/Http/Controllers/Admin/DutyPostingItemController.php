<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyDutyPostingItemRequest;
use App\Http\Requests\StoreDutyPostingItemRequest;
use App\Http\Requests\UpdateDutyPostingItemRequest;
use App\Models\DutyPostingForm;
use App\Models\DutyPostingItem;
use App\Models\Employee;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DutyPostingItemController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('duty_posting_item_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $dutyPostingItems = DutyPostingItem::with(['employee', 'form'])->get();

        return view('admin.dutyPostingItems.index', compact('dutyPostingItems'));
    }

    public function create()
    {
        abort_if(Gate::denies('duty_posting_item_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employees = Employee::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $forms = DutyPostingForm::pluck('type', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.dutyPostingItems.create', compact('employees', 'forms'));
    }

    public function store(StoreDutyPostingItemRequest $request)
    {
        $dutyPostingItem = DutyPostingItem::create($request->all());

        return redirect()->route('admin.duty-posting-items.index');
    }

    public function edit(DutyPostingItem $dutyPostingItem)
    {
        abort_if(Gate::denies('duty_posting_item_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employees = Employee::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $forms = DutyPostingForm::pluck('type', 'id')->prepend(trans('global.pleaseSelect'), '');

        $dutyPostingItem->load('employee', 'form');

        return view('admin.dutyPostingItems.edit', compact('dutyPostingItem', 'employees', 'forms'));
    }

    public function update(UpdateDutyPostingItemRequest $request, DutyPostingItem $dutyPostingItem)
    {
        $dutyPostingItem->update($request->all());

        return redirect()->route('admin.duty-posting-items.index');
    }

    public function show(DutyPostingItem $dutyPostingItem)
    {
        abort_if(Gate::denies('duty_posting_item_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $dutyPostingItem->load('employee', 'form');

        return view('admin.dutyPostingItems.show', compact('dutyPostingItem'));
    }

    public function destroy(DutyPostingItem $dutyPostingItem)
    {
        abort_if(Gate::denies('duty_posting_item_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $dutyPostingItem->delete();

        return back();
    }

    public function massDestroy(MassDestroyDutyPostingItemRequest $request)
    {
        $dutyPostingItems = DutyPostingItem::find(request('ids'));

        foreach ($dutyPostingItems as $dutyPostingItem) {
            $dutyPostingItem->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
