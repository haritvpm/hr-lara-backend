<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDutyPostingFormRequest;
use App\Http\Requests\UpdateDutyPostingFormRequest;
use App\Http\Resources\Admin\DutyPostingFormResource;
use App\Models\DutyPostingForm;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DutyPostingFormApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('duty_posting_form_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new DutyPostingFormResource(DutyPostingForm::with(['created_by_seat', 'owner_seat', 'approver_seat'])->get());
    }

    public function store(StoreDutyPostingFormRequest $request)
    {
        $dutyPostingForm = DutyPostingForm::create($request->all());

        return (new DutyPostingFormResource($dutyPostingForm))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(DutyPostingForm $dutyPostingForm)
    {
        abort_if(Gate::denies('duty_posting_form_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new DutyPostingFormResource($dutyPostingForm->load(['created_by_seat', 'owner_seat', 'approver_seat']));
    }

    public function update(UpdateDutyPostingFormRequest $request, DutyPostingForm $dutyPostingForm)
    {
        $dutyPostingForm->update($request->all());

        return (new DutyPostingFormResource($dutyPostingForm))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(DutyPostingForm $dutyPostingForm)
    {
        abort_if(Gate::denies('duty_posting_form_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $dutyPostingForm->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
