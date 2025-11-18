<?php

declare(strict_types=1);

namespace App\Domain\Policies;

use App\Domain\ParkingPolicy;

final class MotorcyclePolicy implements ParkingPolicy
{
    private const FARE_PER_HOUR = 3.0;

    public function calculate(int $hours): float
    {
        return self::FARE_PER_HOUR  * $hours;
    }
}
