<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;
use App\Models\Driver;
use App\Models\Vehicle;

class Order extends Model
{
    use BelongsToTenant;

    /**
     * Les attributs qui peuvent être assignés massivement.
     */
    protected $fillable = [
        'customer_name',
        'origin_address',
        'destination_address',
        'pickup_time',
        'price',
        'status',
        'driver_id',
        'vehicle_id',
        'tenant_id', // Nécessaire pour ton architecture multi-tenant
    ];
    
    protected function casts(): array
    {
        return [
            'pickup_time' => 'datetime', // C'est ici que la magie opère
            'price' => 'decimal:2',
            'scheduled_at' => 'datetime',
        ];
    }

    // Relations
    public function driver() { return $this->belongsTo(Driver::class); }
    public function vehicle() { return $this->belongsTo(Vehicle::class); }

    // Scope pour le Dashboard
    public function scopeUpcoming($query)
    {
        return $query->where('scheduled_at', '>=', now())->orderBy('scheduled_at', 'asc');
    }
}