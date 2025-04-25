<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Uf extends Model
{
    protected $fillable = ['name', 'abbreviation'];

    public function cities()
    {
        return $this->hasMany(City::class);
    }
}
