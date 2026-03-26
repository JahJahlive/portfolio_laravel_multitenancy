@extends('layouts.tabler')

@section('content')
<div class="container-xl">
    <div class="page-header d-print-none">
        <div class="row align-items-center">
            <div class="col">
                <h2 class="page-title">Ajouter un nouveau véhicule</h2>
            </div>
        </div>
    </div>

    <div class="row row-cards mt-3">
        <div class="col-md-8">
            <form action="{{ route('vehicles.store') }}" method="POST" class="card">
                @csrf
                <div class="card-body">
                    {{-- Nom du véhicule --}}
                    <div class="mb-3">
                        <label class="form-label required">Nom du véhicule</label>
                        <input type="text" name="name" 
                               class="form-control @error('name') is-invalid @enderror" 
                               placeholder="ex: Ford Transit Blanche" value="{{ old('name') }}" required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="row">
                        {{-- Modèle --}}
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label required">Modèle</label>
                                <input type="text" name="model" 
                                       class="form-control @error('model') is-invalid @enderror" 
                                       placeholder="ex: Transit 2016" value="{{ old('model') }}" required>
                                @error('model') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        {{-- Plaque --}}
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label required">Plaque d'immatriculation</label>
                                <input type="text" name="plate_number" 
                                       class="form-control @error('plate_number') is-invalid @enderror" 
                                       placeholder="ex: ABC-1234" value="{{ old('plate_number') }}" required>
                                @error('plate_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Statut Initial (Valeurs Enum) --}}
                    <div class="mb-3">
                        <label class="form-label">Statut initial</label>
                        <select name="status" class="form-select @error('status') is-invalid @enderror">
                            {{-- On utilise les valeurs attendues par l'Enum en anglais --}}
                            <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>Disponible</option>
                            <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>En maintenance</option>
                            <option value="on_mission" {{ old('status') == 'on_mission' ? 'selected' : '' }}>En mission</option>
                        </select>
                        @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>
                <div class="card-footer text-end">
                    <a href="{{ route('vehicles.index') }}" class="btn btn-link">Annuler</a>
                    <button type="submit" class="btn btn-primary">Enregistrer le véhicule</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection