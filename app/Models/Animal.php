<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Animal extends Model
{
    use HasFactory;

    protected $fillable = [
        'tag',
        'breed',
        'birth_date',
        'initial_weight'
    ];

    public function purchase()
    {
        return $this->hasOne(Purchase::class);
    }

    public function sale()
    {
        return $this->hasOne(Sale::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
