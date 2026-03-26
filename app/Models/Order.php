<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;
use App\Models\Driver;
use App\Models\Vehicle;

class Order extends Model
{
    use BelongsToTenant;

    protected $casts = [
        'scheduled_at' => 'datetime',
    ];

    // Relations
    public function driver() { return $this->belongsTo(Driver::class); }
    public function vehicle() { return $this->belongsTo(Vehicle::class); }

    // Scope pour le Dashboard
    public function scopeUpcoming($query)
    {
        return $query->where('scheduled_at', '>=', now())->orderBy('scheduled_at', 'asc');
    }
}