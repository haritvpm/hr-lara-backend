<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Employee;
use App\Models\Role;
use App\Models\User;
use Gate;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UsersControllerCustom extends Controller
{
   
    public function resetpassword(Request $request)
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $user = User::find($request->id);
        $user->password = bcrypt($user->username);
        $user->save();
        \Session::flash('success', 'Password reset successfully to username');
        return redirect()->route('admin.users.index');
    }
      
}
