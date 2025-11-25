<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Animal;
use App\Models\Purchase;
use App\Models\Sale;
use App\Models\SupplyExpense;
use App\Models\OperationalExpense;
use App\Models\Freight;

class DashboardController extends Controller
{
    public function index()
    {
        // Receitas (Vendas)
        $totalRevenue = Sale::sum('value');
        
        // Despesas
        $totalPurchases = Purchase::sum('value');
        $totalSupplyExpenses = SupplyExpense::sum('value');
        $totalOperationalExpenses = OperationalExpense::sum('value');
        $totalFreightExpenses = Freight::sum('value');
        
        $totalExpenses = $totalPurchases + $totalSupplyExpenses + $totalOperationalExpenses + $totalFreightExpenses;
        
        // Lucro/Prejuízo
        $profitLoss = $totalRevenue - $totalExpenses;
        
        return view('dashboard', [
            'totalAnimals' => Animal::count(),
            'totalPurchases' => Purchase::count(),
            'totalSales' => Sale::count(),
            'totalSpent' => $totalPurchases,
            'profitLoss' => $profitLoss,
            'totalRevenue' => $totalRevenue,
            'totalExpenses' => $totalExpenses,
        ]);
    }
}
