<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyExemptionRequest;
use App\Http\Requests\StoreExemptionRequest;
use App\Http\Requests\UpdateExemptionRequest;
use App\Models\AssemblySession;
use App\Models\Employee;
use App\Models\Exemption;
use App\Models\Seat;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ExemptionControllerCustom extends Controller
{
    public function exemptedIndex()
    {
      //  abort_if(Gate::denies('exemption_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $exemptions = Exemption::with(['employee', 'session', 'owner'])->get();

        return view('admin.exemptions.exemptedIndex', compact('exemptions'));
    }


    public function showadd()
    {
     //   abort_if(Gate::denies('exemption_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        //$employees = Employee::pluck('name', 'id');
        $employees = Employee::getEmployeesWithAadhaarDesig(null,null,true,true);
        $sessions = AssemblySession::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

       // $owners = Seat::pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.exemptions.add', compact('employees',  'sessions'));
    }

    public function storeexemption(Request $request)
    {
        //$exemption = Exemption::create($request->all());
        \Log::info($request->all());
        //\Log::info( $request->input('employees', []));

        foreach ($request->input('employees', []) as $id) {
            $exemption = new Exemption();
            $exemption->employee_id = $id;
            $exemption->session_id = $request->session_id;
            $exemption->owner_id = null;
            $exemption->date_from = null;
            $exemption->date_to = null;
            $exemption->forwarded_by = null;
            $exemption->submitted_to_services = 1;
            $exemption->approval_status = 1;
            $exemption->save();
        }

        return redirect()->route('admin.exemptions.exemptedIndex');
    }


}
