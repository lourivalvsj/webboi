<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::resource('categorys', \App\Http\Controllers\CategoryController::class);
//Route::resource('categorys', \App\Http\Controllers\CategoryController::class)->middleware('auth');

Route::prefix('admin')->group(function (){
    Route::resource('purchase', \App\Http\Controllers\GenreController::class);
});

require __DIR__.'/auth.php';
