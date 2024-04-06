<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Td extends Model
{
    use HasFactory;

    public $table = 'tds';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'pan',
        'pen',
        'name',
        'gross',
        'tds',
        'slno',
        'date_id',
        'created_by_id',
        'remarks',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function date()
    {
        return $this->belongsTo(TaxEntry::class, 'date_id');
    }

    public function created_by()
    {
        return $this->belongsTo(Seat::class, 'created_by_id');
    }
}
