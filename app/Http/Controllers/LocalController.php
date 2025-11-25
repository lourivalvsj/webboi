<?php

namespace App\Http\Controllers;

use App\Models\Local;
use Illuminate\Http\Request;

class LocalController extends Controller
{
    public function index(Request $request)
    {
        $query = Local::query();

        // Filtros de busca
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'LIKE', "%{$search}%");
        }

        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->whereNull('exit_date')->orWhere('exit_date', '>', now());
            } elseif ($request->status === 'inactive') {
                $query->whereNotNull('exit_date')->where('exit_date', '<=', now());
            }
        }

        if ($request->filled('date_from')) {
            $query->where('entry_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('entry_date', '<=', $request->date_to);
        }

        $locals = $query->orderBy('name')->paginate(15)->withQueryString();
            
        return view('locals.index', compact('locals'));
    }

    public function create()
    {
        return view('locals.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'entry_date' => 'nullable|date',
            'exit_date' => 'nullable|date|after_or_equal:entry_date',
        ]);

        Local::create($request->all());
        return redirect()->route('locals.index')->with('success', 'Local cadastrado com sucesso.');
    }

    public function edit(Local $local)
    {
        return view('locals.edit', compact('local'));
    }

    public function update(Request $request, Local $local)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'entry_date' => 'nullable|date',
            'exit_date' => 'nullable|date|after_or_equal:entry_date',
        ]);

        $local->update($request->all());
        return redirect()->route('locals.index')->with('success', 'Local atualizado com sucesso.');
    }

    public function destroy(Local $local)
    {
        $local->delete();
        return redirect()->route('locals.index')->with('success', 'Local excluído com sucesso.');
    }
}
