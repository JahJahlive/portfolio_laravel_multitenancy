<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Driver extends Model
{
    use BelongsToTenant;

    protected $casts = [
        'status' => \App\Enums\DriverStatus::class,
    ];

    protected $fillable = [
        'first_name', 'last_name', 'email', 'phone', 
        'license_number', 'status', 'vehicle_id'
    ];

    /**
     * Un chauffeur peut être assigné à un véhicule.
     */
    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    /**
     * Helper pour le nom complet (pratique pour Tabler)
     */
    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }
}