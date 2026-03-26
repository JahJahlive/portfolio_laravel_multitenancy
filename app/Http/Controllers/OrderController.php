<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Driver;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use \App\Enums\DriverStatus;
use \App\Enums\VehicleStatus;

class OrderController extends Controller
{
    /**
     * Formulaire d'assignation
     */
    public function showAssignForm(Order $order)
    {
        // On ne propose que ceux qui sont réellement disponibles
        $drivers = Driver::where('status', 'available')->get();
        $vehicles = Vehicle::whereDoesntHave('driver', function($q) use ($order) {
            // Logique optionnelle : exclure les véhicules en maintenance
        })->get();

        return view('orders.assign', compact('order', 'drivers', 'vehicles'));
    }

    /**
     * Logique d'assignation (POST)
     */
    public function assign(Request $request, Order $order)
    {
        $validated = $request->validate([
            'driver_id'  => 'required|exists:drivers,id',
            'vehicle_id' => 'required|exists:vehicles,id',
        ]);

       DB::transaction(function () use ($validated, $order) {
            $order->update([
                'driver_id'  => $validated['driver_id'],
                'vehicle_id' => $validated['vehicle_id'],
                'status'     => 'assigned'
            ]);

            // Utilisation des Enums : Propre, Lisible, Robuste
            $order->driver->update(['status' => DriverStatus::ON_MISSION]);
            $order->vehicle->update(['status' => VehicleStatus::ON_MISSION]);
        });

        return redirect()->route('orders.index')
            ->with('success', "Mission assignée avec succès à l'équipe.");
    }
}