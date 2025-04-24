<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Animal;
use App\Models\Purchase;
use App\Models\Sale;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'totalAnimals' => Animal::count(),
            'totalPurchases' => Purchase::count(),
            'totalSales' => Sale::count(),
            'totalSpent' => Purchase::sum('value'),
        ]);
    }
}
