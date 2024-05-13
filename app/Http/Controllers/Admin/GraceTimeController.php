<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyGraceTimeRequest;
use App\Http\Requests\StoreGraceTimeRequest;
use App\Http\Requests\UpdateGraceTimeRequest;
use App\Models\GraceTime;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class GraceTimeController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('office_time_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $graceTimes = GraceTime::all();

        return view('admin.graceTimes.index', compact('graceTimes'));
    }

    public function create()
    {
        abort_if(Gate::denies('office_time_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.graceTimes.create');
    }

    public function store(StoreGraceTimeRequest $request)
    {
        $graceTime = GraceTime::create($request->all());

        return redirect()->route('admin.grace-times.index');
    }

    public function edit(GraceTime $graceTime)
    {
        abort_if(Gate::denies('office_time_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.graceTimes.edit', compact('graceTime'));
    }

    public function update(UpdateGraceTimeRequest $request, GraceTime $graceTime)
    {
        $graceTime->update($request->all());

        return redirect()->route('admin.grace-times.index');
    }

    public function destroy(GraceTime $graceTime)
    {
        abort_if(Gate::denies('office_time_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $graceTime->delete();

        return back();
    }

    public function massDestroy(MassDestroyGraceTimeRequest $request)
    {
        $graceTimes = GraceTime::find(request('ids'));

        foreach ($graceTimes as $graceTime) {
            $graceTime->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
