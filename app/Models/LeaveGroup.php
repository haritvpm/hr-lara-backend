<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeaveGroup extends Model
{
    use SoftDeletes, HasFactory;

    public $table = 'leave_groups';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'groupname',
        'allowed_casual_per_year',
        'allowed_compen_per_year',
        'allowed_special_casual_per_year',
        'allowed_earned_per_year',
        'allowed_halfpay_per_year',
        'allowed_continuous_casual_and_compen',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
