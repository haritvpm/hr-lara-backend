<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Seat;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
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
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized login',
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
        $request->validate([
            //  'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            // 'name' => $request->name,
            'username' => $request->name,
            'password' => Hash::make($request->password),
        ]);

        $token = Auth::login($user);

        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully',
            'user' => $user,
            'access_token' => $token,
            'refresh_token' => $token,
            'type' => 'bearer',

        ]);
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
            // 'email' => $user->email,
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
            'srismt' => $user?->employee?->srismt ?? null,
            'name_mal' => $user?->employee?->name_mal ?? null,
            'name' => $user?->employee?->name ?? null,
            'mobile' => $user?->employee?->employeeExtra?->mobile ?? null,
            'pan' => $user?->employee?->employeeExtra?->pan ?? null,
            'klaid' => $user?->employee?->employeeExtra?->klaid ?? null,
            'dateOfJoinInKLA' => $user?->employee?->employeeExtra?->date_of_joining_kla ?? null,
        ]);
    }

    public function saveprofile(Request $request)
    {
        $user = User::with(['employee', 'employee.employeeExtra'])->find(Auth::id());

        $dateOfJoinInKLA = $request->dateOfJoinInKLA ? Carbon::parse($request->dateOfJoinInKLA)->format('Y-m-d') : null;

        \Log::info('in save profile', $request->all());
        $validator = Validator::make($request->all(), [
           // 'email' => 'email'|'unique:employee_extras,email,' . $user->employee?->employeeExtra?->id,
            'mobile' => 'required|numeric|digits:10',
            'dateOfJoinInKLA' => 'date',
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
