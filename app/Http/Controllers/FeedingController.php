<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\Feeding;
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
        $animals = Animal::all();
        return view('feedings.create', compact('animals'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'animal_id' => 'required|exists:animals,id',
            'feed_type' => 'required|string|max:100',
            'quantity' => 'required|numeric',
            'feeding_date' => 'required|date',
        ]);

        Feeding::create($request->all());
        return redirect()->route('feedings.index')->with('success', 'Alimentação registrada com sucesso.');
    }

    public function edit(Feeding $feeding)
    {
        $animals = Animal::all();
        return view('feedings.edit', compact('feeding', 'animals'));
    }

    public function update(Request $request, Feeding $feeding)
    {
        $request->validate([
            'animal_id' => 'required|exists:animals,id',
            'feed_type' => 'required|string|max:100',
            'quantity' => 'required|numeric',
            'feeding_date' => 'required|date',
        ]);

        $feeding->update($request->all());
        return redirect()->route('feedings.index')->with('success', 'Alimentação atualizada com sucesso.');
    }

    public function destroy(Feeding $feeding)
    {
        $feeding->delete();
        return redirect()->route('feedings.index')->with('success', 'Registro de alimentação excluído.');
    }
}
