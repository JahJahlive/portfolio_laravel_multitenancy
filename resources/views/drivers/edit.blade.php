@extends('layouts.tabler')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">Modifier le chauffeur : {{ $driver->full_name }}</h2>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        <form action="{{ route('drivers.update', $driver) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Prénom</label>
                            <input type="text" name="first_name" class="form-control" value="{{ old('first_name', $driver->first_name) }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nom de famille</label>
                            <input type="text" name="last_name" class="form-control" value="{{ old('last_name', $driver->last_name) }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Numéro de téléphone</label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone', $driver->phone) }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Numéro de licence (Permis)</label>
                            <input type="text" name="license_number" class="form-control" value="{{ old('license_number', $driver->license_number) }}" required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Statut opérationnel</label>
                            <select name="status" class="form-select">
                                <option value="available" {{ $driver->status == 'available' ? 'selected' : '' }}>Disponible</option>
                                <option value="on_mission" {{ $driver->status == 'on_mission' ? 'selected' : '' }}>En mission</option>
                                <option value="off_duty" {{ $driver->status == 'off_duty' ? 'selected' : '' }}>En repos / Congé</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Véhicule assigné</label>
                            <select name="vehicle_id" class="form-select">
                                <option value="">-- Aucun véhicule --</option>
                                @foreach($availableVehicles as $vehicle)
                                    <option value="{{ $vehicle->id }}" {{ $driver->vehicle_id == $vehicle->id ? 'selected' : '' }}>
                                        {{ $vehicle->name }} ({{ $vehicle->plate_number }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex">
                    <a href="{{ route('drivers.index') }}" class="btn btn-link">Annuler</a>
                    <button type="submit" class="btn btn-primary ms-auto">Enregistrer les modifications</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection