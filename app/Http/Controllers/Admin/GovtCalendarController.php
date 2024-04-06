<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateGovtCalendarRequest;
use App\Models\AssemblySession;
use App\Models\GovtCalendar;
use App\Models\Session;
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

        $sessions = Session::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

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
        $date = $request->query('date');
     
        if(!$date) $date = Carbon::now()->format('Y-m-d'); //today

        \Log::info("fetch attendance trace !. " .  $date);
        $insertedcount = (new PunchingService())->fetchTrace($date);

        \Session::flash('message', 'Updated ' . $insertedcount . ' rows for' . $date ); 

        return redirect()->back();
    }

    public function fetchmonth(Request $request)
    {
        $date = date;

       \Log::info("fetchmonth attendance trace !. " );
       

        return redirect()->back();
    }
}
