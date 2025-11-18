<?php
declare(strict_types=1);

namespace App\Infra;

use App\Domain\ParkingRecord;
use App\Domain\ParkingRepository;
use \PDO;

final class SqliteParkingRepository implements ParkingRepository
{
    private const TABLE_NAME = 'parking_records';

    public function __construct(
        private readonly PDO $db
    ) {
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /**
     * @param array<string, mixed> $row
     */
    private function hydrate(array $row): ParkingRecord
    {
        return new ParkingRecord(
            id: (int)$row['id'],
            plate: (string)$row['plate'],
            vehicleType: (string)$row['vehicle_type'],
            entryTimestamp: (int)$row['entry_timestamp'],
            exitTimestamp: (int)$row['exit_timestamp'],
            fee: (float)$row['fee']
        );
    }

    /**
     * @return ParkingRecord[]
     */
    public function all(): array
    {
        $sql = "SELECT * FROM " . self::TABLE_NAME . " ORDER BY id DESC";
        $stmt = $this->db->query($sql);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];

        return array_map([$this, 'hydrate'], $rows);
    }

    public function find(int $id): ?ParkingRecord
    {
        $sql = "SELECT * FROM " . self::TABLE_NAME . " WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? $this->hydrate($row) : null;
    }

    public function create(ParkingRecord $record): ParkingRecord
    {
        $sql = "INSERT INTO " . self::TABLE_NAME . " 
                    (plate, vehicle_type, entry_timestamp, exit_timestamp, fee) 
                VALUES (:plate, :vehicle_type, :entry_timestamp, :exit_timestamp, :fee)";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':plate' => $record->plate,
            ':vehicle_type' => $record->vehicleType,
            ':entry_timestamp' => $record->entryTimestamp,
            ':exit_timestamp' => $record->exitTimestamp,
            ':fee' => $record->fee
        ]);

        $id = (int)$this->db->lastInsertId();
        return new ParkingRecord(
            $id,
            $record->plate,
            $record->vehicleType,
            $record->entryTimestamp,
            $record->exitTimestamp,
            $record->fee
        );
    }

    public function update(ParkingRecord $record): void
    {
        if ($record->id() === null) {
            throw new \InvalidArgumentException('ID é obrigatório para atualizar o registro.');
        }

        $sql = "UPDATE " . self::TABLE_NAME . " SET 
                    plate = :plate, 
                    vehicle_type = :vehicle_type, 
                    entry_timestamp = :entry_timestamp, 
                    exit_timestamp = :exit_timestamp, 
                    fee = :fee 
                WHERE id = :id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':plate' => $record->plate,
            ':vehicle_type' => $record->vehicleType,
            ':entry_timestamp' => $record->entryTimestamp,
            ':exit_timestamp' => $record->exitTimestamp,
            ':fee' => $record->fee,
            ':id' => $record->id()
        ]);
    }

    public function delete(int $id): void
    {
        $sql = "DELETE FROM " . self::TABLE_NAME . " WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
    }
}