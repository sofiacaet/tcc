<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GestanteController;
use App\Http\Controllers\DietaController;
use App\Http\Controllers\PlanoController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return view('home');
})->name('home')->middleware(['auth', 'verified']);

Route::resource('/dieta', DietaController::class)->middleware(['auth', 'verified']);
Route::get('/report/dieta', [DietaController::class, 'report'])->name('report.dieta')->middleware(['auth', 'verified']);

Route::resource('/gestante', GestanteController::class)->middleware(['auth', 'verified']);
Route::get('/report/gestante', [GestanteController::class, 'report'])->name('report.gestante')->middleware(['auth', 'verified']);

Route::resource('/plano', PlanoController::class)->middleware(['auth', 'verified']);
Route::get('/report/plano', [PlanoController::class, 'report'])->name('report.plano')->middleware(['auth', 'verified']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
