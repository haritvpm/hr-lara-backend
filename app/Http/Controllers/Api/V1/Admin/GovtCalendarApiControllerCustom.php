<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateGovtCalendarRequest;
use App\Http\Resources\Admin\GovtCalendarResource;
use App\Models\GovtCalendar;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class GovtCalendarApiControllerCustom extends Controller
{
    public function getHolidays(Request $request)
    {
        $date = $request->date ? Carbon::createFromFormat('Y-m-d', $request->date) : Carbon::now()->startOfDay(); //today
        $date_start_str = $date->clone()->subMonths(6)->format('Y-m-d');
        $date_end_str = $date->clone()->addMonths(2)->format('Y-m-d');

        $holidays = GovtCalendar::
            where('date', '>=', $date_start_str)
            ->where('date', '<=', $date_end_str)
            ->where('govtholidaystatus', 1)
            ->orderby('date')
            ->get();

        return response()->json([
            $holidays
        ], 200);
    }
}
