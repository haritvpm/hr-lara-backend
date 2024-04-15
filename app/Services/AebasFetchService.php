<?php

namespace App\Services;
use Carbon\Carbon;
use App\Employee;
use Illuminate\Support\Facades\Http;

class AebasFetchService {

    public function fetchApi( $apinum, $offset=0, $reportdate = null )
    {
        $apikey =  env('AEBAS_KEY');
        $count = 500;
        
        $returnkey = "successattendance";
        // should be in format 2024-02-11
        if($reportdate){
            $reportdate = Carbon::createFromFormat(config('app.date_format'), $reportdate)->format('Y-m-d');
        } else {
            $reportdate = Carbon::today()->format('Y-m-d');
        }

        $data = [];

        for (; ;$offset += $count) {

            //5
            $url = "https://basreports.attendance.gov.in/api/unibasglobal/api/attendance/offset/{$offset}/count/{$count}/reportdate/{$reportdate}/apikey/{$apikey}";

            if (1 == $apinum) {
                $url = "https://basreports.attendance.gov.in/api/unibasglobal/api/employee/offset/{$offset}/count/{$count}/apikey/{$apikey}";
                $returnkey = "employee";
            } else
            if ($apinum == 6) {
                $url = "https://basreports.attendance.gov.in/api/unibasglobal/api/trace/offset/{$offset}/count/{$count}/reportdate/{$reportdate}/apikey/{$apikey}";
                $returnkey = "attendancetrace";
            } else if ($apinum == 4) {
                $url = "https://basreports.attendance.gov.in/api/unibasglobal/api/attendancetodaytrace/offset/{$offset}/count/{$count}/apikey/{$apikey}";
                $returnkey = "attendancetodaytrace";
            } else if ($apinum == 3) {
                $url = "https://basreports.attendance.gov.in/api/unibasglobal/api/attendancetoday/offset/{$offset}/count/{$count}/apikey/{$apikey}";
                $returnkey = "SuccessAttendanceToday";
            }  else if ($apinum == 9) {
                $url = "https://basreports.attendance.gov.in/api/unibasglobal/api/orgleave/offset/{$offset}/count/{$count}/apikey/{$apikey}";
                $returnkey = "leavedetails";
            } else if ($apinum == 11) {
                $url = "https://basreports.attendance.gov.in/api/unibasglobal/api/orgleavebydate/offset/{$offset}/count/{$count}/reportdate/{$reportdate}/apikey/{$apikey}";
                $returnkey = "leavedetails";
            } else if ($apinum == 13) {
                $url = "https://basreports.attendance.gov.in/api/unibasglobal/api/attendancewithdetails/reportdate/{$reportdate}/offset/{$offset}/count/{$count}/apikey/{$apikey}";
                $returnkey = "AttendanceWithdetails";
            } else if ($apinum == 14) {
                $url = "https://basreports.attendance.gov.in/api/unibasglobal/api/tracewithdetails/reportdate/{$reportdate}/offset/{$offset}/count/{$count}/apikey/{$apikey}";
                $returnkey = "AttendanceTraceWithdetails";
            } else if ($apinum == (14 + 5)) {
                $url = "https://basreports.attendance.gov.in/api/unibasglobal/api/orgshift/{$apikey}";
                $returnkey = "orgshift";
            }else if ($apinum == (14 + 9)) {

                $url = "https://basreports.attendance.gov.in/api/unibasglobal/api/detailsbydistrictid/districtid/00581/offset/{$offset}/count/{$count}/apikey/{$apikey}";
                $returnkey = "DeviceDetailsDistrictId";
            }


            // $url = 'http://localhost:3000/data';
            \Log::info($url);
            $response = Http::timeout(60)->withHeaders([
                'Access-Control-Allow-Origin' => '*',
                'Content-Type' => 'application/json',
            ])->withOptions([
                'verify' => false,
            ])->get($url);


            if ($response->status() !== 200) {
              //  \Session::flash('message-danger',  $response->status());
                Log::error('Response for fetchAPI:' . $response->status());
                return ;
                //break;
            }
            $jsonData = $response->json();
            $jsonData = $jsonData ? $jsonData[$returnkey] : [];
            $data = array_merge($data, $jsonData);


            //if reached end of data, break
            if (count($jsonData) < $count) {
                break;
            }
        }

        return $data;
    }

  
}