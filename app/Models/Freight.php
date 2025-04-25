<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Freight extends Model
{
    protected $fillable = [
        'truck_driver_id', 'local_id', 'quantity_animals', 'value', 'departure_date', 'arrival_date'
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
