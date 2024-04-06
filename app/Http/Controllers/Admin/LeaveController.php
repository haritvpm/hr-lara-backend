<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyLeafRequest;
use App\Http\Requests\StoreLeafRequest;
use App\Http\Requests\UpdateLeafRequest;
use App\Models\Employee;
use App\Models\Leaf;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LeaveController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('leaf_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $leaves = Leaf::with(['employee', 'created_by'])->get();

        return view('admin.leaves.index', compact('leaves'));
    }

    public function create()
    {
        abort_if(Gate::denies('leaf_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employees = Employee::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $created_bies = Employee::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.leaves.create', compact('created_bies', 'employees'));
    }

    public function store(StoreLeafRequest $request)
    {
        $leaf = Leaf::create($request->all());

        return redirect()->route('admin.leaves.index');
    }

    public function edit(Leaf $leaf)
    {
        abort_if(Gate::denies('leaf_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employees = Employee::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $created_bies = Employee::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $leaf->load('employee', 'created_by');

        return view('admin.leaves.edit', compact('created_bies', 'employees', 'leaf'));
    }

    public function update(UpdateLeafRequest $request, Leaf $leaf)
    {
        $leaf->update($request->all());

        return redirect()->route('admin.leaves.index');
    }

    public function show(Leaf $leaf)
    {
        abort_if(Gate::denies('leaf_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $leaf->load('employee', 'created_by');

        return view('admin.leaves.show', compact('leaf'));
    }

    public function destroy(Leaf $leaf)
    {
        abort_if(Gate::denies('leaf_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $leaf->delete();

        return back();
    }

    public function massDestroy(MassDestroyLeafRequest $request)
    {
        $leaves = Leaf::find(request('ids'));

        foreach ($leaves as $leaf) {
            $leaf->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
