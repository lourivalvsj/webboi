<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupplyExpense extends Model
{
    protected $fillable = ['animal_id', 'name', 'description', 'purchase_date', 'value'];

    public function animal()
    {
        return $this->belongsTo(Animal::class);
    }
}
