<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDesignationWithoutGradeRequest;
use App\Http\Requests\UpdateDesignationWithoutGradeRequest;
use App\Http\Resources\Admin\DesignationWithoutGradeResource;
use App\Models\DesignationWithoutGrade;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DesignationWithoutGradeApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('designation_without_grade_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new DesignationWithoutGradeResource(DesignationWithoutGrade::all());
    }

    public function store(StoreDesignationWithoutGradeRequest $request)
    {
        $designationWithoutGrade = DesignationWithoutGrade::create($request->all());

        return (new DesignationWithoutGradeResource($designationWithoutGrade))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(DesignationWithoutGrade $designationWithoutGrade)
    {
        abort_if(Gate::denies('designation_without_grade_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new DesignationWithoutGradeResource($designationWithoutGrade);
    }

    public function update(UpdateDesignationWithoutGradeRequest $request, DesignationWithoutGrade $designationWithoutGrade)
    {
        $designationWithoutGrade->update($request->all());

        return (new DesignationWithoutGradeResource($designationWithoutGrade))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(DesignationWithoutGrade $designationWithoutGrade)
    {
        abort_if(Gate::denies('designation_without_grade_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $designationWithoutGrade->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
