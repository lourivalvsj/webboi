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
        return view('supply_expenses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:medicamento,alimentacao',
            'description' => 'nullable|string|max:1000',
            'purchase_date' => 'required|date',
            'value' => 'required|numeric|min:0',
            'unit_of_measure' => 'nullable|string|max:50',
            'quantity' => 'nullable|numeric|min:0',
        ]);

        SupplyExpense::create($request->all());
        return redirect()->route('supply-expenses.index')->with('success', 'Gasto com insumo registrado com sucesso.');
    }

    public function edit(SupplyExpense $supplyExpense)
    {
        return view('supply_expenses.edit', compact('supplyExpense'));
    }

    public function update(Request $request, SupplyExpense $supplyExpense)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:medicamento,alimentacao',
            'description' => 'nullable|string|max:1000',
            'purchase_date' => 'required|date',
            'value' => 'required|numeric|min:0',
            'unit_of_measure' => 'nullable|string|max:50',
            'quantity' => 'nullable|numeric|min:0',
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
