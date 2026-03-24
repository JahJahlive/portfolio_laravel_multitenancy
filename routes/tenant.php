<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {
    
    // Page d'accueil du Tenant (ex: alpha.logistics.test)
    Route::get('/', function () {
        dd('Tenant ID: ' . tenant('id')); // Affiche l'ID du Tenant pour vérification
        return 'Bienvenue dans votre espace logistique : ' . tenant('id');
    });

    // Importation des routes d'authentification de Breeze
    // Elles seront automatiquement isolées par Tenant
    require __DIR__.'/auth.php';

    // Dashboard protégé
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');
});