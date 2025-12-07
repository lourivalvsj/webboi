<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\AnimalWeight;
use Illuminate\Http\Request;

class AnimalWeightController extends Controller
{
    public function index()
    {
        $weights = AnimalWeight::with(['animal'])
                        ->orderBy('recorded_at', 'desc')
                        ->paginate(15);
        return view('animal_weights.index', compact('weights'));
    }

    public function create()
    {
        // Apenas animais disponíveis para registros
        $animals = Animal::availableForRecords()->get();
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

        // Verificar se o animal já foi vendido
        if ($animal->isSold()) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['animal_id' => 'Não é possível registrar pesagem para este animal pois ele já foi vendido.']);
        }

        AnimalWeight::create($request->all());
        return redirect()->route('animal-weights.index')->with('success', 'Pesagem registrada com sucesso.');
    }

    public function edit(AnimalWeight $animalWeight)
    {
        // Animais com compra e não vendidos + o animal atual da pesagem (para permitir edição)
        $animals = Animal::withPurchase()->whereDoesntHave('sale')->get();
        
        // Adicionar o animal atual se não estiver na lista (permitir edição mesmo se vendido)
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

        // Verificar se o animal já foi vendido
        if ($animal->isSold()) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['animal_id' => 'Não é possível atualizar pesagem para este animal pois ele já foi vendido.']);
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
