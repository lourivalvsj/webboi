<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\Medication;
use Illuminate\Http\Request;

class MedicationController extends Controller
{
    public function index()
    {
        $medications = Medication::with('animal')->get();
        return view('medications.index', compact('medications'));
    }

    public function create()
    {
        // Apenas animais que já têm uma compra registrada
        $animals = Animal::withPurchase()->get();
        return view('medications.create', compact('animals'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'animal_id' => 'required|exists:animals,id',
            'medication_name' => 'required|string|max:100',
            'dose' => 'required|string|max:50',
            'administration_date' => 'required|date',
        ]);

        // Verificar se o animal tem uma compra registrada
        $animal = Animal::find($request->animal_id);
        if (!$animal->hasPurchase()) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['animal_id' => 'Este animal não pode ter medicação registrada pois não possui uma compra registrada.']);
        }

        Medication::create($request->all());
        return redirect()->route('medications.index')->with('success', 'Medicação registrada com sucesso.');
    }

    public function edit(Medication $medication)
    {
        // Animais com compra + o animal atual da medicação (para permitir edição)
        $animals = Animal::withPurchase()->get();
        
        // Adicionar o animal atual se não estiver na lista
        if ($medication->animal && !$animals->contains('id', $medication->animal->id)) {
            $animals->push($medication->animal);
        }
        
        return view('medications.edit', compact('medication', 'animals'));
    }

    public function update(Request $request, Medication $medication)
    {
        $request->validate([
            'animal_id' => 'required|exists:animals,id',
            'medication_name' => 'required|string|max:100',
            'dose' => 'required|string|max:50',
            'administration_date' => 'required|date',
        ]);

        // Verificar se o animal tem uma compra registrada
        $animal = Animal::find($request->animal_id);
        if (!$animal->hasPurchase()) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['animal_id' => 'Este animal não pode ter medicação registrada pois não possui uma compra registrada.']);
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
