<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OperationalExpense extends Model
{
    protected $fillable = ['local_id', 'name', 'value', 'date', 'unit_of_measure', 'quantity'];

    public function local()
    {
        return $this->belongsTo(Local::class);
    }
}
