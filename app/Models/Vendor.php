<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'cpf_cnpj',
        'address',
        'uf',
        'city',
        'email',
        'phone',
        'state_registration'
    ];

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }
}
