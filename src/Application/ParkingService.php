<?php
declare(strict_types=1);

namespace App\Application;

use App\Domain\ParkingCalculator;
use App\Domain\ParkingRecord;
use App\Domain\ParkingRepository;
use App\Domain\ParkingValidator;

final class ParkingService
{
    public function __construct(
        private ParkingRepository $repo,
        private ParkingValidator $validator,
        private ParkingCalculator $calculator
    ) {}

    /**
     * @param array{
     * plate?:string, vehicle_type?:string, 
     * entry_time?:string|int, exit_time?:string|int
     * } $input
     * @return array{ok:bool, errors?:string[], id?:int}
     */
    public function create(array $input): array
    {
        $errors = $this->validator->validate($input);
        if ($errors !== []) {
            return ['ok' => false, 'errors' => $errors];
        }

        $plate = strtoupper(trim((string)($input['plate'] ?? '')));
        $vt = strtolower(trim((string)($input['vehicle_type'] ?? '')));
        $entryTs = (int)($input['entry_time'] ?? 0);
        $exitTs = (int)($input['exit_time'] ?? 0);

        $fee = $this->calculator->calculateFee($vt, $entryTs, $exitTs);

        $record = new ParkingRecord(
            id: null,
            plate: $plate,
            vehicleType: $vt,
            entryTimestamp: $entryTs,
            exitTimestamp: $exitTs,
            fee: $fee
        );

        $created = $this->repo->create($record);
        return ['ok' => true, 'id' => $created->id()];
    }

    /**
     * @param array{
     * plate?:string, vehicle_type?:string, 
     * entry_time?:string|int, exit_time?:string|int
     * } $input
     * @return array{ok:bool, errors?:string[]}
     */
    public function update(int $id, array $input): array
    {
        $existing = $this->repo->find($id);
        if (!$existing) {
            return ['ok' => false, 'errors' => ['Registro de estacionamento não encontrado.']];
        }

        $errors = $this->validator->validate($input);
        if ($errors !== []) {
            return ['ok' => false, 'errors' => $errors];
        }

        $plate = strtoupper(trim((string)($input['plate'] ?? '')));
        $vt = strtolower(trim((string)($input['vehicle_type'] ?? '')));
        $entryTs = (int)($input['entry_time'] ?? 0);
        $exitTs = (int)($input['exit_time'] ?? 0);

        $fee = $this->calculator->calculateFee($vt, $entryTs, $exitTs);

        $updated = new ParkingRecord(
            id: $id,
            plate: $plate,
            vehicleType: $vt,
            entryTimestamp: $entryTs,
            exitTimestamp: $exitTs,
            fee: $fee
        );

        $this->repo->update($updated);
        return ['ok' => true];
    }

    public function delete(int $id): array
    {
        $existing = $this->repo->find($id);
        if (!$existing) {
            return ['ok' => false, 'errors' => ['Registro de estacionamento não encontrado.']];
        }
        $this->repo->delete($id);
        return ['ok' => true];
    }

    /** @return ParkingRecord[] */
    public function all(): array
    {
        return $this->repo->all();
    }

    public function find(int $id): ?ParkingRecord
    {
        return $this->repo->find($id);
    }
}