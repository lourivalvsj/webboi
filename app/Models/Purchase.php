<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'animal_id',
        'vendor_id',
        'purchase_date',
        'value',
        'freight_cost',
        'transporter',
        'commission_value',
        'commission_percent'
    ];

    protected $casts = [
        'purchase_date' => 'date',
        'value' => 'decimal:2',
        'freight_cost' => 'decimal:2',
        'commission_value' => 'decimal:2',
        'commission_percent' => 'decimal:2'
    ];

    public function animal()
    {
        return $this->belongsTo(Animal::class);
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}
