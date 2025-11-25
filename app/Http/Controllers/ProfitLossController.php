<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Purchase;
use App\Models\SupplyExpense;
use App\Models\OperationalExpense;
use App\Models\Freight;
use App\Models\Animal;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ProfitLossController extends Controller
{
    public function index(Request $request)
    {
        // Definir período padrão (último ano)
        $dateFrom = $request->filled('date_from') ? $request->date_from : Carbon::now()->subYear()->format('Y-m-d');
        $dateTo = $request->filled('date_to') ? $request->date_to : Carbon::now()->format('Y-m-d');
        
        // Dados de vendas no período
        $sales = Sale::with(['animal.purchase'])
            ->whereBetween('sale_date', [$dateFrom, $dateTo])
            ->get();
            
        // Receitas
        $totalSalesRevenue = $sales->sum('value');
        
        // Custos de compra (animais vendidos)
        $totalPurchaseCosts = $sales->sum(function($sale) {
            return $sale->animal && $sale->animal->purchase ? $sale->animal->purchase->value : 0;
        });
        
        // Custos operacionais no período
        $supplyExpenses = SupplyExpense::whereBetween('purchase_date', [$dateFrom, $dateTo])->sum('value');
        $operationalExpenses = OperationalExpense::whereBetween('date', [$dateFrom, $dateTo])->sum('value');
        $freightCosts = Freight::whereBetween('departure_date', [$dateFrom, $dateTo])->sum('value');
        
        // Custos de frete das compras (se houver)
        $purchaseFreightCosts = $sales->sum(function($sale) {
            return $sale->animal && $sale->animal->purchase ? ($sale->animal->purchase->freight_cost ?? 0) : 0;
        });
        
        // Custos de comissão das compras (se houver)
        $purchaseCommissionCosts = $sales->sum(function($sale) {
            return $sale->animal && $sale->animal->purchase ? ($sale->animal->purchase->commission_value ?? 0) : 0;
        });
        
        // Cálculos totais
        $totalCosts = $totalPurchaseCosts + $supplyExpenses + $operationalExpenses + 
                     $freightCosts + $purchaseFreightCosts + $purchaseCommissionCosts;
        
        $netProfit = $totalSalesRevenue - $totalCosts;
        $profitMargin = $totalSalesRevenue > 0 ? ($netProfit / $totalSalesRevenue) * 100 : 0;
        
        // Dados por mês para gráfico
        $monthlyData = [];
        $startDate = Carbon::parse($dateFrom)->startOfMonth();
        $endDate = Carbon::parse($dateTo)->endOfMonth();
        
        while ($startDate <= $endDate) {
            $monthStart = $startDate->copy()->startOfMonth();
            $monthEnd = $startDate->copy()->endOfMonth();
            
            // Vendas do mês
            $monthlySales = Sale::with(['animal.purchase'])
                ->whereBetween('sale_date', [$monthStart, $monthEnd])
                ->get();
            
            $monthRevenue = $monthlySales->sum('value');
            
            // Custos do mês
            $monthPurchaseCosts = $monthlySales->sum(function($sale) {
                return $sale->animal && $sale->animal->purchase ? $sale->animal->purchase->value : 0;
            });
            
            $monthSupplyExpenses = SupplyExpense::whereBetween('purchase_date', [$monthStart, $monthEnd])->sum('value');
            $monthOperationalExpenses = OperationalExpense::whereBetween('date', [$monthStart, $monthEnd])->sum('value');
            $monthFreightCosts = Freight::whereBetween('departure_date', [$monthStart, $monthEnd])->sum('value');
            
            $monthTotalCosts = $monthPurchaseCosts + $monthSupplyExpenses + $monthOperationalExpenses + $monthFreightCosts;
            $monthProfit = $monthRevenue - $monthTotalCosts;
            
            $monthlyData[] = [
                'month' => $startDate->format('M/Y'),
                'revenue' => $monthRevenue,
                'costs' => $monthTotalCosts,
                'profit' => $monthProfit,
                'sales_count' => $monthlySales->count()
            ];
            
            $startDate->addMonth();
        }
        
        // Análise por categoria de animal (se houver)
        $profitByCategory = [];
        if ($sales->count() > 0) {
            $categories = $sales->groupBy(function($sale) {
                return $sale->animal && $sale->animal->category ? $sale->animal->category->name : 'Sem categoria';
            });
            
            foreach ($categories as $categoryName => $categorySales) {
                $categoryRevenue = $categorySales->sum('value');
                $categoryCosts = $categorySales->sum(function($sale) {
                    return $sale->animal && $sale->animal->purchase ? $sale->animal->purchase->value : 0;
                });
                
                $profitByCategory[] = [
                    'category' => $categoryName,
                    'revenue' => $categoryRevenue,
                    'costs' => $categoryCosts,
                    'profit' => $categoryRevenue - $categoryCosts,
                    'count' => $categorySales->count()
                ];
            }
        }
        
        // Top 5 vendas mais lucrativas
        $topProfitableSales = $sales->map(function($sale) {
            $purchaseValue = $sale->animal && $sale->animal->purchase ? $sale->animal->purchase->value : 0;
            $profit = $sale->value - $purchaseValue;
            
            return [
                'sale' => $sale,
                'profit' => $profit,
                'profit_margin' => $sale->value > 0 ? ($profit / $sale->value) * 100 : 0
            ];
        })->sortByDesc('profit')->take(5);
        
        // Animais em estoque (comprados mas não vendidos)
        $animalsInStock = Animal::whereHas('purchase')
            ->whereDoesntHave('sale')
            ->with(['purchase', 'category'])
            ->get();
            
        $stockValue = $animalsInStock->sum(function($animal) {
            return $animal->purchase ? $animal->purchase->value : 0;
        });
        
        return view('profit_loss.index', compact(
            'dateFrom', 
            'dateTo',
            'totalSalesRevenue',
            'totalCosts',
            'netProfit',
            'profitMargin',
            'monthlyData',
            'profitByCategory',
            'topProfitableSales',
            'animalsInStock',
            'stockValue',
            'sales',
            'supplyExpenses',
            'operationalExpenses',
            'freightCosts',
            'totalPurchaseCosts'
        ));
    }
}