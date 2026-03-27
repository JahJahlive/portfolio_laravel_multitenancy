@extends('layouts.tabler')

@section('content')
<div class="container-xl">
    <div class="page-header d-print-none">
        <div class="row align-items-center">
            <div class="col">
                <h2 class="page-title">Gestion des Missions - {{ 'Transport Sud-Ouest' }}</h2>
            </div>
            <div class="col-auto ms-auto">
                <a href="{{ route('orders.create') }}" class="btn btn-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                    Nouvelle Mission
                </a>
            </div>
        </div>
    </div>

    <div class="card mt-3">
        <div class="table-responsive">
            <table class="table table-vcenter card-table">
                <thead>
                    <tr>
                        <th>Client / Date</th>
                        <th>Trajet (De -> À)</th>
                        <th>Assignation</th>
                        <th>Statut</th>
                        <th class="w-1"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr>
                        <td>
                            <div class="font-weight-medium">{{ $order->customer_name }}</div>
                            <div class="text-muted small">{{ $order->pickup_time->format('d/m/Y H:i') }}</div>
                        </td>
                        <td class="small">
                            <div class="text-blue">↑ {{ Str::limit($order->origin_address, 35) }}</div>
                            <div class="text-green">↓ {{ Str::limit($order->destination_address, 35) }}</div>
                        </td>
                        <td>
                            @if($order->vehicle_id)
                                <div class="d-flex align-items-center">
                                    <span class="badge badge-outline text-blue">{{ $order->vehicle->name }}</span>
                                    <span class="text-muted small ms-2">({{ $order->driver->first_name . ' ' . $order->driver->last_name  ?? 'N/A' }})</span>
                                </div>
                            @else
                                <span class="badge bg-warning-lt text-uppercase font-weight-bold" style="font-size: 0.65rem;">
                                    ⚠️ À Planifier
                                </span>
                            @endif
                        </td>
                        <td>
                            <span class="badge {{ $order->status === 'completed' ? 'bg-green' : ($order->status === 'assigned' ? 'bg-blue' : 'bg-secondary') }} text-white">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('orders.edit', $order) }}" class="btn btn-sm btn-light">Gérer</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection