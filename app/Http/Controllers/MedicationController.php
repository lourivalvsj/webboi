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
        $animals = Animal::all();
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

        Medication::create($request->all());
        return redirect()->route('medications.index')->with('success', 'Medicação registrada com sucesso.');
    }

    public function edit(Medication $medication)
    {
        $animals = Animal::all();
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

        $medication->update($request->all());
        return redirect()->route('medications.index')->with('success', 'Medicação atualizada com sucesso.');
    }

    public function destroy(Medication $medication)
    {
        $medication->delete();
        return redirect()->route('medications.index')->with('success', 'Registro de medicação excluído.');
    }
}
