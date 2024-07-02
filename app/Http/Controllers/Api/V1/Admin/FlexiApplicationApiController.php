<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFlexiApplicationRequest;
use App\Http\Requests\UpdateFlexiApplicationRequest;
use App\Http\Resources\Admin\FlexiApplicationResource;
use App\Models\Employee;
use App\Models\User;
use App\Models\FlexiApplication;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Services\EmployeeService;
use Carbon\Carbon;

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

    public function store(Request $request)
    {
        \Log::info($request->all());
        [$me, $seat_ids_of_loggedinuser, $status] = User::getLoggedInUserSeats();

        $id = $request->id;
        //do this in a transaction, so user cannot delete it while we are approving it

        //if under has not appproved the application before the witheffect date, make witheffect date the next day of approval

        $message = null;
        $status = 'success';

        \DB::transaction( function() use ($id, $seat_ids_of_loggedinuser, $me, &$message, &$status){
            $flexi_application = FlexiApplication::with('employee')->find($id);

            if(!$flexi_application){
                $status = 'failed';
                $message = 'Application not found';
                return ;
            }
            if( $seat_ids_of_loggedinuser->contains($flexi_application->owner_seat) == false){
                $status = 'failed';
                $message = 'Application not with user';
                return ;
            }
            //also make sure it has not been approved during delete
            if($flexi_application->approved_on){
                $status = 'failed';
                $message = 'Application already approved';
                return ;
            }

            $c_wef = Carbon::parse($flexi_application->with_effect_from);
            $c_now = Carbon::today();

            if($c_wef->lte($c_now)){
                //employee expected date has passed, so we need to update the with effect date to the next day
                //$c_wef = $c_now->addDay();
              //  $status = 'failed';
              //  $message = 'WithEffect date has passed';
               // return ;
            }


            //also update the flexi minutes of the employee

            $res = EmployeeService::createOrUpdateFlexi(
                $flexi_application->employee->id,
                $flexi_application->flexi_minutes,
                $c_wef->format('Y-m-d')

                );
              //  \Log::info($res);
             //   \Log::info($res->content());
            $resData = json_decode($res->content(), true);
           // \Log::info('Flexi update response');
          //  \Log::info($resData);

            if($resData['status'] == 'failed'){
                $status = 'failed';
                $message = $resData['message'];
                return ;
            }

            $flexi_application->update([
                'approved_on' => now(),
                'approved_by' => $me->employee->aadhaarid . ',' . $me->employee->name,

            ]);


        });

        return response()->json(['status' => $status, 'message' => $message],  $status == 'success' ? 200 : 400);
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
