<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Driver;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Vehicle extends Model
{
    use BelongsToTenant; // Filtre automatiquement par tenant_id

    protected $casts = [
        'status' => \App\Enums\VehicleStatus::class,
    ];

    protected $fillable = ['name', 'model', 'plate_number', 'status', 'tenant_id'];

    public function driver(): HasOne
    {
        // Un véhicule a un chauffeur attitré
        return $this->hasOne(Driver::class);
    }
}
