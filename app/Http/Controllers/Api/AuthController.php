<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\ApiRequests\UpdatePasswordApiRequest;
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
        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 401);
        }

        $user =  Auth::guard('api')->user();
        return response()->json([
            'status' => 'success',
            'user' => $user,
            'access_token' => $token,
            'refresh_token' => $token,
            'type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 600

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
        if (!auth()->guard('api')->check()) {
            return response()->json([
                'status' => 'failed',


            ]);
        }


        $token =  Auth::guard('api')->refresh();
        return response()->json([
            'status' => 'success',
            //'user' => Auth::guard('api')->user(),
            'access_token' => $token,
            'refresh_token' => $token,
            'type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 600


        ]);
    }


    public function me(Request $request)
    {
        $user = User::with(['roles', 'roles.permissions', 'employee'])->find(Auth::id());

        $permList = collect();
        foreach ($user->roles as $role) {
            foreach ($role->permissions as $p) {
                $permList->add($p->title);
            }
        }

        return response()->json([
            'id' =>  $user->id,
            'username' => $user->username,
            'email' => $user->email,
            'avatar' => '',
            'roles' =>  $user->roles->pluck('title'),
            'permissions' => $permList->unique(),
            'aadhaarid' => $user?->employee?->aadhaarid ?? null,
        ]);
    }
    public function resetpassword(Request $request)
    {
        $user = User::find(Auth::id());

        $validator = Validator::make($request->all(), [
            'password' => 'required|string|min:9',
        ]);

        if($validator->fails()){
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
            'id' =>  $user->id,
            'username' => $user->username,
        ]);
    }
}
