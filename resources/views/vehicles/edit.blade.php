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
                    {{-- Nom --}}
                    <div class="mb-3">
                        <label class="form-label required">Nom</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                               value="{{ old('name', $vehicle->name) }}" required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="row">
                        {{-- Modèle --}}
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label required">Modèle</label>
                                <input type="text" name="model" class="form-control @error('model') is-invalid @enderror" 
                                       value="{{ old('model', $vehicle->model) }}" required>
                                @error('model') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        {{-- Plaque --}}
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label required">Plaque</label>
                                <input type="text" name="plate_number" class="form-control @error('plate_number') is-invalid @enderror" 
                                       value="{{ old('plate_number', $vehicle->plate_number) }}" required>
                                @error('plate_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Statut (Correction des valeurs) --}}
                    <div class="mb-3">
                        <label class="form-label">Statut</label>
                        <select name="status" class="form-select @error('status') is-invalid @enderror">
                            {{-- On compare avec ->value de l'enum --}}
                            <option value="available" {{ old('status', $vehicle->status->value) == 'available' ? 'selected' : '' }}>Disponible</option>
                            <option value="on_mission" {{ old('status', $vehicle->status->value) == 'on_mission' ? 'selected' : '' }}>En mission</option>
                            <option value="maintenance" {{ old('status', $vehicle->status->value) == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                        </select>
                        @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="card-footer d-flex justify-content-between">
                    {{-- Bouton Supprimer --}}
                    <button type="button" class="btn btn-outline-danger" 
                            onclick="if(confirm('Supprimer définitivement ce véhicule de la flotte ?')) document.getElementById('delete-form').submit();">
                        Supprimer
                    </button>
                    
                    <div class="d-flex">
                        <a href="{{ route('vehicles.index') }}" class="btn btn-link">Annuler</a>
                        <button type="submit" class="btn btn-primary">Mettre à jour</button>
                    </div>
                </div>
            </form>

            {{-- Formulaire de suppression caché --}}
            <form id="delete-form" action="{{ route('vehicles.destroy', $vehicle) }}" method="POST" style="display: none;">
                @csrf
                @method('DELETE')
            </form>
        </div>
    </div>
</div>
@endsection