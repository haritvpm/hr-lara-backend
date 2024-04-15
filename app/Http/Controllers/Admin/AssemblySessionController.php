<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyAssemblySessionRequest;
use App\Http\Requests\StoreAssemblySessionRequest;
use App\Http\Requests\UpdateAssemblySessionRequest;
use App\Models\AssemblySession;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AssemblySessionController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('assembly_session_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $assemblySessions = AssemblySession::all();

        return view('admin.assemblySessions.index', compact('assemblySessions'));
    }

    public function create()
    {
        abort_if(Gate::denies('assembly_session_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.assemblySessions.create');
    }

    public function store(StoreAssemblySessionRequest $request)
    {
        $assemblySession = AssemblySession::create($request->all());

        return redirect()->route('admin.assembly-sessions.index');
    }

    public function edit(AssemblySession $assemblySession)
    {
        abort_if(Gate::denies('assembly_session_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.assemblySessions.edit', compact('assemblySession'));
    }

    public function update(UpdateAssemblySessionRequest $request, AssemblySession $assemblySession)
    {
        $assemblySession->update($request->all());

        return redirect()->route('admin.assembly-sessions.index');
    }

    public function show(AssemblySession $assemblySession)
    {
        abort_if(Gate::denies('assembly_session_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $assemblySession->load('sessionGovtCalendars');

        return view('admin.assemblySessions.show', compact('assemblySession'));
    }

    public function destroy(AssemblySession $assemblySession)
    {
        abort_if(Gate::denies('assembly_session_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $assemblySession->delete();

        return back();
    }

    public function massDestroy(MassDestroyAssemblySessionRequest $request)
    {
        $assemblySessions = AssemblySession::find(request('ids'));

        foreach ($assemblySessions as $assemblySession) {
            $assemblySession->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
