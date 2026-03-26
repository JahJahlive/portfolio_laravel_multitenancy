@extends('layouts.tabler')

@section('content')
<div class="card">
    <div class="card-header"><h3 class="card-title">Nouveau Chauffeur</h3></div>
    <form action="{{ route('drivers.store') }}" method="POST">
        @csrf
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Prénom</label>
                    <input type="text" name="first_name" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nom</label>
                    <input type="text" name="last_name" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Téléphone</label>
                    <input type="text" name="phone" class="form-control">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Numéro de Licence</label>
                    <input type="text" name="license_number" class="form-control" placeholder="ABC-12345" required>
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label">Assigner un véhicule (Optionnel)</label>
                    <select name="vehicle_id" class="form-select">
                        <option value="">-- Aucun --</option>
                        @foreach($availableVehicles as $vehicle)
                            <option value="{{ $vehicle->id }}">{{ $vehicle->name }} ({{ $vehicle->plate_number }})</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="card-footer text-end">
            <button type="submit" class="btn btn-primary">Enregistrer le chauffeur</button>
        </div>
    </form>
</div>
@endsection