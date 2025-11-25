<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Animal;
use App\Models\Purchase;
use App\Models\Sale;
use App\Models\SupplyExpense;
use App\Models\OperationalExpense;
use App\Models\Freight;
use App\Models\AnimalWeight;
use App\Models\Feeding;
use App\Models\Medication;
use Carbon\Carbon;

class ReportController extends Controller
{
    // Relatório de Animais
    public function animals(Request $request)
    {
        $query = Animal::with(['category', 'purchase', 'sale', 'weights', 'feedings', 'medications']);
        
        // Filtros
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        
        if ($request->filled('status')) {
            if ($request->status === 'ativo') {
                $query->whereDoesntHave('sale');
            } elseif ($request->status === 'vendido') {
                $query->whereHas('sale');
            }
        }
        
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }
        
        $animals = $query->paginate(15);
        
        // Estatísticas
        $stats = [
            'total_animals' => Animal::count(),
            'active_animals' => Animal::whereDoesntHave('sale')->count(),
            'sold_animals' => Animal::whereHas('sale')->count(),
            'average_weight' => AnimalWeight::avg('weight'),
            'total_weight' => AnimalWeight::sum('weight'),
        ];
        
        if ($request->input('export') === 'pdf') {
            return $this->exportAnimalsPDF($animals, $stats, $request);
        }
        
