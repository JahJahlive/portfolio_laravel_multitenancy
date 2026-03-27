@extends('layouts.tabler')

@section('content')
<div class="container-xl">
    <div class="page-header d-print-none">
        <h2 class="page-title">Tableau de Bord - {{ ucfirst(tenant('id')) }}</h2>
    </div>

    <div class="row row-cards mt-3">
        {{-- Card: Véhicules en service --}}
        <div class="col-sm-6 col-lg-3">
            <div class="card card-sm">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <span class="bg-blue text-white avatar">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 17m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M17 17m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M5 17h-2v-11a1 1 0 0 1 1 -1h9v12m-4 0h6m4 0h2v-6h-8m0 -5h5l3 5" /></svg>
                            </span>
                        </div>
                        <div class="col">
                            <div class="font-weight-medium">{{ $stats['vehicles_on_mission'] }} En Mission</div>
                            <div class="text-muted">Sur {{ $stats['vehicles_available'] + $stats['vehicles_on_mission'] }} véhicules</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Card: Chauffeurs Disponibles --}}
        <div class="col-sm-6 col-lg-3">
            <div class="card card-sm">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <span class="bg-green text-white avatar">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /></svg>
                            </span>
                        </div>
                        <div class="col">
                            <div class="font-weight-medium">{{ $stats['drivers_available'] }} Chauffeurs</div>
                            <div class="text-secondary">Prêts pour assignation</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Section: Activité Récente (Optionnel) --}}
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Dernières Missions à {{ ucfirst(tenant('id')) }}</h3>
                </div>
                <div class="card-table table-responsive">
                    {{-- Ici tu pourras boucler sur tes $recentOrders --}}
                    <table class="table table-vcenter">
                        <thead>
                            <tr>
                                <th>Client / Destination</th>
                                <th>Chauffeur</th>
                                <th>Véhicule</th>
                                <th>Statut</th>
                            </tr>
                        </thead>
                       <tbody>
                            @forelse($recentOrders as $order)
                                <tr>
                                    <td>
                                        <div class="font-weight-medium">{{ $order->customer_name }}</div>
                                        <div class="text-muted small">{{ $order->destination_address }}</div>
                                    </td>
                                    <td>{{ $order->driver->full_name ?? 'Non assigné' }}</td>
                                    <td>{{ $order->vehicle->name ?? 'N/A' }}</td>
                                    <td>
                                        <span class="badge bg-{{ $order->status === 'completed' ? 'green' : 'blue' }}-lt">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr class="text-muted"><td colspan="4" class="text-center">Aucune mission active pour le moment.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 mt-4">
        <div class="card">
            <div class="card-body">
                <h3 class="card-title">Évolution des Livraisons (7 derniers jours)</h3>
                <div style="height: 300px;">
                    <canvas id="deliveryChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>


{{-- Script Chart.js --}}
    @push('scripts')
    <script>
    // Utiliser window.onload garantit que Chart.js est bien chargé avant de dessiner
    window.onload = function() {
        const canvas = document.getElementById('deliveryChart');
        if (canvas) {
            const ctx = canvas.getContext('2d');
            // ... le reste de ton code new Chart()
        } else {
            console.error("Impossible de trouver le canvas 'deliveryChart'");
        }
    };
</script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const ctx = document.getElementById('deliveryChart').getContext('2d');
            
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($labels) !!}, // Dates générées par le contrôleur
                    datasets: [
                        {
                            label: 'Nombre de livraisons',
                            data: {!! json_encode($orderData) !!}, //
                            borderColor: '#206bc4',
                            backgroundColor: 'rgba(32, 107, 196, 0.1)',
                            fill: true,
                            tension: 0.3,
                            yAxisID: 'y',
                        },
                        {
                            label: 'Revenus ($)',
                            data: {!! json_encode($revenueData) !!}, //
                            borderColor: '#2fb344',
                            backgroundColor: 'transparent',
                            tension: 0.3,
                            yAxisID: 'y1',
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        mode: 'index',
                        intersect: false,
                    },
                    scales: {
                        y: {
                            type: 'linear',
                            display: true,
                            position: 'left',
                            title: { display: true, text: 'Livraisons' },
                            beginAtZero: true,
                            ticks: { stepSize: 1 }
                        },
                        y1: {
                            type: 'linear',
                            display: true,
                            position: 'right',
                            title: { display: true, text: 'Revenus ($)' },
                            beginAtZero: true,
                            grid: { drawOnChartArea: false }, // Évite de surcharger la grille
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    if (label === 'Revenus ($)') {
                                        return label + ': ' + new Intl.NumberFormat('fr-CA', { style: 'currency', currency: 'CAD' }).format(context.parsed.y);
                                    }
                                    return label + ': ' + context.parsed.y;
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
    @endpush
@endsection