<?php

namespace App\Enums;

enum VehicleStatus: string {
    case AVAILABLE = 'available';
    case ON_MISSION = 'on_mission';
    case MAINTENANCE = 'maintenance';

    public function label(): string {
        return match($this) {
            self::AVAILABLE => 'Disponible',
            self::ON_MISSION => 'En route',
            self::MAINTENANCE => 'En maintenance',
        };
    }

    public function color(): string {
        return match($this) {
            self::AVAILABLE => 'bg-green-lt',
            self::ON_MISSION => 'bg-blue-lt',
            self::MAINTENANCE => 'bg-red-lt',
        };
    }
}