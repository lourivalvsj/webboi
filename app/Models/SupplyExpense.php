<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupplyExpense extends Model
{
    protected $fillable = ['animal_id', 'name', 'category', 'description', 'purchase_date', 'value', 'unit_of_measure', 'quantity'];

    protected $casts = [
        'purchase_date' => 'date',
        'value' => 'decimal:2',
        'quantity' => 'decimal:3'
    ];

    const CATEGORY_MEDICAMENTO = 'medicamento';
    const CATEGORY_ALIMENTACAO = 'alimentacao';

    public static function getCategories()
    {
        return [
            self::CATEGORY_MEDICAMENTO => 'Medicamento',
            self::CATEGORY_ALIMENTACAO => 'Alimentação',
        ];
    }

    public function getCategoryLabelAttribute()
    {
        $categories = self::getCategories();
        return $categories[$this->category] ?? $this->category;
    }

    public function animal()
    {
        return $this->belongsTo(Animal::class);
    }

    public function renewals()
    {
        return $this->hasMany(SupplyRenewal::class);
    }

    /**
     * Calcula a quantidade restante do insumo após uso em medicações e alimentações
     */
    public function getRemainingQuantityAttribute()
    {
        if (!$this->quantity || $this->quantity <= 0) {
            return 0;
        }

        $totalUsed = 0;

        // Calcular quantidade usada em medicações (quando o nome do medicamento coincide)
        if ($this->category === self::CATEGORY_MEDICAMENTO) {
            $totalUsed += Medication::where('medication_name', $this->name)
                ->sum('dose');
        }

        // Calcular quantidade usada em alimentações (quando o tipo de ração coincide)
        if ($this->category === self::CATEGORY_ALIMENTACAO) {
            $totalUsed += Feeding::where('feed_type', $this->name)
                ->sum('quantity');
        }

        $remaining = $this->quantity - $totalUsed;
        return max(0, $remaining); // Não permite valores negativos
    }

    /**
     * Verifica se o estoque está baixo (menos de 10% restante)
     */
    public function getIsLowStockAttribute()
    {
        if (!$this->quantity || $this->quantity <= 0) {
            return false;
        }
        
        return $this->remaining_quantity <= ($this->quantity * 0.1);
    }
}
