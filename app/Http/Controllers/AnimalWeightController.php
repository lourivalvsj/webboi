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
        // Apenas animais que já têm uma compra registrada
        $animals = Animal::withPurchase()->get();
        return view('animal_weights.create', compact('animals'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'animal_id' => 'required|exists:animals,id',
            'weight' => 'required|numeric',
            'recorded_at' => 'required|date',
        ]);

        // Verificar se o animal tem uma compra registrada
        $animal = Animal::find($request->animal_id);
        if (!$animal->hasPurchase()) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['animal_id' => 'Este animal não pode ter pesagem registrada pois não possui uma compra registrada.']);
        }

        AnimalWeight::create($request->all());
        return redirect()->route('animal-weights.index')->with('success', 'Pesagem registrada com sucesso.');
    }

    public function edit(AnimalWeight $animalWeight)
    {
        // Animais com compra + o animal atual da pesagem (para permitir edição)
        $animals = Animal::withPurchase()->get();
        
        // Adicionar o animal atual se não estiver na lista
        if ($animalWeight->animal && !$animals->contains('id', $animalWeight->animal->id)) {
            $animals->push($animalWeight->animal);
        }
        
        return view('animal_weights.edit', compact('animalWeight', 'animals'));
    }

    public function update(Request $request, AnimalWeight $animalWeight)
    {
        $request->validate([
            'animal_id' => 'required|exists:animals,id',
            'weight' => 'required|numeric',
            'recorded_at' => 'required|date',
        ]);

        // Verificar se o animal tem uma compra registrada
        $animal = Animal::find($request->animal_id);
        if (!$animal->hasPurchase()) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['animal_id' => 'Este animal não pode ter pesagem registrada pois não possui uma compra registrada.']);
        }

        $animalWeight->update($request->all());
        return redirect()->route('animal-weights.index')->with('success', 'Pesagem atualizada com sucesso.');
    }

    public function destroy(AnimalWeight $animalWeight)
    {
        $animalWeight->delete();
        return redirect()->route('animal-weights.index')->with('success', 'Registro excluído.');
    }
}
