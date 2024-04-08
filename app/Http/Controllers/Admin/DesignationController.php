<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyDesignationRequest;
use App\Http\Requests\StoreDesignationRequest;
use App\Http\Requests\UpdateDesignationRequest;
use App\Models\Designation;
use App\Models\DesignationLine;
use App\Models\DesignationWithoutGrade;
use App\Models\OfficeTimeGroup;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DesignationController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('designation_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $designations = Designation::with(['desig_line', 'designation_wo_grade', 'time_group'])->get();

        return view('admin.designations.index', compact('designations'));
    }

    public function create()
    {
        abort_if(Gate::denies('designation_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $desig_lines = DesignationLine::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $designation_wo_grades = DesignationWithoutGrade::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $time_groups = OfficeTimeGroup::pluck('groupname', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.designations.create', compact('desig_lines', 'designation_wo_grades', 'time_groups'));
    }

    public function store(StoreDesignationRequest $request)
    {
        $designation = Designation::create($request->all());

        return redirect()->route('admin.designations.index');
    }

    public function edit(Designation $designation)
    {
        abort_if(Gate::denies('designation_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $desig_lines = DesignationLine::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $designation_wo_grades = DesignationWithoutGrade::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $time_groups = OfficeTimeGroup::pluck('groupname', 'id')->prepend(trans('global.pleaseSelect'), '');

        $designation->load('desig_line', 'designation_wo_grade', 'time_group');

        return view('admin.designations.edit', compact('desig_lines', 'designation', 'designation_wo_grades', 'time_groups'));
    }

    public function update(UpdateDesignationRequest $request, Designation $designation)
    {
        $designation->update($request->all());

        return redirect()->route('admin.designations.index');
    }

    public function show(Designation $designation)
    {
        abort_if(Gate::denies('designation_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $designation->load('desig_line', 'designation_wo_grade', 'time_group');

        return view('admin.designations.show', compact('designation'));
    }

    public function destroy(Designation $designation)
    {
        abort_if(Gate::denies('designation_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $designation->delete();

        return back();
    }

    public function massDestroy(MassDestroyDesignationRequest $request)
    {
        $designations = Designation::find(request('ids'));

        foreach ($designations as $designation) {
            $designation->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
