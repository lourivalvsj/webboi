<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Freight extends Model
{
    protected $fillable = [
        'truck_driver_id', 'local_id', 'quantity_animals', 'value', 'departure_date', 'arrival_date'
    ];

    protected $casts = [
        'departure_date' => 'date',
        'arrival_date' => 'date',
        'value' => 'decimal:2',
        'quantity_animals' => 'integer'
    ];

    public function truckDriver()
    {
        return $this->belongsTo(TruckDriver::class);
    }

    public function local()
    {
        return $this->belongsTo(Local::class);
    }
}
