<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = ['name', 'uf_id', 'latitude', 'longitude'];

    public function uf()
    {
        return $this->belongsTo(Uf::class);
    }
}
