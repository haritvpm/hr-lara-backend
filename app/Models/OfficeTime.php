<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OfficeTime extends Model
{
    use SoftDeletes, HasFactory;

    public $table = 'office_times';

    protected $dates = [
        'with_effect_from',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'groupname',
        'description',
        'fn_from',
        'fn_to',
        'an_from',
        'an_to',
        'with_effect_from',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
    public static function getOfficeTimes($date)
    {
        $office_times = OfficeTime::whereDate('with_effect_from', '<=', $date)->orderBy('with_effect_from', 'desc')->get();
        return $office_times;
    }
}
