@extends('layouts.tabler')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Nouvelle Mission</h2>

    <form action="{{ route('orders.store') }}" method="POST">
        @csrf
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nom du Client</label>
                        <input type="text" name="customer_name" class="form-control" required>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label">Prix ($)</label>
                        <input type="number" step="0.01" name="price" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Adresse de Départ (Montréal/LaSalle)</label>
                        <input type="text" name="origin_address" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Adresse de Destination</label>
                        <input type="text" name="destination_address" class="form-control" required>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">Heure de ramassage</label>
                        <input type="datetime-local" name="pickup_time" class="form-control" required>
                    </div>

                    <hr>

                    <div class="col-md-6">
                        <label class="form-label">Assigner un Chauffeur (Optionnel)</label>
                        <select name="driver_id" class="form-select">
                            <option value="">Laisser en attente</option>
                            @foreach($availableDrivers as $driver)
                                <option value="{{ $driver->id }}">{{ $driver->first_name }} {{ $driver->last_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Assigner un Véhicule (Optionnel)</label>
                        <select name="vehicle_id" class="form-select">
                            <option value="">Aucun véhicule</option>
                            @foreach($availableVehicles as $vehicle)
                                <option value="{{ $vehicle->id }}">{{ $vehicle->name }} ({{ $vehicle->plate_number }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-end gap-2">
                <a href="{{ route('orders.index') }}" class="btn btn-secondary">Annuler</a>
                <button type="submit" class="btn btn-primary">Créer la Mission</button>
            </div>
        </div>
    </form>
</div>
@endsection