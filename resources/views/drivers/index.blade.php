@extends('layouts.tabler')

@section('content')
<div class="page-header d-print-none">
    <div class="row g-2 align-items-center">
        <div class="col">
            <h2 class="page-title">Gestion des Chauffeurs</h2>
        </div>
        <div class="col-auto ms-auto d-print-none">
            <a href="{{ route('drivers.create') }}" class="btn btn-primary d-none d-sm-inline-block">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                Ajouter un chauffeur
            </a>
        </div>
    </div>
</div>

<div class="card mt-3">
    <div class="table-responsive">
        <table class="table table-vcenter card-table">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Contact</th>
                    <th>Licence</th>
                    <th>Véhicule</th>
                    <th>Statut</th>
                    <th class="w-1"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($drivers as $driver)
                <tr>
                    <td>{{ $driver->full_name }}</td>
                    <td class="text-muted">
                        {{ $driver->phone }}
                        @if($driver->email)<br><small>{{ $driver->email }}</small>@endif
                    </td>
                    <td>{{ $driver->license_number }}</td>
                    <td>
                        @if($driver->vehicle)
                            <span class="badge bg-blue-lt">{{ $driver->vehicle->name }}</span>
                        @else
                            <span class="text-muted small italic">Non assigné</span>
                        @endif
                    </td>
                    <td>
                        {{-- On utilise directement les méthodes de l'Enum --}}
                        <span class="badge {{ $driver->status->color() }} dot"></span> 
                        {{ $driver->status->label() }}
                    </td>
                    <td>
                        <div class="btn-list flex-nowrap">
                            <a href="{{ route('drivers.edit', $driver) }}" class="btn btn-white btn-sm">Modifier</a>
                            <form action="{{ route('drivers.destroy', $driver) }}" method="POST" onsubmit="return confirm('Supprimer ce chauffeur ?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm">Suppr.</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection