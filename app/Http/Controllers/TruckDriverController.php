<?php

namespace App\Http\Controllers;

use App\Models\TruckDriver;
use Illuminate\Http\Request;

class TruckDriverController extends Controller
{
    public function index()
    {
        $truckDrivers = TruckDriver::all();
        return view('truck_drivers.index', compact('truckDrivers'));
    }

    public function create()
    {
        return view('truck_drivers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'truck_description' => 'nullable|string|max:255',
        ]);

        TruckDriver::create($request->all());
        return redirect()->route('truck-drivers.index')->with('success', 'Caminhoneiro cadastrado com sucesso.');
    }

    public function edit(TruckDriver $truckDriver)
    {
        return view('truck_drivers.edit', compact('truckDriver'));
    }

    public function update(Request $request, TruckDriver $truckDriver)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'truck_description' => 'nullable|string|max:255',
        ]);

        $truckDriver->update($request->all());
        return redirect()->route('truck-drivers.index')->with('success', 'Caminhoneiro atualizado com sucesso.');
    }

    public function destroy(TruckDriver $truckDriver)
    {
        $truckDriver->delete();
        return redirect()->route('truck-drivers.index')->with('success', 'Caminhoneiro excluído com sucesso.');
    }
}
