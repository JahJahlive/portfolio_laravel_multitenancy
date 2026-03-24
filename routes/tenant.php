<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;

Route::middleware([
    'web',
    \Stancl\Tenancy\Middleware\InitializeTenancyByDomain::class,
    \Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains::class,
])->group(function () {

    // Page d'accueil du Tenant (ex: alpha.logistics.test)
    Route::get('/', function () {
        return view("welcome");
    });

    require __DIR__.'/auth.php';

    // Dashboard protégé
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');

});
