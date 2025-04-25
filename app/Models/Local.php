<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Local extends Model
{
    protected $fillable = ['name', 'entry_date', 'exit_date'];

    public function freights()
    {
        return $this->hasMany(Freight::class);
    }

    public function operationalExpenses()
    {
        return $this->hasMany(OperationalExpense::class);
    }
}
