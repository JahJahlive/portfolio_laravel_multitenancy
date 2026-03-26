<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Tenant;
use App\Models\Vehicle;
use App\Models\Driver;
use App\Enums\VehicleStatus;
use App\Enums\DriverStatus;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // 1. ADMIN CENTRAL (Agence)
        User::firstOrCreate(
            ['email' => 'yannick@logistics.test'],
            [
                'name' => 'Yannick Kobe',
                'password' => bcrypt('password'),
                'tenant_id' => null,
            ]
        );

        // 2. LISTE DES CLIENTS (Tenants)
        $tenants = ['alpha', 'beta'];

        foreach ($tenants as $id) {
            $tenant = Tenant::firstOrCreate(['id' => $id]);

            $tenant->domains()->firstOrCreate([
                'domain' => $id . '.logistics.test'
            ]);

            // Admin du client
            User::firstOrCreate(
                ['email' => "admin@{$id}.com"],
                [
                    'name' => "Admin " . ucfirst($id),
                    'password' => bcrypt('password'),
                    'tenant_id' => $tenant->id,
                ]
            );

            // 3. CRÉATION DE LA FLOTTE HARMONISÉE
            // Véhicule 1 : Disponible
            $v1 = Vehicle::create([
                'tenant_id'    => $tenant->id,
                'name'         => 'Ford Transit',
                'model'        => 'Fourgon Blanc 2016',
                'plate_number' => 'FT-' . strtoupper($id) . '-001',
                'status'       => VehicleStatus::AVAILABLE, // Utilisation de l'Enum
            ]);

            // Véhicule 2 : En mission
            $v2 = Vehicle::create([
                'tenant_id'    => $tenant->id,
                'name'         => 'RAM ProMaster',
                'model'        => 'Camion Déménagement',
                'plate_number' => 'RAM-' . strtoupper($id) . '-002',
                'status'       => VehicleStatus::ON_MISSION,
            ]);

            // 4. CRÉATION DES CHAUFFEURS (Pour tester tes relations)
            Driver::create([
                'tenant_id'      => $tenant->id,
                'vehicle_id'     => $v1->id, // Assigné au Transit
                'first_name'     => 'Jean',
                'last_name'      => 'Dupont',
                'phone'          => '514-000-0000',
                'license_number' => 'LIC-' . $id . '-1',
                'status'         => DriverStatus::AVAILABLE,
            ]);

            Driver::create([
                'tenant_id'      => $tenant->id,
                'vehicle_id'     => $v2->id, // Assigné au RAM
                'first_name'     => 'Marc',
                'last_name'      => 'Tremblay',
                'phone'          => '514-999-9999',
                'license_number' => 'LIC-' . $id . '-2',
                'status'         => DriverStatus::ON_MISSION,
            ]);
        }
    }
}