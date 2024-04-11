<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmployeeToSectionRequest;
use App\Http\Requests\UpdateEmployeeToSectionRequest;
use App\Http\Resources\Admin\EmployeeToSectionResource;
use App\Models\EmployeeToSection;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EmployeeToSectionApiController extends Controller
{
    public function index()
    {
       // abort_if(Gate::denies('employee_to_section_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new EmployeeToSectionResource(EmployeeToSection::with(['employee', 'section', 'attendance_book'])->get());
    }

    public function store(StoreEmployeeToSectionRequest $request)
    {
        $employeeToSection = EmployeeToSection::create($request->all());

        return (new EmployeeToSectionResource($employeeToSection))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(EmployeeToSection $employeeToSection)
    {
       // abort_if(Gate::denies('employee_to_section_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new EmployeeToSectionResource($employeeToSection->load(['employee', 'section', 'attendance_book']));
    }

    public function update(UpdateEmployeeToSectionRequest $request, EmployeeToSection $employeeToSection)
    {
        $employeeToSection->update($request->all());

        return (new EmployeeToSectionResource($employeeToSection))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(EmployeeToSection $employeeToSection)
    {
      //  abort_if(Gate::denies('employee_to_section_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employeeToSection->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
