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
                    <div class="mb-3">
                        <label class="form-label required">Nom du véhicule</label>
                        <input type="text" name="name" class="form-control" placeholder="ex: Ford Transit Blanche" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label required">Modèle</label>
                                <input type="text" name="model" class="form-control" placeholder="ex: Transit 2016" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label required">Plaque d'immatriculation</label>
                                <input type="text" name="plate_number" class="form-control" placeholder="ex: ABC-1234" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Statut initial</label>
                        <select name="status" class="form-select">
                            <option value="disponible">Disponible</option>
                            <option value="maintenance">En maintenance</option>
                            <option value="en_route">En mission</option>
                        </select>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <button type="submit" class="btn btn-primary">Enregistrer le véhicule</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection