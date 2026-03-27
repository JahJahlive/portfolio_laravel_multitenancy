@extends('layouts.tabler')

@section('content')
<div class="container-xl">
    <div class="page-header d-print-none">
        <div class="row align-items-center">
            <div class="col">
                <h2 class="page-title">Modifier la Mission #{{ $order->id }}</h2>
            </div>
        </div>
    </div>

    <div class="row row-cards mt-3">
        <div class="col-12">
            <form action="{{ route('orders.update', $order) }}" method="POST" class="card">
                @csrf
                @method('PUT')
                
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label required">Nom du Client</label>
                            <input type="text" name="customer_name" class="form-control @error('customer_name') is-invalid @enderror" 
                                   value="{{ old('customer_name', $order->customer_name) }}" required>
                            @error('customer_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label required">Date et Heure de ramassage</label>
                            <input type="datetime-local" name="pickup_time" class="form-control @error('pickup_time') is-invalid @enderror" 
                                   value="{{ old('pickup_time', $order->pickup_time->format('Y-m-d\TH:i')) }}" required>
                            @error('pickup_time') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label required">Adresse de Départ</label>
                            <input type="text" name="origin_address" class="form-control" value="{{ old('origin_address', $order->origin_address) }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label required">Destination</label>
                            <input type="text" name="destination_address" class="form-control" value="{{ old('destination_address', $order->destination_address) }}" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Prix de la mission ($)</label>
                            <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price', $order->price) }}">
                        </div>
                          <div class="col-md-4 mb-3">
        <label class="form-label">Statut de la mission</label>
        <select name="status" class="form-select">
            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>En attente</option>
            <option value="assigned" {{ $order->status == 'assigned' ? 'selected' : '' }}>Assignée</option>
            <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Terminée</option>
            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Annulée</option>
        </select>
    </div>
                    </div>
           <div class="row">
  

    <div class="col-md-4 mb-3">
        <label class="form-label">Assignation (Chauffeur)</label>
        <select name="driver_id" class="form-select @error('driver_id') is-invalid @enderror">
            <option value="">-- Aucun chauffeur --</option>
            @foreach($drivers as $driver)
                <option value="{{ $driver->id }}" {{ $order->driver_id == $driver->id ? 'selected' : '' }}>
                    {{ $driver->first_name }} {{ $driver->last_name }}
                </option>
            @endforeach
        </select>
        @error('driver_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

    <div class="col-md-4 mb-3">
        <label class="form-label">Assignation (Véhicule)</label>
        <select name="vehicle_id" class="form-select">
            <option value="">-- Aucun véhicule --</option>
            @foreach($vehicles as $vehicle)
                <option value="{{ $vehicle->id }}" {{ $order->vehicle_id == $vehicle->id ? 'selected' : '' }}>
                    {{ $vehicle->name }} ({{ $vehicle->plate_number }})
                </option>
            @endforeach
        </select>
    </div>
</div>
                    </div>
                </div>
                




                

                <div class="card-footer text-end">
                    <div class="d-flex">
                        <a href="{{ route('orders.index') }}" class="btn btn-link">Annuler</a>
                        <button type="submit" class="btn btn-primary ms-auto">Mettre à jour la mission</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection