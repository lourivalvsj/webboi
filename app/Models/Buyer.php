<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buyer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'cpf_cnpj',
        'address',
        'phone',
        'state_registration'
    ];

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
}
