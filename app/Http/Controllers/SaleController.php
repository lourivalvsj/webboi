<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Animal;
use App\Models\Buyer;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::with(['animal', 'buyer'])->get();
        return view('sales.index', compact('sales'));
    }

    public function create()
    {
        $animals = Animal::all();
        $buyers = Buyer::all();
        return view('sales.create', compact('animals', 'buyers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'animal_id' => 'required|exists:animals,id',
            'buyer_id' => 'nullable|exists:buyers,id',
            'sale_date' => 'nullable|date',
            'value' => 'required|numeric',
        ]);

        Sale::create($request->all());
        return redirect()->route('sales.index')->with('success', 'Sale recorded successfully.');
    }

    public function edit(Sale $sale)
    {
        $animals = Animal::all();
        $buyers = Buyer::all();
        return view('sales.edit', compact('sale', 'animals', 'buyers'));
    }

    public function update(Request $request, Sale $sale)
    {
        $request->validate([
            'animal_id' => 'required|exists:animals,id',
            'buyer_id' => 'nullable|exists:buyers,id',
            'sale_date' => 'nullable|date',
            'value' => 'required|numeric',
        ]);

        $sale->update($request->all());
        return redirect()->route('sales.index')->with('success', 'Sale updated successfully.');
    }

    public function destroy(Sale $sale)
    {
        $sale->delete();
        return redirect()->route('sales.index')->with('success', 'Sale deleted.');
    }
}
