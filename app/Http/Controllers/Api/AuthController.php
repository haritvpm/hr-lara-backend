<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Role;
use App\Models\Seat;
use App\Models\User;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register', 'logout']]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);
        $credentials = $request->only('username', 'password');

        $token = Auth::guard('api')->attempt($credentials);
        if (! $token) {

            //see if username exists
            $user = User::where('username', $request->username)->first();

            return response()->json([
                'status' => 'error',
                'message' =>   $user ? 'Invalid password' : 'User not found',
                "errors"=>
                     !$user ? ["username" => ["User not found"]]  :  ["password"=> ["Invalid password"]],


            ], 401);
        }

        $user = Auth::guard('api')->user();

        return response()->json([
            'status' => 'success',
            'user' => $user,
            'access_token' => $token,
            'refresh_token' => $token,
            'type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,

        ]);

        // return response()->json([
        //     'status' => 'success',
        //     'user' => $user,
        //     'authorisation' => [
        //         'access_token' => $token,
        //         'type' => 'bearer',
        //        // 'expires_in' => auth()->factory()->getTTL() * 60

        //     ]
        // ]);

    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pen' => 'required|string|max:255|min:6',
            'aadhaarid' => 'required|string|max:255|min:8',
            'username' => 'required|string|min:6|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            $response['response'] = $validator->messages();

            return response()->json([
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $request->merge(['username' => trim($request->username)]);
        $request->merge(['pen' => strtoupper(trim($request->pen))]);
        $request->merge(['aadhaarid' => trim($request->aadhaarid)]);

        //check if employee exists

        $employee = Employee::where('aadhaarid', $request->aadhaarid)->first();
        if (! $employee) {
            return response()->json([
                'status' => 'error',
                'message' => 'Employee with AttendanceId not found',
                "errors"=>
                     ["aadhaarid" => ["invalid AttendanceId"]],

            ], 422);
        }
        //make sure username does not exist

        $user = User::where('username', $request->username)->first();
        if ($user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User already exists',
                "errors"=>
                     ["username" => ["username already exists"]],

            ], 422);
        }

        //make sure user with this employee id does not exist
        $user = User::where('employee_id', $employee->id)->first();
        if ($user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User already exists with this employee id',
                "errors"=>
                     ["username" => ["Username {$user->username} exists for this employee "]],

            ], 422);
        }

        $user = User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'employee_id' => $employee->id,
        ]);

        $employee->update(['pen' => $request->pen]);

        //$employee->save();

        //assign 'employee' role to this user
        $role = Role::where('title', 'employee')->first();
        $user->roles()->attach($role->id);

        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully',
            'user' => $user,
        ]);

      /*  $token = Auth::login($user);

        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully',
            'user' => $user,
            'access_token' => $token,
            'refresh_token' => $token,
            'type' => 'bearer',

        ]);*/
    }

    public function logout()
    {
        Auth::logout();

        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }

    public function refresh()
    {
        \Log::info('in refres');
        if (! auth()->guard('api')->check()) {
            return response()->json([
                'status' => 'failed',

            ]);
        }

        $token = Auth::guard('api')->refresh();

        return response()->json([
            'status' => 'success',
            //'user' => Auth::guard('api')->user(),
            'access_token' => $token,
            'refresh_token' => $token,
            'type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,

        ]);
    }

    public function me(Request $request)
    {
        $user = User::with(['roles', 'roles.permissions', 'employee'])->find(Auth::id());

        $permList = collect();
        $allroles = $user->roles;
        foreach ($user->roles as $role) {
            foreach ($role->permissions as $p) {
                $permList->add($p->title);
            }
        }
        //get roles of this user's seat
        [$me, $seat_ids_of_loggedinuser, $status] = User::getLoggedInUserSeats();
        if ($seat_ids_of_loggedinuser && count($seat_ids_of_loggedinuser)) {

            $roles = Seat::whereIn('id', $seat_ids_of_loggedinuser)->with('roles', 'roles.permissions')->get()->pluck('roles')->flatten();
            $allroles = $allroles->merge($roles);
            foreach ($roles as $role) {
                foreach ($role->permissions as $p) {
                    $permList->add($p->title);
                    //\Log::info('seat p: ' . $p->title);

                }
            }
        }

        return response()->json([
            'id' => $user->id,
            'username' => $user->username,
             'name' => $user->employee?->name ?? null,
            // 'avatar' => '',
            'roles' => $allroles->pluck('title')->unique(),
            'permissions' => $permList->unique(),
            'aadhaarid' => $user?->employee?->aadhaarid ?? null,
        ]);
    }

    public function resetpassword(Request $request)
    {
        $user = User::find(Auth::id());

        $validator = Validator::make($request->all(), [
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            $response['response'] = $validator->messages();

            return response()->json([
                'message' => $validator->errors()->first(),
            ], 400);

        }

        $user->update(
            [
                'password' => Hash::make($request->password),
            ]
        );

        return response()->json([
            'id' => $user->id,
            'username' => $user->username,
        ]);
    }

    public function profile(Request $request)
    {
        $user = User::with(['employee', 'employee.employeeExtra'])->find(Auth::id());

        return response()->json([
            'id' => $user->id,
            'username' => $user->username,
            'email' => $user?->employee?->employeeExtra?->email ?? null,
            'avatar' => '',
            'aadhaarid' => $user?->employee?->aadhaarid ?? null,
            'pen' => $user?->employee?->pen ?? null,
            'srismt' => $user?->employee?->srismt ?? null,
            'name_mal' => $user?->employee?->name_mal ?? null,
            'name' => $user?->employee?->name ?? null,
            'mobile' => $user?->employee?->employeeExtra?->mobile ?? null,
            'pan' => $user?->employee?->employeeExtra?->pan ?? null,
            'klaid' => $user?->employee?->employeeExtra?->klaid ?? null,
            'dateOfJoinInKLA' => $user?->employee?->employeeExtra?->date_of_joining_kla ?? null,
            'electionid' => $user?->employee?->employeeExtra?->electionid ?? null,
            'dob' => $user?->employee?->employeeExtra?->dob ?? null,
            'dateOfEntryInService' => $user?->employee?->employeeExtra?->date_of_entry_in_service ?? null,
            'dateOfCommencementOfContinousService' => $user?->employee?->employeeExtra?->date_of_commencement_of_continous_service ?? null,
            'address' => $user?->employee?->employeeExtra?->address ?? null,
        ]);
    }

    public function saveprofile(Request $request)
    {
        $user = User::with(['employee', 'employee.employeeExtra'])->find(Auth::id());

        $dob = $request->dob ? Carbon::parse($request->dob)->format('Y-m-d') : null;
        $dateOfJoinInKLA = $request->dateOfJoinInKLA ? Carbon::parse($request->dateOfJoinInKLA)->format('Y-m-d') : null;
        $dateOfEntryInService = $request->dateOfEntryInService ? Carbon::parse($request->dateOfEntryInService)->format('Y-m-d') : null;
        $dateOfCommencementOfContinousService = $request->dateOfCommencementOfContinousService ? Carbon::parse($request->dateOfCommencementOfContinousService)->format('Y-m-d') : null;

        \Log::info('in save profile', $request->all());
        $validator = Validator::make($request->all(), [

            'email' =>  [Rule::unique('employee_extras')->ignore($user->employee?->employeeExtra?->id),],
            'pan' => [Rule::unique('employee_extras')->ignore($user->employee?->employeeExtra?->id),],
            'klaid' => [Rule::unique('employee_extras')->ignore($user->employee?->employeeExtra?->id),],
            'electionid' => [Rule::unique('employee_extras')->ignore($user->employee?->employeeExtra?->id),],
            'mobile' => [Rule::unique('employee_extras')->ignore($user->employee?->employeeExtra?->id),],
        ]);

        if ($validator->fails()) {
            $response['response'] = $validator->messages();

            return response()->json([
                'message' => $validator->errors()->first(),
            ], 400);
        }
        $user->employee->update(
            [
                'name_mal' => $request->name_mal,
                'srismt' => $request->srismt,
            ]
        );
        $values = [
            'email' => $request->email,
            'mobile' => $request->mobile,
            'date_of_joining_kla' => $dateOfJoinInKLA,
            'pan' => $request->pan,
            'klaid' => $request->klaid,
            'electionid' => $request->electionid ?? null,
            'dob' => $dob,
            'date_of_entry_in_service' => $dateOfEntryInService,
            'date_of_commencement_of_continous_service' => $dateOfCommencementOfContinousService,
            'address'   => $request->address,

        ];
        if($user->employee->employeeExtra){
            $user->employee->employeeExtra->update($values);
        } else {
            $user->employee->employeeExtra()->create($values);
        }


        return response()->json([
            'id' => $user->id,
            'username' => $user->username,
        ]);
    }
}
