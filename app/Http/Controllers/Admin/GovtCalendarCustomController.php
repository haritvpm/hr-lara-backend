<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateGovtCalendarRequest;
use App\Models\AssemblySession;
use App\Models\GovtCalendar;

use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Jobs\AebasFetchDay;
use App\Services\PunchingCalcService;
use Carbon\Carbon;
use App\Services\PunchingTraceFetchService;

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
        $date = $request->date;
        \Log::info("calculate attendance tr !. " .  $date);

        if(!$date) $date = Carbon::now()->format('Y-m-d'); //today

        //dont do anything if $date is today
        $c_today = Carbon::now()->format('Y-m-d');
        if ($date == $c_today) {
            \Session::flash('message', 'Today attendance is not calculated' );

            return redirect()->back();
        }


        \Log::info("calculate attendance !. " .  $date);
        (new PunchingCalcService())->calculate($date);

        return redirect()->back();
    }


    public function fetchmonth(Request $request)
    {
       \Log::info("fetchmonth attendance trace !. " );
       // (new PunchingTraceFetchService())->fetchTodayTrace($reportdate);
       $today = today();
       $dates = [];
      // $punchingservice = new PunchingTraceFetchService();

       for($i=1; $i <= $today->daysInMonth; ++$i)
       {
           $date = Carbon::createFromDate($today->year, $today->month, $i,0,0,0);
           $date_string = $date->format('Y-m-d');

           $calender = GovtCalendar::getGovtCalender($date_string);

           \Log::info("fetchmonth --".  $date->toString());

           if($date > now()) break;

           //\Log::info("call AebasFetchDay --".  $date_string);

           //AebasFetch::dispatch($date)->delay(now()->addMinutes($i));

           //dont forget to set queue driver in env
           //QUEUE_CONNECTION=database

          // $this->dispatch($job);
          //AebasFetchDay::dispatch($date)->delay(now()->addMinutes($i));
          //AebasFetchDay::dispatch($date_string);
          //(new PunchingTraceFetchService())->fetchTrace( $date);

       }

        return redirect()->back();
    }
}
