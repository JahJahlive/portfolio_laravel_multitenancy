<?php

namespace App\Enums;

enum DriverStatus: string {
    case AVAILABLE = 'available';
    case ON_MISSION = 'on_mission';
    case OFF_DUTY = 'off_duty';

    public function label(): string {
        return match($this) {
            self::AVAILABLE => 'Disponible',
            self::ON_MISSION => 'En mission',
            self::OFF_DUTY => 'En repos',
        };
    }

    // app/Enums/DriverStatus.php

    public function color(): string {
        return match($this) {
            self::AVAILABLE => 'bg-success',
            self::ON_MISSION => 'bg-warning',
            self::OFF_DUTY => 'bg-secondary',
        };
    }
}