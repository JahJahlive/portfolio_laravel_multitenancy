<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Builder;

class Vehicle extends Model
{
    use BelongsToTenant; // Filtre automatiquement par tenant_id

    protected $fillable = ['name', 'model', 'plate_number', 'status', 'tenant_id'];
}
