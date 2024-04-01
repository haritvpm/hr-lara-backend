<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSectionEmployeeRequest;
use App\Http\Requests\UpdateSectionEmployeeRequest;
use App\Http\Resources\Admin\SectionEmployeeResource;
use App\Models\SectionEmployee;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SectionEmployeeApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('section_employee_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new SectionEmployeeResource(SectionEmployee::with(['employee', 'section', 'attendance_book'])->get());
    }

    public function store(StoreSectionEmployeeRequest $request)
    {
        $sectionEmployee = SectionEmployee::create($request->all());

        return (new SectionEmployeeResource($sectionEmployee))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(SectionEmployee $sectionEmployee)
    {
        abort_if(Gate::denies('section_employee_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new SectionEmployeeResource($sectionEmployee->load(['employee', 'section', 'attendance_book']));
    }

    public function update(UpdateSectionEmployeeRequest $request, SectionEmployee $sectionEmployee)
    {
        $sectionEmployee->update($request->all());

        return (new SectionEmployeeResource($sectionEmployee))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(SectionEmployee $sectionEmployee)
    {
        abort_if(Gate::denies('section_employee_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sectionEmployee->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
