<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use Illuminate\Http\Request;

class AnimalDeathController extends Controller
{
    public function index(Request $request)
    {
        $query = Animal::dead()->with('category');

        // Filtros de busca
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('tag', 'LIKE', "%{$search}%")
                  ->orWhere('breed', 'LIKE', "%{$search}%");
            });
        }

        if ($request->filled('death_date_from')) {
            $query->where('death_date', '>=', $request->death_date_from);
        }

        if ($request->filled('death_date_to')) {
            $query->where('death_date', '<=', $request->death_date_to);
        }

        if ($request->filled('death_cause')) {
            $query->where('death_cause', 'LIKE', "%{$request->death_cause}%");
        }

        $animals = $query->orderBy('death_date', 'desc')->paginate(15)->withQueryString();
        
        return view('animal-deaths.index', compact('animals'));
    }

    public function create()
    {
        // Buscar apenas animais vivos e não vendidos
        $animals = Animal::alive()
            ->whereDoesntHave('sale')
            ->with('category')
            ->orderBy('tag')
            ->get();

        // Estatísticas para o painel lateral
        $aliveCount = Animal::alive()->count();
        $deadCount = Animal::dead()->count();
        $totalCount = Animal::count();

        return view('animal-deaths.create', compact('animals', 'aliveCount', 'deadCount', 'totalCount'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'animal_id' => 'required|exists:animals,id',
            'death_date' => 'required|date|before_or_equal:today',
            'death_location' => 'nullable|string|max:255',
            'death_cause' => 'nullable|string|max:500',
            'death_observations' => 'nullable|string|max:1000',
        ]);

        $animal = Animal::findOrFail($request->animal_id);

        // Verificar se o animal já morreu
        if ($animal->is_dead) {
            return redirect()->route('animal-deaths.index')
                ->with('error', 'Este animal já foi registrado como morto.');
        }

        // Verificar se o animal foi vendido
        if ($animal->isSold()) {
            return redirect()->route('animals.index')
                ->with('error', 'Não é possível registrar óbito de animal já vendido.');
        }

        $animal->registerDeath($request->only([
            'death_date',
            'death_location', 
            'death_cause',
            'death_observations'
        ]));

        return redirect()->route('animal-deaths.index')
            ->with('success', "Óbito do animal '{$animal->tag}' registrado com sucesso.");
    }

    public function show(Animal $animal)
    {
        if (!$animal->is_dead) {
            return redirect()->route('animals.show', $animal)
                ->with('error', 'Este animal não está registrado como morto.');
        }

        return view('animal-deaths.show', compact('animal'));
    }

    public function edit(Animal $animal)
    {
        if (!$animal->is_dead) {
            return redirect()->route('animals.show', $animal)
                ->with('error', 'Este animal não está registrado como morto.');
        }

        return view('animal-deaths.edit', compact('animal'));
    }

    public function update(Request $request, Animal $animal)
    {
        $request->validate([
            'death_date' => 'required|date|before_or_equal:today',
            'death_location' => 'required|string|max:255',
            'death_cause' => 'required|string|max:500',
            'death_observations' => 'nullable|string|max:1000',
        ]);

        if (!$animal->is_dead) {
            return redirect()->route('animals.show', $animal)
                ->with('error', 'Este animal não está registrado como morto.');
        }

        $animal->update($request->only([
            'death_date',
            'death_location', 
            'death_cause',
            'death_observations'
        ]));

        return redirect()->route('animal-deaths.show', $animal)
            ->with('success', 'Dados do óbito atualizados com sucesso.');
    }

    public function revive(Animal $animal)
    {
        if (!$animal->is_dead) {
            return redirect()->route('animals.show', $animal)
                ->with('error', 'Este animal não está registrado como morto.');
        }

        $animal->update([
            'is_dead' => false,
            'death_date' => null,
            'death_location' => null,
            'death_cause' => null,
            'death_observations' => null,
        ]);

        return redirect()->route('animals.show', $animal)
            ->with('success', 'Registro de óbito removido. Animal reativado.');
    }
}
