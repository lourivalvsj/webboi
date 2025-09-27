<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TruckDriver extends Model
{
    protected $fillable = [
        'name', 
        'cpf', 
        'cnh', 
        'phone', 
        'email', 
        'address',
        'city',
        'state',
        'zip_code',
        'truck_plate', 
        'truck_model', 
        'truck_year', 
        'truck_capacity',
        'truck_description',
        'observations'
    ];

    protected $casts = [
        'truck_year' => 'integer',
        'truck_capacity' => 'decimal:2'
    ];

    public function freights()
    {
        return $this->hasMany(Freight::class);
    }

    // Accessor para formatar CPF
    public function getFormattedCpfAttribute()
    {
        if ($this->cpf) {
            return preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "$1.$2.$3-$4", $this->cpf);
        }
        return null;
    }

    // Accessor para formatar telefone
    public function getFormattedPhoneAttribute()
    {
        if ($this->phone) {
            $phone = preg_replace('/\D/', '', $this->phone);
            if (strlen($phone) == 11) {
                return preg_replace("/(\d{2})(\d{5})(\d{4})/", "($1) $2-$3", $phone);
            } elseif (strlen($phone) == 10) {
                return preg_replace("/(\d{2})(\d{4})(\d{4})/", "($1) $2-$3", $phone);
            }
        }
        return $this->phone;
    }

    // Scope para busca
    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('cpf', 'like', "%{$search}%")
              ->orWhere('truck_plate', 'like', "%{$search}%")
              ->orWhere('truck_model', 'like', "%{$search}%");
        });
    }
}
