<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feeding extends Model
{
    use HasFactory;

    protected $fillable = ['animal_id', 'feed_type', 'quantity', 'unit_of_measure', 'feeding_date'];

    protected $casts = [
        'feeding_date' => 'date',
        'quantity' => 'decimal:3'
    ];

    public function animal()
    {
        return $this->belongsTo(Animal::class);
    }
}
