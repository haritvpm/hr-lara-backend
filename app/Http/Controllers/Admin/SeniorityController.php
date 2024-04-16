<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroySeniorityRequest;
use App\Http\Requests\StoreSeniorityRequest;
use App\Http\Requests\UpdateSeniorityRequest;
use App\Models\Employee;
use App\Models\Seniority;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SeniorityController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('seniority_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $seniorities = Seniority::with(['employee', 'employee.designation()'])->get();

        return view('admin.seniorities.index', compact('seniorities'));
    }

    public function create()
    {
        abort_if(Gate::denies('seniority_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employees = Employee::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.seniorities.create', compact('employees'));
    }

    public function store(StoreSeniorityRequest $request)
    {
        $seniority = Seniority::create($request->all());

        return redirect()->route('admin.seniorities.index');
    }

    public function edit(Seniority $seniority)
    {
        abort_if(Gate::denies('seniority_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employees = Employee::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $seniority->load('employee');

        return view('admin.seniorities.edit', compact('employees', 'seniority'));
    }

    public function update(UpdateSeniorityRequest $request, Seniority $seniority)
    {
        $seniority->update($request->all());

        return redirect()->route('admin.seniorities.index');
    }

    public function show(Seniority $seniority)
    {
        abort_if(Gate::denies('seniority_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $seniority->load('employee');

        return view('admin.seniorities.show', compact('seniority'));
    }

    public function destroy(Seniority $seniority)
    {
        abort_if(Gate::denies('seniority_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $seniority->delete();

        return back();
    }

    public function massDestroy(MassDestroySeniorityRequest $request)
    {
        $seniorities = Seniority::find(request('ids'));

        foreach ($seniorities as $seniority) {
            $seniority->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
