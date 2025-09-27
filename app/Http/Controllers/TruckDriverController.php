<?php

namespace App\Http\Controllers;

use App\Models\TruckDriver;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TruckDriverController extends Controller
{
    public function index(Request $request)
    {
        $query = TruckDriver::with('freights')->withCount('freights');
        
        // Busca
        if ($request->filled('search')) {
            $query->search($request->search);
        }
        
        $truckDrivers = $query->orderBy('name')->paginate(15);
        
        return view('truck_drivers.index', compact('truckDrivers'));
    }

    public function create()
    {
        return view('truck_drivers.create');
    }

    public function store(Request $request)
    {
        // Remove formatação do CPF antes da validação
        $cpfUnformatted = $request->cpf ? preg_replace('/\D/', '', $request->cpf) : null;
        $request->merge(['cpf' => $cpfUnformatted]);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'cpf' => 'nullable|string|size:11|unique:truck_drivers,cpf',
            'cnh' => 'nullable|string|max:20',
            'phone' => 'nullable|string|max:15',
            'email' => 'nullable|email|max:255|unique:truck_drivers,email',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|size:2',
            'zip_code' => 'nullable|string|max:10',
            'truck_plate' => 'nullable|string|max:10|unique:truck_drivers,truck_plate',
            'truck_model' => 'nullable|string|max:100',
            'truck_year' => 'nullable|integer|min:1980|max:' . (date('Y') + 1),
            'truck_capacity' => 'nullable|numeric|min:0|max:999999.99',
            'truck_description' => 'nullable|string|max:255',
            'observations' => 'nullable|string|max:1000',
        ], [
            'name.required' => 'O nome é obrigatório.',
            'cpf.size' => 'O CPF deve ter exatamente 11 dígitos.',
            'cpf.unique' => 'Este CPF já está cadastrado.',
            'email.email' => 'Digite um e-mail válido.',
            'email.unique' => 'Este e-mail já está cadastrado.',
            'truck_plate.unique' => 'Esta placa já está cadastrada.',
            'truck_year.min' => 'O ano deve ser maior que 1980.',
            'truck_year.max' => 'O ano não pode ser maior que ' . (date('Y') + 1) . '.',
            'truck_capacity.numeric' => 'A capacidade deve ser um número.',
            'truck_capacity.min' => 'A capacidade deve ser maior que 0.',
            'state.size' => 'O estado deve ter 2 letras (ex: GO).',
        ]);

        // Remove formatação de outros campos antes de salvar
        if ($validated['phone']) {
            $validated['phone'] = preg_replace('/\D/', '', $validated['phone']);
        }
        if ($validated['truck_plate']) {
            $validated['truck_plate'] = strtoupper(preg_replace('/[^A-Za-z0-9]/', '', $validated['truck_plate']));
        }
        if ($validated['state']) {
            $validated['state'] = strtoupper($validated['state']);
        }

        TruckDriver::create($validated);
        
        return redirect()->route('truck-drivers.index')
            ->with('success', 'Caminhoneiro cadastrado com sucesso.');
    }

    public function show(TruckDriver $truckDriver)
    {
        return view('truck_drivers.show', compact('truckDriver'));
    }

    public function edit(TruckDriver $truckDriver)
    {
        return view('truck_drivers.edit', compact('truckDriver'));
    }

    public function update(Request $request, TruckDriver $truckDriver)
    {
        // Remove formatação do CPF antes da validação
        $cpfUnformatted = $request->cpf ? preg_replace('/\D/', '', $request->cpf) : null;
        $request->merge(['cpf' => $cpfUnformatted]);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'cpf' => ['nullable', 'string', 'size:11', Rule::unique('truck_drivers')->ignore($truckDriver->id)],
            'cnh' => 'nullable|string|max:20',
            'phone' => 'nullable|string|max:15',
            'email' => ['nullable', 'email', 'max:255', Rule::unique('truck_drivers')->ignore($truckDriver->id)],
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|size:2',
            'zip_code' => 'nullable|string|max:10',
            'truck_plate' => ['nullable', 'string', 'max:10', Rule::unique('truck_drivers')->ignore($truckDriver->id)],
            'truck_model' => 'nullable|string|max:100',
            'truck_year' => 'nullable|integer|min:1980|max:' . (date('Y') + 1),
            'truck_capacity' => 'nullable|numeric|min:0|max:999999.99',
            'truck_description' => 'nullable|string|max:255',
            'observations' => 'nullable|string|max:1000',
        ], [
            'name.required' => 'O nome é obrigatório.',
            'cpf.size' => 'O CPF deve ter exatamente 11 dígitos.',
            'cpf.unique' => 'Este CPF já está cadastrado.',
            'email.email' => 'Digite um e-mail válido.',
            'email.unique' => 'Este e-mail já está cadastrado.',
            'truck_plate.unique' => 'Esta placa já está cadastrada.',
            'truck_year.min' => 'O ano deve ser maior que 1980.',
            'truck_year.max' => 'O ano não pode ser maior que ' . (date('Y') + 1) . '.',
            'truck_capacity.numeric' => 'A capacidade deve ser um número.',
            'truck_capacity.min' => 'A capacidade deve ser maior que 0.',
            'state.size' => 'O estado deve ter 2 letras (ex: GO).',
        ]);

        // Remove formatação de outros campos antes de salvar
        if ($validated['phone']) {
            $validated['phone'] = preg_replace('/\D/', '', $validated['phone']);
        }
        if ($validated['truck_plate']) {
            $validated['truck_plate'] = strtoupper(preg_replace('/[^A-Za-z0-9]/', '', $validated['truck_plate']));
        }
        if ($validated['state']) {
            $validated['state'] = strtoupper($validated['state']);
        }

        $truckDriver->update($validated);
        
        return redirect()->route('truck-drivers.index')
            ->with('success', 'Caminhoneiro atualizado com sucesso.');
    }

    public function destroy(TruckDriver $truckDriver)
    {
        // Verificar se há fretes associados
        if ($truckDriver->freights()->exists()) {
            return redirect()->route('truck-drivers.index')
                ->with('error', 'Não é possível excluir este caminhoneiro pois existem fretes associados a ele.');
        }

        $truckDriver->delete();
        
        return redirect()->route('truck-drivers.index')
            ->with('success', 'Caminhoneiro excluído com sucesso.');
    }
}
