<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\PunchingTraceResource;
use App\Models\EmployeeToSection;
use App\Models\PunchingTrace;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Punching;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Models\GovtCalendar;

class PunchingApiSearchController extends Controller
{
    public function search( Request $request )
    {

        Log::info($request->all()    );
    //     aadhaarid : new FormControl<string>(''),
    // single_punches : new FormControl<boolean>(false),
    // one_hour_exceeded : new FormControl<boolean>(false),
    // grace_exceeded : new FormControl<boolean>(false),
    // unauthorized : new FormControl<boolean>(false),
        $start_date = Carbon::parse($request->range['start'])->format('Y-m-d');
        $end_date = Carbon::parse($request->range['end'])->format('Y-m-d');

        $holidays = GovtCalendar::where('govtholidaystatus', 1)
            ->where('date', '>=', $start_date)
            ->where('date', '<=', $end_date)
            ->pluck('date')->toArray();


        $punchings = Punching::where('date', '>=', $start_date)
            ->where('date', '<=', $end_date)
            ->whereNotIn('date', $holidays)
            //->wherenotnull('section')
            ->orderBy('date', 'desc')
            ->when($request->single_punches, function ($query) use ($request) {
                return $query->where('punching_count',1)
                ->where('date', '<', Carbon::today()->toDateString())
                ->where( 'leave_id',null)
                ->where ( fn($q) => $q->where('hint',null)
                        ->orWhere( fn($q) => $q->where('hint', '<>' ,'casual_fn' )->Where('hint', '<>' ,'casual_an' ))
                );
            })
            ->when($request->unauthorized, function ($query) use ($request) {
                return $query->where('is_unauthorised',  1) ->where( 'leave_id',null)
                ->where( 'hint',null);
            })
            ->when($request->one_hour_exceeded, function ($query) use ($request) {
                return $query->where('grace_total_exceeded_one_hour', '>', 1)
                ->where ( fn($q) => $q->where('hint',null)
                ->orWhere( fn($q) => $q->where('hint', '<>' ,'casual_fn' )->Where('hint', '<>' ,'casual_an' ))
                );
            })
            ->when($request->category && $request->category != 'all', function ($query) use ($request) {
                return $query->where('time_group', $request->category);
            })
            ->orderBy( 'date', 'desc')
            ->get()->groupBy('aadhaarid')->sortByDesc( function($punchings) {
                return $punchings->count();
            });

            $data = [];
            $i = 1;
            foreach ($punchings as $key => $value) {

              //  $section = EmployeeToSection::onDate($end_date)->where('aadhaarid', $key)->first();

                $data[] = [
                    'aadhaarid' => $key . ' - ' . $value[0]->employee->name . ', ' . $value[0]->designation . ' (' . $value->count() . ')',
                    'children' => $value,
                    'index' => $i,
                ];

                $i++;

            }

            return response()->json(
                $data, 200);

    }
}
