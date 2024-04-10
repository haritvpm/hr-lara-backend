<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\OvertimeSittingResource;
use App\Models\OvertimeSitting;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OvertimeSittingApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('overtime_sitting_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new OvertimeSittingResource(OvertimeSitting::with(['overtime'])->get());
    }
}
