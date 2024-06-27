<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyFlexiApplicationRequest;
use App\Http\Requests\StoreFlexiApplicationRequest;
use App\Http\Requests\UpdateFlexiApplicationRequest;
use App\Models\Employee;
use App\Models\FlexiApplication;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FlexiApplicationController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('office_time_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $flexiApplications = FlexiApplication::with(['employee'])->get();

        return view('admin.flexiApplications.index', compact('flexiApplications'));
    }

    public function create()
    {
        abort_if(Gate::denies('office_time_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employees = Employee::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.flexiApplications.create', compact('employees'));
    }

    public function store(StoreFlexiApplicationRequest $request)
    {
        $flexiApplication = FlexiApplication::create($request->all());

        return redirect()->route('admin.flexi-applications.index');
    }

    public function edit(FlexiApplication $flexiApplication)
    {
        abort_if(Gate::denies('office_time_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employees = Employee::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $flexiApplication->load('employee');

        return view('admin.flexiApplications.edit', compact('employees', 'flexiApplication'));
    }

    public function update(UpdateFlexiApplicationRequest $request, FlexiApplication $flexiApplication)
    {
        $flexiApplication->update($request->all());

        return redirect()->route('admin.flexi-applications.index');
    }

    public function show(FlexiApplication $flexiApplication)
    {
        abort_if(Gate::denies('office_time_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $flexiApplication->load('employee');

        return view('admin.flexiApplications.show', compact('flexiApplication'));
    }

    public function destroy(FlexiApplication $flexiApplication)
    {
        abort_if(Gate::denies('office_time_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $flexiApplication->delete();

        return back();
    }

    public function massDestroy(MassDestroyFlexiApplicationRequest $request)
    {
        $flexiApplications = FlexiApplication::find(request('ids'));

        foreach ($flexiApplications as $flexiApplication) {
            $flexiApplication->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
