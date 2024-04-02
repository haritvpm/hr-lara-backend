<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmployeeToAcquittanceRequest;
use App\Http\Requests\UpdateEmployeeToAcquittanceRequest;
use App\Http\Resources\Admin\EmployeeToAcquittanceResource;
use App\Models\EmployeeToAcquittance;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EmployeeToAcquittanceApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('employee_to_acquittance_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new EmployeeToAcquittanceResource(EmployeeToAcquittance::with(['employee', 'acquittance'])->get());
    }

    public function store(StoreEmployeeToAcquittanceRequest $request)
    {
        $employeeToAcquittance = EmployeeToAcquittance::create($request->all());

        return (new EmployeeToAcquittanceResource($employeeToAcquittance))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(EmployeeToAcquittance $employeeToAcquittance)
    {
        abort_if(Gate::denies('employee_to_acquittance_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new EmployeeToAcquittanceResource($employeeToAcquittance->load(['employee', 'acquittance']));
    }

    public function update(UpdateEmployeeToAcquittanceRequest $request, EmployeeToAcquittance $employeeToAcquittance)
    {
        $employeeToAcquittance->update($request->all());

        return (new EmployeeToAcquittanceResource($employeeToAcquittance))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(EmployeeToAcquittance $employeeToAcquittance)
    {
        abort_if(Gate::denies('employee_to_acquittance_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employeeToAcquittance->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