        return view('reports.animals', compact('animals', 'stats'));
    }
    
    // Relatório Financeiro
    public function financial(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth());
        $endDate = $request->input('end_date', now());
        
        // Receitas
        $sales = Sale::whereBetween('sale_date', [$startDate, $endDate])
                    ->with(['animal', 'buyer'])
                    ->get();
        $totalRevenue = $sales->sum('value');
        
        // Despesas
        $purchases = Purchase::whereBetween('purchase_date', [$startDate, $endDate])
                            ->with(['animal', 'vendor'])
                            ->get();
        $supplyExpenses = SupplyExpense::whereBetween('purchase_date', [$startDate, $endDate])
                                     ->with('animal')
                                     ->get();
        $operationalExpenses = OperationalExpense::whereBetween('date', [$startDate, $endDate])
                                                ->with('local')
                                                ->get();
        $freights = Freight::whereBetween('departure_date', [$startDate, $endDate])
                          ->with(['truckDriver', 'local'])
                          ->get();
        
        $totalPurchases = $purchases->sum('value');
        $totalSupplyExpenses = $supplyExpenses->sum('value');
        $totalOperationalExpenses = $operationalExpenses->sum('value');
        $totalFreights = $freights->sum('value');
        $totalExpenses = $totalPurchases + $totalSupplyExpenses + $totalOperationalExpenses + $totalFreights;
        
        $profitLoss = $totalRevenue - $totalExpenses;
        $profitMargin = $totalRevenue > 0 ? ($profitLoss / $totalRevenue) * 100 : 0;
        
        $data = [
            'period' => ['start' => $startDate, 'end' => $endDate],
            'revenue' => ['sales' => $sales, 'total' => $totalRevenue],
            'expenses' => [
                'purchases' => ['data' => $purchases, 'total' => $totalPurchases],
                'supplies' => ['data' => $supplyExpenses, 'total' => $totalSupplyExpenses],
                'operational' => ['data' => $operationalExpenses, 'total' => $totalOperationalExpenses],
                'freights' => ['data' => $freights, 'total' => $totalFreights],
                'total' => $totalExpenses
            ],
            'profit_loss' => $profitLoss,
            'profit_margin' => $profitMargin
        ];
        
        if ($request->input('export') === 'pdf') {
            return $this->exportFinancialPDF($data);
        }
        
        return view('reports.financial', $data);
    }
    
    // Relatório de Vendas
    public function sales(Request $request)
    {
        $query = Sale::with(['animal.category', 'buyer']);
        
        // Filtros
        if ($request->filled('buyer_id')) {
            $query->where('buyer_id', $request->buyer_id);
        }
        
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('sale_date', [$request->start_date, $request->end_date]);
        }
        
        if ($request->filled('min_value')) {
            $query->where('value', '>=', $request->min_value);
        }
        
        if ($request->filled('max_value')) {
            $query->where('value', '<=', $request->max_value);
        }
        
        $sales = $query->orderBy('sale_date', 'desc')->paginate(15);
        
        // Estatísticas
        $stats = [
            'total_sales' => $query->count(),
            'total_revenue' => $query->sum('value'),
            'average_sale_value' => $query->avg('value'),
            'best_sale' => $query->max('value'),
            'total_weight_sold' => $query->sum('weight_at_sale'),
        ];
        
        if ($request->input('export') === 'pdf') {
            return $this->exportSalesPDF($sales, $stats, $request);
        }
        
        return view('reports.sales', compact('sales', 'stats'));
    }
    
    // Relatório de Compras
    public function purchases(Request $request)
    {
        $query = Purchase::with(['animal.category', 'animal.animalWeights', 'vendor']);
        
        // Filtros
        if ($request->filled('vendor_id')) {
            $query->where('vendor_id', $request->vendor_id);
        }
        
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('purchase_date', [$request->start_date, $request->end_date]);
        }
        
        if ($request->filled('min_value')) {
            $query->where('value', '>=', $request->min_value);
        }
        
        if ($request->filled('max_value')) {
            $query->where('value', '<=', $request->max_value);
        }
        
        $purchases = $query->orderBy('purchase_date', 'desc')->paginate(15);
        
        // Estatísticas
        $stats = [
            'total_purchases' => $query->count(),
            'total_spent' => $query->sum('value'),
            'average_purchase_value' => $query->avg('value'),
            'highest_purchase' => $query->max('value'),
            'total_animals_purchased' => $query->whereNotNull('animal_id')->count(),
        ];
        
        if ($request->input('export') === 'pdf') {
            return $this->exportPurchasesPDF($purchases, $stats, $request);
        }
        
        return view('reports.purchases', compact('purchases', 'stats'));
    }
    
    // Relatório de Transportes
    public function transports(Request $request)
    {
        $query = Freight::with(['truckDriver', 'local']);
        
        // Filtros
        if ($request->filled('truck_driver_id')) {
            $query->where('truck_driver_id', $request->truck_driver_id);
        }
        
        if ($request->filled('local_id')) {
            $query->where('local_id', $request->local_id);
        }
        
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('departure_date', [$request->start_date, $request->end_date]);
        }
        
        $transports = $query->orderBy('departure_date', 'desc')->paginate(15);
        
        // Estatísticas
        $stats = [
            'total_transports' => $query->count(),
            'total_freight_cost' => $query->sum('value'),
            'total_animals_transported' => $query->sum('quantity_animals'),
            'average_cost_per_transport' => $query->avg('value'),
            'average_animals_per_transport' => $query->avg('quantity_animals'),
        ];
        
        if ($request->input('export') === 'pdf') {
            return $this->exportTransportsPDF($transports, $stats, $request);
        }
        
        return view('reports.transports', compact('transports', 'stats'));
    }
    
    // Relatório de Despesas
    public function expenses(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth());
        $endDate = $request->input('end_date', now());
        
        // Despesas por categoria
        $supplyExpenses = SupplyExpense::whereBetween('purchase_date', [$startDate, $endDate])
                                     ->with('animal')
                                     ->get();
        
        $operationalExpenses = OperationalExpense::whereBetween('date', [$startDate, $endDate])
                                                ->with('local')
                                                ->get();
        
        $freightExpenses = Freight::whereBetween('departure_date', [$startDate, $endDate])
                                 ->with(['truckDriver', 'local'])
                                 ->get();
        
        // Agrupamento por categoria
        $expensesByCategory = [
            'supply' => [
                'medicamento' => $supplyExpenses->where('category', 'medicamento')->sum('value'),
                'alimentacao' => $supplyExpenses->where('category', 'alimentacao')->sum('value'),
            ],
            'operational' => $operationalExpenses->sum('value'),
            'freight' => $freightExpenses->sum('value'),
        ];
        
        $totalExpenses = array_sum($expensesByCategory['supply']) + 
                        $expensesByCategory['operational'] + 
                        $expensesByCategory['freight'];
        
        $data = [
            'period' => ['start' => $startDate, 'end' => $endDate],
            'supply_expenses' => $supplyExpenses,
            'operational_expenses' => $operationalExpenses,
            'freight_expenses' => $freightExpenses,
            'expenses_by_category' => $expensesByCategory,
            'total_expenses' => $totalExpenses,
        ];
        
        if ($request->input('export') === 'pdf') {
            return $this->exportExpensesPDF($data);
        }
        
        return view('reports.expenses', $data);
    }
    
    // Métodos para exportar PDFs
    private function exportAnimalsPDF($animals, $stats, $request)
    {
        return view('reports.pdf.animals', compact('animals', 'stats', 'request'))
                  ->with('title', 'Relatório de Animais - ' . now()->format('d/m/Y'))
                  ->with('printable', true);
    }
    
    private function exportFinancialPDF($data)
    {
        return view('reports.pdf.financial', $data)
                  ->with('title', 'Relatório Financeiro - ' . now()->format('d/m/Y'))
                  ->with('printable', true);
    }
    
    private function exportSalesPDF($sales, $stats, $request)
    {
        return view('reports.pdf.sales', compact('sales', 'stats', 'request'))
                  ->with('title', 'Relatório de Vendas - ' . now()->format('d/m/Y'))
                  ->with('printable', true);
    }
    
    private function exportPurchasesPDF($purchases, $stats, $request)
    {
        return view('reports.pdf.purchases', compact('purchases', 'stats', 'request'))
                  ->with('title', 'Relatório de Compras - ' . now()->format('d/m/Y'))
                  ->with('printable', true);
    }
    
    private function exportTransportsPDF($transports, $stats, $request)
    {
        return view('reports.pdf.transports', compact('transports', 'stats', 'request'))
                  ->with('title', 'Relatório de Transportes - ' . now()->format('d/m/Y'))
                  ->with('printable', true);
    }
    
    private function exportExpensesPDF($data)
    {
        return view('reports.pdf.expenses', $data)
                  ->with('title', 'Relatório de Despesas - ' . now()->format('d/m/Y'))
                  ->with('printable', true);
    }
}