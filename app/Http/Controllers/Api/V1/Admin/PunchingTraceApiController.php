<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\PunchingTraceResource;
use App\Models\PunchingTrace;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PunchingTraceApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('punching_trace_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PunchingTraceResource(PunchingTrace::with(['punching'])->get());
    }
}
