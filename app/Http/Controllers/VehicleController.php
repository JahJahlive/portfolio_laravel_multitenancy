<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicle;

class VehicleController extends Controller
{
    public function index()
    {
        // Ne retournera QUE les véhicules du client actuel
        $vehicles = Vehicle::all(); 
        return view('vehicles.index', compact('vehicles'));
    }

    public function create()
    {
        return view('vehicles.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'plate_number' => 'required|string|unique:vehicles,plate_number',
            'status' => 'required|in:available,on_mission,maintenance'
        ]);

        \App\Models\Vehicle::create($validated);

        return redirect()->route('vehicles.index')->with('success', 'Véhicule ajouté avec succès !');
    }

    public function edit(Vehicle $vehicle)
    {
        return view('vehicles.edit', compact('vehicle'));
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        if ($vehicle->tenant_id !== tenant('id')) {
            abort(404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'plate_number' => 'required|string|unique:vehicles,plate_number,' . $vehicle->id,
            'status' => 'required|in:available,on_mission,maintenance',
        ]);

        $vehicle->update($validated);

        return redirect()->route('vehicles.index')->with('success', 'Véhicule mis à jour.');
    }

    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();
        return redirect()->route('vehicles.index')->with('success', 'Véhicule supprimé.');
    }
}
