<?php

namespace App\Http\Controllers;

use App\Models\Local;
use Illuminate\Http\Request;

class LocalController extends Controller
{
    public function index()
    {
        $locals = Local::all();
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
