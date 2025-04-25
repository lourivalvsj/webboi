<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TruckDriver extends Model
{
    protected $fillable = ['name', 'truck_description'];

    public function freights()
    {
        return $this->hasMany(Freight::class);
    }
}
