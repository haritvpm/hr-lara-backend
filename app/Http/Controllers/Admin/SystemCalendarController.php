<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\GovtCalendar;

class SystemCalendarController extends Controller
{
    public $sources = [
        [
            'model'      => '\App\Models\GovtCalendar',
            'date_field' => 'date',
            'field'      => 'id',
            'prefix'     => '',
            'suffix'     => '',
            'route'      => 'admin.govt-calendars.edit',
        ],
    ];

    public function index(Request $request)
    {
        // dd($request->all());
        // $events = [];
        // foreach ($this->sources as $source) {
        //     foreach ($source['model']::all() as $model) {
        //         $crudFieldValue = $model->getAttributes()[$source['date_field']];

        //         if (! $crudFieldValue) {
        //             continue;
        //         }

        //         $events[] = [
        //             'title' => trim($source['prefix'] . ' ' . $model->{$source['field']} . ' ' . $source['suffix']),
        //             'start' => $crudFieldValue,
        //             'url'   => route($source['route'], $model->id),
        //         ];
        //     }
        // }



        // return view('admin.calendar.calendar', compact('events'));
        return view('admin.calendar.calendar');
    }

    public function indexajax(Request $request)
    {

        if($request->ajax()) {

            \Log::info('indexajax'.$request->start);
             $data = GovtCalendar::whereDate('date', '>=', $request->start)
                       ->whereDate('date',   '<=', $request->end)
                       ->get()->transform(function ($calenderday) {
                           return [
                               'id' => $calenderday->id,
                               'date' => $calenderday->date,
                               'title' => $calenderday->attendancetodaytrace_lastfetchtime ?
                                        Carbon::parse($calenderday->attendancetodaytrace_lastfetchtime)->format('H:i'):
                                           'Not Fetched Yet' ,
                               'start' => $calenderday->date,
                               'url'   => route('admin.govt-calendars.show', $calenderday->id),
                             //  'editlink' => route('admin.govt-calendars.edit', $calenderday->id),
                               'color' => $calenderday->govtholidaystatus ? 'red' : 'black',
                           ];
                       });

             return response()->json($data);
        }

        return view('admin.calendar.calendar');
    }

}
