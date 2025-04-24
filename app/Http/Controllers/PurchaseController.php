<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\Animal;
use App\Models\Vendor;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function index()
    {
        $purchases = Purchase::with(['animal', 'vendor'])->get();
        return view('purchases.index', compact('purchases'));
    }

    public function create()
    {
        $animals = Animal::all();
        $vendors = Vendor::all();
        return view('purchases.create', compact('animals', 'vendors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'animal_id' => 'required|exists:animals,id',
            'vendor_id' => 'nullable|exists:vendors,id',
            'purchase_date' => 'nullable|date',
            'value' => 'required|numeric',
        ]);

        Purchase::create($request->all());
        return redirect()->route('purchases.index')->with('success', 'Purchase recorded successfully.');
    }

    public function edit(Purchase $purchase)
    {
        $animals = Animal::all();
        $vendors = Vendor::all();
        return view('purchases.edit', compact('purchase', 'animals', 'vendors'));
    }

    public function update(Request $request, Purchase $purchase)
    {
        $request->validate([
            'animal_id' => 'required|exists:animals,id',
            'vendor_id' => 'nullable|exists:vendors,id',
            'purchase_date' => 'nullable|date',
            'value' => 'required|numeric',
        ]);

        $purchase->update($request->all());
        return redirect()->route('purchases.index')->with('success', 'Purchase updated successfully.');
    }

    public function destroy(Purchase $purchase)
    {
        $purchase->delete();
        return redirect()->route('purchases.index')->with('success', 'Purchase deleted.');
    }
}
