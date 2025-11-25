<?php

namespace App\Http\Controllers;

use App\Models\SupplyExpense;
use App\Models\Animal;
use Illuminate\Http\Request;

class SupplyExpenseController extends Controller
{
    public function index(Request $request)
    {
        $query = SupplyExpense::with(['animal']);

        // Filtros de busca
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('date_from')) {
            $query->where('purchase_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('purchase_date', '<=', $request->date_to);
        }

        if ($request->filled('min_value')) {
            $query->where('value', '>=', $request->min_value);
        }

        if ($request->filled('max_value')) {
            $query->where('value', '<=', $request->max_value);
        }

        $expenses = $query->orderBy('purchase_date', 'desc')->paginate(15)->withQueryString();
        
        // Buscar produtos únicos para o filtro
        $products = SupplyExpense::select('name')
            ->distinct()
            ->orderBy('name')
            ->pluck('name');
            
        return view('supply_expenses.index', compact('expenses', 'products'));
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
