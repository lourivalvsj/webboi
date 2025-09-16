<?php

namespace App\Http\Controllers;

use App\Models\Buyer;
use Illuminate\Http\Request;

class BuyerController extends Controller
{
    public function index(Request $request)
    {
        $query = Buyer::query();

        // Filtro de busca
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere('phone', 'LIKE', "%{$search}%")
                  ->orWhere('city', 'LIKE', "%{$search}%");
            });
        }

        $buyers = $query->orderBy('name')->paginate(15)->withQueryString();
        return view('buyers.index', compact('buyers'));
    }

    public function create()
    {
        return view('buyers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'cpf_cnpj' => 'nullable|string|max:18',
            'email' => 'nullable|email|max:100',
            'phone' => 'nullable|string|max:15',
            'uf' => 'required|string|size:2',
            'city' => 'required|string|max:100',
            'address' => 'nullable|string|max:255',
            'state_registration' => 'nullable|string|max:50'
        ]);

        Buyer::create($request->all());
        return redirect()->route('buyers.index')->with('success', 'Comprador adicionado com sucesso.');
    }

    public function edit(Buyer $buyer)
    {
        return view('buyers.edit', compact('buyer'));
    }

    public function update(Request $request, Buyer $buyer)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'cpf_cnpj' => 'nullable|string|max:18',
            'email' => 'nullable|email|max:100',
            'phone' => 'nullable|string|max:15',
            'uf' => 'required|string|size:2',
            'city' => 'required|string|max:100',
            'address' => 'nullable|string|max:255',
            'state_registration' => 'nullable|string|max:50'
        ]);

        $buyer->update($request->all());
        return redirect()->route('buyers.index')->with('success', 'Comprador atualizado com sucesso.');
    }

    public function destroy(Buyer $buyer)
    {
        $buyer->delete();
        return redirect()->route('buyers.index')->with('success', 'Buyer deleted.');
    }
}
