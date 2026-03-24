<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
 public function run(): void
    {
        // 1. CRÉER L'ADMINISTRATEUR DE L'AGENCE (Central)
        // On ne lui donne pas de tenant_id (ou on le met à null)
        \App\Models\User::firstOrCreate(
            ['email' => 'yannick@logistics.test'], // Ton email pro
            [
                'name' => 'Yannick Kobe (Agence Admin)',
                'password' => bcrypt('password'),
                'tenant_id' => null, // Important : l'admin central n'appartient à aucun client
            ]
        );

        // 2. LISTE DES TENANTS À CRÉER
        $tenants = ['alpha', 'beta', 'ceta', 'delta'];

        foreach ($tenants as $id) {
            // Créer le client
            $tenant = \App\Models\Tenant::firstOrCreate(['id' => $id]);

            // Créer le domaine associé
            $tenant->domains()->firstOrCreate([
                'domain' => $id . '.logistics.test'
            ]);

            // 3. CRÉER L'ADMINISTRATEUR DU TENANT
            \App\Models\User::firstOrCreate(
                ['email' => "admin@{$id}.com"],
                [
                    'name' => "Admin " . ucfirst($id),
                    'password' => bcrypt('password'),
                    'tenant_id' => $tenant->id, // Lié au client spécifique
                ]
            );
        }
}
}
