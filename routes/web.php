<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnimalController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\BuyerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AnimalWeightController;
use App\Http\Controllers\FeedingController;
use App\Http\Controllers\MedicationController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\TruckDriverController;
use App\Http\Controllers\FreightController;
use App\Http\Controllers\LocalController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\SupplyExpenseController;
use App\Http\Controllers\OperationalExpenseController;
use App\Http\Controllers\ProfitLossController;
use App\Http\Controllers\ReportController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('animals', AnimalController::class);
    Route::resource('purchases', PurchaseController::class);
    Route::resource('sales', SaleController::class);
    Route::resource('vendors', VendorController::class);
    Route::resource('buyers', BuyerController::class);
    Route::resource('categories', CategoryController::class);

    // Route::resource('ufs', UfController::class); // Removido - usando helper LocationHelper
    // Route::resource('cities', CityController::class); // Removido - usando helper LocationHelper
    Route::resource('truck-drivers', TruckDriverController::class);
    Route::resource('freights', FreightController::class);
    Route::resource('locals', LocalController::class);
    Route::resource('schedules', ScheduleController::class);
    Route::resource('supply-expenses', SupplyExpenseController::class);
    Route::resource('operational-expenses', OperationalExpenseController::class);

    // 🆕 Rotas para recursos de saúde animal
    Route::resource('animal-weights', AnimalWeightController::class);
    Route::resource('feedings', FeedingController::class);
    Route::resource('medications', MedicationController::class);

    // 💰 Dashboard Financeiro - Lucro/Prejuízo
    Route::get('/profit-loss', [ProfitLossController::class, 'index'])->name('profit-loss.index');
    Route::get('/profit-loss/period', [ProfitLossController::class, 'profitByPeriod'])->name('profit-loss.period');
    Route::get('/profit-loss/expenses', [ProfitLossController::class, 'expensesSummary'])->name('profit-loss.expenses');
    Route::get('/profit-loss/monthly', [ProfitLossController::class, 'monthlyComparison'])->name('profit-loss.monthly');
    Route::get('/profit-loss/yearly', [ProfitLossController::class, 'yearlyComparison'])->name('profit-loss.yearly');
    Route::get('/profit-loss/top-animals', [ProfitLossController::class, 'topProfitableAnimals'])->name('profit-loss.top-animals');

    // 📊 Relatórios
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/animals', [ReportController::class, 'animals'])->name('animals');
        Route::get('/financial', [ReportController::class, 'financial'])->name('financial');
        Route::get('/sales', [ReportController::class, 'sales'])->name('sales');
        Route::get('/purchases', [ReportController::class, 'purchases'])->name('purchases');
        Route::get('/transports', [ReportController::class, 'transports'])->name('transports');
        Route::get('/expenses', [ReportController::class, 'expenses'])->name('expenses');
    });

    // Rotas para gerenciamento de cidades
    Route::get('/cities/by-uf', [CityController::class, 'getCitiesByUf'])->name('cities.by-uf');
    Route::post('/cities', [CityController::class, 'store'])->name('cities.store');
    Route::get('/cities/search', [CityController::class, 'search'])->name('cities.search');
});

require __DIR__.'/auth.php';
