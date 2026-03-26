<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\DriverController;


Route::get('/', function () { return view("welcome"); })->name('home');
Route::get('/dashboard', function () {  return view('dashboard'); })->middleware(['auth', 'verified'])->name('dashboard_tenant');

Route::middleware(['auth'])->group(function () {
     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('vehicles', VehicleController::class);
    Route::resource('drivers', DriverController::class);
});

require __DIR__.'/auth.php';