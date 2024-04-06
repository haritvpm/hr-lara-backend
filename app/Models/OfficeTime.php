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
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'description',
        'office_id',
        'full_from',
        'full_to',
        'office_hours',
        'fn_from',
        'fn_to',
        'an_from',
        'an_to',
        'flexi_from',
        'flexi_to',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function office()
    {
        return $this->belongsTo(AdministrativeOffice::class, 'office_id');
    }
}