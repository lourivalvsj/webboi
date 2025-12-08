<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\Feeding;
use App\Models\SupplyExpense;
use Illuminate\Http\Request;

class FeedingController extends Controller
{
    public function index(Request $request)
    {
        $query = Feeding::with(['animal']);

        // Filtros de busca
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('animal', function($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%")
                      ->orWhere('tag', 'LIKE', "%{$search}%");
                })
                ->orWhere('feed_type', 'LIKE', "%{$search}%");
            });
        }

        if ($request->filled('feed_type')) {
            $query->where('feed_type', 'LIKE', "%{$request->feed_type}%");
        }

        if ($request->filled('date_from')) {
            $query->where('feeding_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('feeding_date', '<=', $request->date_to);
        }

        $feedings = $query->orderBy('feeding_date', 'desc')->paginate(15)->withQueryString();
        
        // Buscar tipos de alimento únicos para o filtro
        $feedTypes = Feeding::select('feed_type')
            ->distinct()
            ->orderBy('feed_type')
            ->pluck('feed_type');
            
        return view('feedings.index', compact('feedings', 'feedTypes'));
    }

    public function create()
    {
        // Apenas animais que já têm uma compra registrada e não foram vendidos
        $animals = Animal::withPurchase()->whereDoesntHave('sale')->get();
        
        // Buscar produtos únicos dos insumos cadastrados de alimentação
        $feedTypes = SupplyExpense::where('category', 'alimentacao')
            ->select('name')
            ->distinct()
            ->orderBy('name')
            ->pluck('name');
            
        return view('feedings.create', compact('animals', 'feedTypes'));
    }

    public function createBulk()
    {
        $animals = Animal::withPurchase()->whereDoesntHave('sale')->get();
        $feedTypes = SupplyExpense::where('category', 'alimentacao')
            ->select('name')
            ->distinct()
            ->orderBy('name')
            ->pluck('name');
        return view('feedings.create-bulk', compact('animals', 'feedTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'animal_id' => 'required|exists:animals,id',
            'feed_type' => 'required|string|max:100',
            'quantity' => 'required|numeric',
            'unit_of_measure' => 'nullable|string|max:50',
            'feeding_date' => 'required|date',
        ]);

        // Verificar se o animal tem uma compra registrada
        $animal = Animal::find($request->animal_id);
        if (!$animal->hasPurchase()) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['animal_id' => 'Este animal não pode ter alimentação registrada pois não possui uma compra registrada.']);
        }

        // Verificar se o animal já foi vendido
        if ($animal->isSold()) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['animal_id' => 'Não é possível registrar alimentação para este animal pois ele já foi vendido.']);
        }

        Feeding::create($request->all());
        return redirect()->route('feedings.index')->with('success', 'Alimentação registrada com sucesso.');
    }

    public function storeBulk(Request $request)
    {
        $request->validate([
            'feedings' => 'required|array|min:1',
            'feedings.*.animal_id' => 'required|exists:animals,id',
            'feedings.*.feed_type' => 'required|string|max:100',
            'feedings.*.quantity' => 'required|numeric|min:0',
            'feedings.*.unit_of_measure' => 'nullable|string|max:50',
            'feedings.*.feeding_date' => 'required|date',
        ]);

        $createdCount = 0;
        $errors = [];
        
        foreach ($request->feedings as $index => $feedingData) {
            if (!empty($feedingData['animal_id']) && !empty($feedingData['feed_type']) && !empty($feedingData['quantity']) && !empty($feedingData['feeding_date'])) {
                $animal = Animal::find($feedingData['animal_id']);
                
                if (!$animal->hasPurchase()) {
                    $errors[] = "Animal da linha " . ($index + 1) . " não possui compra registrada.";
                    continue;
                }
                
                if ($animal->isSold()) {
                    $errors[] = "Animal da linha " . ($index + 1) . " já foi vendido.";
                    continue;
                }
                
                Feeding::create($feedingData);
                $createdCount++;
            }
        }

        if (!empty($errors)) {
            return redirect()->route('feedings.index')
                ->with('success', "$createdCount alimentações registradas com sucesso.")
                ->with('errors', $errors);
        }

        return redirect()->route('feedings.index')
            ->with('success', "$createdCount alimentações registradas com sucesso.");
    }

    public function edit(Feeding $feeding)
    {
        // Animais com compra e não vendidos + o animal atual da alimentação (para permitir edição)
        $animals = Animal::withPurchase()->whereDoesntHave('sale')->get();
        
        // Adicionar o animal atual se não estiver na lista (permitir edição mesmo se vendido)
        if ($feeding->animal && !$animals->contains('id', $feeding->animal->id)) {
            $animals->push($feeding->animal);
        }
        
        // Buscar produtos únicos dos insumos cadastrados de alimentação
        $feedTypes = SupplyExpense::where('category', 'alimentacao')
            ->select('name')
            ->distinct()
            ->orderBy('name')
            ->pluck('name');
        
        return view('feedings.edit', compact('feeding', 'animals', 'feedTypes'));
    }

    public function update(Request $request, Feeding $feeding)
    {
        $request->validate([
            'animal_id' => 'required|exists:animals,id',
            'feed_type' => 'required|string|max:100',
            'quantity' => 'required|numeric',
            'unit_of_measure' => 'nullable|string|max:50',
            'feeding_date' => 'required|date',
        ]);

        // Verificar se o animal tem uma compra registrada
        $animal = Animal::find($request->animal_id);
        if (!$animal->hasPurchase()) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['animal_id' => 'Este animal não pode ter alimentação registrada pois não possui uma compra registrada.']);
        }

        // Verificar se o animal já foi vendido
        if ($animal->isSold()) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['animal_id' => 'Não é possível atualizar alimentação para este animal pois ele já foi vendido.']);
        }

        $feeding->update($request->all());
        return redirect()->route('feedings.index')->with('success', 'Alimentação atualizada com sucesso.');
    }

    public function destroy(Feeding $feeding)
    {
        $feeding->delete();
        return redirect()->route('feedings.index')->with('success', 'Registro de alimentação excluído.');
    }
}
