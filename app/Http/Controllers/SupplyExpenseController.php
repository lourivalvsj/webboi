<?php

namespace App\Http\Controllers;

use App\Models\SupplyExpense;
use App\Models\Animal;
use Illuminate\Http\Request;

class SupplyExpenseController extends Controller
{
    public function index()
    {
        $expenses = SupplyExpense::with('animal')->get();
        return view('supply_expenses.index', compact('expenses'));
    }

    public function create()
    {
        $animals = Animal::all();
        return view('supply_expenses.create', compact('animals'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'animal_id' => 'required|exists:animals,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'purchase_date' => 'required|date',
            'value' => 'required|numeric|min:0',
        ]);

        SupplyExpense::create($request->all());
        return redirect()->route('supply-expenses.index')->with('success', 'Gasto com insumo registrado com sucesso.');
    }

    public function edit(SupplyExpense $supplyExpense)
    {
        $animals = Animal::all();
        return view('supply_expenses.edit', compact('supplyExpense', 'animals'));
    }

    public function update(Request $request, SupplyExpense $supplyExpense)
    {
        $request->validate([
            'animal_id' => 'required|exists:animals,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'purchase_date' => 'required|date',
            'value' => 'required|numeric|min:0',
        ]);

        $supplyExpense->update($request->all());
        return redirect()->route('supply-expenses.index')->with('success', 'Gasto com insumo atualizado com sucesso.');
    }

    public function destroy(SupplyExpense $supplyExpense)
    {
        $supplyExpense->delete();
        return redirect()->route('supply-expenses.index')->with('success', 'Gasto com insumo excluído com sucesso.');
    }
}
