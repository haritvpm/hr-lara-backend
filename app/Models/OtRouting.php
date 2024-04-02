<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtRouting extends Model
{
    use HasFactory;

    public $table = 'ot_routings';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'seat_id',
        'last_forwarded_to',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function seat()
    {
        return $this->belongsTo(Seat::class, 'seat_id');
    }

    public function routing_seats()
    {
        return $this->belongsToMany(Seat::class);
    }
}
