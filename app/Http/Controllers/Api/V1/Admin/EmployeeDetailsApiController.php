<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmployeeDetailRequest;
use App\Http\Requests\UpdateEmployeeDetailRequest;
use App\Http\Resources\Admin\EmployeeDetailResource;
use App\Models\EmployeeDetail;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EmployeeDetailsApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('employee_detail_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new EmployeeDetailResource(EmployeeDetail::with(['employee'])->get());
    }

    public function store(StoreEmployeeDetailRequest $request)
    {
        $employeeDetail = EmployeeDetail::create($request->all());

        return (new EmployeeDetailResource($employeeDetail))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(EmployeeDetail $employeeDetail)
    {
        abort_if(Gate::denies('employee_detail_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new EmployeeDetailResource($employeeDetail->load(['employee']));
    }

    public function update(UpdateEmployeeDetailRequest $request, EmployeeDetail $employeeDetail)
    {
        $employeeDetail->update($request->all());

        return (new EmployeeDetailResource($employeeDetail))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(EmployeeDetail $employeeDetail)
    {
        abort_if(Gate::denies('employee_detail_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employeeDetail->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
