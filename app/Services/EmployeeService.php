<?php

namespace App\Services;

use App\Models\Section;
use App\Models\Employee;
use App\Models\Designation;
use App\Models\EmployeeToSeat;
use App\Models\EmployeeToFlexi;
use App\Models\AttendanceRouting;
use App\Models\EmployeeToSection;
use App\Models\EmployeeToDesignation;
use Carbon\Carbon;
use Auth;

class EmployeeService
{
    // private AebasFetchService $aebasFetchService;
    // public function __construct(AebasFetchService $aebasFetchService)
    // {
    //     $this->aebasFetchService = $aebasFetchService;
    // }
    // public function getEmployeeType(Employee $emp)
    // {

    //     $desig = strtolower($emp->designation->designation);
    //     $category = strtolower($emp->categories?->category);
    //     // Log::info($desig);
    //     // Log::info($category);

    //     $isPartime = str_contains($desig, 'part time') || str_contains($desig, 'parttime') ||
    //         str_contains($category, 'parttime') ||
    //         $emp->designation->normal_office_hours == 3; //ugly
    //     $isFulltime = str_contains($category, 'fulltime') ||
    //         $emp->designation->normal_office_hours == 6;

    //     $isWatchnward = str_contains($category, 'watch');
    //     $isNormal = ! $isPartime && ! $isFulltime && ! $isWatchnward;

    //     return [$isPartime, $isFulltime,  $isWatchnward,  $isNormal];
    // }
    private function createDesigMapping($emp,  $aebas_desig_to_ourId, $empployee)
    {
        $designation_id = null;
        if (!array_key_exists($emp['designation'], $aebas_desig_to_ourId)) {
            $designation_id = Designation::updateOrCreate(['designation' => $emp['designation']])->id;
        } else {
            $designation_id = $aebas_desig_to_ourId[$emp['designation']];
        }

        EmployeeToDesignation::create(
            [

                'employee_id' => $empployee->id,
                'designation_id' => $designation_id,
                'start_date' => Carbon::parse($emp['creation_date'])->format('Y-m-d'),

            ]
        );
    }

