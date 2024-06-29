<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmployeeToFlexiRequest;
use App\Http\Requests\UpdateEmployeeToFlexiRequest;
use App\Http\Resources\Admin\EmployeeToFlexiResource;
use App\Models\Employee;
//use App\Models\EmployeeToFlexi;
use App\Models\Section;
use App\Models\OfficeTime;
use Carbon\Carbon;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EmployeeToFlexiApiController extends Controller
{
    public function index()
    {
       // abort_if(Gate::denies('employee_to_flexi_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        //return new EmployeeToFlexiResource(EmployeeToFlexi::with(['employee'])->get());


        //find all employees, and their flexi data
        $date_str = Carbon::now()->format('Y-m-d');
        $sections = Section::all();
        $time_groups = OfficeTime::getOfficeTimes($date_str);
        $allEmps = Employee::with(['employeeSectionMapping' => function ($q) use ($date_str) {
            $q->OnDate($date_str)->with(['section' => function ($q) {
                $q->select('id', 'name');
            }]);
        }])
        ->with(['employeeEmployeeToDesignations' => function ($q) use ($date_str) {
            $q->DesignationDuring($date_str)->with(['designation', 'designation.default_time_group']);
        }])
        ->with(['employeeToFlexi' => function ($q) use ($date_str) {
            $q->whereDate('with_effect_from', '<=', $date_str)->orderBy('with_effect_from', 'desc');
        }])
        ->get()
       
        ->transform(
            function ($employee) use ($time_groups, $date_str){

                $flexi_minutes = $employee->employeeToFlexi?->first()?->flexi_minutes ?? 0;
                $time_group_name = $employee->employeeEmployeeToDesignations->first()?->designation->default_time_group?->groupname ?? 'default';
                //$time_group = count($employee?->employee_employee_to_designations) ? $employee->employee_employee_to_designations[0]->designation->default_time_group?->groupname : null;
                $time_group = $time_groups->where('groupname', $time_group_name)->first()->toArray() ;
                $normal_fn_in = Carbon::createFromFormat('Y-m-d H:i:s', $date_str . ' ' .  $time_group['fn_from']); //10.15
                $normal_fn_out = Carbon::createFromFormat('Y-m-d H:i:s', $date_str . ' ' .  $time_group['fn_to']); //1.15
                if (!str_contains($time_group_name,'parttime')) {
                    $normal_an_out = Carbon::createFromFormat('Y-m-d H:i:s', $date_str . ' ' .  $time_group['an_to']); //5.15pm
                } else {
                    $normal_an_out = $normal_fn_out;
                }
        
                $c_flexi_10am = $normal_fn_in->clone()->addMinutes($flexi_minutes);
                $c_flexi_530pm = $normal_an_out->clone()->addMinutes($flexi_minutes);
                $flex_string_for_display = "{$c_flexi_10am->format('H:i')} - {$c_flexi_530pm->format('H:i')}";
        
        
                return [
                    'id' => $employee->id,
                    'name' => $employee->name,
                   // 'employee_to_flexi' => $employee->employeeToFlexi,
                  //  'employee_section_mapping' => $employee->employeeSectionMapping,
                    'aadhaarid' => $employee->aadhaarid,
                    'section_name' => $employee->employeeSectionMapping?->first()?->section->short_name ?? '',
                    'flexi_minutes' => $flexi_minutes,
                    //'designation' => $employee->designation,
                    'designation_name' => $employee->employeeEmployeeToDesignations->first()?->designation->designation ?? '',
                    'flex_string_for_display' => $flex_string_for_display,
                 //   'time_group' => $time_group,
                    'time_group_name' => $time_group_name,
                ];
            }
        )->filter(function ($employee)  {
            return $employee['section_name'] != '';
        });


        return response()->json([
            'employees' => $allEmps,
            'sections' =>  $sections,
        ]
    
    );


    }

    public function store(StoreEmployeeToFlexiRequest $request)
    {
        $employeeToFlexi = EmployeeToFlexi::create($request->all());

        return (new EmployeeToFlexiResource($employeeToFlexi))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(EmployeeToFlexi $employeeToFlexi)
    {
        abort_if(Gate::denies('employee_to_flexi_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new EmployeeToFlexiResource($employeeToFlexi->load(['employee']));
    }

    public function update(UpdateEmployeeToFlexiRequest $request, EmployeeToFlexi $employeeToFlexi)
    {
        $employeeToFlexi->update($request->all());

        return (new EmployeeToFlexiResource($employeeToFlexi))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(EmployeeToFlexi $employeeToFlexi)
    {
        abort_if(Gate::denies('employee_to_flexi_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employeeToFlexi->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
