<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmployeeExtraRequest;
use App\Http\Requests\UpdateEmployeeExtraRequest;
use App\Http\Resources\Admin\EmployeeExtraResource;
use App\Models\EmployeeExtra;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EmployeeExtraApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('employee_extra_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new EmployeeExtraResource(EmployeeExtra::with(['employee'])->get());
    }

    public function store(StoreEmployeeExtraRequest $request)
    {
        $employeeExtra = EmployeeExtra::create($request->all());

        return (new EmployeeExtraResource($employeeExtra))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(EmployeeExtra $employeeExtra)
    {
        abort_if(Gate::denies('employee_extra_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new EmployeeExtraResource($employeeExtra->load(['employee']));
    }

    public function update(UpdateEmployeeExtraRequest $request, EmployeeExtra $employeeExtra)
    {
        $employeeExtra->update($request->all());

        return (new EmployeeExtraResource($employeeExtra))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(EmployeeExtra $employeeExtra)
    {
        abort_if(Gate::denies('employee_extra_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employeeExtra->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
