<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePunchingRequest;
use App\Http\Requests\UpdatePunchingRequest;
use App\Http\Resources\Admin\PunchingResource;
use App\Models\PunchingTrace;
use App\Models\Punching;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;
use App\Services\PunchingService;


class PunchingApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('punching_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PunchingResource(Punching::with(['employee', 'punchin_trace', 'punchout_trace', 'leave'])->get());
    }

    public function store(StorePunchingRequest $request)
    {
        $punching = Punching::create($request->all());

        return (new PunchingResource($punching))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Punching $punching)
    {
        abort_if(Gate::denies('punching_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PunchingResource($punching->load(['employee', 'punchin_trace', 'punchout_trace', 'leave']));
    }

    public function update(UpdatePunchingRequest $request, Punching $punching)
    {
        $punching->update($request->all());

        return (new PunchingResource($punching))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }
    public function getpunchings(Request $request)
    {
  
  
        //this has to be rewritten. we need to give emp data from Punchings which has to calculated after 
        //we call our api refresh.
        $date = $request->date ? Carbon::createFromFormat('Y-m-d', $request->date )
            : Carbon::now(); //today

        
        $data = (new PunchingService())->calculate($date);
        return response()->json([
            'status' => 'success',
            'punchings' => $data
            ]);

       //  \Log::info("got" . $request->date);
  /*
      $punchingstest = Punching::where('date', $date->format('Y-m-d'))->get();
      return response()->json([
        'status' => 'success',
        'punchings' => $punchingstest
        ]);

        */
    }
    
}
