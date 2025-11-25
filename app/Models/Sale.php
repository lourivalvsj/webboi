<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'animal_id',
        'buyer_id',
        'sale_date',
        'value',
        'weight_at_sale'
    ];

    protected $casts = [
        'sale_date' => 'date',
        'value' => 'decimal:2',
        'weight_at_sale' => 'decimal:2'
    ];

    public function animal()
    {
        return $this->belongsTo(Animal::class);
    }

    public function buyer()
    {
        return $this->belongsTo(Buyer::class);
    }
}
