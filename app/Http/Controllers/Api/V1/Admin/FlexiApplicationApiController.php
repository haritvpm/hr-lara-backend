<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFlexiApplicationRequest;
use App\Http\Requests\UpdateFlexiApplicationRequest;
use App\Http\Resources\Admin\FlexiApplicationResource;
use App\Models\User;
use App\Models\FlexiApplication;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FlexiApplicationApiController extends Controller
{
    public function index()
    {
       // abort_if(Gate::denies('flexi_application_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        // return new FlexiApplicationResource(FlexiApplication::with(['employee'])->get());

        [$me, $seat_ids_of_loggedinuser, $status] = User::getLoggedInUserSeats();

        if ($status !== 'success') {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'User has no seats mapped'
                ],
                400
            );
        }


        $flexiApplications = FlexiApplication::with(['employee'])
        ->wherein('owner_seat', $seat_ids_of_loggedinuser)
        ->orderBy('created_at', 'desc')
        ->get();

        return new FlexiApplicationResource($flexiApplications);

    }

    public function store(StoreFlexiApplicationRequest $request)
    {
        $flexiApplication = FlexiApplication::create($request->all());

        return (new FlexiApplicationResource($flexiApplication))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(FlexiApplication $flexiApplication)
    {
        abort_if(Gate::denies('flexi_application_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new FlexiApplicationResource($flexiApplication->load(['employee']));
    }

    public function update(UpdateFlexiApplicationRequest $request, FlexiApplication $flexiApplication)
    {
        $flexiApplication->update($request->all());

        return (new FlexiApplicationResource($flexiApplication))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(FlexiApplication $flexiApplication)
    {
        abort_if(Gate::denies('flexi_application_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $flexiApplication->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
