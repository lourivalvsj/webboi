<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\Category;
use Illuminate\Http\Request;

class AnimalController extends Controller
{
    public function index()
    {
        $animals = Animal::with('category')->get();
        return view('animals.index', compact('animals'));
    }

    public function create()
    {
        $categories = Category::where('type', 'animal')->get();
        return view('animals.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tag' => 'required|unique:animals,tag',
            'breed' => 'nullable|string|max:50',
            'birth_date' => 'nullable|date',
            'initial_weight' => 'nullable|numeric',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        Animal::create($request->all());
        return redirect()->route('animals.index')->with('success', 'Animal criado com sucesso.');
    }

    public function show(Animal $animal)
    {
        return view('animals.show', compact('animal'));
    }

    public function edit(Animal $animal)
    {
        $categories = Category::where('type', 'animal')->get();
        return view('animals.edit', compact('animal', 'categories'));
    }

    public function update(Request $request, Animal $animal)
    {
        $request->validate([
            'tag' => 'required|unique:animals,tag,' . $animal->id,
            'breed' => 'nullable|string|max:50',
            'birth_date' => 'nullable|date',
            'initial_weight' => 'nullable|numeric',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        $animal->update($request->all());
        return redirect()->route('animals.index')->with('success', 'Animal anualizado com sucesso.');
    }

    public function destroy(Animal $animal)
    {
        $animal->delete();
        return redirect()->route('animals.index')->with('success', 'Animal excluído com sucesso.');
    }
}
