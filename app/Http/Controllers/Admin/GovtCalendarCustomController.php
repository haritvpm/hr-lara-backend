<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateGovtCalendarRequest;
use App\Models\AssemblySession;
use App\Models\GovtCalendar;

use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Jobs\AebasFetchDayJob;
use App\Services\PunchingCalcService;
use Carbon\Carbon;
use App\Services\PunchingTraceFetchService;
use App\Services\LeaveFetchService;
use App\Services\AebasFetchService;
use Carbon\CarbonPeriod;

class GovtCalendarCustomController extends Controller
{
    public function fetch(Request $request)
    {
        $date = $request->date;
        \Log::info("fetch attendance tr !. " .  $date);

        if(!$date) $date = Carbon::now()->format('Y-m-d'); //today

        \Log::info("fetch attendance trace !. " .  $date);
        $insertedcount = (new PunchingTraceFetchService())->fetchTrace($date);

        \Session::flash('message', 'Updated ' . $insertedcount . ' rows for' . $date );

        return redirect()->back();
    }
    public function calculate(Request $request)
    {
        $date_str = $request->date;
        \Log::info("calculate attendance tr !. " .  $date_str);


        if(!$date_str) $date_str = Carbon::today()->format('Y-m-d'); //today

        $date = Carbon::parse($date_str);
        $date->setTime(0,0,0);


        //dont do anything if $date is today
        $c_today = Carbon::today();
        $c_today->setTime(0,0,0);



        if ($date->greaterThan($c_today)) {
            \Session::flash('message', 'Tomorrow attendance is not calculated' );

            return redirect()->back();
        }


        \Log::info("calculate attendance !. " .  $date_str);
        (new PunchingCalcService())->calculate($date_str);

        return redirect()->back();
    }
    public function opendate(Request $request)
    {
        $date_string = $request->date;
        $calender = GovtCalendar::getGovtCalender($date_string);
        return redirect()->route('admin.govt-calendars.show', [$calender->id]);

    }

    public function fetchmonth(Request $request)
    {
       \Log::info("fetchmonth attendance trace !. " );
       // (new PunchingTraceFetchService())->fetchTodayTrace($reportdate);
       //get last day of GovtCalendar
       $from = GovtCalendar::orderBy('date', 'desc')->first();

       if(!$from) $from = Carbon::parse('2024-01-01');
       else $from = Carbon::parse($from->date);
       $today = Carbon::now()->endOfMonth();
       $today->setTime(0,0,0);
        \Log::info("fetchmonth --".  $from->toString() . " to " . $today->toString());

        $dates = CarbonPeriod::create($from, $today);

        foreach ($dates as $date) {
           $date_string = $date->format('Y-m-d');

           $calender = GovtCalendar::getGovtCalender($date_string);

           \Log::info("fetchmonth --".  $date->toString());

          // if($date > now()) break;

           //\Log::info("call AebasFetchDayJob --".  $date_string);

           //AebasFetch::dispatch($date)->delay(now()->addMinutes($i));

           //dont forget to set queue driver in env
           //QUEUE_CONNECTION=database

          // $this->dispatch($job);
          //AebasFetchDayJob::dispatch($date)->delay(now()->addMinutes($i));
          //AebasFetchDayJob::dispatch($date_string);
          //(new PunchingTraceFetchService())->fetchTrace( $date);

       }

        return redirect()->back();
    }
    public function fetchleaves(Request $request)
    {
        $date = $request->date;
        \Log::info("fetch leave tr !. " .  $date);

        if(!$date) $date = Carbon::now()->format('Y-m-d'); //today

        \Log::info("fetch attendance trace !. " .  $date);
        $insertedcount = (new LeaveFetchService())->fetchLeave($date);

        \Session::flash('message', 'Fetched Leaves ' . $insertedcount . ' rows for' . $date );

        return redirect()->back();
    }

    public function downloadleaves(Request $request)
    {
        $date = $request->date;
        $list =  (new AebasFetchService())->fetchApi(11, 0, $date );

           $callback = function() use ($list)
            {
                $FH = fopen('php://output', 'w');
                foreach ($list as $row) {
                    fputcsv($FH, $row);
                }
                fclose($FH);
            };
            $headers = [
                'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0'
            ,   'Content-type'        => 'text/csv'
            ,   'Content-Disposition' => 'attachment; filename=leave_for' . $date . '.csv'
            ,   'Expires'             => '0'
            ,   'Pragma'              => 'public'
            ];
            return response()->stream($callback, 200, $headers);
    }
}
