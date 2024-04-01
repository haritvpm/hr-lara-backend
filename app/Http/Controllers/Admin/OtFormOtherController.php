<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyOtFormOtherRequest;
use App\Http\Requests\StoreOtFormOtherRequest;
use App\Http\Requests\UpdateOtFormOtherRequest;
use App\Models\OtFormOther;
use App\Models\Session;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OtFormOtherController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('ot_form_other_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $otFormOthers = OtFormOther::with(['session'])->get();

        return view('admin.otFormOthers.index', compact('otFormOthers'));
    }

    public function create()
    {
        abort_if(Gate::denies('ot_form_other_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sessions = Session::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.otFormOthers.create', compact('sessions'));
    }

    public function store(StoreOtFormOtherRequest $request)
    {
        $otFormOther = OtFormOther::create($request->all());

        return redirect()->route('admin.ot-form-others.index');
    }

    public function edit(OtFormOther $otFormOther)
    {
        abort_if(Gate::denies('ot_form_other_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sessions = Session::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $otFormOther->load('session');

        return view('admin.otFormOthers.edit', compact('otFormOther', 'sessions'));
    }

    public function update(UpdateOtFormOtherRequest $request, OtFormOther $otFormOther)
    {
        $otFormOther->update($request->all());

        return redirect()->route('admin.ot-form-others.index');
    }

    public function show(OtFormOther $otFormOther)
    {
        abort_if(Gate::denies('ot_form_other_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $otFormOther->load('session');

        return view('admin.otFormOthers.show', compact('otFormOther'));
    }

    public function destroy(OtFormOther $otFormOther)
    {
        abort_if(Gate::denies('ot_form_other_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $otFormOther->delete();

        return back();
    }

    public function massDestroy(MassDestroyOtFormOtherRequest $request)
    {
        $otFormOthers = OtFormOther::find(request('ids'));

        foreach ($otFormOthers as $otFormOther) {
            $otFormOther->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
