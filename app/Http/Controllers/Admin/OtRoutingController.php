<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyOtRoutingRequest;
use App\Http\Requests\StoreOtRoutingRequest;
use App\Http\Requests\UpdateOtRoutingRequest;
use App\Models\OtRouting;
use App\Models\Seat;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OtRoutingController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('ot_routing_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $otRoutings = OtRouting::with(['from_seat', 'to_seats', 'js_as_ss'])->get();

        return view('admin.otRoutings.index', compact('otRoutings'));
    }

    public function create()
    {
        abort_if(Gate::denies('ot_routing_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $from_seats = Seat::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $to_seats = Seat::pluck('title', 'id');

        $js_as_sses = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.otRoutings.create', compact('from_seats', 'js_as_sses', 'to_seats'));
    }

    public function store(StoreOtRoutingRequest $request)
    {
        $otRouting = OtRouting::create($request->all());
        $otRouting->to_seats()->sync($request->input('to_seats', []));

        return redirect()->route('admin.ot-routings.index');
    }

    public function edit(OtRouting $otRouting)
    {
        abort_if(Gate::denies('ot_routing_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $from_seats = Seat::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $to_seats = Seat::pluck('title', 'id');

        $js_as_sses = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $otRouting->load('from_seat', 'to_seats', 'js_as_ss');

        return view('admin.otRoutings.edit', compact('from_seats', 'js_as_sses', 'otRouting', 'to_seats'));
    }

    public function update(UpdateOtRoutingRequest $request, OtRouting $otRouting)
    {
        $otRouting->update($request->all());
        $otRouting->to_seats()->sync($request->input('to_seats', []));

        return redirect()->route('admin.ot-routings.index');
    }

    public function show(OtRouting $otRouting)
    {
        abort_if(Gate::denies('ot_routing_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $otRouting->load('from_seat', 'to_seats', 'js_as_ss');

        return view('admin.otRoutings.show', compact('otRouting'));
    }

    public function destroy(OtRouting $otRouting)
    {
        abort_if(Gate::denies('ot_routing_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $otRouting->delete();

        return back();
    }

    public function massDestroy(MassDestroyOtRoutingRequest $request)
    {
        $otRoutings = OtRouting::find(request('ids'));

        foreach ($otRoutings as $otRouting) {
            $otRouting->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
