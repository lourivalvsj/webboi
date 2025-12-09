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
    Route::get('animals-bulk/create', [AnimalController::class, 'createBulk'])->name('animals.create-bulk');
    Route::post('animals-bulk', [AnimalController::class, 'storeBulk'])->name('animals.store-bulk');
    Route::resource('purchases', PurchaseController::class);
    Route::get('purchases-bulk/create', [PurchaseController::class, 'createBulk'])->name('purchases.create-bulk');
    Route::post('purchases-bulk', [PurchaseController::class, 'storeBulk'])->name('purchases.store-bulk');
    Route::resource('sales', SaleController::class);
    Route::get('sales-bulk/create', [SaleController::class, 'createBulk'])->name('sales.create-bulk');
    Route::post('sales-bulk', [SaleController::class, 'storeBulk'])->name('sales.store-bulk');
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
    Route::get('supply-expenses/{supplyExpense}/renew', [SupplyExpenseController::class, 'renew'])->name('supply-expenses.renew');
    Route::post('supply-expenses/{supplyExpense}/renew', [SupplyExpenseController::class, 'processRenewal'])->name('supply-expenses.process-renewal');
    Route::get('supply-expenses/{supplyExpense}/renewal-history', [SupplyExpenseController::class, 'renewalHistory'])->name('supply-expenses.renewal-history');
    Route::resource('operational-expenses', OperationalExpenseController::class);

    // 🆕 Rotas para recursos de saúde animal
    Route::resource('animal-weights', AnimalWeightController::class);
    Route::get('animal-weights-bulk/create', [AnimalWeightController::class, 'createBulk'])->name('animal-weights.create-bulk');
    Route::post('animal-weights-bulk', [AnimalWeightController::class, 'storeBulk'])->name('animal-weights.store-bulk');
    Route::resource('feedings', FeedingController::class);
    Route::get('feedings-bulk/create', [FeedingController::class, 'createBulk'])->name('feedings.create-bulk');
    Route::post('feedings-bulk', [FeedingController::class, 'storeBulk'])->name('feedings.store-bulk');
    Route::resource('medications', MedicationController::class);
    Route::get('medications-bulk/create', [MedicationController::class, 'createBulk'])->name('medications.create-bulk');
    Route::post('medications-bulk', [MedicationController::class, 'storeBulk'])->name('medications.store-bulk');

    // 💀 Registro de Óbitos dos Animais
    Route::resource('animal-deaths', App\Http\Controllers\AnimalDeathController::class);
    Route::patch('animals/{animal}/revive', [App\Http\Controllers\AnimalDeathController::class, 'revive'])->name('animals.revive');

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
        Route::get('/feeding-expenses', [ReportController::class, 'feedingExpenses'])->name('feeding_expenses');
        Route::get('/medication-expenses', [ReportController::class, 'medicationExpenses'])->name('medication_expenses');
    });

    // Rotas para gerenciamento de cidades
    Route::get('/cities/by-uf', [CityController::class, 'getCitiesByUf'])->name('cities.by-uf');
    Route::post('/cities', [CityController::class, 'store'])->name('cities.store');
    Route::get('/cities/search', [CityController::class, 'search'])->name('cities.search');
});

require __DIR__.'/auth.php';
