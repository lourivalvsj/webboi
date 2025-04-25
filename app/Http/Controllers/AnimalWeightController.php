<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\AnimalWeight;
use Illuminate\Http\Request;

class AnimalWeightController extends Controller
{
    public function index()
    {
        $weights = AnimalWeight::with('animal')->get();
        return view('animal_weights.index', compact('weights'));
    }

    public function create()
    {
        $animals = Animal::all();
        return view('animal_weights.create', compact('animals'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'animal_id' => 'required|exists:animals,id',
            'weight' => 'required|numeric',
            'recorded_at' => 'required|date',
        ]);

        AnimalWeight::create($request->all());
        return redirect()->route('animal-weights.index')->with('success', 'Pesagem registrada com sucesso.');
    }

    public function edit(AnimalWeight $animalWeight)
    {
        $animals = Animal::all();
        return view('animal_weights.edit', compact('animalWeight', 'animals'));
    }

    public function update(Request $request, AnimalWeight $animalWeight)
    {
        $request->validate([
            'animal_id' => 'required|exists:animals,id',
            'weight' => 'required|numeric',
            'recorded_at' => 'required|date',
        ]);

        $animalWeight->update($request->all());
        return redirect()->route('animal-weights.index')->with('success', 'Pesagem atualizada com sucesso.');
    }

    public function destroy(AnimalWeight $animalWeight)
    {
        $animalWeight->delete();
        return redirect()->route('animal-weights.index')->with('success', 'Registro excluído.');
    }
}
