<?php

namespace Database\Seeders;

use App\Models\{User, Tenant, Vehicle, Driver, Order};
use App\Enums\{VehicleStatus, DriverStatus};
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Super Admin
        User::firstOrCreate(['email' => 'admin@logistics.test'], [
            'name' => 'Yannick Admin',
            'password' => bcrypt('password'),
            'tenant_id' => null,
        ]);

        foreach (['alpha', 'beta'] as $id) {
            $tenant = Tenant::firstOrCreate(['id' => $id]);
            $tenant->domains()->firstOrCreate(['domain' => $id . '.logistics.test']);

            // 2. Accès Tenant
            User::create([
                'name' => "Gestionnaire " . ucfirst($id),
                'email' => $id . "@logistics.test",
                'password' => bcrypt('password'),
                'tenant_id' => $tenant->id,
            ]);

            // 3. Flotte (Correction: champ 'model' inclus)
            $v1 = Vehicle::create([
                'tenant_id' => $tenant->id,
                'name' => 'Ford Transit #1',
                'model' => 'T-350 High Roof',
                'plate_number' => 'FT-01-' . strtoupper($id),
                'status' => VehicleStatus::AVAILABLE
            ]);

            $vehicles = collect([$v1]);

            // 4. Chauffeurs (Correction: champs 'phone' et 'license_number' inclus)
            $drivers = collect([
                [
                    'fn' => 'Jean', 
                    'ln' => 'Dupont', 
                    'ph' => '514-555-0101', 
                    'lic' => 'QUE-'.strtoupper($id).'-889'
                ],
                [
                    'fn' => 'Marc', 
                    'ln' => 'Tremblay', 
                    'ph' => '514-555-0102', 
                    'lic' => 'QUE-'.strtoupper($id).'-990'
                ]
            ])->map(fn($d) => Driver::create([
                'tenant_id' => $tenant->id,
                'first_name' => $d['fn'],
                'last_name' => $d['ln'],
                'phone' => $d['ph'],
                'license_number' => $d['lic'], // Ajout pour respecter ta migration
                'status' => 'available',
                'vehicle_id' => $v1->id // Optionnel : assignation directe au camion
            ]));

            // 5. Missions (Logique anti-contradiction)
            for ($i = 10; $i >= 0; $i--) {
                $date = Carbon::now()->subDays($i);
                for ($j = 0; $j < rand(2, 4); $j++) {
                    $status = ($i > 0) ? 'completed' : fake()->randomElement(['pending', 'assigned']);
                    $isAssigned = in_array($status, ['assigned', 'completed']);

                    Order::create([
                        'tenant_id' => $tenant->id,
                        'customer_name' => 'Client ' . fake()->lastName(),
                        'origin_address' => fake()->streetAddress() . ', Montréal',
                        'destination_address' => fake()->streetAddress() . ', LaSalle',
                        'pickup_time' => $date->copy()->setHour(rand(8, 17)),
                        'price' => rand(200, 800),
                        'status' => $status,
                        'vehicle_id' => $isAssigned ? $v1->id : null,
                        'driver_id'  => $isAssigned ? $drivers->random()->id : null,
                        'created_at' => $date,
                    ]);
                }
            }
        }
    }
}