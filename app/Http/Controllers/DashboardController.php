<?php

namespace App\Http\Controllers;

use App\Models\{Order, Vehicle, Driver};
use App\Enums\{VehicleStatus, DriverStatus};
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Génération des jours (Labels pour le graphique)
        $labels = collect(range(6, 0))->map(fn($i) => now()->subDays($i)->format('d M'));
        
        // 2. Données des commandes (Counts)
        $orderData = collect(range(6, 0))->map(fn($i) => 
            Order::whereDate('created_at', now()->subDays($i))->count()
        );

        // 3. Données financières (Revenus)
        $revenueData = collect(range(6, 0))->map(fn($i) => 
            Order::whereDate('created_at', now()->subDays($i))
                ->where('status', 'completed')
                ->sum('price')
        );

        // 4. Statistiques globales
        $stats = [
            'vehicles_on_mission' => Vehicle::where('status', VehicleStatus::ON_MISSION)->count(),
            'vehicles_available'  => Vehicle::where('status', VehicleStatus::AVAILABLE)->count(),
            'drivers_available'   => Driver::where('status', DriverStatus::AVAILABLE)->count(),
            'pending_orders'      => Order::where('status', 'pending')->count(),
        ];

        // 5. Dernières missions (Variable $recentOrders manquante)
        $recentOrders = Order::with(['vehicle', 'driver'])->latest()->take(5)->get();

        return view('dashboard', compact('labels', 'orderData', 'revenueData', 'stats', 'recentOrders'));
    }
}