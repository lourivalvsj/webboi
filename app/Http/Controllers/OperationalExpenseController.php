<?php

namespace App\Http\Controllers;

use App\Models\OperationalExpense;
use App\Models\Local;
use Illuminate\Http\Request;

class OperationalExpenseController extends Controller
{
    public function index(Request $request)
    {
        $query = OperationalExpense::with(['local']);

        // Filtros de busca
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhereHas('local', function($q) use ($search) {
                      $q->where('name', 'LIKE', "%{$search}%");
                  });
            });
        }

        if ($request->filled('local_id')) {
            $query->where('local_id', $request->local_id);
        }

        if ($request->filled('date_from')) {
            $query->where('date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('date', '<=', $request->date_to);
        }

        if ($request->filled('min_value')) {
            $query->where('value', '>=', $request->min_value);
        }

        if ($request->filled('max_value')) {
            $query->where('value', '<=', $request->max_value);
        }

        $expenses = $query->orderBy('date', 'desc')->paginate(15)->withQueryString();
        
        // Buscar locais para o filtro
        $locals = Local::orderBy('name')->get();
            
        return view('operational_expenses.index', compact('expenses', 'locals'));
    }

    public function create()
    {
        $locals = Local::all();
        return view('operational_expenses.create', compact('locals'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'local_id' => 'required|exists:locals,id',
            'name' => 'required|string|max:255',
            'value' => 'required|numeric|min:0',
            'date' => 'required|date',
            'unit_of_measure' => 'nullable|string|max:50',
            'quantity' => 'nullable|numeric|min:0',
        ]);

        OperationalExpense::create($request->all());
        return redirect()->route('operational-expenses.index')->with('success', 'Despesa operacional registrada com sucesso.');
    }

    public function edit(OperationalExpense $operationalExpense)
    {
        $locals = Local::all();
        return view('operational_expenses.edit', compact('operationalExpense', 'locals'));
    }

    public function update(Request $request, OperationalExpense $operationalExpense)
    {
        $request->validate([
            'local_id' => 'required|exists:locals,id',
            'name' => 'required|string|max:255',
            'value' => 'required|numeric|min:0',
            'date' => 'required|date',
            'unit_of_measure' => 'nullable|string|max:50',
            'quantity' => 'nullable|numeric|min:0',
        ]);

        $operationalExpense->update($request->all());
        return redirect()->route('operational-expenses.index')->with('success', 'Despesa operacional atualizada com sucesso.');
    }

    public function destroy(OperationalExpense $operationalExpense)
    {
        $operationalExpense->delete();
        return redirect()->route('operational-expenses.index')->with('success', 'Despesa operacional excluída com sucesso.');
    }
}
