<?php
declare(strict_types=1);

namespace App\Domain;

final class ParkingRecord
{
    public function __construct(
        public ?int $id,
        public string $plate,
        public string $vehicleType,
        public int $entryTimestamp,
        public int $exitTimestamp,
        public float $fee
    ) {}

    public function id(): ?int { return $this->id; }
    public function plate(): string { return $this->plate; }
    public function vehicleType(): string { return $this->vehicleType; }
    public function entryTimestamp(): int { return $this->entryTimestamp; }
    public function exitTimestamp(): int { return $this->exitTimestamp; }
    public function fee(): float { return $this->fee; }
}