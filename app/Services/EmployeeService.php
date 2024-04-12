<?php

namespace App\Services;
use Carbon\Carbon;
use App\Employee;
use App\Services\AebasFetchService;

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
}