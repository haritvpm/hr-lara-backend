<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmployeeDesignationHistoryRequest;
use App\Http\Requests\UpdateEmployeeDesignationHistoryRequest;
use App\Http\Resources\Admin\EmployeeDesignationHistoryResource;
use App\Models\EmployeeDesignationHistory;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EmployeeDesignationHistoryApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('employee_designation_history_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new EmployeeDesignationHistoryResource(EmployeeDesignationHistory::with(['employee', 'designation'])->get());
    }

    public function store(StoreEmployeeDesignationHistoryRequest $request)
    {
        $employeeDesignationHistory = EmployeeDesignationHistory::create($request->all());

        return (new EmployeeDesignationHistoryResource($employeeDesignationHistory))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(EmployeeDesignationHistory $employeeDesignationHistory)
    {
        abort_if(Gate::denies('employee_designation_history_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new EmployeeDesignationHistoryResource($employeeDesignationHistory->load(['employee', 'designation']));
    }

    public function update(UpdateEmployeeDesignationHistoryRequest $request, EmployeeDesignationHistory $employeeDesignationHistory)
    {
        $employeeDesignationHistory->update($request->all());

        return (new EmployeeDesignationHistoryResource($employeeDesignationHistory))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(EmployeeDesignationHistory $employeeDesignationHistory)
    {
        abort_if(Gate::denies('employee_designation_history_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employeeDesignationHistory->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
