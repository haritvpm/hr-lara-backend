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
use Carbon\Carbon;
use App\Services\PunchingService;


class GovtCalendarController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('govt_calendar_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $govtCalendars = GovtCalendar::with(['session'])->get();

        return view('admin.govtCalendars.index', compact('govtCalendars'));
    }

    public function edit(GovtCalendar $govtCalendar)
    {
        abort_if(Gate::denies('govt_calendar_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sessions = AssemblySession::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $govtCalendar->load('session');

        return view('admin.govtCalendars.edit', compact('govtCalendar', 'sessions'));
    }

    public function update(UpdateGovtCalendarRequest $request, GovtCalendar $govtCalendar)
    {
        $govtCalendar->update($request->all());

        return redirect()->route('admin.govt-calendars.index');
    }

    public function show(GovtCalendar $govtCalendar)
    {
        abort_if(Gate::denies('govt_calendar_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $govtCalendar->load('session');

        return view('admin.govtCalendars.show', compact('govtCalendar'));
    }


    
    public function fetch(Request $request)
    {
        $date = $request->date;
        \Log::info("fetch attendance tr !. " .  $date);
     
        if(!$date) $date = Carbon::now()->format('Y-m-d'); //today

        \Log::info("fetch attendance trace !. " .  $date);
        $insertedcount = (new PunchingService())->fetchTrace($date);

        \Session::flash('message', 'Updated ' . $insertedcount . ' rows for' . $date ); 

        return redirect()->back();
    }

    public function fetchmonth(Request $request)
    {
       \Log::info("fetchmonth attendance trace !. " );
       // (new PunchingService())->fetchTodayTrace($reportdate);
       $today = today(); 
       $dates = []; 
       $punchingservice = new PunchingService();

       for($i=1; $i <= $today->daysInMonth; ++$i) 
       {
           $date = Carbon::createFromDate($today->year, $today->month, $i,0,0,0); 
           $date_string = $date->format('Y-m-d');

           $calender = $punchingservice->getGovtCalender($date_string);

           \Log::info("fetchmonth --".  $date->toString());
           
           if($date > now()) break;

           //\Log::info("call AebasFetchDay --".  $date_string);
         
           //AebasFetch::dispatch($date)->delay(now()->addMinutes($i));

           //dont forget to set queue driver in env
           //QUEUE_CONNECTION=database
 
          // $this->dispatch($job);
          //AebasFetchDay::dispatch($date)->delay(now()->addMinutes($i));
          //AebasFetchDay::dispatch($date_string);
          //(new PunchingService())->fetchTrace( $date);
         
       }

        return redirect()->back();
    }
}