    public function syncEmployeeDataFromAebas()
    {
        $aebas_employees = (new AebasFetchService())->fetchApi(1, 0);
        //\Log::info('got emp' . count($aebas_employees));

        $aebas_desig_to_ourId = [
            'Additional Personal Assistant to Deputy Speaker' => 1,
            'Additional Personal Assistant to Speaker' => 2,
            'Additional Private Secretary to Deputy Speaker' => 3,
            'additional private Secretary to Speaker' => 4,
            'Additional Secretary' => 5,
            'Amenities Assistant' => 6,
            'Amenities Supervisor' => 7,
            'Assembly Attendant' => 8,
            'Assistant' => 9,
            'Assistant (Office of the Deputy Speaker)' => 10,
            'Assistant (Office of the Speaker)' => 11,
            'Assistant Agriculture Officer' => 12,
            'Assistant Librarian Grade I' => 13,
            'Assistant Librarian Grade II' => 14,
            'Assistant Private Secretary' => 15,
            'Assistant Private Secretary to Deputy Speaker' => 16,
            'Assistant Section Officer' => 17,
            'ASSISTANT SENIOR GRADE' => 18,
            'ATTENDER GR-II' => 19,
            'Attender(Hg)' => 20,
            'Binder Gr I' => 21,
            'Binder Gr II' => 22,
            'Catalogue Assistant' => 23,
            'Chauffeur (Office of the Deputy Speaker)' => 24,
            'Chauffeur (Office of the Speaker)' => 25,
            'Chief Amenities Assistant' => 26,
            'Chief Editor' => 27,
            'Chief Information Assistant' => 28,
            'Chief Librarian' => 29,
            'CHM Technician' => 30,
            'Clerical Assistant (Grade II)' => 31,
            'Clerical Assistant (GradeI)' => 32,
            'Clerk ( Office of the Deputy Speaker)' => 33,
            'Computer Assistant (Grade I)' => 34,
            'Computer Assistant (Grade II)' => 35,
            'Computer Assistant (Office of the Deputy Speaker)' => 36,
            'Computer Assistant (Sel Grade)' => 37,
            'Computer Assistant (Sen Grade)' => 38,
            'Computer Operator cum Web Designer' => 39,
            'Computer Programmer ( Hardware)' => 40,
            'Computer Programmer ( Software)' => 41,
            'Confidential Assistant  (Grade I)' => 42,
            'Confidential Assistant  (Grade II)`' => 43,
            'Confidential Assistant (Office of the Deputy Speaker)' => 44,
            'Confidential Assistant (Selection Grade )' => 45,
            'Confidential Assistant (Sen Grade)' => 46,
            'Consultant IT' => 47,
            'COPY HOLDER' => 48,
            'Deputy Chief Editor' => 49,
            'Deputy Librarian' => 50,
            'Deputy Secretary' => 51,
            'Driver Gr I' => 52,
            'Driver Gr II' => 53,
            'Driver Snr Grade' => 54,
            'DTP OPERATOR' => 55,
            'Duffedar' => 56,
            'Editor of Debates' => 57,
            'Foreman' => 58,
            'Full Time Cleaner' => 59,
            'Full Time Gardner' => 60,
            'Full Time Sanitation Worker' => 61,
            'Full Time Sweeper' => 62,
            'Head Driver' => 63,
            'Head Gardener' => 64,
            'Helper' => 65,
            'Information Assistant' => 66,
            'Joint Chief Editor' => 67,
            'Joint Secretary' => 68,
            'Junior Health Inspector' => 69,
            'Lady Attendant' => 70,
            'Librarian' => 71,
            'Lift Operator' => 72,
            'Lift Supervisor' => 73,
            'Mochee' => 74,
            'NETWORK ADMINISTRATOR(NG)' => 75,
            'Office Attendant' => 76,
            'Office Attendant  GrI' => 77,
            'Office Attendant (Office of the Deputy Speaker)' => 78,
            'Office Attendant (Office of the Speaker)' => 79,
            'Office Superintendant' => 80,
            'Office Superintendent (Office of Speaker)' => 81,
            'Offset Machine Operator' => 82,
            'Part time Cleaner' => 83,
            'Part Time Gardener' => 84,
            'Part Time Sanitary Worker' => 85,
            'Part Time Sweeper' => 86,
            'Part Time Sweeper Cum Sanitation Worker' => 87,
            'PASTE-UP ARTIST GRADE II' => 88,
            'Personal Assistant' => 89,
            'Personal Assistant to Speaker' => 90,
            'PERSONAL SECRETARY' => 91,
            'Photocopier Operator' => 92,
            'Press Secretary to Speaker' => 93,
            'Private Secretary to Speaker' => 94,
            'Pump Operator' => 95,
            'READER GRADE II' => 96,
            'Reporter Grade I' => 97,
            'Reporter Grade II' => 98,
            'Roneo  Operator' => 99,
            'Secretary' => 100,
            'Section Officer' => 101,
            'Selection Grade Reporter' => 102,
            'Senior Grade Reporter' => 103,
            'Special Secretary' => 104,
            'System Administrator (Software)' => 105,
            'System Administrator (Hardware)' => 106,
            'Under Secretary' => 107,
            'Video Editor' => 108,
        ];

        foreach ($aebas_employees as $key => $emp) {

            $aadhaarid = preg_replace('/\s+/', '', trim($emp['emp_id']));
            $empployee = Employee::where('aadhaarid', $aadhaarid)->first();

            if ($aadhaarid !== $emp['emp_id']) {

                \Log::info('aebas emp_id has spaces' . $emp['emp_id'] . ' aadhaarid ' . $aadhaarid);

                if (!$empployee) {
                    $empployee = Employee::where('aadhaarid', $emp['emp_id'])->first();
                }
            }


            $gender = $emp['gender'];
            $email = $emp['emp_mail'];

            if (!$empployee) {
                //employee does not exist. create it

                $empployee = Employee::create([
                    'aadhaarid' => $aadhaarid,
                    'name' => $emp['emp_name'],
                    'srismt' =>  $gender == 'M' ? 'Sri' : 'Smt',
                ]);

                //designation does not exist. create it
                $this->createDesigMapping($emp,  $aebas_desig_to_ourId, $empployee);
                
            } else {

                $empployee->update([
                    'srismt' =>  $gender == 'M' ? 'Sri' : 'Smt',
                ]);

                // if('88295424' == $aadhaarid){
                //     \Log::info('88295424 found');
                //     \Log::info($empployee);
                // }

                // if($email){
                //     $emp->employeeExtra()->updateOrCreate([
                //         'email' => $email,
                //     ]);
                // }
                //check if employee has designation mapping
                $emptodesig = EmployeeToDesignation::where('employee_id', $empployee->id)->first();
                if (!$emptodesig) {
                    \Log::info('designation not found for ' . $empployee->name);
                    $this->createDesigMapping($emp,  $aebas_desig_to_ourId, $empployee);
                }

            }
        }

        return $aebas_employees;
    }

