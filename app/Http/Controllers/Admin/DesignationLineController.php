<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyDesignationLineRequest;
use App\Http\Requests\StoreDesignationLineRequest;
use App\Http\Requests\UpdateDesignationLineRequest;
use App\Models\DesignationLine;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DesignationLineController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('designation_line_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $designationLines = DesignationLine::all();

        return view('admin.designationLines.index', compact('designationLines'));
    }

    public function create()
    {
        abort_if(Gate::denies('designation_line_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.designationLines.create');
    }

    public function store(StoreDesignationLineRequest $request)
    {
        $designationLine = DesignationLine::create($request->all());

        return redirect()->route('admin.designation-lines.index');
    }

    public function edit(DesignationLine $designationLine)
    {
        abort_if(Gate::denies('designation_line_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.designationLines.edit', compact('designationLine'));
    }

    public function update(UpdateDesignationLineRequest $request, DesignationLine $designationLine)
    {
        $designationLine->update($request->all());

        return redirect()->route('admin.designation-lines.index');
    }

    public function show(DesignationLine $designationLine)
    {
        abort_if(Gate::denies('designation_line_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.designationLines.show', compact('designationLine'));
    }

    public function destroy(DesignationLine $designationLine)
    {
        abort_if(Gate::denies('designation_line_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $designationLine->delete();

        return back();
    }

    public function massDestroy(MassDestroyDesignationLineRequest $request)
    {
        $designationLines = DesignationLine::find(request('ids'));

        foreach ($designationLines as $designationLine) {
            $designationLine->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
