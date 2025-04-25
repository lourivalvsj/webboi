<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnimalWeight extends Model
{
    use HasFactory;

    protected $fillable = [
        'animal_id',
        'weight',
        'recorded_at',
    ];

    public function animal()
    {
        return $this->belongsTo(Animal::class);
    }
}
