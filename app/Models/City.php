<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'uf_id',
        'latitude',
        'longitude'
    ];

    public function uf()
    {
        return $this->belongsTo(Uf::class);
    }
}