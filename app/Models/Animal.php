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
        'gender',
        'is_breeder',
        'is_dead',
        'death_date',
        'death_location',
        'death_cause',
        'death_observations',
        'birth_date',
        'initial_weight',
        'category_id'
    ];

    protected $casts = [
        'birth_date' => 'date',
        'death_date' => 'date',
        'is_breeder' => 'boolean',
        'is_dead' => 'boolean',
    ];

    /**
     * Scope para animais disponíveis para venda
     */
    public function scopeAvailableForSale($query)
    {
        return $query->whereHas('purchase')
                    ->whereDoesntHave('sale')
                    ->where('is_dead', false);
    }
    
    /**
     * Scope para animais disponíveis para registros (pesagem, alimentação, medicação)
     * São animais com compra registrada que ainda não foram vendidos e estão vivos
     */
    public function scopeAvailableForRecords($query)
    {
        return $query->whereHas('purchase')
                    ->whereDoesntHave('sale')
                    ->where('is_dead', false);
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

    public function supplyExpenses()
    {
        return $this->hasMany(SupplyExpense::class);
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

    /**
     * Verifica se é macho reprodutor
     */
    public function isMaleBreeder()
    {
        return $this->gender === 'macho' && $this->is_breeder === true;
    }

    /**
     * Verifica se é fêmea reprodutora (matriz)
     */
    public function isFemaleBreeder()
    {
        return $this->gender === 'femea' && $this->is_breeder === true;
    }

    /**
     * Retorna descrição do tipo reprodutivo
     */
    public function getReproductiveTypeAttribute()
    {
        if (!$this->is_breeder) {
            return $this->gender === 'macho' ? 'Macho' : 'Fêmea';
        }
        
        return $this->gender === 'macho' ? 'Reprodutor' : 'Matriz';
    }

    /**
     * Scope para buscar reprodutores machos
     */
    public function scopeMaleBreeders($query)
    {
        return $query->where('gender', 'macho')->where('is_breeder', true);
    }

    /**
     * Scope para buscar matrizes (fêmeas reprodutoras)
     */
    public function scopeFemaleBreeders($query)
    {
        return $query->where('gender', 'femea')->where('is_breeder', true);
    }

    /**
     * Verifica se o animal morreu
     */
    public function isDead()
    {
        return $this->is_dead === true;
    }

    /**
     * Scope para animais vivos
     */
    public function scopeAlive($query)
    {
        return $query->where('is_dead', false);
    }

    /**
     * Scope para animais mortos
     */
    public function scopeDead($query)
    {
        return $query->where('is_dead', true);
    }

    /**
     * Registra o óbito do animal
     */
    public function registerDeath($deathData)
    {
        $this->update([
            'is_dead' => true,
            'death_date' => $deathData['death_date'],
            'death_location' => $deathData['death_location'],
            'death_cause' => $deathData['death_cause'],
            'death_observations' => $deathData['death_observations'] ?? null,
        ]);
    }

    /**
     * Retorna status de vida do animal
     */
    public function getLifeStatusAttribute()
    {
        return $this->is_dead ? 'Morto' : 'Vivo';
    }
}
