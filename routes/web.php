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

    // 🆕 Rotas para recursos de saúde animal
    Route::resource('animal-weights', AnimalWeightController::class);
    Route::resource('feedings', FeedingController::class);
    Route::resource('medications', MedicationController::class);
});

require __DIR__.'/auth.php';
