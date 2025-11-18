<?php
declare(strict_types=1);

namespace App\Domain;

final class ParkingCalculator
{
    /** @var array<string, ParkingPolicy> */
    private array $policies = [];

    /**
     * @param array<string, ParkingPolicy> $policies
     */
    public function __construct(array $policies)
    {
        $this->policies = array_change_key_case($policies, CASE_LOWER);
    }

    public function calculateFee(string $vehicleType, int $entryTimestamp, int $exitTimestamp): float
    {
        $key = strtolower($vehicleType);

        if (!isset($this->policies[$key])) {
            return 0.0; 
        }
        $policy = $this->policies[$key];

        $hours = $this->calculateHours($entryTimestamp, $exitTimestamp);

        return $policy->calculate($hours);
    }

    private function calculateHours(int $entryTimestamp, int $exitTimestamp): int
    {
        if ($exitTimestamp <= $entryTimestamp) {
            return 0;
        }

        $seconds = $exitTimestamp - $entryTimestamp;
        $minutes = $seconds / 60;
        
        return (int) ceil($minutes / 60);
    }
}