<?php

namespace App\Http\Controllers;

use App\Models\Freight;
use App\Models\TruckDriver;
use App\Models\Local;
use Illuminate\Http\Request;

class FreightController extends Controller
{
    public function index()
    {
        $freights = Freight::with(['truckDriver', 'local'])->get();
        return view('freights.index', compact('freights'));
    }

    public function create()
    {
        $truckDrivers = TruckDriver::all();
        $locals = Local::all();
        return view('freights.create', compact('truckDrivers', 'locals'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'truck_driver_id' => 'required|exists:truck_drivers,id',
            'local_id' => 'required|exists:locals,id',
            'quantity_animals' => 'required|integer|min:1',
            'value' => 'required|numeric|min:0',
            'departure_date' => 'required|date',
            'arrival_date' => 'required|date|after_or_equal:departure_date',
        ]);

        Freight::create($request->all());
        return redirect()->route('freights.index')->with('success', 'Frete cadastrado com sucesso.');
    }

    public function edit(Freight $freight)
    {
        $truckDrivers = TruckDriver::all();
        $locals = Local::all();
        return view('freights.edit', compact('freight', 'truckDrivers', 'locals'));
    }

    public function update(Request $request, Freight $freight)
    {
        $request->validate([
            'truck_driver_id' => 'required|exists:truck_drivers,id',
            'local_id' => 'required|exists:locals,id',
            'quantity_animals' => 'required|integer|min:1',
            'value' => 'required|numeric|min:0',
            'departure_date' => 'required|date',
            'arrival_date' => 'required|date|after_or_equal:departure_date',
        ]);

        $freight->update($request->all());
        return redirect()->route('freights.index')->with('success', 'Frete atualizado com sucesso.');
    }

    public function destroy(Freight $freight)
    {
        $freight->delete();
        return redirect()->route('freights.index')->with('success', 'Frete excluído com sucesso.');
    }
}
