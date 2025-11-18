<?php
declare(strict_types=1);

$dir = __DIR__; 
$dbPath = $dir . '/database.sqlite';

if (!is_dir($dir)) {
    mkdir($dir, 0777, true);
}

$pdo = new PDO('sqlite:' . $dbPath);

$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql = <<<SQL
CREATE TABLE IF NOT EXISTS parking_records (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  plate TEXT NOT NULL,
  vehicle_type TEXT NOT NULL,
  entry_timestamp INTEGER NOT NULL,
  exit_timestamp INTEGER NOT NULL,
  fee REAL NOT NULL CHECK(fee >= 0)
);
SQL;

$pdo->exec($sql);

echo "OK: 'database.sqlite' e tabela 'parking_records' criados/atualizados.\n";