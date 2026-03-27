<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Driver;
use App\Models\Vehicle;
use App\Enums\OrderStatus; // Hypothèse : tu as créé cet Enum
use App\Enums\DriverStatus;
use App\Enums\VehicleStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class OrderController extends Controller
{
    /**
     * Liste des commandes du tenant actuel.
     */
    public function index(): View
    {
        $orders = Order::with(['driver', 'vehicle'])
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    /**
     * Formulaire de création d'une nouvelle mission.
     */
    public function create(): View
    {
        // On ne propose que les ressources prêtes à travailler
        $availableDrivers = Driver::where('status', DriverStatus::AVAILABLE)->get();
        $availableVehicles = Vehicle::where('status', VehicleStatus::AVAILABLE)->get();

        return view('orders.create', compact('availableDrivers', 'availableVehicles'));
    }

    /**
     * Enregistrement d'une commande avec assignation immédiate (Transactionnelle).
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'origin_address' => 'required|string',
            'destination_address' => 'required|string',
            'pickup_time' => 'required|date',
            'driver_id' => 'nullable|exists:drivers,id',
            'vehicle_id' => 'nullable|exists:vehicles,id',
            'price' => 'nullable|numeric|min:0',
        ]);

        try {
            DB::transaction(function () use ($validated, $request) {
                // 1. Création de la commande
                $order = Order::create(array_merge($validated, [
                    'status' => $request->filled('driver_id') ? 'assigned' : 'pending'
                ]));

                // 2. Mise à jour du Chauffeur si assigné
                if ($order->driver_id) {
                    Driver::where('id', $order->driver_id)->update([
                        'status' => DriverStatus::ON_MISSION
                    ]);
                }

                // 3. Mise à jour du Véhicule si assigné
                if ($order->vehicle_id) {
                    Vehicle::where('id', $order->vehicle_id)->update([
                        'status' => VehicleStatus::ON_MISSION
                    ]);
                }
            });

            return redirect()->route('orders.index')
                ->with('success', 'Mission créée avec succès.');

        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Erreur lors de la création : ' . $e->getMessage());
        }
    }

    /**
     * Formulaire d'assignation pour une commande en attente (Pending).
     */
    public function showAssignForm(Order $order): View
    {
        $drivers = Driver::where('status', DriverStatus::AVAILABLE)->get();
        $vehicles = Vehicle::where('status', VehicleStatus::AVAILABLE)->get();

        return view('orders.assign', compact('order', 'drivers', 'vehicles'));
    }

    /**
     * Logique d'assignation a posteriori (POST).
     */
    public function assign(Request $request, Order $order): RedirectResponse
    {
        $validated = $request->validate([
            'driver_id'  => 'required|exists:drivers,id',
            'vehicle_id' => 'required|exists:vehicles,id',
        ]);

        DB::transaction(function () use ($validated, $order) {
            // Mise à jour de la commande
            $order->update([
                'driver_id'  => $validated['driver_id'],
                'vehicle_id' => $validated['vehicle_id'],
                'status'     => 'assigned'
            ]);

            // Mise à jour des statuts via Enums
            Driver::where('id', $order->driver_id)->update(['status' => DriverStatus::ON_MISSION]);
            Vehicle::where('id', $order->vehicle_id)->update(['status' => VehicleStatus::ON_MISSION]);
        });

        return redirect()->route('orders.index')
            ->with('success', "Ressources assignées à la mission {$order->id}.");
    }

    /**
     * Finaliser une mission (Libère le chauffeur et le véhicule).
     */
    public function complete(Order $order): RedirectResponse
    {
        DB::transaction(function () use ($order) {
            $order->update(['status' => 'completed']);

            if ($order->driver_id) {
                Driver::where('id', $order->driver_id)->update(['status' => DriverStatus::AVAILABLE]);
            }

            if ($order->vehicle_id) {
                Vehicle::where('id', $order->vehicle_id)->update(['status' => VehicleStatus::AVAILABLE]);
            }
        });

        return redirect()->route('orders.index')->with('success', 'Mission terminée et ressources libérées.');
    }

    /**
     * Affiche le formulaire d'édition d'une commande.
     */
    public function edit(Order $order)
    {
        // On récupère les ressources disponibles au cas où on voudrait réassigner
        $drivers = Driver::all(); 
        $vehicles = Vehicle::all();

        return view('orders.edit', compact('order', 'drivers', 'vehicles'));
    }

    /**
     * Met à jour la commande en base de données.
     */
    public function update(Request $request, Order $order): RedirectResponse
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'origin_address' => 'required|string',
            'destination_address' => 'required|string',
            'pickup_time' => 'required|date',
            'price' => 'nullable|numeric',
            'status' => 'required|string',
            'driver_id' => 'nullable|exists:drivers,id',
            'vehicle_id' => 'nullable|exists:vehicles,id',
        ]);

        DB::transaction(function () use ($validated, $order) {
            // 1. Si le véhicule a changé, on gère les statuts de la flotte
            if ($order->vehicle_id != $validated['vehicle_id']) {
                
                // Libérer l'ancien véhicule s'il y en avait un
                if ($order->vehicle_id) {
                    Vehicle::where('id', $order->vehicle_id)->update(['status' => VehicleStatus::AVAILABLE]);
                }

                // Occuper le nouveau véhicule
                if ($validated['vehicle_id']) {
                    Vehicle::where('id', $validated['vehicle_id'])->update(['status' => VehicleStatus::ON_MISSION]);
                }
            }

            // 2. Faire de même pour le chauffeur si nécessaire
            if ($order->driver_id != $validated['driver_id']) {
                if ($order->driver_id) {
                    Driver::where('id', $order->driver_id)->update(['status' => DriverStatus::AVAILABLE]);
                }
                if ($validated['driver_id']) {
                    Driver::where('id', $validated['driver_id'])->update(['status' => DriverStatus::ON_MISSION]);
                }
            }

            // 3. Appliquer les changements à la commande
            $order->update($validated);
        });

        return redirect()->route('orders.index')
            ->with('success', 'La commande et les ressources ont été mises à jour.');
    }
}