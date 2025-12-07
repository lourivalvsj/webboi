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
        'initial_weight',
        'category_id'
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];

    /**
     * Scope para animais disponíveis para venda
     */
    public function scopeAvailableForSale($query)
    {
        return $query->whereHas('purchase')
                    ->whereDoesntHave('sale');
    }
    
    /**
     * Scope para animais disponíveis para registros (pesagem, alimentação, medicação)
     * São animais com compra registrada que ainda não foram vendidos
     */
    public function scopeAvailableForRecords($query)
    {
        return $query->whereHas('purchase')
                    ->whereDoesntHave('sale');
    }

    /**
     * Scope para animais com compra registrada
     */
    public function scopeWithPurchase($query)
    {
        return $query->whereHas('purchase');
    }

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
    public function weights()
    {
        return $this->hasMany(AnimalWeight::class);
    }

    public function animalWeights()
    {
        return $this->hasMany(AnimalWeight::class);
    }

    public function feedings()
    {
        return $this->hasMany(Feeding::class);
    }

    public function medications()
    {
        return $this->hasMany(Medication::class);
    }

    /**
     * Verifica se o animal está disponível para venda
     * (tem compra registrada e ainda não foi vendido)
     */
    public function isAvailableForSale()
    {
        return $this->purchase && !$this->sale;
    }

    /**
     * Verifica se o animal já foi vendido
     */
    public function isSold()
    {
        return $this->sale !== null;
    }

    /**
     * Verifica se o animal tem compra registrada
     */
    public function hasPurchase()
    {
        return $this->purchase !== null;
    }
}
