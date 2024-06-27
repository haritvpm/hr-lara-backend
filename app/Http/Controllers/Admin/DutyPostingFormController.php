<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyDutyPostingFormRequest;
use App\Http\Requests\StoreDutyPostingFormRequest;
use App\Http\Requests\UpdateDutyPostingFormRequest;
use App\Models\DutyPostingForm;
use App\Models\Seat;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DutyPostingFormController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('duty_posting_form_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $dutyPostingForms = DutyPostingForm::with(['created_by_seat', 'owner_seat', 'approver_seat'])->get();

        return view('admin.dutyPostingForms.index', compact('dutyPostingForms'));
    }

    public function create()
    {
        abort_if(Gate::denies('duty_posting_form_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $created_by_seats = Seat::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $owner_seats = Seat::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $approver_seats = Seat::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.dutyPostingForms.create', compact('approver_seats', 'created_by_seats', 'owner_seats'));
    }

    public function store(StoreDutyPostingFormRequest $request)
    {
        $dutyPostingForm = DutyPostingForm::create($request->all());

        return redirect()->route('admin.duty-posting-forms.index');
    }

    public function edit(DutyPostingForm $dutyPostingForm)
    {
        abort_if(Gate::denies('duty_posting_form_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $created_by_seats = Seat::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $owner_seats = Seat::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $approver_seats = Seat::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $dutyPostingForm->load('created_by_seat', 'owner_seat', 'approver_seat');

        return view('admin.dutyPostingForms.edit', compact('approver_seats', 'created_by_seats', 'dutyPostingForm', 'owner_seats'));
    }

    public function update(UpdateDutyPostingFormRequest $request, DutyPostingForm $dutyPostingForm)
    {
        $dutyPostingForm->update($request->all());

        return redirect()->route('admin.duty-posting-forms.index');
    }

    public function show(DutyPostingForm $dutyPostingForm)
    {
        abort_if(Gate::denies('duty_posting_form_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $dutyPostingForm->load('created_by_seat', 'owner_seat', 'approver_seat');

        return view('admin.dutyPostingForms.show', compact('dutyPostingForm'));
    }

    public function destroy(DutyPostingForm $dutyPostingForm)
    {
        abort_if(Gate::denies('duty_posting_form_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $dutyPostingForm->delete();

        return back();
    }

    public function massDestroy(MassDestroyDutyPostingFormRequest $request)
    {
        $dutyPostingForms = DutyPostingForm::find(request('ids'));

        foreach ($dutyPostingForms as $dutyPostingForm) {
            $dutyPostingForm->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