    public static function getDesignationOfEmployeesOnDate($date_str, $emp_ids)
    {
        $employee_section_maps = Employee::with(['employeeEmployeeToDesignations' => function ($q) use ($date_str) {
            $q->DesignationDuring($date_str)->with(['designation', 'designation.default_time_group']);
        }])
            ->wherein('id', $emp_ids)
            ->get();
        // dd($employee_section_maps);
        $employee_section_maps = $employee_section_maps->mapWithKeys(function ($item, $key) {

            $employee = json_decode(json_encode($item));

            $desig = count($employee?->employee_employee_to_designations) ? $employee->employee_employee_to_designations[0]->designation->designation : '';

            $time_group = count($employee?->employee_employee_to_designations) ? $employee->employee_employee_to_designations[0]->designation->default_time_group?->groupname : null;

            return [
                $item['aadhaarid'] => [
                    'name' => $employee?->name,
                    'designation' => $desig,
                    'shift' => $employee?->is_shift,
                    'time_group' => $time_group,
                ],
            ];
        });

        return $employee_section_maps;
    }
    /*
    public static function getEmployeeSectionMappingsAndDesignationsOnDate($date_str, $emp_ids)
    {
        $employee_section_maps = EmployeeToSection::duringPeriod($date_str, $date_str)
            ->with(['employee', 'section'])
            ->with(['employee.employeeEmployeeToDesignations' => function ($q) use ($date_str) {

                $q->DesignationDuring($date_str)->with(['designation', 'designation.default_time_group']);
            }])
            ->wherein('employee_id', $emp_ids)
            ->get();
        // dd($employee_section_maps);
        $employee_section_maps = $employee_section_maps->mapWithKeys(function ($item, $key) {

            $x = json_decode(json_encode($item));

            $desig = count($x->employee?->employee_employee_to_designations) ? $x->employee->employee_employee_to_designations[0]->designation->designation : '';

            $time_group_id = count($x->employee?->employee_employee_to_designations) ? $x->employee->employee_employee_to_designations[0]->designation->default_time_group_id : null;

            $time_group = count($x->employee?->employee_employee_to_designations) ? $x->employee->employee_employee_to_designations[0]->designation->default_time_group?->groupname : null;

            return [
                $item['aadhaarid'] => [
                    'name' => $x->employee?->name,
                    'designation' => $desig,
                    'section' => $x->section->name,
                    'section_id' => $x->section->id,
                    'shift' => $x->employee?->is_shift,
                    'time_group_id' => $time_group_id,
                    'time_group' => $time_group,
                ],
            ];
        });

        return $employee_section_maps;
    }
   */
    public static function getEmployeeSectionMappingsOnDate($date_str, $emp_ids)
    {
        $employee_section_maps = EmployeeToSection::onDate($date_str)
            ->with(['employee', 'section'])
            ->wherein('employee_id', $emp_ids)
            ->get();
        //dd($employee_section_maps);
        $employee_section_maps = $employee_section_maps->mapWithKeys(function ($item, $key) {

            $x = json_decode(json_encode($item));

            return [
                $x->employee->aadhaarid => [
                    'section' => $x->section->short_name,
                    'section_id' => $x->section->id,
                ],
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
                    'name' => $x->employee?->name,
                    'designation' => $desig,
                    'section' => $x->section->short_name,
                    'section_name' => $x->section->short_name,
                    'section_id' => $x->section->id,
                    'shift' => $x->employee?->is_shift,
                    'time_group_id' => $time_group_id,
                ],
            ];
        });

