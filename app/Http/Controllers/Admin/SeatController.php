<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroySeatRequest;
use App\Http\Requests\StoreSeatRequest;
use App\Http\Requests\UpdateSeatRequest;
use App\Models\Role;
use App\Models\Seat;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SeatController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('seat_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $seats = Seat::with(['roles'])->get();

        return view('admin.seats.index', compact('seats'));
    }

    public function create()
    {
        abort_if(Gate::denies('seat_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = Role::pluck('title', 'id');

        return view('admin.seats.create', compact('roles'));
    }

    public function store(StoreSeatRequest $request)
    {
        $seat = Seat::create($request->all());
        $seat->roles()->sync($request->input('roles', []));

        return redirect()->route('admin.seats.index');
    }

    public function edit(Seat $seat)
    {
        abort_if(Gate::denies('seat_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $roles = Role::pluck('title', 'id');

        $seat->load('roles');

        return view('admin.seats.edit', compact('roles', 'seat'));
    }

    public function update(UpdateSeatRequest $request, Seat $seat)
    {
        $seat->update($request->all());
        $seat->roles()->sync($request->input('roles', []));

        return redirect()->route('admin.seats.index');
    }

    public function show(Seat $seat)
    {
        abort_if(Gate::denies('seat_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $seat->load('roles', 'createdByTaxEntries', 'toSeatsOtRoutings');

        return view('admin.seats.show', compact('seat'));
    }

    public function destroy(Seat $seat)
    {
        abort_if(Gate::denies('seat_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $seat->delete();

        return back();
    }

    public function massDestroy(MassDestroySeatRequest $request)
    {
        $seats = Seat::find(request('ids'));

        foreach ($seats as $seat) {
            $seat->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
