<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Validation\Rule;

class DriverController extends Controller
{
    /**
     * Liste des chauffeurs avec leurs véhicules (Eager Loading).
     */
    public function index(): View
    {
        // On récupère les chauffeurs du tenant actuel avec leur véhicule associé
        $drivers = Driver::with('vehicle')->latest()->get();

        return view('drivers.index', compact('drivers'));
    }

    /**
     * Formulaire de création.
     */
    public function create(): View
    {
        // On ne propose que les véhicules qui n'ont pas encore de chauffeur
        // pour éviter les doublons d'assignation.
        $availableVehicles = Vehicle::whereDoesntHave('driver')->get();

        return view('drivers.create', compact('availableVehicles'));
    }

    /**
     * Enregistrement d'un nouveau chauffeur.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'first_name'     => 'required|string|max:255',
            'last_name'      => 'required|string|max:255',
            'email'          => 'nullable|email|max:255',
            'phone'          => 'required|string|max:20',
            'license_number' => 'required|string|unique:drivers,license_number',
            'vehicle_id'     => [
                'nullable',
                Rule::exists('vehicles', 'id')->where(function ($query) {
                    // On s'assure que le véhicule appartient au tenant actuel
                    $query->where('tenant_id', tenant('id'));
                }),
            ],
        ]);

        Driver::create($validated);

        return redirect()->route('drivers.index')
            ->with('success', 'Chauffeur ajouté avec succès.');
    }

    /**
     * Formulaire d'édition.
     */
    public function edit(Driver $driver): View
    {
        // Pour l'édition, on propose les véhicules libres + celui déjà assigné à ce chauffeur
        $availableVehicles = Vehicle::whereDoesntHave('driver')
            ->orWhere('id', $driver->vehicle_id)
            ->get();

        return view('drivers.edit', compact('driver', 'availableVehicles'));
    }

    /**
     * Mise à jour du chauffeur.
     */
    public function update(Request $request, Driver $driver): RedirectResponse
    {
        $validated = $request->validate([
            'first_name'     => 'required|string|max:255',
            'last_name'      => 'required|string|max:255',
            'email'          => 'nullable|email|max:255',
            'phone'          => 'required|string|max:20',
            'license_number' => [
                'required',
                'string',
                // Important : on ignore l'ID actuel pour ne pas bloquer l'update
                Rule::unique('drivers')->ignore($driver->id),
            ],
            'status'         => 'required|in:available,on_mission,off_duty',
            'vehicle_id'     => 'nullable|exists:vehicles,id',
        ]);

        $driver->update($validated);

        return redirect()->route('drivers.index')
            ->with('success', "Le profil de {$driver->full_name} a été mis à jour.");
    }

    /**
     * Suppression.
     */
    public function destroy(Driver $driver): RedirectResponse
    {
        $driver->delete();

        return redirect()->route('drivers.index')
            ->with('success', 'Chauffeur supprimé de la flotte.');
    }
}