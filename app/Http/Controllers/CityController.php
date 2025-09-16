<?php

namespace App\Http\Controllers;

use App\Helpers\LocationHelper;
use Illuminate\Http\Request;

class CityController extends Controller
{
    /**
     * Busca cidades por UF para popular select
     */
    public function getCitiesByUf(Request $request)
    {
        $uf = $request->get('uf');
        $citiesByUf = LocationHelper::getCitiesByUf();
        
        $cities = $citiesByUf[$uf] ?? [];
        
        return response()->json($cities);
    }

    /**
     * Adiciona uma nova cidade
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'uf' => 'required|string|size:2'
        ]);

        $cityName = trim($request->name);
        $uf = $request->uf;

        $city = LocationHelper::addCity($cityName, $uf);

        if ($city) {
            return response()->json([
                'success' => true,
                'message' => 'Cidade adicionada com sucesso!',
                'city' => $cityName
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Cidade já existe ou UF inválida.'
            ], 400);
        }
    }

    /**
     * Busca cidades para autocomplete
     */
    public function search(Request $request)
    {
        $search = $request->get('search');
        $uf = $request->get('uf');
        
        if (strlen($search) < 2) {
            return response()->json([]);
        }

        $cities = LocationHelper::searchCities($search, $uf);
        
        return response()->json($cities);
    }
}