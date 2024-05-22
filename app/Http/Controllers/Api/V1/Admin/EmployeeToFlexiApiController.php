<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmployeeToFlexiRequest;
use App\Http\Requests\UpdateEmployeeToFlexiRequest;
use App\Http\Resources\Admin\EmployeeToFlexiResource;
use App\Models\EmployeeToFlexi;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EmployeeToFlexiApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('employee_to_flexi_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new EmployeeToFlexiResource(EmployeeToFlexi::with(['employee'])->get());
    }

    public function store(StoreEmployeeToFlexiRequest $request)
    {
        $employeeToFlexi = EmployeeToFlexi::create($request->all());

        return (new EmployeeToFlexiResource($employeeToFlexi))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(EmployeeToFlexi $employeeToFlexi)
    {
        abort_if(Gate::denies('employee_to_flexi_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new EmployeeToFlexiResource($employeeToFlexi->load(['employee']));
    }

    public function update(UpdateEmployeeToFlexiRequest $request, EmployeeToFlexi $employeeToFlexi)
    {
        $employeeToFlexi->update($request->all());

        return (new EmployeeToFlexiResource($employeeToFlexi))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(EmployeeToFlexi $employeeToFlexi)
    {
        abort_if(Gate::denies('employee_to_flexi_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employeeToFlexi->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
