<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmployeeSectionHistoryRequest;
use App\Http\Requests\UpdateEmployeeSectionHistoryRequest;
use App\Http\Resources\Admin\EmployeeSectionHistoryResource;
use App\Models\EmployeeSectionHistory;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EmployeeSectionHistoryApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('employee_section_history_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new EmployeeSectionHistoryResource(EmployeeSectionHistory::with(['employee', 'section_seat'])->get());
    }

    public function store(StoreEmployeeSectionHistoryRequest $request)
    {
        $employeeSectionHistory = EmployeeSectionHistory::create($request->all());

        return (new EmployeeSectionHistoryResource($employeeSectionHistory))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(EmployeeSectionHistory $employeeSectionHistory)
    {
        abort_if(Gate::denies('employee_section_history_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new EmployeeSectionHistoryResource($employeeSectionHistory->load(['employee', 'section_seat']));
    }

    public function update(UpdateEmployeeSectionHistoryRequest $request, EmployeeSectionHistory $employeeSectionHistory)
    {
        $employeeSectionHistory->update($request->all());

        return (new EmployeeSectionHistoryResource($employeeSectionHistory))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(EmployeeSectionHistory $employeeSectionHistory)
    {
        abort_if(Gate::denies('employee_section_history_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employeeSectionHistory->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
