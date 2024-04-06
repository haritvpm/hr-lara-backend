<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAssemblySessionRequest;
use App\Http\Requests\UpdateAssemblySessionRequest;
use App\Http\Resources\Admin\AssemblySessionResource;
use App\Models\AssemblySession;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AssemblySessionApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('assembly_session_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new AssemblySessionResource(AssemblySession::all());
    }

    public function store(StoreAssemblySessionRequest $request)
    {
        $assemblySession = AssemblySession::create($request->all());

        return (new AssemblySessionResource($assemblySession))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(AssemblySession $assemblySession)
    {
        abort_if(Gate::denies('assembly_session_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new AssemblySessionResource($assemblySession);
    }

    public function update(UpdateAssemblySessionRequest $request, AssemblySession $assemblySession)
    {
        $assemblySession->update($request->all());

        return (new AssemblySessionResource($assemblySession))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(AssemblySession $assemblySession)
    {
        abort_if(Gate::denies('assembly_session_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $assemblySession->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
