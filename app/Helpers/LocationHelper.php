<?php

namespace App\Helpers;

use App\Models\Uf;
use App\Models\City;
use Illuminate\Support\Facades\Cache;

class LocationHelper
{
    /**
     * Retorna array com UFs do banco de dados
     */
    public static function getUfs()
    {
        return Cache::remember('ufs_list', 60 * 24, function () {
            return Uf::orderBy('name')->pluck('name', 'abbreviation')->toArray();
        });
    }

    /**
     * Retorna cidades agrupadas por UF do banco de dados
     */
    public static function getCitiesByUf()
    {
        return Cache::remember('cities_by_uf', 60 * 24, function () {
            $ufs = Uf::with(['cities' => function($query) {
                $query->orderBy('name');
            }])->get();

            $result = [];
            foreach ($ufs as $uf) {
                $result[$uf->abbreviation] = $uf->cities->pluck('name')->toArray();
            }
            return $result;
        });
    }

    /**
     * Retorna todas as cidades ordenadas alfabeticamente
     */
    public static function getAllCities()
    {
        return Cache::remember('all_cities', 60 * 24, function () {
            return City::orderBy('name')->pluck('name')->unique()->values()->toArray();
        });
    }

    /**
     * Adiciona uma nova cidade ao banco de dados
     */
    public static function addCity($cityName, $ufAbbreviation)
    {
        $uf = Uf::where('abbreviation', $ufAbbreviation)->first();
        
        if (!$uf) {
            return false;
        }

        // Verifica se a cidade já existe nesta UF
        $existingCity = City::where('name', $cityName)
                           ->where('uf_id', $uf->id)
                           ->first();

        if ($existingCity) {
            return false; // Cidade já existe
        }

        $city = City::create([
            'name' => $cityName,
            'uf_id' => $uf->id
        ]);

        // Limpa o cache para atualizar as listas
        Cache::forget('cities_by_uf');
        Cache::forget('all_cities');

        return $city;
    }

    /**
     * Busca cidades por nome (para autocomplete)
     */
    public static function searchCities($search, $ufAbbreviation = null)
    {
        $query = City::where('name', 'LIKE', "%{$search}%");
        
        if ($ufAbbreviation) {
            $uf = Uf::where('abbreviation', $ufAbbreviation)->first();
            if ($uf) {
                $query->where('uf_id', $uf->id);
            }
        }

        return $query->orderBy('name')->limit(10)->pluck('name')->toArray();
    }

    /**
     * Retorna UF por sigla
     */
    public static function getUfByAbbreviation($abbreviation)
    {
        return Uf::where('abbreviation', $abbreviation)->first();
    }
}