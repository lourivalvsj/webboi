<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medication extends Model
{
    use HasFactory;

    protected $fillable = ['animal_id', 'medication_name', 'dose', 'unit_of_measure', 'administration_date'];

    protected $casts = [
        'dose' => 'decimal:3',
        'administration_date' => 'date',
    ];

    public function animal()
    {
        return $this->belongsTo(Animal::class);
    }
}
