<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feeding extends Model
{
    use HasFactory;

    protected $fillable = ['animal_id', 'feed_type', 'quantity', 'feeding_date'];

    public function animal()
    {
        return $this->belongsTo(Animal::class);
    }
}
