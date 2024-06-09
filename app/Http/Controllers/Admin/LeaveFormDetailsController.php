<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyLeaveFormDetailRequest;
use App\Http\Requests\StoreLeaveFormDetailRequest;
use App\Http\Requests\UpdateLeaveFormDetailRequest;
use App\Models\Leaf;
use App\Models\LeaveFormDetail;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LeaveFormDetailsController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('leave_form_detail_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $leaveFormDetails = LeaveFormDetail::with(['leave'])->get();

        return view('admin.leaveFormDetails.index', compact('leaveFormDetails'));
    }

    public function create()
    {
        abort_if(Gate::denies('leave_form_detail_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $leaves = Leaf::pluck('leave_type', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.leaveFormDetails.create', compact('leaves'));
    }

    public function store(StoreLeaveFormDetailRequest $request)
    {
        $leaveFormDetail = LeaveFormDetail::create($request->all());

        return redirect()->route('admin.leave-form-details.index');
    }

    public function edit(LeaveFormDetail $leaveFormDetail)
    {
        abort_if(Gate::denies('leave_form_detail_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $leaves = Leaf::pluck('leave_type', 'id')->prepend(trans('global.pleaseSelect'), '');

        $leaveFormDetail->load('leave');

        return view('admin.leaveFormDetails.edit', compact('leaveFormDetail', 'leaves'));
    }

    public function update(UpdateLeaveFormDetailRequest $request, LeaveFormDetail $leaveFormDetail)
    {
        $leaveFormDetail->update($request->all());

        return redirect()->route('admin.leave-form-details.index');
    }

    public function show(LeaveFormDetail $leaveFormDetail)
    {
        abort_if(Gate::denies('leave_form_detail_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $leaveFormDetail->load('leave');

        return view('admin.leaveFormDetails.show', compact('leaveFormDetail'));
    }

    public function destroy(LeaveFormDetail $leaveFormDetail)
    {
        abort_if(Gate::denies('leave_form_detail_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $leaveFormDetail->delete();

        return back();
    }

    public function massDestroy(MassDestroyLeaveFormDetailRequest $request)
    {
        $leaveFormDetails = LeaveFormDetail::find(request('ids'));

        foreach ($leaveFormDetails as $leaveFormDetail) {
            $leaveFormDetail->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
