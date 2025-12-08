<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\Medication;
use App\Models\SupplyExpense;
use Illuminate\Http\Request;

class MedicationController extends Controller
{
    public function index(Request $request)
    {
        $query = Medication::with(['animal']);

        // Filtros de busca
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('animal', function($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%")
                      ->orWhere('tag', 'LIKE', "%{$search}%");
                })
                ->orWhere('medication_name', 'LIKE', "%{$search}%");
            });
        }

        if ($request->filled('medication_name')) {
            $query->where('medication_name', 'LIKE', "%{$request->medication_name}%");
        }

        if ($request->filled('date_from')) {
            $query->where('administration_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('administration_date', '<=', $request->date_to);
        }

        $medications = $query->orderBy('administration_date', 'desc')->paginate(15)->withQueryString();
        
        // Buscar nomes de medicamentos únicos para o filtro
        $medicationNames = Medication::select('medication_name')
            ->distinct()
            ->orderBy('medication_name')
            ->pluck('medication_name');
            
        return view('medications.index', compact('medications', 'medicationNames'));
    }

    public function create()
    {
        // Apenas animais que já têm uma compra registrada e não foram vendidos
        $animals = Animal::withPurchase()->whereDoesntHave('sale')->get();
        
        // Buscar produtos únicos dos insumos cadastrados de medicamento
        $medicationNames = SupplyExpense::where('category', 'medicamento')
            ->select('name')
            ->distinct()
            ->orderBy('name')
            ->pluck('name');
            
        return view('medications.create', compact('animals', 'medicationNames'));
    }

    public function createBulk()
    {
        $animals = Animal::withPurchase()->whereDoesntHave('sale')->get();
        $medicationNames = SupplyExpense::where('category', 'medicamento')
            ->select('name')
            ->distinct()
            ->orderBy('name')
            ->pluck('name');
        return view('medications.create-bulk', compact('animals', 'medicationNames'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'animal_id' => 'required|exists:animals,id',
            'medication_name' => 'required|string|max:100',
            'dose' => 'required|numeric|min:0',
            'unit_of_measure' => 'nullable|string|max:50',
            'administration_date' => 'required|date',
        ]);

        // Verificar se o animal tem uma compra registrada
        $animal = Animal::find($request->animal_id);
        if (!$animal->hasPurchase()) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['animal_id' => 'Este animal não pode ter medicação registrada pois não possui uma compra registrada.']);
        }

        // Verificar se o animal já foi vendido
        if ($animal->isSold()) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['animal_id' => 'Não é possível registrar medicação para este animal pois ele já foi vendido.']);
        }

        Medication::create($request->all());
        return redirect()->route('medications.index')->with('success', 'Medicação registrada com sucesso.');
    }

    public function storeBulk(Request $request)
    {
        $request->validate([
            'medications' => 'required|array|min:1',
            'medications.*.animal_id' => 'required|exists:animals,id',
            'medications.*.medication_name' => 'required|string|max:100',
            'medications.*.dose' => 'required|numeric|min:0',
            'medications.*.unit_of_measure' => 'nullable|string|max:50',
            'medications.*.administration_date' => 'required|date',
        ]);

        $createdCount = 0;
        $errors = [];
        
        foreach ($request->medications as $index => $medicationData) {
            if (!empty($medicationData['animal_id']) && !empty($medicationData['medication_name']) && !empty($medicationData['dose']) && !empty($medicationData['administration_date'])) {
                $animal = Animal::find($medicationData['animal_id']);
                
                if (!$animal->hasPurchase()) {
                    $errors[] = "Animal da linha " . ($index + 1) . " não possui compra registrada.";
                    continue;
                }
                
                if ($animal->isSold()) {
                    $errors[] = "Animal da linha " . ($index + 1) . " já foi vendido.";
                    continue;
                }
                
                Medication::create($medicationData);
                $createdCount++;
            }
        }

        if (!empty($errors)) {
            return redirect()->route('medications.index')
                ->with('success', "$createdCount medicações registradas com sucesso.")
                ->with('errors', $errors);
        }

        return redirect()->route('medications.index')
            ->with('success', "$createdCount medicações registradas com sucesso.");
    }

    public function edit(Medication $medication)
    {
        // Animais com compra e não vendidos + o animal atual da medicação (para permitir edição)
        $animals = Animal::withPurchase()->whereDoesntHave('sale')->get();
        
        // Adicionar o animal atual se não estiver na lista (permitir edição mesmo se vendido)
        if ($medication->animal && !$animals->contains('id', $medication->animal->id)) {
            $animals->push($medication->animal);
        }
        
        // Buscar produtos únicos dos insumos cadastrados de medicamento
        $medicationNames = SupplyExpense::where('category', 'medicamento')
            ->select('name')
            ->distinct()
            ->orderBy('name')
            ->pluck('name');
        
        return view('medications.edit', compact('medication', 'animals', 'medicationNames'));
    }

    public function update(Request $request, Medication $medication)
    {
        $request->validate([
            'animal_id' => 'required|exists:animals,id',
            'medication_name' => 'required|string|max:100',
            'dose' => 'required|numeric|min:0',
            'unit_of_measure' => 'nullable|string|max:50',
            'administration_date' => 'required|date',
        ]);

        // Verificar se o animal tem uma compra registrada
        $animal = Animal::find($request->animal_id);
        if (!$animal->hasPurchase()) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['animal_id' => 'Este animal não pode ter medicação registrada pois não possui uma compra registrada.']);
        }

        // Verificar se o animal já foi vendido
        if ($animal->isSold()) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['animal_id' => 'Não é possível atualizar medicação para este animal pois ele já foi vendido.']);
        }

        $medication->update($request->all());
        return redirect()->route('medications.index')->with('success', 'Medicação atualizada com sucesso.');
    }

    public function destroy(Medication $medication)
    {
        $medication->delete();
        return redirect()->route('medications.index')->with('success', 'Registro de medicação excluído.');
    }
}
