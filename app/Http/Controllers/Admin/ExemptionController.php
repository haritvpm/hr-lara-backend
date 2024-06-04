<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyExemptionRequest;
use App\Http\Requests\StoreExemptionRequest;
use App\Http\Requests\UpdateExemptionRequest;
use App\Models\AssemblySession;
use App\Models\Employee;
use App\Models\Exemption;
use App\Models\Seat;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ExemptionController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('exemption_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $exemptions = Exemption::with(['employee', 'session', 'owner'])->get();

        return view('admin.exemptions.index', compact('exemptions'));
    }


    public function create()
    {
        abort_if(Gate::denies('exemption_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employees = Employee::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $sessions = AssemblySession::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $owners = Seat::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.exemptions.create', compact('employees', 'owners', 'sessions'));
    }


    public function store(StoreExemptionRequest $request)
    {
        $exemption = Exemption::create($request->all());

        return redirect()->route('admin.exemptions.index');
    }
    public function edit(Exemption $exemption)
    {
        abort_if(Gate::denies('exemption_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employees = Employee::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $sessions = AssemblySession::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $owners = Seat::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $exemption->load('employee', 'session', 'owner');

        return view('admin.exemptions.edit', compact('employees', 'exemption', 'owners', 'sessions'));
    }

    public function update(UpdateExemptionRequest $request, Exemption $exemption)
    {
        $exemption->update($request->all());

        return redirect()->route('admin.exemptions.index');
    }

    public function show(Exemption $exemption)
    {
        abort_if(Gate::denies('exemption_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $exemption->load('employee', 'session', 'owner');

        return view('admin.exemptions.show', compact('exemption'));
    }

    public function destroy(Exemption $exemption)
    {
        abort_if(Gate::denies('exemption_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $exemption->delete();

        return back();
    }

    public function massDestroy(MassDestroyExemptionRequest $request)
    {
        $exemptions = Exemption::find(request('ids'));

        foreach ($exemptions as $exemption) {
            $exemption->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
