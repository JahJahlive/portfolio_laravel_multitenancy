@extends('layouts.tabler')

@section('content')
<div class="page-header">
    <div class="container-xl">
        <h2 class="page-title">Assignation : Mission #{{ $order->id }}</h2>
        <div class="text-muted small">{{ $order->pickup_address }} ➔ {{ $order->delivery_address }}</div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        <form action="{{ route('orders.assign.post', $order) }}" method="POST">
            @csrf
            <div class="row row-cards">
                {{-- Sélection du Chauffeur --}}
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header"><h3 class="card-title">Choisir un chauffeur</h3></div>
                        <div class="card-body">
                            <select name="driver_id" class="form-select @error('driver_id') is-invalid @enderror">
                                <option value="">-- Sélectionner --</option>
                                @foreach($drivers as $driver)
                                    <option value="{{ $driver->id }}">{{ $driver->full_name }}</option>
                                @endforeach
                            </select>
                            @error('driver_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>

                {{-- Sélection du Véhicule --}}
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header"><h3 class="card-title">Choisir un véhicule</h3></div>
                        <div class="card-body">
                            <select name="vehicle_id" class="form-select @error('vehicle_id') is-invalid @enderror">
                                <option value="">-- Sélectionner --</option>
                                @foreach($vehicles as $vehicle)
                                    <option value="{{ $vehicle->id }}">{{ $vehicle->name }} ({{ $vehicle->plate_number }})</option>
                                @endforeach
                            </select>
                            @error('vehicle_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-4 text-end">
                <a href="{{ route('orders.index') }}" class="btn btn-link">Annuler</a>
                <button type="submit" class="btn btn-primary">Confirmer l'envoi de la mission</button>
            </div>
        </form>
    </div>
</div>
@endsection