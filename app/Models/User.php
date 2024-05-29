<?php

namespace App\Models;

use Carbon\Carbon;
use DateTimeInterface;
use Hash;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable, HasFactory;

    public $table = 'users';

    protected $hidden = [
        'remember_token',
        'password',
    ];

    protected $dates = [
        'email_verified_at',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'username',
        'email',
        'mobile',
        'email_verified_at',
        'password',
        'remember_token',
        'employee_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function getIsAdminAttribute()
    {
        return $this->roles()->where('id', 1)->exists();
    }

    public function getEmailVerifiedAtAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

    public function setEmailVerifiedAtAttribute($value)
    {
        $this->attributes['email_verified_at'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }

    public function setPasswordAttribute($input)
    {
        if ($input) {
            $this->attributes['password'] = app('hash')->needsRehash($input) ? Hash::make($input) : $input;
        }
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    public function canDo($permission)
    {
        \Log::info('canDo' . $permission);


        $e =  $this->roles()->whereHas('permissions', function ($query) use ($permission) {
            $query->where('title', $permission);
        })->exists();

        \Log::info('canDo' . $permission . ' ' . $e);
        return $e;
    }
    public function canDoAny($permission)
    {
       $e =$this->roles()->whereHas('permissions', function ($query) use ($permission) {
            $query->whereIn('title', $permission);
        })->exists();

        \Log::info('canDoAny' . implode($permission) . ' ' . $e);
        return $e;
    }
    public function hasRole($role)
    {
        return $this->roles()->where('title', $role)->exists();
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public static function getLoggedInUserSeats()
    {
         //get current logged in user's charges
         $me = User::with('employee', 'leave_group')->find(auth()->id());

         if ($me->employee_id == null) {
            $status = 'No linked employee';
            return [  $me , null,  $status];

         }

        $seat_ids_of_loggedinuser = EmployeeToSeat::where('employee_id', $me->employee_id)->get()->pluck('seat_id');

        if (!$seat_ids_of_loggedinuser || ($seat_ids_of_loggedinuser && count($seat_ids_of_loggedinuser) == 0)) {
           // $status = 'No seats in charge';
            //return [   $me , null,  $status];
        }
        $status = 'success';

        return [  $me , $seat_ids_of_loggedinuser, $status];
    }
}
