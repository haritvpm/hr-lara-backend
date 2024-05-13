<?php

namespace App\Models;

use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GraceTime extends Model
{
    use HasFactory;

    public $table = 'grace_times';

    protected $dates = [
        'with_effect_from',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'title',
        'minutes',
        'with_effect_from',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function getWithEffectFromAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setWithEffectFromAttribute($value)
    {
        $this->attributes['with_effect_from'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public static function getGraceGroups($date)
    {
        $graces = GraceTime::whereDate('with_effect_from', '<=', $date)->orderBy('with_effect_from', 'desc')->get();
        return $graces;
    }

}
