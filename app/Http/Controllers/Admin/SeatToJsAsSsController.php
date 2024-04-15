<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroySeatToJsAsSsRequest;
use App\Http\Requests\StoreSeatToJsAsSsRequest;
use App\Http\Requests\UpdateSeatToJsAsSsRequest;
use App\Models\Employee;
use App\Models\Seat;
use App\Models\SeatToJsAsSs;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SeatToJsAsSsController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('seat_to_js_as_ss_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $seatToJsAsSses = SeatToJsAsSs::with(['seat', 'employee'])->get();

        return view('admin.seatToJsAsSses.index', compact('seatToJsAsSses'));
    }

    public function create()
    {
        abort_if(Gate::denies('seat_to_js_as_ss_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $seats = Seat::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $employees = Employee::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.seatToJsAsSses.create', compact('employees', 'seats'));
    }

    public function store(StoreSeatToJsAsSsRequest $request)
    {
        $seatToJsAsSs = SeatToJsAsSs::create($request->all());

        return redirect()->route('admin.seat-to-js-as-sses.index');
    }

    public function edit(SeatToJsAsSs $seatToJsAsSs)
    {
        abort_if(Gate::denies('seat_to_js_as_ss_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employees = Employee::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $seatToJsAsSs->load('seat', 'employee');

        return view('admin.seatToJsAsSses.edit', compact('employees', 'seatToJsAsSs'));
    }

    public function update(UpdateSeatToJsAsSsRequest $request, SeatToJsAsSs $seatToJsAsSs)
    {
        $seatToJsAsSs->update($request->all());

        return redirect()->route('admin.seat-to-js-as-sses.index');
    }

    public function show(SeatToJsAsSs $seatToJsAsSs)
    {
        abort_if(Gate::denies('seat_to_js_as_ss_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $seatToJsAsSs->load('seat', 'employee');

        return view('admin.seatToJsAsSses.show', compact('seatToJsAsSs'));
    }

    public function destroy(SeatToJsAsSs $seatToJsAsSs)
    {
        abort_if(Gate::denies('seat_to_js_as_ss_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $seatToJsAsSs->delete();

        return back();
    }

    public function massDestroy(MassDestroySeatToJsAsSsRequest $request)
    {
        $seatToJsAsSses = SeatToJsAsSs::find(request('ids'));

        foreach ($seatToJsAsSses as $seatToJsAsSs) {
            $seatToJsAsSs->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
