<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Acquittance extends Model
{
    use SoftDeletes, HasFactory;

    public $table = 'acquittances';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'title',
        'office_id',
        'ddo_id',
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

    public function ddo()
    {
        return $this->belongsTo(Ddo::class, 'ddo_id');
    }
}
