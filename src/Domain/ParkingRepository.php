<?php
declare(strict_types=1);

namespace App\Domain;
interface ParkingRepository
{
    /** @return ParkingRecord[] */
    public function all(): array;

    public function find(int $id): ?ParkingRecord;

    public function create(ParkingRecord $record): ParkingRecord;

    public function update(ParkingRecord $record): void;

    public function delete(int $id): void;
}