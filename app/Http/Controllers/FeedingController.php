<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\Feeding;
use App\Models\SupplyExpense;
use Illuminate\Http\Request;

class FeedingController extends Controller
{
    public function index()
    {
        $feedings = Feeding::with('animal')->get();
        return view('feedings.index', compact('feedings'));
    }

    public function create()
    {
        // Apenas animais que já têm uma compra registrada
        $animals = Animal::withPurchase()->get();
        
        // Buscar produtos únicos dos insumos cadastrados de alimentação
        $feedTypes = SupplyExpense::where('category', 'alimentacao')
            ->select('name')
            ->distinct()
            ->orderBy('name')
            ->pluck('name');
            
        return view('feedings.create', compact('animals', 'feedTypes'));
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

        Feeding::create($request->all());
        return redirect()->route('feedings.index')->with('success', 'Alimentação registrada com sucesso.');
    }

    public function edit(Feeding $feeding)
    {
        // Animais com compra + o animal atual da alimentação (para permitir edição)
        $animals = Animal::withPurchase()->get();
        
        // Adicionar o animal atual se não estiver na lista
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

        $feeding->update($request->all());
        return redirect()->route('feedings.index')->with('success', 'Alimentação atualizada com sucesso.');
    }

    public function destroy(Feeding $feeding)
    {
        $feeding->delete();
        return redirect()->route('feedings.index')->with('success', 'Registro de alimentação excluído.');
    }
}
