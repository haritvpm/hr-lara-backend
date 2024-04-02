<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmployeeSeatHistoryRequest;
use App\Http\Requests\UpdateEmployeeSeatHistoryRequest;
use App\Http\Resources\Admin\EmployeeSeatHistoryResource;
use App\Models\EmployeeSeatHistory;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EmployeeSeatHistoryApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('employee_seat_history_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new EmployeeSeatHistoryResource(EmployeeSeatHistory::with(['seat', 'employee'])->get());
    }

    public function store(StoreEmployeeSeatHistoryRequest $request)
    {
        $employeeSeatHistory = EmployeeSeatHistory::create($request->all());

        return (new EmployeeSeatHistoryResource($employeeSeatHistory))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(EmployeeSeatHistory $employeeSeatHistory)
    {
        abort_if(Gate::denies('employee_seat_history_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new EmployeeSeatHistoryResource($employeeSeatHistory->load(['seat', 'employee']));
    }

    public function update(UpdateEmployeeSeatHistoryRequest $request, EmployeeSeatHistory $employeeSeatHistory)
    {
        $employeeSeatHistory->update($request->all());

        return (new EmployeeSeatHistoryResource($employeeSeatHistory))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(EmployeeSeatHistory $employeeSeatHistory)
    {
        abort_if(Gate::denies('employee_seat_history_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employeeSeatHistory->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
