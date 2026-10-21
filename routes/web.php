<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GestanteController;
use App\Http\Controllers\ConsultaController;
use App\Http\Controllers\ExameController;
use App\Http\Controllers\OrientacaoController;
use App\Http\Controllers\HomeController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware(['auth', 'verified']);

Route::resource('/consulta', ConsultaController::class)->middleware(['auth', 'verified']);
Route::get('/report/consulta', [ConsultaController::class, 'report'])->name('report.consulta')->middleware(['auth', 'verified']);

Route::resource('/gestante', GestanteController::class)->middleware(['auth', 'verified']);
Route::get('/report/gestante', [GestanteController::class, 'report'])->name('report.gestante')->middleware(['auth', 'verified']);
Route::patch('/gestante/{id}/status', [GestanteController::class, 'updateStatus'])->name('gestante.status')->middleware(['auth', 'verified']);

Route::resource('/exame', ExameController::class)->middleware(['auth', 'verified']);
Route::get('/report/exame', [ExameController::class, 'report'])->name('report.exame')->middleware(['auth', 'verified']);
Route::put('/exame/{id}/upload', [ExameController::class, 'uploadDocumento'])->name('exame.upload')->middleware(['auth', 'verified']);

Route::resource('/orientacao', OrientacaoController::class)->middleware(['auth', 'verified']);


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
