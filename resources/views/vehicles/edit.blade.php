@extends('layouts.tabler')

@section('content')
<div class="container-xl">
    <div class="page-header d-print-none">
        <h2 class="page-title">Modifier le véhicule : {{ $vehicle->name }}</h2>
    </div>

    <div class="row row-cards mt-3">
        <div class="col-md-8">
            <form action="{{ route('vehicles.update', $vehicle) }}" method="POST" class="card">
                @csrf
                @method('PATCH')
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label required">Nom</label>
                        <input type="text" name="name" class="form-control" value="{{ $vehicle->name }}" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label required">Modèle</label>
                                <input type="text" name="model" class="form-control" value="{{ $vehicle->model }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label required">Plaque</label>
                                <input type="text" name="plate_number" class="form-control" value="{{ $vehicle->plate_number }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Statut</label>
                        <select name="status" class="form-select">
                            <option value="disponible" {{ $vehicle->status == 'disponible' ? 'selected' : '' }}>Disponible</option>
                            <option value="en_route" {{ $vehicle->status == 'en_route' ? 'selected' : '' }}>En mission</option>
                            <option value="maintenance" {{ $vehicle->status == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                        </select>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-outline-danger" onclick="if(confirm('Supprimer ce véhicule ?')) document.getElementById('delete-form').submit();">
                        Supprimer
                    </button>
                    <button type="submit" class="btn btn-primary">Mettre à jour</button>
                </div>
            </form>

            <form id="delete-form" action="{{ route('vehicles.destroy', $vehicle) }}" method="POST" style="display: none;">
                @csrf
                @method('DELETE')
            </form>
        </div>
    </div>
</div>
@endsection