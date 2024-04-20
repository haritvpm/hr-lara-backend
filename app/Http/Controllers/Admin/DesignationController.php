<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyDesignationRequest;
use App\Http\Requests\StoreDesignationRequest;
use App\Http\Requests\UpdateDesignationRequest;
use App\Models\Designation;
use App\Models\OfficeTime;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DesignationController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('designation_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $designations = Designation::with(['default_time_group'])->orderBy('sort_index', 'asc')->get();

        return view('admin.designations.index', compact('designations'));
    }

    public function create()
    {
        abort_if(Gate::denies('designation_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $default_time_groups = OfficeTime::pluck('groupname', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.designations.create', compact('default_time_groups'));
    }

    public function store(StoreDesignationRequest $request)
    {
        $designation = Designation::create($request->all());

        return redirect()->route('admin.designations.index');
    }

    public function edit(Designation $designation)
    {
        abort_if(Gate::denies('designation_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $default_time_groups = OfficeTime::pluck('groupname', 'id')->prepend(trans('global.pleaseSelect'), '');

        $designation->load('default_time_group');

        return view('admin.designations.edit', compact('default_time_groups', 'designation'));
    }

    public function update(UpdateDesignationRequest $request, Designation $designation)
    {

        $sort_index = $request->sort_index;

        //now see if the sort index is changed
        if($sort_index != $designation->sort_index && $designation->sort_index != null){
            //if changed, then we need to update all the other designations sort index
            $designations = Designation::where('sort_index', '>=', $sort_index)
         //   ->orWhereNull('sort_index')
            ->get();
            foreach($designations as $d){
                $d->sort_index = $d->sort_index + 1 ;
                $d->save();
            }
        }

        $designation->update($request->all());

        return redirect()->route('admin.designations.index');
    }

    public function show(Designation $designation)
    {
        abort_if(Gate::denies('designation_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $designation->load('default_time_group');

        return view('admin.designations.show', compact('designation'));
    }

    public function destroy(Designation $designation)
    {
        abort_if(Gate::denies('designation_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $designation->delete();

        return back();
    }

    public function massDestroy(MassDestroyDesignationRequest $request)
    {
        $designations = Designation::find(request('ids'));

        foreach ($designations as $designation) {
            $designation->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
