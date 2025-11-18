<?php 
declare(strict_types=1);

namespace App\Domain\Policies;
use App\Domain\ParkingPolicy;

final class CarPolicy implements ParkingPolicy
{
    private const FARE_PER_HOUR = 5.0;

    public function calculate(int $hours): float
    {
        return self::FARE_PER_HOUR  * $hours;
    }
}