        return $employee_section_maps;
    }

    public function getEmployeeSectionMappingInPeriodFromSeats(
        $emp_ids,
        $seat_ids_of_loggedinuser,
        $date_from,
        $date_to,
        $all_subordinates = true
    ) {

        $seat_ids = $seat_ids_of_loggedinuser;

        $sections_under_charge = $all_subordinates ?

            Section::wherein('seat_of_controlling_officer_id', $seat_ids)
            ->orwherein('seat_of_reporting_officer_id', $seat_ids)
            ->orwherein('js_as_ss_employee_id', $emp_ids)->get()
            :

            Section::wherein('seat_of_reporting_officer_id', $seat_ids_of_loggedinuser)->get();




        if ($sections_under_charge->count() == 0 &&  $emp_ids == null && $seat_ids == null) {
            return null;
        }

        //\Log::info(' sections_under_charge ' . $sections_under_charge);
        // \Log::info(' employee_ids ' . $employee_ids);
        return $this->getEmployeesSectionMappingFromSeatsAndSections(
            $seat_ids_of_loggedinuser,
            $date_from,
            $date_to,
            $sections_under_charge->pluck('id'),
        );
    }


    public function  getEmployeesSectionMappingFromSeatsAndSections(
        $seat_ids_of_loggedinuser,
        $date_from,
        $date_to,
        $section_ids,
    ) {

        if (!$section_ids) {
            return null;
        }

        $today = Carbon::today()->format('Y-m-d');
        $employee_section_maps = EmployeeToSection::onDate($today)
        ->with(['employee', 'attendance_book', 'section', 'employee.seniority'])
        ->with(['employee.employeeEmployeeToDesignations' => function ($q) use ($date_from) {

            $q->DesignationDuring($date_from)->with(['designation', 'designation.default_time_group']);
        }])

        ->wherein('section_id', $section_ids)
        ->get();

      return $employee_section_maps && $employee_section_maps->count() ? $employee_section_maps : null;


    }


    /*
    For a list of employee ids, finds the seats and get sections related to that seat and then employees mppaed to that sections
    */

    public function getEmployeesToShow(
        $emp_ids,
        $seat_ids_of_loggedinuser,
        $date_from,
        $date_to,
        $subordinate_seats_controlled_by_me,
        $subordinate_seats_waydown,
        $employee_ids,
        $all_subordinates = true
    ) {
        // \Log::info('subordinate_seats_waydown ');
      //   \Log::info($subordinate_seats_waydown);


        $seat_ids = collect($subordinate_seats_controlled_by_me)->concat($subordinate_seats_waydown)->unique();

        $sections_controlled_by_me = $all_subordinates ?

            Section::wherein('seat_of_controlling_officer_id', $seat_ids_of_loggedinuser)

            ->orwherein('seat_of_reporting_officer_id', $seat_ids_of_loggedinuser)
            ->orwherein('js_as_ss_employee_id', $emp_ids)->get()
            :

            Section::wherein('seat_of_reporting_officer_id', $seat_ids_of_loggedinuser)->get();

        $sections_waydown = $all_subordinates ?

            Section::wherein('seat_of_controlling_officer_id', $subordinate_seats_waydown)
            ->orwherein('seat_of_controlling_officer_id', $subordinate_seats_controlled_by_me)
            ->orwherein('seat_of_reporting_officer_id', $subordinate_seats_controlled_by_me)
            ->orwherein('seat_of_reporting_officer_id', $subordinate_seats_waydown)
            ->orwherein('js_as_ss_employee_id', $emp_ids)->get()
            :

            Section::wherein('seat_of_reporting_officer_id', $seat_ids_of_loggedinuser)->get();



        if ($sections_controlled_by_me == null &&  $sections_waydown == null && $employee_ids == null && $seat_ids == null) {
            return null;
        }

        $section_officers_controlled_by_me = $sections_controlled_by_me->pluck('seat_of_reporting_officer_id');
        $subordinate_seats_controlled_by_me =  $subordinate_seats_controlled_by_me->concat($section_officers_controlled_by_me)->unique();
        $section_officers_waydown = $sections_waydown->pluck('seat_of_reporting_officer_id');
        $subordinate_seats_waydown = $subordinate_seats_waydown->concat($section_officers_waydown)->unique();

        $sections_under_charge = $sections_controlled_by_me->concat($sections_waydown)->unique();
        //\Log::info(' sections_under_charge ' . $sections_under_charge);
        // \Log::info(' employee_ids ' . $employee_ids);
        return $this->getEmployeesToShowFromSeatsAndSectionsAndEmpIDs(
            $seat_ids_of_loggedinuser,
            $date_from,
            $date_to,
            $sections_under_charge->pluck('id'),
            $subordinate_seats_controlled_by_me,
            $subordinate_seats_waydown,
            $sections_controlled_by_me,
            $sections_waydown,
            $employee_ids
        );
    }

    public function  getEmployeesToShowFromSeatsAndSectionsAndEmpIDs(
        $seat_ids_of_loggedinuser,
        $date_from,
        $date_to,
        $section_ids,
        $subordinate_seats_controlled_by_me,
        $subordinate_seats_waydown,
        $sections_controlled_by_me,
        $sections_waydown,
        $employee_ids
    ) {

        $seat_ids = collect($subordinate_seats_controlled_by_me);

        //$seat_ids = collect($subordinate_seats_controlled_by_me);
        if( $subordinate_seats_waydown){
            $seat_ids = $seat_ids->concat($subordinate_seats_waydown)->unique();
        }

        $my_emp_id = auth()->user()->employee_id;
        $emp_ids_of_subordinate_seats_controlled_by_me =  $subordinate_seats_controlled_by_me ? EmployeeToSeat::wherein('seat_id', $subordinate_seats_controlled_by_me)->pluck('employee_id') : collect();

        $emp_ids_of_subordinate_seats_waydown =  $subordinate_seats_waydown ? EmployeeToSeat::wherein('seat_id', $subordinate_seats_waydown)
                                                            ->pluck('employee_id') : collect();

        // $emp_ids_of_seats = $seat_ids->count()  ? EmployeeToSeat:: //duringPeriod($date_from, $date_to)->
        //     wherein('seat_id', $seat_ids)
        //     ->get()->pluck('employee_id')
        //     : EmployeeToSeat::pluck('employee_id'); //get all emps for secretary
        $emp_ids_of_seats = $seat_ids->count()  ? $emp_ids_of_subordinate_seats_controlled_by_me->concat($emp_ids_of_subordinate_seats_waydown)
            : EmployeeToSeat::pluck('employee_id'); //get all emps for secretary

       //\Log::info(' section_ids ' .  $section_ids->implode(','));

        if ($seat_ids->count()==0 && !$section_ids && !$employee_ids) {
            //view all for secretary
            //$all_sections = Section::all();
            //$section_ids = $all_sections->pluck('id');
            $sections_controlled_by_me = Section::wherein('seat_of_controlling_officer_id', $seat_ids_of_loggedinuser)
                ->get();
            $sections_waydown = Section::wherenotin('seat_of_controlling_officer_id', $seat_ids_of_loggedinuser)->get();
            $section_ids = $sections_controlled_by_me->pluck('id')->concat($sections_waydown->pluck('id'))->unique();

        } else
        if (!$emp_ids_of_seats && !$section_ids && !$employee_ids) {
            return null;
        }

        $employee_ids_combined = $employee_ids ?
            array_merge( $emp_ids_of_seats->toArray(),  $employee_ids->toArray())
            :  $emp_ids_of_seats->toArray();
        if($my_emp_id){
            $employee_ids_combined[] = $my_emp_id;
        }

        //$employee_ids_combined = $employee_ids ? $employee_ids->toArray() : [];

        \Log::info(' employee_ids_combined ' . implode(',', $employee_ids_combined));


        //$all_reporting_officers = $sections_controlled_by_me->pluck('seat_of_reporting_officer_id')
        //            ->concat($sections_waydown->pluck('seat_of_reporting_officer_id'))->unique();

        //allow jayasree mam to see old nasar sir attendance
        $today = Carbon::today()->format('Y-m-d');
        $employees = Employee::with(['employeeSectionMapping' => function ($q) use ($today, $date_from) {
            $q->onDate($today);
        }])
            ->with(['employeeSectionMapping.attendance_book', 'employeeSectionMapping.section', 'seniority'])
            ->with(['employeeEmployeeToDesignations' => function ($q) use ($date_from, $today) {

                $q->DesignationNow()->with(['designation', 'designation.default_time_group']);
            }])
            ->with(['employeeToSeatmapping'])
            ->wherehas('employeeSectionMapping', function ($q) use ($section_ids, $date_from, $today) {
                $q->wherein('section_id', $section_ids)
                ->OnDate($date_from);

            })
            ->orwherein('id', $employee_ids_combined)
            ->get();


            foreach ($employees as $emp) {
               if($employee_ids){
                 $emp->setAttribute('employeeLoadedDirectly', in_array($emp->id, $employee_ids->toArray()));
               }
               $emp->setAttribute('subordinate_seat_controlled_by_me', $emp_ids_of_subordinate_seats_controlled_by_me->contains($emp->id));
               $emp->setAttribute('subordinate_seat_waydown', $emp_ids_of_subordinate_seats_waydown->contains($emp->id));
               //if( $emp['employee_to_seatmapping'] )
               //section officers are not added to a section. so they will EmployeeToSectionMapping
               //in order to show their section, we need to find their seat and then find the section
               {
                   $emp_json = json_decode(json_encode($emp));
                   $emp_seats = $emp_json?->employee_to_seatmapping;
                   $emp_seat = null;
                   if(count($emp_seats)){
                       $emp_seat = $emp_seats[0]->seat_id;
                   }

                   if($emp_seat){
                   //\Log::info('found emp_seat');
                   //\Log::info($emp_seat);

                    $section = null;
                    if($sections_controlled_by_me)
                        $section = $sections_controlled_by_me->where('seat_of_reporting_officer_id', $emp_seat)->first();
                    if(!$section && $sections_waydown){
                        $section = $sections_waydown->where('seat_of_reporting_officer_id', $emp_seat)->first();
                    }

                    if( $section){
                           //\Log::info('found section');
                           //\Log::info($section);


                        $emp->setAttribute('section_id', $section->id);
                        $emp->setAttribute('section_name', $section->short_name);
                    }
                   }
               }
            }


        return $employees && $employees->count() ? $employees : null;
    }

    public function getLoggedUserSubordinateEmployees($date_from, $date_to, $seat_ids_of_loggedinuser, $me, $loadRouting = true)
    {

        // \Log::info('seat_ids_of_loggedinuser ' . $seat_ids_of_loggedinuser );
        $subordinate_seats_controlled_by_me = collect($seat_ids_of_loggedinuser);
        $subordinate_seats_waydown = collect();
        $seat_ids = $seat_ids_of_loggedinuser;
        $employee_ids = null;

        $recursion = 0;
        while (1) {
            $recursion++;

            $routing = AttendanceRouting::with(['viewer_seat', 'viewable_seats'])
                ->wherein('viewer_seat_id', $seat_ids)
                ->get();

            $subordinate_seats = $routing->pluck('viewable_seats')->flatten()->pluck('id');

            if (!$employee_ids) {
                $employee_ids = $routing->pluck('viewable_js_as_ss_employees')->flatten()->pluck('id'); //lets not recurse
            }/*else{
                $employee_ids = $employee_ids->merge($routing->pluck('viewable_js_as_ss_employees')->flatten()->pluck('id'));
            }*/

            if ($subordinate_seats->count() == 0) {
                break;
            }
            \Log::info('subordinate_seats ' . $subordinate_seats);
            $seat_ids = $subordinate_seats;
            //$seat_ids = $seat_ids->concat($subordinate_seats);

            if ($recursion === 1) {
                $subordinate_seats_controlled_by_me = $subordinate_seats;
            } else {
                $subordinate_seats_waydown = $subordinate_seats_waydown->concat($subordinate_seats);
            }

            if (!$loadRouting) break; //mmonthlyview prevent all hundreds of assistants/oas to be loaded for secretary which will be loaded in daily view
        }

         \Log::info('all_subordinate_seats ' . $subordinate_seats_controlled_by_me );
        //  \Log::info('employee_ids ' . $employee_ids );


        $employees = $this->getEmployeesToShow(
            [$me->employee_id],
            $seat_ids_of_loggedinuser,
            $date_from,
            $date_to,
            $subordinate_seats_controlled_by_me,
            $subordinate_seats_waydown,
            $employee_ids
        );

        // $seat_ids_already_fetched = collect($seat_ids_of_loggedinuser);

        return $employees;
    }

    public function employeeToResource($employees, $seat_ids_of_loggedinuser, $userIsSuperiorOfficer)
    {
        if (!$employees) {
            return null;
        }

        $data = collect($employees);

        $mycontrolledseats = AttendanceRouting::getSeatsUnderMyDirectControl($seat_ids_of_loggedinuser);
        $employeetoSeatmapping = EmployeeToSeat::with(['employee','seat'])
        ->where('employee_id', '!=', null) //ignore vacant seats
        ->get()->mapWithKeys(function ($item) {
            return [$item->employee->id => $item->seat->id];
        });
        \Log::info('$mycontrolledseats');
        \Log::info($mycontrolledseats);
        $isSecretary = Auth::user()->hasRole('secretary');
        $my_emp_id = auth()->user()->employee_id;
        $data = $data->unique('id')->map(function ($employee, $key) use ( $isSecretary, $my_emp_id,$seat_ids_of_loggedinuser,  $employeetoSeatmapping,$mycontrolledseats, $userIsSuperiorOfficer) {
            // $employee_to_designation = $employeeToSection->employee->employee_employee_to_designations
            $results = json_decode(json_encode($employee)); //somehow cant get above line to work
            $employee_to_designation = count($results->employee_employee_to_designations)
                ? $results->employee_employee_to_designations[0] : null; //take the first item of array. there cant be two designations on a given day

            //\Log::info($employee);

            $employeeToSection = count($results->employee_section_mapping) ? collect($results->employee_section_mapping)->sortByDesc('start_date')->first() : null;
            $logged_in_user_is_controller =
                $seat_ids_of_loggedinuser?->contains($employeeToSection?->section->seat_of_controlling_officer_id) ?? false;

            if(!$logged_in_user_is_controller && $employeetoSeatmapping->has($employee->id) ){
               $logged_in_user_is_controller = $mycontrolledseats->contains($employeetoSeatmapping[$employee->id]);
              // if($logged_in_user_is_controller) \Log::info('found ' . $employee->name);
            }
            //since we also load ourselves, we need to check if we are controller of our own seat
            $this_is_me = $employee->id == $my_emp_id;
            if(!$logged_in_user_is_controller && !$this_is_me){
                $logged_in_user_is_controller = $employee?->subordinate_seat_controlled_by_me ?? false;
            }
            if($userIsSuperiorOfficer && (!$employee?->employeeLoadedDirectly)){
                $userIsSuperiorOfficer = false;
            }

            if($userIsSuperiorOfficer && $this_is_me){
                $userIsSuperiorOfficer = false;
            }
            if($isSecretary){
                $userIsSuperiorOfficer = true;
            }
            // \Log::info($employeeToSection);
            //if we loaded employee through AttendanceRoutings' viewable_js_as_ss_employees, then we need to mark it as such
            //as that does not mean that the employee is a subordinate of the logged in user
            return [
                'employee_id' => $employee->id,
                'name' => $employee->name,
                'start_date' => $employeeToSection?->start_date,
                'end_date' => $employeeToSection?->end_date,
                'aadhaarid' => $employee->aadhaarid,
                'attendance_book_id' => $employeeToSection?->attendance_book_id,
                'attendance_book' => $employeeToSection?->attendance_book,
                'section_id' => $employeeToSection?->section_id ?? $employee['section_id'],
                'section_name' => $employeeToSection?->section->short_name ?? $employee['section_name'],
                'works_nights_during_session' => $employeeToSection?->section->works_nights_during_session,
                'seat_of_controlling_officer_id' => $employeeToSection?->section->seat_of_controlling_officer_id,
                'logged_in_user_is_controller' => $logged_in_user_is_controller,
                'logged_in_user_is_section_officer' => $seat_ids_of_loggedinuser?->contains($employeeToSection?->section->seat_of_reporting_officer_id) ?? false,
                'logged_in_user_is_superior_officer' => $userIsSuperiorOfficer,
                'designation' => $employee_to_designation?->designation->designation,
                'designation_sortindex' => $employee_to_designation?->designation?->sort_index ?? 1000,
                'default_time_group_id' => $employee_to_designation?->designation?->default_time_group_id,
                'seniority' => $employee?->seniority?->sortindex ?? 1000000,
                'created_at' => $employee->created_at,
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
            [$me->employee_id],
            $seat_ids_of_loggedinuser,
            $date_from,
            $date_to,
            true
        );

        if (!$employee_section_maps) {
            return null;
        }

        $data = collect($employee_section_maps);

        $data = $data->unique('employee_id')->map(function ($employeeToSection, $key) use ($seat_ids_of_loggedinuser, $date_from) {
            // $employee_to_designation = $employeeToSection->employee->employee_employee_to_designations
            $results = json_decode(json_encode($employeeToSection)); //somehow cant get above line to work
            $employee_to_designation = count($results->employee->employee_employee_to_designations)
                ? $results->employee->employee_employee_to_designations[0] : null; //take the first item of array. there cant be two designations on a given day

            //  flexi_times: number;
            //   flexi_minutes: number;
            //   flexi_time_last_updated: string;
            $emp_flexi_time = EmployeeToFlexi::getEmployeeFlexiTime($date_from, $employeeToSection->employee_id);
            $emp_flexi_time_upcoming = EmployeeToFlexi::getEmployeeUpcomingFlexiTime($employeeToSection->employee_id);


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
                'section_id' => $employeeToSection->section->id,
                'section_name' => $employeeToSection->section->name,
                'seat_of_controlling_officer_id' => $employeeToSection->section->seat_of_controlling_officer_id,
                'logged_in_user_is_controller' => $seat_ids_of_loggedinuser->contains($employeeToSection->section->seat_of_controlling_officer_id),
                'logged_in_user_is_section_officer' => $seat_ids_of_loggedinuser->contains($employeeToSection->section->seat_of_reporting_officer_id),
                'designation' => $employee_to_designation?->designation->designation,
                'designation_sortindex' => $employee_to_designation?->designation?->sort_index,
                //'default_time_group_id' => $employee_to_designation?->designation?->default_time_group_id,
                'time_group' => $employee_to_designation?->designation?->default_time_group?->groupname ?? 'default',
                'seniority' => $employeeToSection->employee?->seniority?->sortindex,
                'flexi_minutes_current' => $emp_flexi_time?->flexi_minutes ?? 0,
                'flexi_time_wef_current' => $emp_flexi_time?->with_effect_from ?? null,
                'flexi_minutes_upcoming' => $emp_flexi_time_upcoming?->flexi_minutes ?? 0,
                'flexi_time_wef_upcoming' => $emp_flexi_time_upcoming?->with_effect_from ?? null,

            ];
        });

        return $data;
    }

    public static function getSectionOfEmployeeOnDate($aadhaarid, $date)
    {
        $employee = Employee::where('aadhaarid', $aadhaarid)->first();
        if (!$employee) {
            return [null, 'Employee not found', 400];
        }

        $employeeToSection = EmployeeToSection::duringPeriod($date, $date)
            ->where('employee_id', $employee->id)
            ->with('section')
            ->first();

        if (!$employeeToSection) {
            return [null, 'Employee not found  in any section', 400];
        }

        return [$employeeToSection->section, 'success', 200];
    }

    public static function createOrUpdateFlexi($employee_id, $flexi_minutes, $wef)
    {
        \Log::info($employee_id);

        //get current flexi time
        $current_flexi = EmployeeToFlexi::getEmployeeFlexiTime(Carbon::today()->format('Y-m-d'), $employee_id);

        // $empFlexi = EmployeeToFlexi::where('employee_id', $employee_id)->first();

        //check last updated date
        if ($current_flexi) {
            $last_updated = Carbon::parse($current_flexi->with_effect_from);
            $today = Carbon::today();
            if ($last_updated->diffInDays($today, true) < 20) {
                return response()->json(['status' => 'failed', 'message' => 'You cannot update flexi time now'], 400);
            }
            //see if there is any change in flexi time
            if ($current_flexi->flexi_minutes == $flexi_minutes) {
                return response()->json(['status' => 'failed', 'message' => 'No change in flexi time'], 400);
            }
        }

        \Log::info($wef);
        $with_effect_from =  Carbon::parse($wef);
        if ($with_effect_from->isToday() || $with_effect_from->isPast()) {
            return response()->json(['status' => 'failed', 'message' => 'You cannot set flexi time for today/past date ' . $with_effect_from->format('Y-m-d')], 400);
        }

        //we should check if the employee has any flexi time set for the future
        $upcoming_flexi = EmployeeToFlexi::getEmployeeUpcomingFlexiTime($employee_id);
        if ($upcoming_flexi) {
            $upcoming_flexi->update([
                'employee_id' => $employee_id,
                'flexi_minutes' => $flexi_minutes,
                'with_effect_from' => $with_effect_from->format('Y-m-d'),
            ]);
        } else {
            EmployeeToFlexi::create([
                'employee_id' => $employee_id,
                'flexi_minutes' => $flexi_minutes,
                'with_effect_from' => $with_effect_from->format('Y-m-d'),
            ]);
        }

        return response()->json(['status' => 'success'], 200);
    }
}
