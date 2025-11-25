<?php

namespace App\Http\Controllers;

use App\Models\Freight;
use App\Models\TruckDriver;
use App\Models\Local;
use Illuminate\Http\Request;

class FreightController extends Controller
{
    public function index(Request $request)
    {
        $query = Freight::with(['truckDriver', 'local']);

        // Filtros de busca
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('truckDriver', function($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%")
                      ->orWhere('phone', 'LIKE', "%{$search}%");
                })
                ->orWhereHas('local', function($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%");
                });
            });
        }

        if ($request->filled('truck_driver_id')) {
            $query->where('truck_driver_id', $request->truck_driver_id);
        }

        if ($request->filled('local_id')) {
            $query->where('local_id', $request->local_id);
        }

        if ($request->filled('date_from')) {
            $query->where('departure_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('departure_date', '<=', $request->date_to);
        }

        if ($request->filled('min_value')) {
            $query->where('value', '>=', $request->min_value);
        }

        if ($request->filled('max_value')) {
            $query->where('value', '<=', $request->max_value);
        }

        $freights = $query->orderBy('departure_date', 'desc')->paginate(15)->withQueryString();
        
        // Buscar caminhoneiros e locais para os filtros
        $truckDrivers = TruckDriver::orderBy('name')->get();
        $locals = Local::orderBy('name')->get();
            
        return view('freights.index', compact('freights', 'truckDrivers', 'locals'));
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
