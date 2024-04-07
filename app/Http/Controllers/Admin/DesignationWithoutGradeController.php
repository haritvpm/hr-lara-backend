<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyDesignationWithoutGradeRequest;
use App\Http\Requests\StoreDesignationWithoutGradeRequest;
use App\Http\Requests\UpdateDesignationWithoutGradeRequest;
use App\Models\DesignationWithoutGrade;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DesignationWithoutGradeController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('designation_without_grade_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $designationWithoutGrades = DesignationWithoutGrade::all();

        return view('admin.designationWithoutGrades.index', compact('designationWithoutGrades'));
    }

    public function create()
    {
        abort_if(Gate::denies('designation_without_grade_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.designationWithoutGrades.create');
    }

    public function store(StoreDesignationWithoutGradeRequest $request)
    {
        $designationWithoutGrade = DesignationWithoutGrade::create($request->all());

        return redirect()->route('admin.designation-without-grades.index');
    }

    public function edit(DesignationWithoutGrade $designationWithoutGrade)
    {
        abort_if(Gate::denies('designation_without_grade_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.designationWithoutGrades.edit', compact('designationWithoutGrade'));
    }

    public function update(UpdateDesignationWithoutGradeRequest $request, DesignationWithoutGrade $designationWithoutGrade)
    {
        $designationWithoutGrade->update($request->all());

        return redirect()->route('admin.designation-without-grades.index');
    }

    public function show(DesignationWithoutGrade $designationWithoutGrade)
    {
        abort_if(Gate::denies('designation_without_grade_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.designationWithoutGrades.show', compact('designationWithoutGrade'));
    }

    public function destroy(DesignationWithoutGrade $designationWithoutGrade)
    {
        abort_if(Gate::denies('designation_without_grade_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $designationWithoutGrade->delete();

        return back();
    }

    public function massDestroy(MassDestroyDesignationWithoutGradeRequest $request)
    {
        $designationWithoutGrades = DesignationWithoutGrade::find(request('ids'));

        foreach ($designationWithoutGrades as $designationWithoutGrade) {
            $designationWithoutGrade->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
