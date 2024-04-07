<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyOtFormRequest;
use App\Http\Requests\StoreOtFormRequest;
use App\Http\Requests\UpdateOtFormRequest;
use App\Models\AssemblySession;
use App\Models\OtForm;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OtFormController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('ot_form_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $otForms = OtForm::with(['session'])->get();

        return view('admin.otForms.index', compact('otForms'));
    }

    public function create()
    {
        abort_if(Gate::denies('ot_form_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sessions = AssemblySession::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.otForms.create', compact('sessions'));
    }

    public function store(StoreOtFormRequest $request)
    {
        $otForm = OtForm::create($request->all());

        return redirect()->route('admin.ot-forms.index');
    }

    public function edit(OtForm $otForm)
    {
        abort_if(Gate::denies('ot_form_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sessions = AssemblySession::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $otForm->load('session');

        return view('admin.otForms.edit', compact('otForm', 'sessions'));
    }

    public function update(UpdateOtFormRequest $request, OtForm $otForm)
    {
        $otForm->update($request->all());

        return redirect()->route('admin.ot-forms.index');
    }

    public function show(OtForm $otForm)
    {
        abort_if(Gate::denies('ot_form_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $otForm->load('session');

        return view('admin.otForms.show', compact('otForm'));
    }

    public function destroy(OtForm $otForm)
    {
        abort_if(Gate::denies('ot_form_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $otForm->delete();

        return back();
    }

    public function massDestroy(MassDestroyOtFormRequest $request)
    {
        $otForms = OtForm::find(request('ids'));

        foreach ($otForms as $otForm) {
            $otForm->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
