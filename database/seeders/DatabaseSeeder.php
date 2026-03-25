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


        $tenants = ['alpha', 'beta'];

        foreach ($tenants as $id) {
            $tenant = \App\Models\Tenant::find($id);
            
            // On crée des véhicules pour chaque client
            \App\Models\Vehicle::create([
                'tenant_id' => $tenant->id,
                'name' => 'Ford Transit',
                'model' => 'Camionnette Blanche 2016',
                'plate_number' => 'ABC-123-' . $id,
                'status' => 'disponible',
            ]);

            \App\Models\Vehicle::create([
                'tenant_id' => $tenant->id,
                'name' => 'Toyota RAV4',
                'model' => 'SUV Logistique',
                'plate_number' => 'XYZ-789-' . $id,
                'status' => 'en_route',
            ]);
            
            \App\Models\Vehicle::create([
                'tenant_id' => $tenant->id,
                'name' => 'Nissan Sentra',
                'model' => 'Berline Liaison',
                'plate_number' => 'CAM-456-' . $id,
                'status' => 'maintenance',
            ]);
        }
    }
}
