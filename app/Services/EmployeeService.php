<?php

namespace App\Services;
use Carbon\Carbon;
use App\Models\Employee;
use App\Services\AebasFetchService;
use App\Models\User;
use App\Models\PunchingTrace;
use App\Models\EmployeeToSeat;
use App\Models\Punching;
use App\Models\Section;
use App\Models\EmployeeToSection;

class EmployeeService {

    // private AebasFetchService $aebasFetchService;
    // public function __construct(AebasFetchService $aebasFetchService)
    // {
    //     $this->aebasFetchService = $aebasFetchService;
    // }
    public  function getEmployeeType(Employee $emp)
    {

        $desig = strtolower($emp->designation->designation);
        $category =   strtolower($emp->categories?->category);
        // Log::info($desig);
        // Log::info($category);

        $isPartime = str_contains($desig,"part time") || str_contains($desig,"parttime") ||
                     str_contains($category,"parttime")||
                     $emp->designation->normal_office_hours == 3; //ugly
        $isFulltime = str_contains($category,"fulltime")||
                      $emp->designation->normal_office_hours == 6;

        $isWatchnward = str_contains($category,"watch") ;
        $isNormal = !$isPartime && !$isFulltime && !$isWatchnward;

        return [$isPartime,$isFulltime,  $isWatchnward,  $isNormal];
    }
    public  function syncEmployeeDataFromAebas()
    {
        $aebas_employees = (new AebasFetchService())->fetchApi(1,0);
        //\Log::info('got emp' . count($aebas_employees));
        return $aebas_employees;
    }

     /*
    For a list of employee ids, finds the seats and get sections related to that seat and then employees mppaed to that sections
    */
    public function getEmployeeSectionMappingForEmployees($emp_ids, $date, $seat_ids)
    {
        \Log::info('getEmployeeSectionMappingForEmployees seat_ids '. $seat_ids);

        $sections_under_charge = Section::wherein('seat_of_controlling_officer_id', $seat_ids)
            ->orwherein('seat_of_reporting_officer_id', $seat_ids)
            ->orwherein('js_as_ss_employee_id', $emp_ids)->get();

        if ($sections_under_charge == null) {
            return null;
        }
        \Log::info(' sections_under_charge '. $sections_under_charge);

        $employee_section_maps = EmployeeToSection::during($date)
            ->with(['employee', 'attendance_book', 'section', 'employee.seniority'])
            ->with(['employee.employeeEmployeeToDesignations' => function ($q) use ($date) {

                $q->DesignationDuring($date)->with(['designation']);;
            }])
            ->wherein('section_id', $sections_under_charge->pluck('id'))
            ->get();

        //  \Log::info('in getEmployeeSectionMappingForEmployees 3');

        return $employee_section_maps->count() ? $employee_section_maps : null;
    }

    public function getLoggedUserSubordinateEmployees()
    {
          //get current logged in user's charges
          $me = User::with('employee')->find(auth()->id());

          if ($me->employee_id == null) {
              return response()->json(['status' => 'No linked employee'], 400);
          }
          $seat_ids_of_loggedinuser = EmployeeToSeat::where('employee_id', $me->employee_id)->get()->pluck('seat_id');

          if (!$seat_ids_of_loggedinuser || count($seat_ids_of_loggedinuser)==0) {
              return response()->json(['status' => 'No seats in charge'], 400);
          }
         // \Log::info('seat_ids_of_loggedinuser ' . $seat_ids_of_loggedinuser );

          $employee_section_maps = $this->getEmployeeSectionMappingForEmployees([$me->employee_id], $date, $seat_ids_of_loggedinuser);
          $seat_ids_already_fetched = collect($seat_ids_of_loggedinuser);

          if (!$employee_section_maps) {
              return response()->json(['status' => 'No employee found'], 200);
          }

          $data = collect($employee_section_maps);

          while (count($emp_ids = $employee_section_maps->pluck('employee.id'))) {
            //  \Log::info('emp_ids --' . $emp_ids );

              $seat_ids = EmployeeToSeat::wherein('employee_id', $emp_ids)
                  ->wherenotin('seat_id', $seat_ids_already_fetched)
                  ->get()->pluck('seat_id');

            //  \Log::info('emp_ids 1' . $seat_ids );


              if (!$seat_ids || count($seat_ids)==0) break;

              $employee_section_maps = $this->getEmployeeSectionMappingForEmployees($emp_ids, $date, $seat_ids);

              if (!$employee_section_maps) break;

              $seat_ids_already_fetched = $seat_ids_already_fetched->concat($seat_ids);
              $data = $data->concat($employee_section_maps);
          }

          $data = $data->unique('employee_id')->map(function ($employeeToSection, $key) use ($seat_ids_of_loggedinuser) {
              // $employee_to_designation = $employeeToSection->employee->employee_employee_to_designations
              $results = json_decode(json_encode($employeeToSection)); //somehow cant get above line to work
              $employee_to_designation =  count($results->employee->employee_employee_to_designations)
                   ? $results->employee->employee_employee_to_designations[0] : null; //take the first item of array. there cant be two designations on a given day
              //\Log::info($employee_to_designation);
              return [
                  'employee_id' => $employeeToSection->employee_id,
                  'name' => $employeeToSection->employee->name,
                  'aadhaarid' => $employeeToSection->employee->aadhaarid,
                  'attendance_book_id' => $employeeToSection->attendance_book_id,
                  'attendance_book' => $employeeToSection->attendance_book,
                  'section_id' => $employeeToSection->section_id,
                  'section_name' => $employeeToSection->section->name,
                  'works_nights_during_session'  => $employeeToSection->section->works_nights_during_session,
                  'seat_of_controlling_officer_id'  => $employeeToSection->section->seat_of_controlling_officer_id,
                  'logged_in_user_is_controller' =>  $seat_ids_of_loggedinuser->contains($employeeToSection->section->seat_of_controlling_officer_id),
                  'designation' =>   $employee_to_designation?->designation->designation,
                  'designation_sortindex' =>  $employee_to_designation?->designation?->sort_index,
                  'default_time_group_id' =>  $employee_to_designation?->designation?->default_time_group_id,
                  'seniority' =>  $employeeToSection->employee?->seniority?->sortindex,
              ];
          });

    }

}
