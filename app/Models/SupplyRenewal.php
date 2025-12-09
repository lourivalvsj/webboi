<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplyRenewal extends Model
{
    use HasFactory;

    protected $fillable = [
        'supply_expense_id',
        'previous_quantity',
        'added_quantity', 
        'new_total_quantity',
        'previous_value',
        'new_value',
        'renewal_cost',
        'renewal_date',
        'notes'
    ];

    protected $casts = [
        'renewal_date' => 'date',
        'previous_quantity' => 'decimal:3',
        'added_quantity' => 'decimal:3',
        'new_total_quantity' => 'decimal:3',
        'previous_value' => 'decimal:2',
        'new_value' => 'decimal:2',
        'renewal_cost' => 'decimal:2'
    ];

    public function supplyExpense()
    {
        return $this->belongsTo(SupplyExpense::class);
    }
}
