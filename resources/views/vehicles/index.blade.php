@extends('layouts.tabler')

@section('content')
<div class="container-xl">
    <div class="page-header d-print-none">
        <div class="row align-items-center">
            <div class="col">
                <h2 class="page-title">Gestion de la Flotte</h2>
                <div class="text-muted mt-1">Client : {{ ucfirst(tenant('id')) }}</div>
            </div>
            <div class="col-auto ms-auto">
                <a href="{{ route('vehicles.create') }}" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
                    Ajouter un véhicule
                </a>
            </div>
        </div>
    </div>

    <div class="row row-cards mt-3">
        <div class="col-12">
            <div class="card">
                <div class="table-responsive">
                    <table class="table table-vcenter card-table">
                        <thead>
                            <tr>
                                <th>Véhicule</th>
                                <th>Plaque</th>
                                <th>Chauffeur Assigné</th>
                                <th>Modèle / Année</th>
                                <th>Statut</th>
                                <th class="w-1"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($vehicles as $vehicle)
                            <tr>
                                <td>
                                    <div class="d-flex py-1 align-items-center">
                                        <span class="avatar me-2 bg-light text-primary">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-truck" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="7" cy="17" r="2" /><circle cx="17" cy="17" r="2" /><path d="M5 17h-2v-11a1 1 0 0 1 1 -1h9v12m-4 0h6m4 0h2v-6h-8m0 -5h5l3 5" /></svg>
                                        </span>
                                        <div class="flex-fill">
                                            <div class="font-weight-medium">{{ $vehicle->name }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-muted">{{ $vehicle->plate_number }}</td>
                                <td class="text-muted">
                                    @if($vehicle->driver)
                                        <span class="avatar avatar-xs bg-green-lt">
                                            {{ substr($vehicle->driver->first_name, 0, 1) }}
                                        </span>
                                        <span class="ms-2">{{ $vehicle->driver->full_name }}</span>
                                    @else
                                        <span class="badge bg-red-lt">Sans chauffeur</span>
                                    @endif
                                </td>
                                <td class="text-muted">{{ $vehicle->model }}</td>
                                <td>
                                    {{-- Utilisation de l'Enum --}}
                                    <span class="badge {{ $vehicle->status->color() }} text-uppercase">
                                        {{ $vehicle->status->label() }}
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-list flex-nowrap">
                                        <a href="{{ route('vehicles.edit', $vehicle) }}" class="btn btn-sm btn-white">Modifier</a>
                                        <form action="{{ route('vehicles.destroy', $vehicle) }}" method="POST" onsubmit="return confirm('Supprimer ce véhicule ?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Suppr.</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">Aucun véhicule enregistré.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection