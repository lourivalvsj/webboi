<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupplyExpense extends Model
{
    protected $fillable = ['animal_id', 'name', 'category', 'description', 'purchase_date', 'value', 'unit_of_measure', 'quantity'];

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
}
