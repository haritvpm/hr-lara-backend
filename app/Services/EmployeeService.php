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
use App\Models\EmployeeToDesignation;
use App\Models\Designation;

class EmployeeService
{

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

        $isPartime = str_contains($desig, "part time") || str_contains($desig, "parttime") ||
            str_contains($category, "parttime") ||
            $emp->designation->normal_office_hours == 3; //ugly
        $isFulltime = str_contains($category, "fulltime") ||
            $emp->designation->normal_office_hours == 6;

        $isWatchnward = str_contains($category, "watch");
        $isNormal = !$isPartime && !$isFulltime && !$isWatchnward;

        return [$isPartime, $isFulltime,  $isWatchnward,  $isNormal];
    }
    public  function syncEmployeeDataFromAebas()
    {
        $aebas_employees = (new AebasFetchService())->fetchApi(1, 0);
        //\Log::info('got emp' . count($aebas_employees));

        $aebas_desig_to_ourId = array(
            "Additional Personal Assistant to Deputy Speaker" => 1,
            "Additional Personal Assistant to Speaker" => 2,
            "Additional Private Secretary to Deputy Speaker" => 3,
            "additional private Secretary to Speaker" => 4,
            "Additional Secretary" => 5,
            "Amenities Assistant" => 6,
            "Amenities Supervisor" => 7,
            "Assembly Attendant" => 8,
            "Assistant" => 9,
            "Assistant (Office of the Deputy Speaker)" => 10,
            "Assistant (Office of the Speaker)" => 11,
            "Assistant Agriculture Officer" => 12,
            "Assistant Librarian Grade I" => 13,
            "Assistant Librarian Grade II" => 14,
            "Assistant Private Secretary" => 15,
            "Assistant Private Secretary to Deputy Speaker" => 16,
            "Assistant Section Officer" => 17,
            "ASSISTANT SENIOR GRADE" => 18,
            "ATTENDER GR-II" => 19,
            "Attender(Hg)" => 20,
            "Binder Gr I" => 21,
            "Binder Gr II" => 22,
            "Catalogue Assistant" => 23,
            "Chauffeur (Office of the Deputy Speaker)" => 24,
            "Chauffeur (Office of the Speaker)" => 25,
            "Chief Amenities Assistant" => 26,
            "Chief Editor" => 27,
            "Chief Information Assistant" => 28,
            "Chief Librarian" => 29,
            "CHM Technician" => 30,
            "Clerical Assistant (Grade II)" => 31,
            "Clerical Assistant (GradeI)" => 32,
            "Clerk ( Office of the Deputy Speaker)" => 33,
            "Computer Assistant (Grade I)" => 34,
            "Computer Assistant (Grade II)" => 35,
            "Computer Assistant (Office of the Deputy Speaker)" => 36,
            "Computer Assistant (Sel Grade)" => 37,
            "Computer Assistant (Sen Grade)" => 38,
            "Computer Operator cum Web Designer" => 39,
            "Computer Programmer ( Hardware)" => 40,
            "Computer Programmer ( Software)" => 41,
            "Confidential Assistant  (Grade I)" => 42,
            "Confidential Assistant  (Grade II)`" => 43,
            "Confidential Assistant (Office of the Deputy Speaker)" => 44,
            "Confidential Assistant (Selection Grade )" => 45,
            "Confidential Assistant (Sen Grade)" => 46,
            "Consultant IT" => 47,
            "COPY HOLDER" => 48,
            "Deputy Chief Editor" => 49,
            "Deputy Librarian" => 50,
            "Deputy Secretary" => 51,
            "Driver Gr I" => 52,
            "Driver Gr II" => 53,
            "Driver Snr Grade" => 54,
            "DTP OPERATOR" => 55,
            "Duffedar" => 56,
            "Editor of Debates" => 57,
            "Foreman" => 58,
            "Full Time Cleaner" => 59,
            "Full Time Gardner" => 60,
            "Full Time Sanitation Worker" => 61,
            "Full Time Sweeper" => 62,
            "Head Driver" => 63,
            "Head Gardener" => 64,
            "Helper" => 65,
            "Information Assistant" => 66,
            "Joint Chief Editor" => 67,
            "Joint Secretary" => 68,
            "Junior Health Inspector" => 69,
            "Lady Attendant" => 70,
            "Librarian" => 71,
            "Lift Operator" => 72,
            "Lift Supervisor" => 73,
            "Mochee" => 74,
            "NETWORK ADMINISTRATOR(NG)" => 75,
            "Office Attendant" => 76,
            "Office Attendant  GrI" => 77,
            "Office Attendant (Office of the Deputy Speaker)" => 78,
            "Office Attendant (Office of the Speaker)" => 79,
            "Office Superintendant" => 80,
            "Office Superintendent (Office of Speaker)" => 81,
            "Offset Machine Operator" => 82,
            "Part time Cleaner" => 83,
            "Part Time Gardener" => 84,
            "Part Time Sanitary Worker" => 85,
            "Part Time Sweeper" => 86,
            "Part Time Sweeper Cum Sanitation Worker" => 87,
            "PASTE-UP ARTIST GRADE II" => 88,
            "Personal Assistant" => 89,
            "Personal Assistant to Speaker" => 90,
            "PERSONAL SECRETARY" => 91,
            "Photocopier Operator" => 92,
            "Press Secretary to Speaker" => 93,
            "Private Secretary to Speaker" => 94,
            "Pump Operator" => 95,
            "READER GRADE II" => 96,
            "Reporter Grade I" => 97,
            "Reporter Grade II" => 98,
            "Roneo  Operator" => 99,
            "Secretary" => 100,
            "Section Officer" => 101,
            "Selection Grade Reporter" => 102,
            "Senior Grade Reporter" => 103,
            "Special Secretary" => 104,
            "System Administrator (Software)" => 105,
            "System Administrator (Hardware)" => 106,
            "Under Secretary" => 107,
            "Video Editor" => 108
        );


        foreach ($aebas_employees as $key => $emp) {

            if (!Employee::where('aadhaarid', $emp['emp_id'])->first()) {
                $id = Employee::create([
                    'aadhaarid' => $emp['emp_id'],
                    'name' => $emp['emp_name'],
                ])->id;

                //designation does not exist. create it
                $designation_id = null;
                if (!array_key_exists($emp['designation'],  $aebas_desig_to_ourId)) {
                    $designation_id = Designation::updateOrCreate(['designation' => $emp['designation']])->id;
                } else {
                    $designation_id = $aebas_desig_to_ourId[$emp['designation']];
                }


                EmployeeToDesignation::create(
                    [

                        'employee_id' =>  $id,
                        'designation_id' => $designation_id,
                        'start_date' =>  '2024-01-01',

                    ]
                );
            }
        }



        return $aebas_employees;
    }


    public static function getDesignationOfEmployeesOnDate($date_str,  $emp_ids)
    {
        $employee_section_maps = Employee::with(['employeeEmployeeToDesignations' => function ($q) use ($date_str) {
                $q->DesignationDuring($date_str)->with(['designation']);
            }])
            ->wherein('id', $emp_ids)
            ->get();
        // dd($employee_section_maps);
        $employee_section_maps = $employee_section_maps->mapWithKeys(function ($item, $key) {

            $employee = json_decode(json_encode($item));

            $desig = count($employee?->employee_employee_to_designations) ? $employee->employee_employee_to_designations[0]->designation->designation : '';

            $time_group_id = count($employee?->employee_employee_to_designations) ? $employee->employee_employee_to_designations[0]->designation->default_time_group_id : null;

            return [
                $item['aadhaarid'] => [
                    'name' =>  $employee?->name,
                    'designation' => $desig,
                    'shift' => $employee?->is_shift,
                    'time_group_id' => $time_group_id,
                ]
            ];
        });

        return $employee_section_maps;
    }

    public function getEmployeeSectionMappingsAndDesignationsOnDate($date_str,  $emp_ids)
    {
        $employee_section_maps = EmployeeToSection::duringPeriod($date_str, $date_str)
            ->with(['employee', 'section'])
            ->with(['employee.employeeEmployeeToDesignations' => function ($q) use ($date_str) {

                $q->DesignationDuring($date_str)->with(['designation']);
            }])
            ->wherein('employee_id', $emp_ids)
            ->get();
        // dd($employee_section_maps);
        $employee_section_maps = $employee_section_maps->mapWithKeys(function ($item, $key) {

            $x = json_decode(json_encode($item));

            $desig = count($x->employee?->employee_employee_to_designations) ? $x->employee->employee_employee_to_designations[0]->designation->designation : '';

            $time_group_id = count($x->employee?->employee_employee_to_designations) ? $x->employee->employee_employee_to_designations[0]->designation->default_time_group_id : null;

            return [
                $item['employee']['aadhaarid'] => [
                    'name' =>  $x->employee?->name,
                    'designation' => $desig,
                    'section' => $x->section->name,
                    'section_id' => $x->section->id,
                    'shift' => $x->employee?->is_shift,
                    'time_group_id' => $time_group_id,
                ]
            ];
        });

        return $employee_section_maps;
    }

    public function getEmployeeSectionMappingInPeriod($emp_id, $date_from, $date_to)
    {
        $employee_section_maps = EmployeeToSection::duringPeriod($date_from, $date_to)
            ->with(['employee', 'section'])
            ->with(['employee.employeeEmployeeToDesignations' => function ($q) use ($date_to) {

                $q->DesignationDuring($date_to)->with(['designation']);
            }])
            ->where('employee_id', $emp_id)
            ->get();

        $employee_section_maps = $employee_section_maps->mapWithKeys(function ($item, $key) {

            $x = json_decode(json_encode($item));

            $desig = count($x->employee?->employee_employee_to_designations) ? $x->employee->employee_employee_to_designations[0]->designation->designation : '';
            $time_group_id = count($x->employee?->employee_employee_to_designations) ? $x->employee->employee_employee_to_designations[0]->designation->default_time_group_id : null;

            return [
                $item['employee']['aadhaarid'] => [
                    'name' =>  $x->employee?->name,
                    'designation' => $desig,
                    'section' => $x->section->name,
                    'section_id' => $x->section->id,
                    'shift' => $x->employee?->is_shift,
                    'time_group_id' => $time_group_id,
                ]
            ];
        });

        return $employee_section_maps;
    }

    /*
    For a list of employee ids, finds the seats and get sections related to that seat and then employees mppaed to that sections
    */
    public function getEmployeeSectionMappingInPeriodFromSeats($emp_ids, $date_from, $date_to,  $seat_ids, $all_subordinates = true)
    {
        // \Log::info('getEmployeeSectionMappingForEmployees seat_ids ' . $seat_ids);

        $sections_under_charge =  $all_subordinates ?

            Section::wherein('seat_of_controlling_officer_id', $seat_ids)
            ->orwherein('seat_of_reporting_officer_id', $seat_ids)
            ->orwherein('js_as_ss_employee_id', $emp_ids)->get() :

            Section::wherein('seat_of_reporting_officer_id', $seat_ids)->get();

        if ($sections_under_charge == null) {
            return null;
        }
        // \Log::info(' sections_under_charge ' . $sections_under_charge);

        $employee_section_maps = EmployeeToSection::duringPeriod($date_from, $date_to )
            ->with(['employee', 'attendance_book', 'section', 'employee.seniority'])
            ->with(['employee.employeeEmployeeToDesignations' => function ($q) use ($date_to) {

                $q->DesignationDuring($date_to)->with(['designation']);
            }])
            ->wherein('section_id', $sections_under_charge->pluck('id'))
            ->get();

        //  \Log::info('in getEmployeeSectionMappingForEmployees 3');

        return $employee_section_maps->count() ? $employee_section_maps : null;
    }

    public function getLoggedUserSubordinateEmployees($date_from, $date_to, $seat_ids_of_loggedinuser, $me)
    {

        // \Log::info('seat_ids_of_loggedinuser ' . $seat_ids_of_loggedinuser );

        $employee_section_maps = $this->getEmployeeSectionMappingInPeriodFromSeats(
                [$me->employee_id], $date_from, $date_to, $seat_ids_of_loggedinuser);

        $seat_ids_already_fetched = collect($seat_ids_of_loggedinuser);

        if (!$employee_section_maps) {
            return null;
        }

        $data = collect($employee_section_maps);

        while (count($emp_ids = $employee_section_maps->pluck('employee.id'))) {
            //  \Log::info('emp_ids --' . $emp_ids );

            $seat_ids = EmployeeToSeat::wherein('employee_id', $emp_ids)
                ->wherenotin('seat_id', $seat_ids_already_fetched)
                ->get()->pluck('seat_id');

            //  \Log::info('emp_ids 1' . $seat_ids );


            if (!$seat_ids || count($seat_ids) == 0) break;

            $employee_section_maps = $this->getEmployeeSectionMappingInPeriodFromSeats(
                $emp_ids, $date_from, $date_to, $seat_ids);

            if (!$employee_section_maps) break;

            $seat_ids_already_fetched = $seat_ids_already_fetched->concat($seat_ids);
            $data = $data->concat($employee_section_maps);
        }

        $data = $data->unique('employee_id')->map(function ($employeeToSection, $key) use ($seat_ids_of_loggedinuser) {
            // $employee_to_designation = $employeeToSection->employee->employee_employee_to_designations
            $results = json_decode(json_encode($employeeToSection)); //somehow cant get above line to work
            $employee_to_designation =  count($results->employee->employee_employee_to_designations)
                ? $results->employee->employee_employee_to_designations[0] : null; //take the first item of array. there cant be two designations on a given day
           // \Log::info($employeeToSection);
            return [
                'employee_id' => $employeeToSection->employee_id,
                'name' => $employeeToSection->employee->name,
                'start_date' => $employeeToSection->start_date,
                'end_date' => $employeeToSection->end_date,
                'aadhaarid' => $employeeToSection->employee->aadhaarid,
                'attendance_book_id' => $employeeToSection->attendance_book_id,
                'attendance_book' => $employeeToSection->attendance_book,
                'section_id' => $employeeToSection->section_id,
                'section_name' => $employeeToSection->section->name,
                'works_nights_during_session'  => $employeeToSection->section->works_nights_during_session,
                'seat_of_controlling_officer_id'  => $employeeToSection->section->seat_of_controlling_officer_id,
                'logged_in_user_is_controller' =>  $seat_ids_of_loggedinuser->contains($employeeToSection->section->seat_of_controlling_officer_id),
                'logged_in_user_is_section_officer' =>  $seat_ids_of_loggedinuser->contains($employeeToSection->section->seat_of_reporting_officer_id),

                'designation' =>   $employee_to_designation?->designation->designation,
                'designation_sortindex' =>  $employee_to_designation?->designation?->sort_index ?? 1000,
                'default_time_group_id' =>  $employee_to_designation?->designation?->default_time_group_id,
                'seniority' =>  $employeeToSection->employee?->seniority?->sortindex ?? 1000000,
            ];
        })

        ->sortBy('designation_sortindex')
        ->sortBy('seniority')
        ->sortBy('section_name');

        return $data;
    }


    public function getLoggedInUserSectionEmployees($date_from, $date_to, $seat_ids_of_loggedinuser, $me)
    {

        //only get my sections' employees. not for which I am controller of
        $employee_section_maps = $this->getEmployeeSectionMappingInPeriodFromSeats(
                [$me->employee_id], $date_from, $date_to, $seat_ids_of_loggedinuser, false);

        if (!$employee_section_maps) {
            return null;
        }

        $data = collect($employee_section_maps);

        $data = $data->unique('employee_id')->map(function ($employeeToSection, $key) use ($seat_ids_of_loggedinuser) {
            // $employee_to_designation = $employeeToSection->employee->employee_employee_to_designations
            $results = json_decode(json_encode($employeeToSection)); //somehow cant get above line to work
            $employee_to_designation =  count($results->employee->employee_employee_to_designations)
                ? $results->employee->employee_employee_to_designations[0] : null; //take the first item of array. there cant be two designations on a given day
           // \Log::info($employeeToSection);
            return [
                'id' => $employeeToSection->id,
                'employee_id' => $employeeToSection->employee_id,
                'name' => $employeeToSection->employee->name,
                'start_date' => $employeeToSection->start_date,
                'end_date' => $employeeToSection->end_date,
                'aadhaarid' => $employeeToSection->employee->aadhaarid,
                'attendance_book_id' => $employeeToSection->attendance_book_id,
                'attendance_book' => $employeeToSection->attendance_book,
                'section_id' => $employeeToSection->section_id,
                'section_name' => $employeeToSection->section->name,
                'seat_of_controlling_officer_id'  => $employeeToSection->section->seat_of_controlling_officer_id,
                'logged_in_user_is_controller' =>  $seat_ids_of_loggedinuser->contains($employeeToSection->section->seat_of_controlling_officer_id),
                'logged_in_user_is_section_officer' =>  $seat_ids_of_loggedinuser->contains($employeeToSection->section->seat_of_reporting_officer_id),
                'designation' =>   $employee_to_designation?->designation->designation,
                'designation_sortindex' =>  $employee_to_designation?->designation?->sort_index,
                'default_time_group_id' =>  $employee_to_designation?->designation?->default_time_group_id,
                'seniority' =>  $employeeToSection->employee?->seniority?->sortindex,
            ];
        });

        return $data;
    }

    public static function getSectionOfEmployeeOnDate($aadhaarid, $date)
    {
        $employee = Employee::where('aadhaarid', $aadhaarid)->first();
        if (!$employee) {
            return [null,'Employee not found', 400];
        }

        $employeeToSection = EmployeeToSection::duringPeriod($date, $date)
            ->where('employee_id', $employee->id)
            ->with('section')
            ->first();

        if (!$employeeToSection) {
            return [null,'Employee not found  in any section', 400];
        }

        return [$employeeToSection->section, 'success', 200];
    }
}
