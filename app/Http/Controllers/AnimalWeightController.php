<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\AnimalWeight;
use Illuminate\Http\Request;

class AnimalWeightController extends Controller
{
    public function index(Request $request)
    {
        $query = AnimalWeight::with(['animal']);
        
        // Filtro por animal
        if ($request->filled('animal_id')) {
            $query->where('animal_id', $request->animal_id);
        }
        
        // Filtro por peso (faixa)
        if ($request->filled('weight_min')) {
            $query->where('weight', '>=', $request->weight_min);
        }
        
        if ($request->filled('weight_max')) {
            $query->where('weight', '<=', $request->weight_max);
        }
        
        // Filtro por data
        if ($request->filled('date_from')) {
            $query->whereDate('recorded_at', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->whereDate('recorded_at', '<=', $request->date_to);
        }
        
        $weights = $query->orderBy('recorded_at', 'desc')->paginate(15);
        
        // Buscar todos os animais para o filtro
        $animals = Animal::select('id', 'tag')->orderBy('tag')->get();
        
        return view('animal_weights.index', compact('weights', 'animals'));
    }

    public function create()
    {
        // Apenas animais disponíveis para registros
        $animals = Animal::availableForRecords()->get();
        return view('animal_weights.create', compact('animals'));
    }

    public function createBulk()
    {
        $animals = Animal::availableForRecords()->get();
        return view('animal_weights.create-bulk', compact('animals'));
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

    public function storeBulk(Request $request)
    {
        $request->validate([
            'weights' => 'required|array|min:1',
            'weights.*.animal_id' => 'required|exists:animals,id',
            'weights.*.weight' => 'required|numeric|min:0',
            'weights.*.recorded_at' => 'required|date',
        ]);

        $createdCount = 0;
        $errors = [];
        
        foreach ($request->weights as $index => $weightData) {
            if (!empty($weightData['animal_id']) && !empty($weightData['weight']) && !empty($weightData['recorded_at'])) {
                $animal = Animal::find($weightData['animal_id']);
                
                if (!$animal->hasPurchase()) {
                    $errors[] = "Animal da linha " . ($index + 1) . " não possui compra registrada.";
                    continue;
                }
                
                if ($animal->isSold()) {
                    $errors[] = "Animal da linha " . ($index + 1) . " já foi vendido.";
                    continue;
                }
                
                AnimalWeight::create($weightData);
                $createdCount++;
            }
        }

        if (!empty($errors)) {
            return redirect()->route('animal-weights.index')
                ->with('success', "$createdCount pesagens registradas com sucesso.")
                ->with('errors', $errors);
        }

        return redirect()->route('animal-weights.index')
            ->with('success', "$createdCount pesagens registradas com sucesso.");
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
