<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\PunchingTraceResource;
use App\Models\PunchingTrace;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Punching;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

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

        $punchings = Punching::where('date', '>=', $start_date)
            ->where('date', '<=', $end_date)
            ->orderBy('date', 'desc')
            ->when($request->single_punches, function ($query) use ($request) {
                return $query->where('punching_count',1)
                ->where('date', '<', Carbon::today()->toDateString())
                ->where( 'leave_id',null)
                ->wherein('hint', '<>', ['casual_fn', 'casual_an'] );
            })
            ->when($request->unauthorized, function ($query) use ($request) {
                return $query->where('is_unauthorised',  1) ->where( 'leave_id',null)
                ->where( 'hint',null);
            })
            ->when($request->one_hour_exceeded, function ($query) use ($request) {
                return $query->where('grace_total_exceeded_one_hour', '>', 1);
            })
            ->get();

            return response()->json(
                $punchings, 200);

    }
}
